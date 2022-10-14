<?php
namespace App\MoneyKeeper\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

/**
 *  Operation model
 *
 *  @author   Yuriy Tokarev <yuriytok@gmail.com>
 */
class Operation extends UserRelative {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'operations';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = array('user_id');

    
    /**
     * Returns available user's Categories of concrete operation type
     * 
     * @param string $type type of operation (spend, income, transfer or any)
     * 
     * @return array user's categories of selected operation type
     */    
    public static function getTypeCategories ($type, $onlyNames = true) {
        $arList = array();
        
        $arItems = Category::user()->select('id', 'name', 'icon')->whereIn('type', array('any', $type))->orderBy('sort')->get();
        foreach($arItems as $obItem) {
            if($onlyNames)
                $arList[$obItem->id] = $obItem->name;
            else
                $arList[$obItem->id] = $obItem;
        }
        
        return $arList;
    }
    
    /**
     * Returns available user's Wallets
     * 
     * 
     * @return array user's wallets
     */
    public static function getWallets ($onlyNames = true) {
        $arList = array();
        
        $arItems = Wallet::user()->select('id', 'name', 'icon', 'group_id')->orderBy('sort')->get();
        foreach($arItems as $obItem) {
            if($onlyNames)
                $arList[$obItem->id] = $obItem->name;
            else
                $arList[$obItem->id] = $obItem;
        }
        
        return $arList;
    }
        
    /**
     * Returns available user's Categories of concrete operation type
     * 
     * @param string $type type of operation (spend, income, transfer or any)
     * 
     * @return array user's categories of selected operation type
     */    
    public static function getTypeCategoriesWithIcons ($type) {
        $arList = array();
        $categoryIcons = \App\MoneyKeeper\Models\Category::getCategoryIcons();
        $arItems = Category::user()->select('id', 'name', 'icon')->whereIn('type', array('any', $type))->orderBy('sort')->get();
        foreach($arItems as $obItem) {
            $arList[] = ['label'=>(isset($categoryIcons[$obItem->icon])?'<img src="'.$categoryIcons[$obItem->icon].'" style="height: 20px; padding-right: 10px; margin-left: -5px;">':'').$obItem->name, 'code'=>$obItem->id];
        }
        
        return $arList;
    }
        
        /**
     * Returns available user's Wallets
     * 
     * 
     * @return array user's wallets
     */
    public static function getWalletsWithIcons () {
        $arList = array();
        $walletIcons = \App\MoneyKeeper\Models\Wallet::getWalletIcons();
        $arItems = Wallet::user()->select('id', 'name', 'icon', 'group_id')->orderBy('sort')->get();
        
        $obWalletGroups = WalletGroup::user()->orderBy('sort','asc')->get();
        foreach($obWalletGroups as $k=>$obGroup) {
            $arList[$obGroup->name] = $obGroup->name;
            foreach ($arItems as $obItem) {
                if ($obItem->group_id == $obGroup->id) {
                    $arList[$obItem->id] = (isset($walletIcons[$obItem->icon])?'<i class="dropdown-icon '.$walletIcons[$obItem->icon].'"></i>':'').$obItem->name;
                }
            }
        }
        $arList[trans('mkeep.wallet_group_others')] = trans('mkeep.wallet_group_others');
        foreach($arItems as $obItem) {
            if (!$obItem->group_id) {
                $arList[$obItem->id] = (isset($walletIcons[$obItem->icon])?'<img src="'.$walletIcons[$obItem->icon].'" style="height: 30px; padding-right: 5px; margin: -5px 0 -5px -10px;">':'').$obItem->name;
            }
        }
        
        return $arList;
    }
        
        /**
         * Returns colors of user wallets
         * 
         * @return [type] [description]
         */
        public static function getWalletColors () {
            $arList = array();
            
            $arItems = Wallet::user()->select('id', 'color')->orderBy('sort')->get();
            foreach($arItems as $obItem) {
                    $arList[$obItem->id] = $obItem->color;
            }
            
            return $arList;
        }
}
