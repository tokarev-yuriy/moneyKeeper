<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\CrudListController;

/**
 *  CRUD controller for transfer operations view and edit
 *
 *  @author   Yuriy Tokarev <yuriytok@gmail.com>
 */
class TransferController extends OperationController {

    public $type = 'transfer';
       
    /**
     * Returns routes of CRUD operations
     * It has to be determined the path to the folowing pages:
     * index, update, delete and add
     * 
     * @return array
     */    
    protected function __getPaths () {
        return [
            'index' => '/account/operations/transfer',
            'update' => '/account/operations/transfer/update',
            'delete' => '/account/operations/transfer/delete',
            'add' => '/account/operations/transfer/add',
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
            'form' => 'account.operations.edit_transfer_form',
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
                'wallet' => trans('mkeep.wallet'),
                'value' => trans('mkeep.summ'),
                'category_id' => trans('mkeep.category'),
                'comment' => trans('mkeep.comment'),
            );
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
            $wallet = '';
            if ($this->arDictionaries['wallet_from_id'][$obItem->wallet_from_id]) {
                $wallet .= '<span class="text-secondary">'.$this->arDictionaries['wallet_from_id'][$obItem->wallet_from_id].'</span>';
            }
            $wallet .= '&nbsp;<i class="fa fa-arrow-right" aria-hidden="true"></i>&nbsp;';
            if ($this->arDictionaries['wallet_to_id'][$obItem->wallet_to_id]) {
                $wallet .= '<span class="text-success">'.$this->arDictionaries['wallet_to_id'][$obItem->wallet_to_id].'</span>';
            }
            $wallet .= '';
            
            $arItems[$k]->wallet = $wallet;
        }
        
        return $arItems;
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
            'list' => trans('mkeep.transfers'),
            'add'  => trans('mkeep.add_transfer'),
            'edit'  => trans('mkeep.edit_transfer'),
            'delete'  => trans('mkeep.delete_transfer')
        ];
    }

}
