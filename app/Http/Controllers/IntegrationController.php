<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\CrudListController;
use App\MoneyKeeper\Models\Wallet;
use View, Input, Session, Config, Request, Auth, Validator, Redirect;

/**
 *  CRUD controller for integrations view and edit
 *
 *  @author   Yuriy Tokarev <yuriytok@gmail.com>
 */
class IntegrationController extends CrudListController {

    public $modelName = '\App\MoneyKeeper\Models\Integration';
    public $sort = array(
        'by' => 'type',
        'order' => 'asc'
    );
    
    
    /**
     * List of transactions
     * 
     * @return <type>
     */    
    public function getSync($id)
    {
        $model = $this->modelName;
        $obItem = $model::user()->find($id);
        if (!$obItem) {
            return Redirect::to($this->__getPath('index'));
        }
        if ($obItem->type=='tinkoff') {
			$obSync = new \App\MoneyKeeper\Integration\Tinkoff($obItem);
		}
		if ($obSync) {
            if(Request::wantsJson()){
                $messages = [];
                $arTransactions = [];
                try {
                    $arTransactions = $obSync->getTransactions();               
                } catch(\Exception $e) {
                    $messages[] = $e->getMessage();
                }
                
                
                return ['errors'=>$messages, 'transactions'=>$arTransactions, 'walletId'=>$obItem->wallet_id, 'syncId'=>$obItem->id];
            }
            
            return view('account.import.integration.sync', ['walletId'=>$obItem->wallet_id, 'syncId'=>$obItem->id]);
		}
        
		return Redirect::to($this->__getPath('index'));
    }
	
	/**
     * Save transactions
     * 
     * @return <type>
     */    
    public function postSync($id)
    {
        $model = $this->modelName;
        $obItem = $model::user()->find($id);
        if (!$obItem) {
            return Redirect::to($this->__getPath('index'));
        }
        if ($obItem->type=='tinkoff') {
			$obSync = new \App\MoneyKeeper\Integration\Tinkoff($obItem);
		}
		if ($obSync) {
			$obSync->saveTransactions();
			return Redirect::to('/');
		}
        
		return Redirect::to($this->__getPath('index'));
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
            'index' => '/account/import/integration',
            'update' => '/account/import/integration/update',
            'delete' => '/account/import/integration/delete',
            'add' => '/account/import/integration/add',
            'sync' => '/account/import/integration/sync',
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
            'edit' => 'account.import.integration.edit',
            'form' => 'account.import.integration.edit_form',
            'index' => 'account.import.integration.index',
            'sync' => 'account.import.integration.sync',
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
                'type' => trans('mkeep.type'),
                'last_sync' => trans('mkeep.last_sync'),
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
            'list' => trans('mkeep.integrations'),
            'add'  => trans('mkeep.add_integration'),
            'edit'  => trans('mkeep.edit_integration'),
            'delete'  => trans('mkeep.delete_integration')
        ];
    }
    
    /**
     * Returns validators for add and edit operation
     * 
     * 
     * @return array
     */    
    protected function __getValidators () {
        return array(
            );
    } 
    
    /**
     * Populate object with user's input
     * 
     * 
     * @return object
     */    
    protected function __populateItem ($obItem) {
        $obItem->type = Input::get('type');
        $obItem->wallet_id = Input::get('wallet_id');
        $obItem->params = json_encode(Input::get('params'));
        $obItem->category_rules = json_encode(Input::get('category_rules'));
        $obItem->last_sync = date("Y-m-d H:i:s");
        
        $obItem->user_id = Auth::id();
        
        return $obItem;
    }
    
    /**
     * Returns dictionaries for enum type fields
     * 
     * 
     * @return array (field=>array(code=>title))
     */      
    protected function __getDictionary () {
        return array(
            'types' => ['tinkoff'=>['name'=>'Tinkoff']]
        );
    }
	
	/**
     * Returns avail table actions
     * 
     * 
     * @return array possible values: edit and delete
     */    
    protected function __getActions () {
        return array('edit', 'delete', 'sync');
    }

    /**
     * Preparing the object fields to display in the table
     * 
     * @param array $arItems 
     * 
     * @return array
     */
    protected function __prepareItems($arItems) {
        $arItems = parent::__prepareItems($arItems);
        foreach($arItems as $k=>$obItem) {
            $arItems[$k]->syncPath = $this->__getPath('sync').'/'.$obItem->id;
        }
        
        return $arItems;
    }

}
