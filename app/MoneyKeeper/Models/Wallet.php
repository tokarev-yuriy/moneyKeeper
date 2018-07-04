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
			$arIcons = array();
			$files = scandir(public_path().'/img/wallets/');
			foreach ($files as $filename) {
				 $arInfo = pathinfo(public_path().'/img/wallets/'.$filename); 
				 if ($arInfo['extension']=='svg') {
						 $arIcons[$arInfo['filename']] = '/img/wallets/'.$filename;
				 }
			}
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

}
