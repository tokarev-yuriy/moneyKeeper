<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\CrudListController;
use App\MoneyKeeper\Models\Wallet;
use View, Input, Session, Config, Request, Auth, Validator, Redirect;

/**
 *  CRUD controller for wallet groups view and edit
 *
 *  @author   Yuriy Tokarev <yuriytok@gmail.com>
 */
class WalletGroupController extends CrudListController {

    public $modelName = '\App\MoneyKeeper\Models\WalletGroup';
    public $sort = array(
        'by' => 'sort',
        'order' => 'asc'
    );
    
    /**
     * Returns routes of CRUD operations
     * It has to be determined the path to the folowing pages:
     * index, update, delete and add
     * 
     * @return array
     */    
    protected function __getPaths () {
        return [
            'index' => '/account/wallets/groups',
            'update' => '/account/wallets/groups/update',
            'delete' => '/account/wallets/groups/delete',
            'add' => '/account/wallets/groups/add',
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
            'edit' => 'account.wallets.groups.edit',
            'form' => 'account.wallets.groups.edit_form',
            'index' => 'account.wallets.groups.index',
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
                'name' => trans('mkeep.name'),
                'sort' => trans('mkeep.sort'),
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
            'list' => trans('mkeep.wallets_groups'),
            'add'  => trans('mkeep.add_wallets_group'),
            'edit'  => trans('mkeep.edit_wallets_group'),
            'delete'  => trans('mkeep.delete_wallets_group')
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
              'name'=>'required|max:255',
              'sort'=>'required|numeric'
            );
    } 
    
    /**
     * Populate object with user's input
     * 
     * 
     * @return object
     */    
    protected function __populateItem ($obItem) {
        $obItem->name = Input::get('name');
        $obItem->sort = Input::get('sort');
        
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
        );
    }

}
