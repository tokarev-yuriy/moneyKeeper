<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use View, Input, Session, Config, Request, Auth, Validator, Redirect;

/**
 *  Abstract CRUD controller with ajax support
 *
 *  @author   Yuriy Tokarev <yuriytok@gmail.com>
 */
class CrudListController extends Controller {

    public $modelName = 'Item';
    public $sort = array(
        'by' => 'id',
        'order' => 'desc'
    );

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->middleware('auth');
              
        View::composer($this->__getViews(), function ($view) {
          $view->with('titles', $this->__getTitles());
          $view->with('paths', $this->__getPaths());
        });        
    }

    /**
     * List of items
     * 
     * @return <type>
     */    
    public function getIndex()
    {
        $model = $this->modelName;
        $arItems = $model::user()->
                orderBy($this->sort['by'],$this->sort['order'])->
                paginate(Config::get('view.itemsPerPage'));
        
        $arItems = $this->__prepareItems($arItems);
        
        $arTable = array(
            'items'=>$arItems,
            'arItems' => $arItems,
            'arHeads' => $this->__getHeads(),
            'arActions' => $this->__getActions(),
            'arDictionaries' => $this->__getDictionary()
        );
        
        return view($this->__getView('index'), $arTable);
    }

    /**
     * Add new Item form
     * 
     * @return <type>
     */    
    public function getAdd()
    {
        
        if (Request::ajax()) {
            return view($this->__getView('form'));
        }
        
        return view($this->__getView('edit'))->nest('editForm', $this->__getView('form'));
    }
    
    /**
     * Edit item from
     * 
     * @param int $id 
     * 
     * @return <type>
     */    
    public function getUpdate($id)
    {
        $model = $this->modelName;
        $obItem = $model::user()->find($id);
        if (!$obItem) {
            App::abort(404);
        }
        if (Request::ajax()) {
            return view($this->__getView('form'), array('obItem'=>$obItem));
        }
        return view($this->__getView('edit'),array('obItem'=>$obItem))->nest('editForm', $this->__getView('form'), array('obItem'=>$obItem));
    }
    
    /**
     * Add new Item
     * 
     * @return <type>
     */    
    public function postAdd()
    {
        $model = $this->modelName;
        $obItem = new $model();
        $obItem->user_id = Auth::id();
        
        return $this->__processItem($obItem);
    }

    /**
     * Update item
     * 
     * @param int $id 
     *
     * @return <type>
     */    
    public function postUpdate($id)
    {
        $model = $this->modelName;
        $obItem = $model::user()->find($id);
        if (!$obItem) {
            App::abort(404);
        }
        
        return $this->__processItem($obItem);
    }
    
    
    /**
     * Delete Item
     * 
     * @param int $id 
     * 
     * @return <type>
     */    
    public function getDelete($id)
    {
        $model = $this->modelName;
        $obItem = $model::user()->find($id);
        if (!$obItem) {
            return Redirect::to($this->__getPath('index'));
        }
        $obItem->delete();
        return Redirect::to($this->__getPath('index'));
    }
    
    /**
     * Process the edit and add item data
     * 
     * @param <type> $obItem 
     * 
     * @return <type>
     */    
    protected function __processItem($obItem) {
        $validator = Validator::make(Input::all(), $this->__getValidators());		
        if(!$validator->fails())
        {
            $obItem = $this->__populateItem($obItem);            
            $obItem->save();
            if (Request::ajax()) {
                return '';
            }
            return Redirect::to($this->__getPath('index'));
        }
        
        $messages = $validator->messages();
        
         if (Request::wantsJson()) {
             return ['errors' => $messages];
         }
         if (Request::ajax()) {
            return view($this->__getView('form'), array(
                'errors' => $messages,
                'obItem'=>$obItem
            ));
        }
        
        return view($this->__getView('edit'), array(
            'errors' => $messages,
            'obItem'=>$obItem
        ))->nest('editForm', $this->__getView('form'), array(
            'errors' => $messages,
            'obItem'=>$obItem
        ));
    }
    
    /**
     * Returns routes of CRUD operations
     * It has to be determined the path to the folowing pages:
     * index, update, delete and add
     * 
     * @return array
     */    
    protected function __getPaths () {
        return [
            'index' => '/items',
            'update' => '/items/update',
            'delete' => '/items/delete',
            'add' => '/items/add',
        ];
    }
    
    /**
     * Returns route to concreate operation
     * 
     * @param string $operation 
     * 
     * @return string
     */    
    protected function __getPath ($operation) {
        $paths = $this->__getPaths();
        return $paths[$operation];
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
            'edit' => 'items.edit',
            'form' => 'items.edit_form',
            'index' => 'items.index',
        ];
    }
    
    /**
     * Returns view template of concreate type
     * 
     * @param string $type 
     * 
     * @return string
     */    
    protected function __getView ($type) {
        $views = $this->__getViews();
        return $views[$type];
    }
    
    /**
     * Returns column titles of the list table
     * 
     * 
     * @return array (field=>title)
     */    
    protected function __getHeads () {
        return array();
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
            'list' => trans('mkeep.items'),
            'add'  => trans('mkeep.add_item'),
            'edit'  => trans('mkeep.edit_item'),
            'delete'  => trans('mkeep.delete_item')
        ];
    }
    
    /**
     * Returns title of concreate type
     * 
     * @param string $type 
     * 
     * @return string
     */    
    protected function __getTitle ($type) {
        $titles = $this->__getTitles();
        return $titles[$type];
    }
    
    /**
     * Returns dictionaries for enum type fields
     * 
     * 
     * @return array (field=>array(code=>title))
     */    
    protected function __getDictionary () {
        return array();
    }
    
    /**
     * Returns avail table actions
     * 
     * 
     * @return array possible values: edit and delete
     */    
    protected function __getActions () {
        return array('edit', 'delete');
    }
    
    /**
     * Returns validators for add and edit operation
     * 
     * 
     * @return array
     */    
    protected function __getValidators () {
        return array(
              /*'value'=>'required|numeric',
              'comment'=>'required|max:255',
              'date'=>'required|date',*/
            );
    } 
    
    /**
     * Populate object with user's input
     * 
     * 
     * @return object
     */    
    protected function __populateItem ($obItem) {
        /*$obItem->comment = Input::get('comment');
        $obItem->date = date('Y-m-d', strtotime(Input::get('date')));
        $obItem->year = date('Y', strtotime(Input::get('date')));
        $obItem->month = date('M', strtotime(Input::get('date')));
        $obItem->user_id = Auth::id();
        $obItem->type = $this->type;
        $obItem->value = floatval(Input::get('value'));
        $obItem->category_id = intval(Input::get('category_id'));
        $obItem->wallet_from_id = intval(Input::get('wallet_from_id'));
        $obItem->wallet_to_id = intval(Input::get('wallet_to_id'));*/
        
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
            $arItems[$k]->editPath = $this->__getPath('update').'/'.$obItem->id;
            $arItems[$k]->deletePath = $this->__getPath('delete').'/'.$obItem->id;
            $arItems[$k]->editTitle = $this->__getTitle('edit');
            $arItems[$k]->deleteTitle = $this->__getTitle('delete');
        }
        
        return $arItems;
    }
    
}
