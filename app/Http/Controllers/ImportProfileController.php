<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\CrudListController;
use App\MoneyKeeper\Models\Category;
use App\MoneyKeeper\Models\Wallet;
use App\MoneyKeeper\Models\Operation;
use View, Input, Session, Config, Request, Auth, Validator, Redirect;

/**
 *  CRUD controller for import profiles view and edit
 *
 *  @author   Yuriy Tokarev <yuriytok@gmail.com>
 */
class ImportProfileController extends CrudListController {

    public $modelName = '\App\MoneyKeeper\Models\ImportProfile';
    public $sort = array(
        'by' => 'name',
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
            'index' => '/account/import/profile',
            'update' => '/account/import/profile/update',
            'delete' => '/account/import/profile/delete',
            'add' => '/account/import/profile/add',
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
            'edit' => 'account.import.profile.edit',
            'form' => 'account.import.profile.edit_form',
            'index' => 'account.import.profile.index',
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
            'list' => trans('mkeep.import_profiles'),
            'add'  => trans('mkeep.add_import_profile'),
            'edit'  => trans('mkeep.edit_import_profile'),
            'delete'  => trans('mkeep.delete_import_profile')
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
        $obItem->encoding = Input::get('encoding');
        $obItem->start_row = Input::get('start_row');
        $obItem->control_row = Input::get('control_row');
        $obItem->control_string = Input::get('control_string');
        $obItem->date_col = Input::get('date_col');
        $obItem->summ_col = Input::get('summ_col');
        $obItem->category_col = Input::get('category_col');
        $obItem->desc_col = Input::get('desc_col');
        $obItem->category_rules = serialize(Input::get('category_rules'));
        
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
        
        $arDictCategories = array();
        $arCategories = Category::user()->select('id', 'name', 'icon')->orderBy('sort')->get();
        $arIcons = Category::getCategoryIcons();
        foreach($arCategories as $arCategory) {
            $arDictCategories[$arCategory->id] = $arCategory;
        }
        
        return array(
            'categories'=>$arDictCategories,
            'type'=>Category::getTypeList(),
            'icon'=>$arIcons
        );
    }

}
