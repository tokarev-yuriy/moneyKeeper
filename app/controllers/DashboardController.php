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
	public function anyIndex($walletId = null)
	{
        
        $dbOperations = Operation::user();
        
        $dbOperations = $this->__processFilter($dbOperations);
        
        if ($walletId>0) {
            $dbOperations->where(function($query) use ($walletId)
            {
                $query->where('wallet_from_id', '=', $walletId)
                      ->orWhere('wallet_to_id', '=', $walletId);
            });
        }
        
        $arOperations = $dbOperations->
                orderBy('date','desc')->
                orderBy('id','desc')->
                paginate(Config::get('view.itemsPerPage'));
                
        $arDicts = array(
            'wallets' => array(),
            'category_id' => array(),
            'type' => Category::getTypeVisualList(),
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
                $wallet = '';
                if (isset($arDicts['wallets'][$obItem->wallet_from_id])) {
                    $wallet .= '<span class="text-secondary">'.$arDicts['wallets'][$obItem->wallet_from_id].'</span>';
                }
                $wallet .= '&nbsp;<i class="fa fa-arrow-right" aria-hidden="true"></i>&nbsp;';
                if (isset($arDicts['wallets'][$obItem->wallet_to_id])) {
                    $wallet .= '<span class="text-success">'.$arDicts['wallets'][$obItem->wallet_to_id].'</span>';
                }
                $wallet .= '';
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
            'arFilters' => array('date'=>array('title'=>trans('mkeep.date'), 'type'=>'period'), 'category_id'=>array('title'=>trans('mkeep.category'), 'type'=>'list', 'values'=>array_merge(array(''=>trans('mkeep.all_categories')), $arDicts['category_id']))),
            'arDictionaries' => $arDicts
        );
        
        return View::make('dashboard', array('items'=>$arOperations))->nest('tablegrid', 'widgets.cardgroup', $arTable);
	}
    
    /**
     * Apply table filter
     * 
     * @param Eloquent $dbRes query resource
     * 
     * @return Eloquent
     */    
    protected function __processFilter ($dbRes) {
        
        if (strlen(Input::get('date_from'))>0) {
            Session::put('date_from', Input::get('date_from'));
        } 
        
        if (strlen(Input::get('date_to'))>0) {
            Session::put('date_to', Input::get('date_to'));
        }
        if (strlen(Input::get('category_id'))>0 && intval(Input::get('category_id'))>0) {
            Session::put('category_id', Input::get('category_id'));
        }
        
        if (strlen(Session::get('date_from'))>0) {
            $dateFrom = date("Y-m-d", strtotime(Session::get('date_from')));
            
            $dbRes->where('date', '>=', $dateFrom);
        } else {
            $dbRes->where('date', '>=', date('Y-m-01'));
        }
        
        if (strlen(Session::get('date_to'))>0) {
            $dateTo = date("Y-m-d", strtotime(Session::get('date_to')));
            
            $dbRes->where('date', '<=', $dateTo);
        } else {
            $dbRes->where('date', '<=', date('Y-m-d'));
        }
        
        if (strlen(Session::get('category_id'))>0 && intval(Session::get('category_id'))>0) {
            $categoryId = intval(Session::get('category_id'));
            
            $dbRes->where('category_id', '=', $categoryId);
        }
        
        return $dbRes;
    }

}
