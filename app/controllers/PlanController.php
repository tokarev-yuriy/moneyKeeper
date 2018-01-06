<?php


/**
 *  CRUD controller for plans view and edit
 *
 *  @author   Yuriy Tokarev <yuriytok@gmail.com>
 */
class PlanController extends CrudListController {

    
    public $type='';
    public $arDictionaries;
    public $modelName = 'Plan';
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
                
        $this->__loadDictionaries();
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
        $arItems = Plan::user()->
                orderBy($this->sort['by'],$this->sort['order'])->
                orderBy('id','desc')->
                paginate(Config::get('view.itemsPerPage'));
        
        $arItems = $this->__prepareItems($arItems);
        
        $arTable = array(
            'arItems' => $arItems,
            'arHeads' => $this->__getHeads(),
            'arActions' => $this->__getActions(),
            'arDictionaries' => $this->__getDictionary()
        );
        
        return View::make($this->__getView('index'), array('items'=>$arItems))->nest('tablegrid', 'widgets.cardgroup', $arTable);
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
