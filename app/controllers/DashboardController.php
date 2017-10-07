<?php


/**
 *  Dashboard controller
 *
 *  @author   Yuriy Tokarev <yuriytok@gmail.com>
 */
class DashboardController extends BaseController {

    /**
     * Only authorized users allowed
     * 
     * 
     * @return <type>
     */
    public function __construct()
    {
        $this->beforeFilter('auth');
    }

    /**
     * Get table of all last operations
     * 
     * 
     * @return <type>
     */	
	public function getIndex()
	{
        
        $arOperations = Operation::user()->
                orderBy('date','desc')->
                get();
                
        $arDicts = array(
            'wallets' => array(),
            'category_id' => array(),
            'type' => Category::getTypeList(),
        );
        
        
        $arCategories = Category::user()->select('id', 'name')->orderBy('sort')->get();
        foreach($arCategories as $arCategory) {
            $arDicts['category_id'][$arCategory->id] = $arCategory->name;
        }
        
        $arWallets = Wallet::user()->select('id', 'name')->orderBy('sort')->get();
        foreach($arWallets as $arWallet) {
            $arDicts['wallets'][$arWallet->id] = $arWallet->name;
        }
        
        foreach($arOperations as $k=>$obItem) {
            $wallet = '';
            if ($obItem->type=='transfer') {
                $wallet = '<div class="text-center float-left">';
                if (isset($arDicts['wallets'][$obItem->wallet_from_id])) {
                    $wallet .= '<span class="text-secondary">'.$arDicts['wallets'][$obItem->wallet_from_id].'</span>';
                }
                $wallet .= '<br/><i class="fa fa-arrow-down" aria-hidden="true"></i>';
                if (isset($arDicts['wallets'][$obItem->wallet_to_id])) {
                    $wallet .= '<br/><span class="text-success">'.$arDicts['wallets'][$obItem->wallet_to_id].'</span>';
                }
                $wallet .= '</div>';
            } else {
                if (isset($arDicts['wallets'][$obItem->wallet_from_id])) {
                    $wallet .= $arDicts['wallets'][$obItem->wallet_from_id];
                } elseif (isset($arDicts['wallets'][$obItem->wallet_to_id])) {
                    $wallet .= $arDicts['wallets'][$obItem->wallet_to_id];
                }
            }
            
            $arOperations[$k]->wallet = $wallet;
            $arOperations[$k]->editPath = '/account/operations/'.$obItem->type.'/update/'.$obItem->id;
            $arOperations[$k]->deletePath = '/account/operations/'.$obItem->type.'/delete/'.$obItem->id;
            $arOperations[$k]->editTitle = trans('mkeep.edit_operation');
            $arOperations[$k]->deleteTitle = trans('mkeep.delete_operation');
        }
        
        $arTable = array(
            'arItems' => $arOperations,
            'arHeads' => array(
                'date' => array('title'=>trans('mkeep.date')),
                'type' => array('title'=>trans('mkeep.type')),
                'wallet' => array('title'=>trans('mkeep.wallet')),
                'value' => array('title'=>trans('mkeep.summ')),
                'category_id' => array('title'=>trans('mkeep.category')),
                'comment' => array('title'=>trans('mkeep.comment')),
            ),
            'arActions' => array('edit', 'delete'),
            'arDictionaries' => $arDicts
        );
        
        return View::make('dashboard', array('items'=>$arOperations))->nest('tablegrid', 'widgets.tablegrid', $arTable);
	}

}
