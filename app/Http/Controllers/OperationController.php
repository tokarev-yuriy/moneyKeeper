<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\CrudListController;
use App\MoneyKeeper\Models\Category;
use App\MoneyKeeper\Models\Wallet;
use App\MoneyKeeper\Models\WalletGroup;
use App\MoneyKeeper\Models\Operation;
use View, Input, Session, Config, Request, Auth, Validator, Redirect;

/**
 *  CRUD controller for operations view and edit
 *
 *  @author   Yuriy Tokarev <yuriytok@gmail.com>
 */
class OperationController extends CrudListController {

    
    public $type='';
    public $arDictionaries;
    public $modelName = 'App\MoneyKeeper\Models\Operation';
    public $sort = array(
        'by' => 'date',
        'order' => 'desc'
    );

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->middleware('auth');
        parent::__construct();
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
            'wallets' => array(),
            'wallet_from_id' => array(),
            'wallet_to_id' => array(),
            'categories' => array(),
            'category_id' => array(),
            'category_id_icons' => array(),
            'category_icon' => array(),
            'type' => Category::getTypeVisualList(),
        );
        
        
        $arCategories = Category::user()->select('id', 'name', 'icon')->orderBy('sort')->get();
        $arIcons = Category::getCategoryIcons();
        foreach($arCategories as $arCategory) {
            $this->arDictionaries['categories'][$arCategory->id] = $arCategory;
            $this->arDictionaries['category_id'][$arCategory->id] = $arCategory->name;
            $this->arDictionaries['category_icon'][$arCategory->id] = '';
            if ($arCategory->icon && isset($arIcons[$arCategory->icon])) {
                $this->arDictionaries['category_icon'][$arCategory->id] = $arIcons[$arCategory->icon];
            }
            
            $this->arDictionaries['category_id_icons'][$arCategory->id] = (isset($arIcons[$arCategory->icon])?'<img src="'.$arIcons[$arCategory->icon].'" style="height: 20px; padding-right: 10px; margin-left: -5px;">':'').$arCategory->name;
        }
        
        $arWallets = Wallet::user()->select('id', 'name')->orderBy('sort')->get();
        foreach($arWallets as $arWallet) {
            $this->arDictionaries['wallets'][$arWallet->id] = $arWallet->name;
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
    public function postIndex($type = false)
    {
        return $this->getIndex($type);
    }
    
    /**
     * List of items
     * 
     * @return <type>
     */    
    public function getIndex($type = false)
    {
        $dbItems = Operation::user();
        if ($type) {
            $dbItems->where('type', '=', $type);
        }
        $dbItems = $this->__processFilter($dbItems);
        $arItems = $dbItems->
                orderBy($this->sort['by'],$this->sort['order'])->
                orderBy('id','desc')->
                paginate(Config::get('view.itemsPerPage'));
				
		$arDicts = $this->__getDictionary();
        
        if(Request::wantsJson()){
			
			
			foreach($arItems as $k=>$obItem) {
				$wallet = '';
				if ($obItem->type=='transfer') {
					$wallet = '';
					if (isset($arDicts['wallets'][$obItem->wallet_from_id])) {
						$wallet .= '<span class="text-secondary">'.$arDicts['wallets'][$obItem->wallet_from_id].'</span>';
					}
					$wallet .= '&nbsp;<i class="fa fa-arrow-right" aria-hidden="true"></i>&nbsp;';
					if (isset($arDicts['wallets'][$obItem->wallet_to_id])) {
						$wallet .= '<span class="text-success">'.$arDicts['wallets'][$obItem->wallet_to_id].'</span>';
					}
					$wallet .= '';
				} else {
					if (isset($arDicts['wallets'][$obItem->wallet_from_id])) {
						$wallet .= $arDicts['wallets'][$obItem->wallet_from_id];
					} elseif (isset($arDicts['wallets'][$obItem->wallet_to_id])) {
						$wallet .= $arDicts['wallets'][$obItem->wallet_to_id];
					}
				}
				
				$arItems[$k]->wallet = $wallet;
			}
            
            return [
                'operations' => $arItems,
                'header' => $this->__getHeads(),
                'actions' => $this->__getActions(),
                'filters' => $this->__getFilters(),
                'dicts' => $arDicts,
            ];
        }
        
        $arTable = array(
            'type' => $type,
            'items' => $arItems,
            'arItems' => $arItems,
            'arHeads' => $this->__getHeads(),
            'arActions' => $this->__getActions(),
            'arFilters' => $this->__getFilters(),
            'arDictionaries' => $arDicts
        );
        
        return view($this->__getView('index'), $arTable);
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
        
        $categories = [];
        $categories['spend'] = \App\MoneyKeeper\Models\Operation::getTypeCategories('spend', false);
        $categories['income'] = \App\MoneyKeeper\Models\Operation::getTypeCategories('income', false);
        $categories['transfer'] = \App\MoneyKeeper\Models\Operation::getTypeCategories('transfer', false);
		
		$wallets = [];
		$arWallets = [];
        $arWallets = \App\MoneyKeeper\Models\Operation::getWallets(false);
        
        $arWalletGroups = [];
        $obWalletGroups = \App\MoneyKeeper\Models\WalletGroup::user()->orderBy('sort','asc')->get();
        foreach($obWalletGroups as $k=>$obGroup) {
            $wallets[] = [
                'name' => $obGroup->name,
                'is_group' => true,
            ];
            foreach ($arWallets as $obWallet) {
                if ($obWallet->group_id == $obGroup->id) $wallets[] = $obWallet;
            }
        }
        $wallets[] = [
            'name' => trans('mkeep.wallet_group_others'),
            'is_group' => true,
        ];
        foreach ($arWallets as $k=>$obWallet) {
            if (!$obWallet->group_id) $wallets[] = $obWallet;
        }
        
        
        $model = $this->modelName;
        $obItem = $model::user()->find($id);
        
        if (!$obItem) {
            $obItem = [
                'type' => Input::get('type'),
                'date' => date("Y-m-d"),
                'wallet_from_id' => Session::get('wallet_from_id'),
                'wallet_to_id' => Session::get('wallet_to_id'),
            ];
            if (!in_array($obItem['type'], ['spend', 'income', 'transfer'])) $obItem['type'] = 'spend';
            
            $cat = current($categories[$obItem['type']]);
            $obItem['category_id'] = $cat->id;
            
            $wallet = current($arWallets);
            if (!$obItem['wallet_from_id']) $obItem['wallet_from_id'] = $wallet->id;
            if (!$obItem['wallet_to_id']) $obItem['wallet_to_id'] = $wallet->id;
        }
        
        return ['operation'=>$obItem, 'categories'=>$categories, 'wallets'=>$wallets];
    }

    /**
     * Process post
     * 
     * @return <type>
     */    
    public function postFilter()
    {
        $filterDate = [];
        $date = Input::get('date');
        if (isset($date['from']) && strlen($date['from'])>0) $filterDate['from'] = $date['from'];
        if (isset($date['to']) && strlen($date['to'])>0) $filterDate['to'] = $date['to'];
        Session::put('operation_filter_date', $filterDate);

        if (strlen(Input::get('category_id'))>0) {
            Session::put('operation_filter_category_id', Input::get('category_id'));
        }
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
              'type'=>'required|in:spend,transfer,income',
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
        if (!$this->arDictionaries) {
          $this->__loadDictionaries();
        }
        return array(
            'date'=>array(
                'title' => trans('mkeep.date'), 
                'code'  => 'date',
                'value' => Session::get('operation_filter_date'),
                'type'  => 'period',
            ), 
            'category_id'=>array(
                'title' => trans('mkeep.category'), 
                'code'  => 'category_id',
                'value' => (Session::get('operation_filter_category_id'))?Session::get('operation_filter_category_id'):0,
                'type'  => 'list',
                'values'=> array_replace(array('0'=>['id'=>'0', 'name'=>trans('mkeep.all_categories')]), $this->arDictionaries['categories'])
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
        $obItem->month = date('n', strtotime(Input::get('date')));
        $obItem->user_id = Auth::id();
        $obItem->type = Input::get('type');
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
     * Returns column titles of the list table
     * 
     * 
     * @return array (field=>title)
     */    
    protected function __getHeads () {
        return array(
                'date' => array('title'=>trans('mkeep.date')),
                'type' => array('title'=>trans('mkeep.type')),
                'wallet' => array('title'=>trans('mkeep.wallet')),
                'value' => array('title'=>trans('mkeep.summ')),
                'category_id' => array('title'=>trans('mkeep.category')),
                'comment' => array('title'=>trans('mkeep.comment')),
            );
    }
    
    /**
     * Apply table filter
     * 
     * @param Eloquent $dbRes query resource
     * 
     * @return Eloquent
     */    
    protected function __processFilter ($dbRes) {
        
        /* date */
        $filterDate = Session::get('operation_filter_date');
        if (!is_array($filterDate)) $filterDate = [];
        if (!isset($filterDate['from']) || !$filterDate['from']) $filterDate['from'] = date('Y-m-01');
        if (!isset($filterDate['to']) || !$filterDate['to']) $filterDate['to'] = date('Y-m-d');
        
        if(strlen($filterDate['from'])>0) {
            $dbRes->where('date', '>=', date("Y-m-d", strtotime($filterDate['from'])));
        }
        if (strlen($filterDate['to'])>0) {
            $dbRes->where('date', '<=', date("Y-m-d", strtotime($filterDate['to'])));
        }
        
        /* categoryId */
        if (strlen(Session::get('operation_filter_category_id'))>0 && intval(Session::get('operation_filter_category_id'))>0) {
            $dbRes->where('category_id', '=', intval(Session::get('operation_filter_category_id')));
        }
        
        return $dbRes;
    }

}
