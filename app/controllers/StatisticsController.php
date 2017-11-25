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
    
    
    /**
     * Show monthly stat widgets
     * 
     * 
     * @return <type>
     */	
	public function getMonth()
	{
        return View::make('account.stats.month');
	}
    
    /**
     * Show monthly stat widgets
     * 
     * 
     * @return <type>
     */	
	public function getMonthavg()
	{
        return View::make('account.stats.monthavg');
	}
    
    /**
     * Show year stat widgets
     * 
     * 
     * @return <type>
     */	
	public function getYear()
	{
        return View::make('account.stats.year');
	}
    
    /**
     * Show year stat widgets
     * 
     * 
     * @return <type>
     */	
	public function getYearavg()
	{
        return View::make('account.stats.yearavg');
	}
    
    
    /**
     * Get data for area chart by month
     * 
     * 
     * @return <type>
     */	
	public function getMonthtotal()
	{
        return json_encode(array_values($this->__getStatByPeriod('month', 'type', 'any')));
	}
    
    /**
     * Get data for area chart of incomes by category
     * 
     * 
     * @return <type>
     */	
	public function getMonthincome()
	{
        return json_encode(array_values($this->__getStatByPeriod('month', 'category_id', 'income')));
	}
    
    /**
     * Get data for area chart of spends by category
     * 
     * 
     * @return <type>
     */	
	public function getMonthspend()
	{
        return json_encode(array_values($this->__getStatByPeriod('month', 'category_id', 'spend')));
	}
    
    /**
     * Get data for area chart by year
     * 
     * 
     * @return <type>
     */	
	public function getYeartotal()
	{
        return json_encode(array_values($this->__getStatByPeriod('year', 'type', 'any')));
	}
    
    /**
     * Get data for area chart of incomes by category
     * 
     * 
     * @return <type>
     */	
	public function getYearincome()
	{
        return json_encode(array_values($this->__getStatByPeriod('year', 'category_id', 'income')));
	}
    
    /**
     * Get data for area chart of spends by category
     * 
     * 
     * @return <type>
     */	
	public function getYearspend()
	{
        return json_encode(array_values($this->__getStatByPeriod('year', 'category_id', 'spend')));
	}
    
    
    /**
     * Get data for pie chart of incomes by category
     * 
     * 
     * @return <type>
     */	
	public function getMonthavgincome()
	{
        return json_encode(array_values($this->__getStatAvg('month','income')));
	}
    
    /**
     * Get data for pie chart of spends by category
     * 
     * 
     * @return <type>
     */	
	public function getMonthavgspend()
	{
        return json_encode(array_values($this->__getStatAvg('month', 'spend')));
	}
    
    /**
     * Get data for pie chart of incomes by category
     * 
     * 
     * @return <type>
     */	
	public function getYearavgincome()
	{
        return json_encode(array_values($this->__getStatAvg('year','income')));
	}
    
    /**
     * Get data for pie chart of spends by category
     * 
     * 
     * @return <type>
     */	
	public function getYearavgspend()
	{
        return json_encode(array_values($this->__getStatAvg('year','spend')));
	}
    
    /**
     * Get data for area chart
     * 
     * 
     * @return <type>
     */	
	protected function __getStatByPeriod($period="month", $field="type", $type="any")
	{
        
        $dbOperations = Operation::select(DB::raw('value, year, month, '.$field))->
                user();
                
        if ($type!='any') {
            $dbOperations->where('type','=',$type);
        }
                       
        $arOperations = $dbOperations->
                orderBy('year', 'asc')->
                orderBy('month', 'asc')->
                get();
        $arCategories = array();
        $arOperationsSum = array();        
        foreach ($arOperations as $obOperation) {
            if ($period=='year') {
                $obOperation->month = 1;
            }
            $date = $obOperation->year.'-'.(($obOperation->month >= 10)?$obOperation->month:'0'.$obOperation->month).'-01';
            if (!isset($arOperationsSum[$date])) {
                $arOperationsSum[$date] = array('date'=>$date);
            }
            $fieldName = $field.'_'.$obOperation->$field;
            if (!isset($arOperationsSum[$date][$fieldName])) {
                $arOperationsSum[$date][$fieldName] = 0;
            }
            $arOperationsSum[$date][$fieldName] += $obOperation->value;
            $arCategories[$fieldName] = $fieldName;
        }
        

        foreach ($arOperationsSum as $date=>$arGroups) {
            foreach ($arCategories as $fieldName) {
                if (!isset($arGroups[$fieldName])) {
                    $arOperationsSum[$date][$fieldName] = 0;
                }
            }
        }
        
        return $arOperationsSum;
	}
    
    /**
     * Get data for pie chart
     * 
     * 
     * @return <type>
     */	
	protected function __getStatAvg($period="month", $type="any")
	{
        
        $arCategories = Operation::getTypeCategories($type);
        
        $dbOperations = Operation::select(DB::raw('value, year, month, category_id'))->
                user();
                
        if ($type!='any') {
            $dbOperations->where('type','=',$type);
        }
                       
        $arOperations = $dbOperations->
                orderBy('year', 'asc')->
                orderBy('month', 'asc')->
                get();

        $arPeriods = array();
        $arOperationsSum = array();        
        foreach ($arOperations as $obOperation) {
            if ($period=='year') {
                $obOperation->month = 1;
            }
            $date = $obOperation->year.'-'.(($obOperation->month >= 10)?$obOperation->month:'0'.$obOperation->month).'-01';
            
            $arPeriods[$date] = $date;
            
            if (!isset($arOperationsSum[$obOperation->category_id])) {
                if (!isset($arCategories[$obOperation->category_id])) {
                    $arCategories[$obOperation->category_id] = $obOperation->category_id;
                }
                $arOperationsSum[$obOperation->category_id] = array('sum'=>0, 'name'=>$arCategories[$obOperation->category_id]);
            }
            $arOperationsSum[$obOperation->category_id]['sum'] += $obOperation->value;
        }
        if (count($arPeriods)>0) {
            foreach($arOperationsSum as $categoryId=>$arValue) {
                $arOperationsSum[$categoryId]['sum'] /= count($arPeriods);
                $arOperationsSum[$categoryId]['sum'] = round($arOperationsSum[$categoryId]['sum']);
            }
        }
        
        return $arOperationsSum;
	}
    
    /**
     * Get data for categories progress
     * 
     * 
     * @return <type>
     */	
	public function getProgress()
	{
        
        $arCategories = Category::user()->whereIn('type', array('any', 'spend'))->orderBy('sort','asc')->get();
        $dbOperations = Operation::select(DB::raw('sum(value) as sum, category_id'))->
                user();
                
        $dbOperations->where('type', '=', 'spend');
        $dbOperations->where('date', '>=', date('Y-m-01'));
        $dbOperations->where('date', '<=', date('Y-m-d'));
        
        $arOperations = $dbOperations->
                groupBy('category_id')->
                get();
        
        $arCategoriesSum = array();        
        foreach ($arOperations as $obOperation) {
            $arCategoriesSum[$obOperation->category_id] = array('sum'=>$obOperation->sum, 'plan'=>0);
        }
        
        $dbPlans = Plan::select(DB::raw('sum(value) as sum, category_id'))->
                user();
        $arPlans = $dbPlans->
                groupBy('category_id')->
                get();
                
        foreach ($arPlans as $obPlan) {
            if (!isset($arCategoriesSum[$obPlan->category_id])) {
                $arCategoriesSum[$obPlan->category_id] = array('sum'=>0);
            }
            $arCategoriesSum[$obPlan->category_id]['plan'] = $obPlan->sum;
        }
                
        
        foreach ($arCategories as $k=>$obCategory) {
            if (!isset($arCategoriesSum[$obCategory->id])) {
                $arCategoriesSum[$obCategory->id] = array('sum'=>0, 'plan'=>0);
            }
            $arCategoriesSum[$obCategory->id]['name'] = $obCategory->name;
            $arCategoriesSum[$obCategory->id]['progress'] = 100;
            if ($arCategoriesSum[$obCategory->id]['plan']>0) {
                $arCategoriesSum[$obCategory->id]['progress'] = 100*$arCategoriesSum[$obCategory->id]['sum'] / $arCategoriesSum[$obCategory->id]['plan'];
            }
        }
        
        return View::make('account.stats.progress', array('arItems'=>$arCategoriesSum));
	}

}
