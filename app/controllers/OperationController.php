<?php


/**
 *  CRUD controller for operations view and edit
 *
 *  @author   Yuriy Tokarev <yuriytok@gmail.com>
 */
class OperationController extends CrudListController {

    
    public $type='';
    public $arDictionaries;
    public $modelName = 'Operation';
    public $sort = array(
        'by' => 'date',
        'order' => 'desc'
    );

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        
        View::composer($this->__getViews(), function ($view) {
          $view->with('type', $this->type);
        }); 
        
        $this->__loadDictionaries();
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
            'index' => '/account/operations',
            'update' => '/account/operations/update',
            'delete' => '/account/operations/delete',
            'add' => '/account/operations/add',
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
            'edit' => 'account.operations.edit',
            'form' => 'account.operations.edit_form',
            'index' => 'account.operations.index',
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
            'wallet_from_id' => array(),
            'wallet_to_id' => array(),
            'category_id' => array(),
            'type' => Category::getTypeVisualList(),
        );
        
        
        $arCategories = Category::user()->select('id', 'name')->orderBy('sort')->get();
        foreach($arCategories as $arCategory) {
            $this->arDictionaries['category_id'][$arCategory->id] = $arCategory->name;
        }
        
        $arWallets = Wallet::user()->select('id', 'name')->orderBy('sort')->get();
        foreach($arWallets as $arWallet) {
            $this->arDictionaries['wallet_to_id'][$arWallet->id] = $arWallet->name;
            $this->arDictionaries['wallet_from_id'][$arWallet->id] = $arWallet->name;
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
        $dbItems = Operation::user()->
                where('type', '=', $this->type);
        $dbItems = $this->__processFilter($dbItems);
        $arItems = $dbItems->
                orderBy($this->sort['by'],$this->sort['order'])->
                orderBy('id','desc')->
                paginate(Config::get('view.itemsPerPage'));
        
        $arItems = $this->__prepareItems($arItems);
        
        $arTable = array(
            'arItems' => $arItems,
            'arHeads' => $this->__getHeads(),
            'arActions' => $this->__getActions(),
            'arFilters' => $this->__getFilters(),
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
              //'comment'=>'required|max:255',
              'date'=>'required|date',
            );
    }     
    
    
    /**
     * Returns Filters for operations table
     * 
     * 
     * @return array
     */    
    protected function __getFilters () {
        return array(
            'date'=>array(
                'title'=>trans('mkeep.date'), 
                'type'=>'period'
            ), 
            'category_id'=>array(
                'title'=>trans('mkeep.category'), 
                'type'=>'list', 
                'values'=>array_replace(array('-1'=>trans('mkeep.all_categories')), $this->arDictionaries['category_id'])
            )
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
        $obItem->date = date('Y-m-d', strtotime(Input::get('date')));
        $obItem->year = date('Y', strtotime(Input::get('date')));
        $obItem->month = date('M', strtotime(Input::get('date')));
        $obItem->user_id = Auth::id();
        $obItem->type = $this->type;
        $obItem->value = floatval(Input::get('value'));
        $obItem->category_id = intval(Input::get('category_id'));
        $obItem->wallet_from_id = intval(Input::get('wallet_from_id'));
        $obItem->wallet_to_id = intval(Input::get('wallet_to_id'));
        
        if (Input::get('wallet_from_id')) {
           Session::put('wallet_from_id', Input::get('wallet_from_id')); 
        }
        if (Input::get('wallet_to_id')) {
           Session::put('wallet_to_id', Input::get('wallet_to_id')); 
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
            $arItems[$k]->editPath = '/account/operations/'.$obItem->type.'/update/'.$obItem->id;
            $arItems[$k]->deletePath = '/account/operations/'.$obItem->type.'/delete/'.$obItem->id;
            $arItems[$k]->editTitle = $this->__getTitle('edit');
            $arItems[$k]->deleteTitle = $this->__getTitle('delete');
        }
        
        return $arItems;
    }
    
    /**
     * Apply table filter
     * 
     * @param Eloquent $dbRes query resource
     * 
     * @return Eloquent
     */    
    protected function __processFilter ($dbRes) {
        if (strlen(Input::get('date_from'))>0) {
            Session::put('date_from', Input::get('date_from'));
        } 
        
        if (strlen(Input::get('date_to'))>0) {
            Session::put('date_to', Input::get('date_to'));
        }
        if (strlen(Input::get('category_id'))>0) {
            Session::put('category_id', Input::get('category_id'));
        }
        
        
        if(strlen(Session::get('date_from'))>0) {
            $dateFrom = date("Y-m-d", strtotime(Session::get('date_from')));
            
            $dbRes->where('date', '>=', $dateFrom);
        } else {
            $dbRes->where('date', '>=', date('Y-m-01'));
        }
        
        if (strlen(Session::get('date_to'))>0) {
            $dateTo = date("Y-m-d", strtotime(Session::get('date_to')));
            
            $dbRes->where('date', '<=', $dateTo);
        } else {
            $dbRes->where('date', '<=', date('Y-m-d'));
        }
        
        if (strlen(Session::get('category_id'))>0 && intval(Session::get('category_id'))>0) {
            $categoryId = intval(Session::get('category_id'));
            
            $dbRes->where('category_id', '=', $categoryId);
        }
        
        return $dbRes;
    }

}
