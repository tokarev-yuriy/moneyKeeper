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
        if(Request::wantsJson()){
            $dbItems = Operation::user();
            if ($type) {
                $dbItems->where('type', '=', $type);
            }
            $dbItems = $this->__processFilter($dbItems);
            $arItems = $dbItems->
                    orderBy($this->sort['by'],$this->sort['order'])->
                    orderBy('id','desc')->
                    paginate(Config::get('view.itemsPerPage'));

            return [
                'operations' => $arItems,
                'filters' => $this->__getFilters(),
            ];
        }

        return view($this->__getView('index'), ['type'=>$type]);
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
            if (Input::get('category_id')) $obItem['category_id'] = Input::get('category_id');
        }
        
        return ['operation'=>$obItem, 'wallets'=>$wallets];
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
              'category_id'=>'required|numeric',
              'wallet_from_id' => 'required_if:type,spend,transfer',
              'wallet_to_id' => 'required_if:type,income,transfer',
              'type'=>'required|in:spend,transfer,income',
              //'comment'=>'required|max:255',
              'date'=>'required|date',
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
        if ($obItem->type=='income') {
            $obItem->wallet_from_id = 0;
        } else {
            $obItem->wallet_from_id = intval(Input::get('wallet_from_id'));
        }
        if ($obItem->type=='spend') {
            $obItem->wallet_to_id = 0;
        } else {
            $obItem->wallet_to_id = intval(Input::get('wallet_to_id'));
        }
        
        if (Input::get('wallet_from_id')) {
           Session::put('wallet_from_id', Input::get('wallet_from_id')); 
        }
        if (Input::get('wallet_to_id')) {
           Session::put('wallet_to_id', Input::get('wallet_to_id')); 
        }
        
        return $obItem;
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
        else $filterDate['from'] = date('Y-m-01');
        
        if (isset($date['to']) && strlen($date['to'])>0) $filterDate['to'] = $date['to'];
        else $filterDate['to'] = date('Y-m-d');
        
        Session::put('operation_filter_date', $filterDate);

        if (is_array(Input::get('category_id'))) {
            Session::put('operation_filter_category_id', Input::get('category_id'));
        }
        
        if (is_array(Input::get('wallet_id'))) {
            Session::put('operation_filter_wallet_id', Input::get('wallet_id'));
        }
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
        if (is_array(Session::get('operation_filter_category_id')) && count(Session::get('operation_filter_category_id'))) {
            $dbRes->whereIn('category_id', Session::get('operation_filter_category_id'));
        }
        
        /* walletId */
        if (is_array(Session::get('operation_filter_wallet_id')) && count(Session::get('operation_filter_wallet_id'))) {
            $dbRes->where(function ($q) {
                $q->whereIn('wallet_from_id', Session::get('operation_filter_wallet_id'));
                $q->orWhereIn('wallet_to_id', Session::get('operation_filter_wallet_id'));
            });
        }
        
        return $dbRes;
    }
    
        
    /**
     * Returns Filters for operations table
     * 
     * 
     * @return array
     */    
    protected function __getFilters () {
        $filterDate = Session::get('operation_filter_date');
        if (!is_array($filterDate)) $filterDate = [];
        if (!isset($filterDate['from']) || !$filterDate['from']) $filterDate['from'] = date('Y-m-01');
        if (!isset($filterDate['to']) || !$filterDate['to']) $filterDate['to'] = date('Y-m-d');
        
        return array(
            'date'=>array(
                'title' => trans('mkeep.date'), 
                'code'  => 'date',
                'value' => $filterDate,
                'type'  => 'period',
            ), 
            'category_id'=>array(
                'title' => trans('mkeep.categories'), 
                'code'  => 'category_id',
                'value' => (Session::get('operation_filter_category_id'))?Session::get('operation_filter_category_id'):0,
                'type'  => 'list',
                'values'=> \App\MoneyKeeper\Helpers\Dictionary::getCategories()
            ),
            'wallet_id'=>array(
                'title' => trans('mkeep.wallets'), 
                'code'  => 'wallet_id',
                'value' => (Session::get('operation_filter_wallet_id'))?Session::get('operation_filter_wallet_id'):0,
                'type'  => 'list',
                'values'=> \App\MoneyKeeper\Helpers\Dictionary::getWallets()
            )
        );
    } 

}