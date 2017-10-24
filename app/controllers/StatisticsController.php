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

}
