<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\CrudListController;

/**
 *  CRUD controller for spend operations view and edit
 *
 *  @author   Yuriy Tokarev <yuriytok@gmail.com>
 */
class SpendController extends OperationController {


    public $type='spend';
    
    /**
     * Returns routes of CRUD operations
     * It has to be determined the path to the folowing pages:
     * index, update, delete and add
     * 
     * @return array
     */    
    protected function __getPaths () {
        return [
            'index' => '/account/operations/spend',
            'update' => '/account/operations/spend/update',
            'delete' => '/account/operations/spend/delete',
            'add' => '/account/operations/spend/add',
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
            'form' => 'account.operations.edit_spend_form',
            'index' => 'account.operations.index',
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
                'date' => trans('mkeep.date'),
                'wallet_from_id' => trans('mkeep.wallet'),
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
            'list' => trans('mkeep.spends'),
            'add'  => trans('mkeep.add_spend'),
            'edit'  => trans('mkeep.edit_spend'),
            'delete'  => trans('mkeep.delete_spend')
        ];
    }

}
