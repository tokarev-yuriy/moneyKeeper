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
            'fff' => '&nbsp;', // white
            'b71c1c' => '&nbsp;', // red
            '880e4f' => '&nbsp;', // pink
            '4a148c' => '&nbsp;', // purple
            '311b92' => '&nbsp;', // deeppurple
            '1a237e' => '&nbsp;', // indigo
            '0d47a1' => '&nbsp;', // blue
            '01579b' => '&nbsp;', // lightBlue
            '006064' => '&nbsp;', // cyan
            '004d40' => '&nbsp;', // teal
            '1b5e20' => '&nbsp;', // green
            '33691e' => '&nbsp;', // lightGreen
            '827717' => '&nbsp;', // lime
            'f57f17' => '&nbsp;', // yellow
            'e65100' => '&nbsp;', // orange
            '3e2723' => '&nbsp;', // brown
            '212121' => '&nbsp;', // grey
            '263238' => '&nbsp;', // blueGrey
            '607d8b' => '&nbsp;', // blueGrey2
            '111111' => '&nbsp;', // black
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
