<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CrudListController;
use App\MoneyKeeper\Models\Category;
use App\MoneyKeeper\Models\Wallet;
use App\MoneyKeeper\Models\WalletGroup;
use App\MoneyKeeper\Models\Operation;
use App\MoneyKeeper\Models\Plan;
use View, Input, Session, Config, Request, Auth, Validator, Redirect, DB;

/**
 *  Statistics controller
 *
 *  @author   Yuriy Tokarev <yuriytok@gmail.com>
 */
class StatisticsController extends Controller {

    /**
     * Only authorized users allowed
     * 
     * 
     * @return <type>
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Get current value for each wallet
     * 
     * 
     * @return <type>
     */	
	public function getWallets()
	{
        
        $arWallets = Wallet::user()->where('active', 1)->orderBy('sort','asc')->get();
       
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
        
        $arIcons = Wallet::getWalletIcons();
        foreach ($arWallets as $k=>$obWallet) {
            $obWallet->value = $obWallet->start;
            if (isset($arIncomes[$obWallet->id])) {
                $obWallet->value += $arIncomes[$obWallet->id];
            }
            if (isset($arSpends[$obWallet->id])) {
                $obWallet->value -= $arSpends[$obWallet->id];
            }
            
            if ($obWallet->icon && isset($arIcons[$obWallet->icon])) {
                $obWallet->icon = $arIcons[$obWallet->icon];
            } else {
                $obWallet->icon = false;
            }
            
            $arWallets[$k] = $obWallet;
        }
        
        $arWalletGroups = [];
        $obWalletGroups = WalletGroup::user()->orderBy('sort','asc')->get();
        foreach($obWalletGroups as $k=>$obGroup) {
            $arWalletGroups[$k] = [
                'name' => $obGroup->name,
                'summ' => 0,
                'items' => [],
            ];
            foreach ($arWallets as $obWallet) {
                if ($obWallet->group_id == $obGroup->id) {
                    $arWalletGroups[$k]['items'][] = $obWallet;
                    $arWalletGroups[$k]['summ'] += $obWallet->value;
                }
            }
        }
        $arWalletGroups['others'] = [
            'name' => trans('mkeep.wallet_group_others'),
            'summ' => 0,
            'items' => []
        ];
        foreach ($arWallets as $k=>$obWallet) {
            if (!$obWallet->group_id) {
                $arWalletGroups['others']['items'][] = $obWallet;
                $arWalletGroups['others']['summ'] += $obWallet->value;
            }
        }
        
        return response()->json(['groups' => array_values($arWalletGroups)]);
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
            $arCategoriesSum[$obOperation->category_id] = array('sum'=>round($obOperation->sum, 2));
        }
                
        
        foreach ($arCategories as $k=>$obCategory) {
            if (isset($arCategoriesSum[$obCategory->id]) && $arCategoriesSum[$obCategory->id]['sum']>0) {
                $arCategoriesSum[$obCategory->id]['name'] = $obCategory->name;
            }
        }
        
