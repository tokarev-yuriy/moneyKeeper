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
            $arIcons['briefcase'] = 'fas fa-briefcase';
            $arIcons['gem'] = 'fas fa-gem';
            $arIcons['home'] = 'fas fa-home';
            $arIcons['landmark'] = 'fas fa-landmark';
            $arIcons['money-bill'] = 'fas fa-money-bill';
            $arIcons['money-check'] = 'fas fa-money-check';
            $arIcons['store-alt'] = 'fas fa-store-alt';
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
            '001f3f' => '&nbsp;',
            '0074d9' => '&nbsp;',
            '7fdbff' => '&nbsp;',
            '39cccc' => '&nbsp;',
            '3d9970' => '&nbsp;',
            '2ecc40' => '&nbsp;',
            '01ff70' => '&nbsp;',
            'ffdc00' => '&nbsp;',
            'ff851b' => '&nbsp;',
            'ff4136' => '&nbsp;',
            '85144b' => '&nbsp;',
            'f012be' => '&nbsp;',
            'b10dc9' => '&nbsp;',
            '111111' => '&nbsp;',
            'aaaaaa' => '&nbsp;',
            'dddddd' => '&nbsp;',
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
