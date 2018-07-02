<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\CrudListController;
use View, Input, Session, Config, Request, Auth, Validator, Redirect;

/**
 *  CRUD controller for wallets view and edit
 *
 *  @author   Yuriy Tokarev <yuriytok@gmail.com>
 */
class WalletController extends CrudListController {

    public $modelName = '\App\MoneyKeeper\Models\Wallet';
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
            'index' => '/account/wallets',
            'update' => '/account/wallets/update',
            'delete' => '/account/wallets/delete',
            'add' => '/account/wallets/add',
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
            'edit' => 'account.wallets.edit',
            'form' => 'account.wallets.edit_form',
            'index' => 'account.wallets.index',
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
                'start' => trans('mkeep.start'),
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
            'list' => trans('mkeep.wallets'),
            'add'  => trans('mkeep.add_wallet'),
            'edit'  => trans('mkeep.edit_wallet'),
            'delete'  => trans('mkeep.delete_wallet')
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
              'start'=>'required|numeric',
              'sort'=>'required|numeric',
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
        $obItem->start = Input::get('start');
        $obItem->sort = Input::get('sort');
        $obItem->user_id = Auth::id();
        
        return $obItem;
    }

}
