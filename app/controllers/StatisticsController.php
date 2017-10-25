<?php


/**
 *  Statistics controller
 *
 *  @author   Yuriy Tokarev <yuriytok@gmail.com>
 */
class StatisticsController extends BaseController {

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
     * Get current value for each wallet
     * 
     * 
     * @return <type>
     */	
	public function getWallets()
	{
        
        $arWallets = Wallet::user()->orderBy('sort','asc')->get();
        $arDbIncomes = Operation::select(DB::raw('sum(value) as sum, wallet_to_id'))->
                user()->
                groupBy('wallet_to_id')->
                get();
        $arIncomes = array();        
        foreach ($arDbIncomes as $obIncome) {
            $arIncomes[$obIncome->wallet_to_id] = $obIncome->sum;
        }
                
        $arDbSpends = Operation::select(DB::raw('sum(value) as sum, wallet_from_id'))->
                user()->
                groupBy('wallet_from_id')->
                get();
        $arSpends = array();
        foreach ($arDbSpends as $obSpend) {
            $arSpends[$obSpend->wallet_from_id] = $obSpend->sum;
        }
        
        foreach ($arWallets as $k=>$obWallet) {
            $obWallet->value = $obWallet->start;
            if (isset($arIncomes[$obWallet->id])) {
                $obWallet->value += $arIncomes[$obWallet->id];
            }
            if (isset($arSpends[$obWallet->id])) {
                $obWallet->value -= $arSpends[$obWallet->id];
            }
            
            $arWallets[$k] = $obWallet;
        }
        
        return View::make('account.stats.wallets', array('arItems'=>$arWallets));
	}
    
    
    /**
     * Get data for pie chart of concreate  operation type
     * 
     * 
     * @return <type>
     */	
	public function getCategories($type = 'spend')
	{
        
        $arCategories = Category::user()->orderBy('sort','asc')->get();
        $dbOperations = Operation::select(DB::raw('sum(value) as sum, category_id'))->
                user();
                
        if (in_array($type, array('spend', 'transfer', 'income'))) {
            $dbOperations->where('type', '=', $type);
        }
        $dbOperations = $this->__processFilter($dbOperations);
        
        $arOperations = $dbOperations->
                groupBy('category_id')->
                get();
        
        $arCategoriesSum = array();        
        foreach ($arOperations as $obOperation) {
            $arCategoriesSum[$obOperation->category_id] = array('sum'=>$obOperation->sum);
        }
                
        
        foreach ($arCategories as $k=>$obCategory) {
            if (isset($arCategoriesSum[$obCategory->id]) && $arCategoriesSum[$obCategory->id]['sum']>0) {
                $arCategoriesSum[$obCategory->id]['name'] = $obCategory->name;
            }
        }
        
        return json_encode(array_values($arCategoriesSum));
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
            $dateFrom = date("Y-m-d", strtotime(Input::get('date_from')));
            
            $dbRes->where('date', '>=', $dateFrom);
        } else {
            $dbRes->where('date', '>=', date('Y-m-01'));
        }
        
        if (strlen(Input::get('date_to'))>0) {
            $dateTo = date("Y-m-d", strtotime(Input::get('date_to')));
            
            $dbRes->where('date', '<=', $dateTo);
        } else {
            $dbRes->where('date', '<=', date('Y-m-d'));
        }
        
        if (strlen(Input::get('category_id'))>0 && intval(Input::get('category_id'))>0) {
            $categoryId = intval(Input::get('category_id'));
            
            $dbRes->where('category_id', '=', $categoryId);
        }
        
        return $dbRes;
    }

}
