<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\CrudListController;
use App\MoneyKeeper\Models\Wallet;
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
                'color' => array('title'=>trans('mkeep.color'), 'type'=>'color'),
                'icon' => array('title'=>trans('mkeep.icon'), 'type'=>'icon'),
                'group_id' => trans('mkeep.wallet_group'),
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
              'color'=>'required|in:'.implode(',',array_keys(Wallet::getColorList())),
              'icon'=>'in:'.implode(',',array_keys(Wallet::getWalletIcons())),
              'group_id'=>'in:'.implode(',',array_keys(Wallet::getWalletGroups())),
              'active'=>'bool',
            );
    }
    
    /**
     * List of items
     * 
     * @return <type>
     */    
    public function getIndex()
    {
        if(Request::wantsJson()){
            $dbItems = Wallet::user();
            $arItems = $dbItems->
                    orderBy($this->sort['by'],$this->sort['order'])->
                    orderBy('id','desc')->
                    get();

            return [
                'wallets' => $arItems,
                'groups' => Wallet::getWalletGroups()
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
            $obItem = ['sort'=>10, 'start'=>0, 'active' => true];
        }
        $obItem['active'] = $obItem['active']?true:false;
        
        $arIcons = [];
        foreach(Wallet::getWalletIcons() as $icon=>$iconTitle) {
            $arIcons[] = [
                'id' => $icon,
                'icon' => $icon,
                'name' => '',
            ];
        }
        $arColors = [];
        foreach(Wallet::getColorList() as $color=>$colorTitle) {
            $arColors[] = [
                'id' => $color,
                'color' => $color,
                'name' => '',
            ];
        }
        
        return ['wallet'=>$obItem, 'groups'=>\App\MoneyKeeper\Models\WalletGroup::user()->orderBy('sort','asc')->get(), 'icons'=>$arIcons, 'colors'=>$arColors];
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
        $obItem->icon = Input::get('icon');
        $obItem->color = Input::get('color');
        $obItem->group_id = intval(Input::get('group_id'));
        $obItem->active = Input::get('active')?1:0;
        
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
            'icon'=>Wallet::getWalletIcons(),
            'group_id'=>Wallet::getWalletGroups()
        );
    }

}
