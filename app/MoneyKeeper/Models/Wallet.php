<?php
namespace App\MoneyKeeper\Models;
use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

/**
 *  Wallet model
 *
 *  @author   Yuriy Tokarev <yuriytok@gmail.com>
 */
class Wallet extends UserRelative {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'wallets';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('user_id');
	
	/**
	 * Returns possible wallet icons
	 * 
	 * 
	 * @return <type>
	 */    
	public static function getWalletIcons () {
			$arIcons = [];
            $arIcons['coins'] = 'fas fa-coins';
            $arIcons['wallet'] = 'fas fa-wallet';
            $arIcons['credit-card'] = 'fas fa-credit-card';
            $arIcons['pound-sign'] = 'fas fa-pound-sign';
            $arIcons['euro-sign'] = 'fas fa-euro-sign';
            $arIcons['dollar-sign'] = 'fas fa-dollar-sign';
            return $arIcons;
	}
	
	/**
	 * Returns possible wallet colors
	 * 
	 * 
	 * @return <type>
	 */    
	public static function getColorList () {
		return array(
			'fff' => '&nbsp;',
			'f1ece9' => '&nbsp;',
			'f9e3be' => '&nbsp;',
			'b8ccc6' => '&nbsp;',
		);
	}
    
    /**
     * Returns available user's Wallet groups
     * 
     * 
     * @return array user's wallet groups
     */
    public static function getWalletGroups () {
        $arList = array(
            0 => trans('mkeep.wallet_group_others')
        );
        
        $arItems = WalletGroup::user()->select('id', 'name')->orderBy('sort')->get();
        foreach($arItems as $obItem) {
            $arList[$obItem->id] = $obItem->name;
        }
        
        return $arList;
    }

}
