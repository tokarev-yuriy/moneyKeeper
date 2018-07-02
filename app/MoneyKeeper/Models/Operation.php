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
    public static function getTypeCategories ($type) {
        $arList = array();
        
        $arItems = Category::user()->select('id', 'name')->whereIn('type', array('any', $type))->orderBy('sort')->get();
        foreach($arItems as $obItem) {
            $arList[$obItem->id] = $obItem->name;
        }
        
        return $arList;
    }
    
    /**
     * Returns available user's Wallets
     * 
     * 
     * @return array user's wallets
     */
    public static function getWallets () {
        $arList = array();
        
        $arItems = Wallet::user()->select('id', 'name')->orderBy('sort')->get();
        foreach($arItems as $obItem) {
            $arList[$obItem->id] = $obItem->name;
        }
        
        return $arList;
    }
}
