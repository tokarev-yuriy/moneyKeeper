<?php


/**
 *  CRUD controller for income operations view and edit
 *
 *  @author   Yuriy Tokarev <yuriytok@gmail.com>
 */
class IncomeController extends OperationController {


    public $type = 'income';

    /**
     * Returns routes of CRUD operations
     * It has to be determined the path to the folowing pages:
     * index, update, delete and add
     * 
     * @return array
     */    
    protected function __getPaths () {
        return [
            'index' => '/account/operations/income',
            'update' => '/account/operations/income/update',
            'delete' => '/account/operations/income/delete',
            'add' => '/account/operations/income/add',
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
            'form' => 'account.operations.edit_income_form',
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
                'wallet_to_id' => trans('mkeep.wallet'),
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
            'list' => trans('mkeep.incomes'),
            'add'  => trans('mkeep.add_income'),
            'edit'  => trans('mkeep.edit_income'),
            'delete'  => trans('mkeep.delete_income')
        ];
    }

}
