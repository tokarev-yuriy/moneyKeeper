<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\CrudListController;
use App\MoneyKeeper\Models\Category;
use App\MoneyKeeper\Models\Wallet;
use App\MoneyKeeper\Models\Operation;
use App\MoneyKeeper\Models\Plan;
use View, Input, Session, Config, Request, Auth, Validator, Redirect;

/**
 *  CRUD controller for plans view and edit
 *
 *  @author   Yuriy Tokarev <yuriytok@gmail.com>
 */
class PlanController extends CrudListController {

    
    public $type='';
    public $arDictionaries;
    public $modelName = 'App\MoneyKeeper\Models\Plan';
    public $sort = array(
        'by' => 'id',
        'order' => 'desc'
    );

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Returns routes of CRUD plans
     * It has to be determined the path to the folowing pages:
     * index, update, delete and add
     * 
     * @return array
     */    
    protected function __getPaths () {
        return [
            'index' => '/account/plans',
            'update' => '/account/plans/update',
            'delete' => '/account/plans/delete',
            'add' => '/account/plans/add',
        ];
    }
    
    /**
     * Returns views of CRUD controller
     * It has to be determined templates of the folowing pages:
     * edit, index and form
     * 
     * @return array
     */    
    protected function __getViews () {
        return [
            'edit' => 'account.plans.edit',
            'form' => 'account.plans.edit_form',
            'index' => 'account.plans.index',
        ];
    }
    
    /**
     * Returns column titles of the list table
     * 
     * 
     * @return array (field=>title)
     */    
    protected function __getHeads () {
        return array(
                'value' => trans('mkeep.summ'),
                'category_id' => trans('mkeep.category'),
                'comment' => trans('mkeep.comment'),
            );
    }
    
    /**
     * Returns page titles
     * It has to be determined titles of the folowing pages:
     * list, add, edit and delete
     * 
     * @return array (code=>title)
     */    
    protected function __getTitles () {
        return [
            'list' => trans('mkeep.plans'),
            'add'  => trans('mkeep.add_plan'),
            'edit'  => trans('mkeep.edit_plan'),
            'delete'  => trans('mkeep.delete_plan')
        ];
    }
    
        
    /**
     * Select all dictionaries for iperation fields
     * 
     * 
     * @return array
     */
    protected function __loadDictionaries () {
        $this->arDictionaries = array(
            'category_id' => array(),
            'category_icon' => array(),
            'type' => Category::getTypeVisualList(),
        );
        
        
        $arCategories = Category::user()->select('id', 'name', 'icon')->orderBy('sort')->get();
        $arIcons = Category::getCategoryIcons();
        foreach($arCategories as $arCategory) {
            $this->arDictionaries['category_id'][$arCategory->id] = $arCategory->name;
            $this->arDictionaries['category_icon'][$arCategory->id] = '';
            if ($arCategory->icon && isset($arIcons[$arCategory->icon])) {
                $this->arDictionaries['category_icon'][$arCategory->id] = $arIcons[$arCategory->icon];
            }
        }
        
        return $this->arDictionaries;
    }
    
    /**
     * Returns dictionaries for enum type fields
     * 
     * 
     * @return array (field=>array(code=>title))
     */   
    protected function __getDictionary () {
        if (!$this->arDictionaries) {
          $this->__loadDictionaries();
        }
        return $this->arDictionaries;
    }
    
     /**
     * List of items
     * 
     * @return <type>
     */    
    public function postIndex()
    {
        return $this->getIndex();
    }
    
    /**
     * List of items
     * 
     * @return <type>
     */    
    public function getIndex()
    {
        if(Request::wantsJson()){
            $arItems = Plan::user()->
                    orderBy($this->sort['by'],$this->sort['order'])->
                    orderBy('id','desc')->
                    paginate(Config::get('view.itemsPerPage'));
            
            $arItems = $this->__prepareItems($arItems);
            $arCategories = [];
            $categories = Category::user()->select('id', 'name', 'icon')->orderBy('sort')->get();
            foreach($categories as $obCategory) {
                $arCategories[$obCategory->id] = $obCategory;
            }
            
            return [
                'plans' => $arItems,
                'categories' => $arCategories
            ];
        }
        
        return view($this->__getView('index'), []);
    }
    
    /**
     * Edit item
     * 
     * @param int $id 
     * 
     * @return <type>
     */    
    public function getEdit($id)
    {
        $model = $this->modelName;
        $obItem = $model::user()->find($id);

        if (!$obItem) {
            $obItem = ['value'=>0];
        }

        return ['plan'=>$obItem, 'categories' => Category::user()->select('id', 'name', 'icon')->orderBy('sort')->get()];
    }
    
   
    /**
     * Returns validators for add and edit operation
     * 
     * 
     * @return array
     */    
    protected function __getValidators () {
        return array(
              'value'=>'required|numeric',
              'active_from'=>'date|nullable',
              'active_to'=>'date|nullable',
            );
    }
    
    /**
     * Populate object with user's input
     * 
     * 
     * @return object
     */    
    protected function __populateItem ($obItem) {
        $obItem->comment = Input::get('comment');
        $obItem->user_id = Auth::id();
        $obItem->value = floatval(Input::get('value'));
        $obItem->category_id = intval(Input::get('category_id'));
        $obItem->active_from = null;
        $obItem->active_to = null;
        if (Input::get('active_from') && strtotime(Input::get('active_from'))>0) {
            $obItem->active_from = date('Y-m-d', strtotime(Input::get('active_from')));
        }
        if (Input::get('active_to') && strtotime(Input::get('active_to'))>0) {
            $obItem->active_to = date('Y-m-d', strtotime(Input::get('active_to')));
        }
        
        return $obItem;
    }
    
    /**
     * Preparing the object fields to display in the table
     * 
     * @param array $arItems 
     * 
     * @return array
     */
    protected function __prepareItems($arItems) {
        
        foreach($arItems as $k=>$obItem) {
            $arItems[$k]->editPath = '/account/plans/update/'.$obItem->id;
            $arItems[$k]->deletePath = '/account/plans/delete/'.$obItem->id;
            $arItems[$k]->editTitle = $this->__getTitle('edit');
            $arItems[$k]->deleteTitle = $this->__getTitle('delete');
            $arItems[$k]->type = 'spend';
        }
        
        return $arItems;
    }

}
