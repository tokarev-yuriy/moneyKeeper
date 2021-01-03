<?php
namespace App\MoneyKeeper\Helpers;
use App\MoneyKeeper\Models\Category;
use App\MoneyKeeper\Models\Wallet;
use App\MoneyKeeper\Models\WalletGroup;
use App\MoneyKeeper\Models\Operation;

/**
 *  Dictionary helper
 *
 *  @author   Yuriy Tokarev <yuriytok@gmail.com>
 */
class Dictionary {

	/**
	 * Get all user categories
	 *
	 * @return array
	 */
	public static function getCategories () {
        $arItems = [];
	    $arCategories = Category::user()->select('id', 'name', 'icon', 'type')->orderBy('sort')->get();
        $arIcons = Category::getCategoryIcons();
        foreach($arCategories as $k=>$obCategory) {
            $obCategory->icon_src = '';
            if ($obCategory->icon && isset($arIcons[$obCategory->icon])) {
                $obCategory->icon_src = $arIcons[$obCategory->icon];
            }
            $arItems[$obCategory->id] = $obCategory;
        }
        return $arItems;
    }
    
    
    /**
	 * Get all user wallets
	 *
	 * @return array
	 */
	public static function getWallets () {
        $arItems = [];
        $arWallets = Wallet::user()->select('id', 'name', 'icon', 'color', 'group_id')->orderBy('sort')->get();
        foreach($arWallets as $k=>$obWallet) {
            $arItems[$obWallet->id] = $obWallet;
        }
        return $arItems;
    }
    
    /**
	 * Get all user wallet gtoups
	 *
	 * @return array
	 */
	public static function getWalletGroups () {
        $arItems = [];
	    $arGroups = \App\MoneyKeeper\Models\WalletGroup::user()->orderBy('sort','asc')->get();
        foreach($arGroups as $k=>$obGroup) {
            $arItems[$obGroup->id] = $obGroup;
        }
        $arItems['others'] = new \StdClass();
        $arItems['others']->name = trans('mkeep.wallet_group_others');
        return $arItems;
    }

}
