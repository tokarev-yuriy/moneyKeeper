<?php
namespace App\MoneyKeeper\Models;
use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

/**
 *  Import profile model
 *
 *  @author   Yuriy Tokarev <yuriytok@gmail.com>
 */
class ImportProfile extends UserRelative {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'import_profile';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('user_id');
    
    /**
     * Returns available encodings
     * 
     * 
     * @return array available encodings
     */ 
    public static function getEncodings () {
        return array(
            'UTF8' => "UTF-8",
            'CP1251' => "Windows-1251",
        );
    }    
    
    /**
     * Returns available row/col nums
     * 
     * 
     * @return array available row/col nums
     */ 
    public static function getRowNums ($limit = 10) {
        $arReturn = array(
            '0' => trans('mkeep_tablegrid.no'),
        );
        
        for($i=1;$i<$limit;$i++) {
            $arReturn[$i] = $i;
        }
        
        return $arReturn;
    }
}