        return response()->json(array_values($arCategoriesSum));
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
        return view('account.stats.month');
	}
    
    /**
     * Show monthly stat widgets
     * 
     * 
     * @return <type>
     */	
	public function getMonthavg()
	{
        return view('account.stats.monthavg');
	}
    
    /**
     * Show year stat widgets
     * 
     * 
     * @return <type>
     */	
	public function getYear()
	{
        return view('account.stats.year');
	}
    
    /**
     * Show year stat widgets
     * 
     * 
     * @return <type>
     */	
	public function getYearavg()
	{
        return view('account.stats.yearavg');
	}
    
    
    /**
     * Get data for area chart by month
     * 
     * 
     * @return <type>
     */	
	public function getMonthtotal()
	{
        return response()->json(array_values($this->__getStatByPeriod('month', 'type', 'any')));
	}
    
    /**
     * Get data for area chart of incomes by category
     * 
     * 
     * @return <type>
     */	
	public function getMonthincome()
	{
        return response()->json(array_values($this->__getStatByPeriod('month', 'category_id', 'income')));
	}
    
    /**
     * Get data for area chart of spends by category
     * 
     * 
     * @return <type>
     */	
	public function getMonthspend()
	{
        return response()->json(array_values($this->__getStatByPeriod('month', 'category_id', 'spend')));
	}
    
    /**
     * Get data for area chart by year
     * 
     * 
     * @return <type>
     */	
	public function getYeartotal()
	{
        return response()->json(array_values($this->__getStatByPeriod('year', 'type', 'any')));
	}
    
    /**
     * Get data for area chart of incomes by category
     * 
     * 
     * @return <type>
     */	
	public function getYearincome()
	{
        return response()->json(array_values($this->__getStatByPeriod('year', 'category_id', 'income')));
	}
    
    /**
     * Get data for area chart of spends by category
     * 
     * 
     * @return <type>
     */	
	public function getYearspend()
	{
        return response()->json(array_values($this->__getStatByPeriod('year', 'category_id', 'spend')));
	}
    
    
    /**
     * Get data for pie chart of incomes by category
     * 
     * 
     * @return <type>
     */	
	public function getMonthavgincome()
	{
        return response()->json(array_values($this->__getStatAvg('month','income')));
	}
    
    /**
     * Get data for pie chart of spends by category
     * 
     * 
     * @return <type>
     */	
	public function getMonthavgspend()
	{
        return response()->json(array_values($this->__getStatAvg('month', 'spend')));
	}
    
    /**
     * Get data for pie chart of incomes by category
     * 
     * 
     * @return <type>
     */	
	public function getYearavgincome()
	{
        return response()->json(array_values($this->__getStatAvg('year','income')));
	}
    
    /**
     * Get data for pie chart of spends by category
     * 
     * 
     * @return <type>
     */	
	public function getYearavgspend()
	{
        return response()->json(array_values($this->__getStatAvg('year','spend')));
	}
    
    /**
     * Get data for area chart
     * 
     * 
     * @return <type>
     */	
	protected function __getStatByPeriod($period="month", $field="type", $type="any")
	{
        
        $dbOperations = Operation::select(DB::raw('value, year, month, type, category_id'))->
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
                } else {
                    $arOperationsSum[$date][$fieldName] = round($arOperationsSum[$date][$fieldName], 2);
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
	public function getTotals($type = 'month', $period = false)
    {
		if ($period) {
			$period = strtotime($period);
		} else {
			$period = time();
		}
		$arPlan = Plan::select(DB::raw('sum(value) as sum'))->user()->get();
		$totals = ['plan'=>$arPlan[0]['sum']];
		
		$dbOperations = Operation::select(DB::raw('sum(value) as sum, type'))->user()
						->where('year','=',date('Y', $period));
						
		if ($type=='month') {
			$dbOperations->where('month','=',date('m', $period));
		} else {
			$totals['plan'] *= 12;
		}
		
		$arOperations = $dbOperations->groupBy('type')->get();
		
		foreach($arOperations as $arOperation) {
			$totals[$arOperation['type']] = $arOperation['sum'];
		}
		$max = max($totals);
		$totalsOld = $totals;
		foreach ($totalsOld as $k=>$v) {
			$totals[$k."_percent"] = 100*$v / $max;
		}
		$totals['max'] = $max;
		
        return response()->json($totals);
    }
    
    /**
     * Get data for categories progress
     * 
     * 
     * @return <type>
     */	
	public function getProgress($type = 'month', $period = false)
    {
        return response()->json(['categories'=>$this->_getPlanStatistics($type, $period)]);
    }
    
    public function getPlan ($type = false, $period = false)
    {
        return view('account.stats.plan', array());
    }
	
    /**
     * Calculate plan and spends for concreate period
     * 
     * @param string $type type of period (month or year)
     * @param string $period date in period (ex.: 2000-01-01)
     * 
     * @return array progress of spends for categories
     */    
    protected function _getPlanStatistics($type='month', $period=false)
	{
        if (!$period) {
            $period = date('Y-m-d');
        }
        $periodFrom = date('Y-m-01');
        $periodTo = date('Y-m-d');
        if ($type=='month') {
            $periodFrom = date('Y-m-01', strtotime($period));
            $periodTo = date('Y-m-31', strtotime($period));
        } else {
            $periodFrom = date('Y-01-01', strtotime($period));
            $periodTo = date('Y-12-31', strtotime($period));
        }
        
        $arCategories = Category::user()->whereIn('type', array('any', 'spend'))->orderBy('sort','asc')->get();
        $dbOperations = Operation::select(DB::raw('sum(value) as sum, category_id'))->
                user();
                
        $dbOperations->where('type', '=', 'spend');
        $dbOperations->where('date', '>=', $periodFrom);
        $dbOperations->where('date', '<=', $periodTo);
        
        $arOperations = $dbOperations->
                groupBy('category_id')->
                get();
        
        $arCategoriesSum = array();        
        foreach ($arOperations as $obOperation) {
            $arCategoriesSum[$obOperation->category_id] = array('sum'=>$obOperation->sum, 'plan'=>0, 'id'=>$obOperation->category_id);
        }
        
        $dbPlans = Plan::select(DB::raw('sum(value) as sum, category_id'))->
                user();
        $arPlans = $dbPlans->
                groupBy('category_id')->
                get();
                
        foreach ($arPlans as $obPlan) {
            if (!isset($arCategoriesSum[$obPlan->category_id])) {
                $arCategoriesSum[$obPlan->category_id] = array('sum'=>0, 'id'=>$obPlan->category_id);
            }
            $arCategoriesSum[$obPlan->category_id]['plan'] = $obPlan->sum;
            if ($type=='year') {
                $arCategoriesSum[$obPlan->category_id]['plan'] *= 12;
            }
        }
                
        $arIcons = Category::getCategoryIcons();
        foreach ($arCategories as $k=>$obCategory) {
            if (!isset($arCategoriesSum[$obCategory->id])) {
                $arCategoriesSum[$obCategory->id] = array('sum'=>0, 'plan'=>0, 'id'=>$obCategory->id);
            }
            $arCategoriesSum[$obCategory->id]['name'] = $obCategory->name;
            $arCategoriesSum[$obCategory->id]['icon'] = false;
            if ($obCategory->icon && isset($arIcons[$obCategory->icon])) {
                $arCategoriesSum[$obCategory->id]['icon'] = $arIcons[$obCategory->icon];
            }
            $arCategoriesSum[$obCategory->id]['progress'] = 100;
            if ($arCategoriesSum[$obCategory->id]['plan']>0) {
                $arCategoriesSum[$obCategory->id]['progress'] = 100*$arCategoriesSum[$obCategory->id]['sum'] / $arCategoriesSum[$obCategory->id]['plan'];
            }
        }
        
        return $arCategoriesSum;
	}

}
