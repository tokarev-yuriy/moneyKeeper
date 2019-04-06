<?php
namespace App\MoneyKeeper\Models;
use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

/**
 *  Category model
 *
 *  @author   Yuriy Tokarev <yuriytok@gmail.com>
 */
class Category extends UserRelative {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'categories';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('user_id');
    
    /**
     * Returns available types of operations
     * 
     * 
     * @return array available types of operations
     */    
    public static function getTypeList () {
        return array(
            'any' => trans('mkeep.any'),
            'income' => trans('mkeep.income'),
            'spend' => trans('mkeep.spend'),
            'transfer' => trans('mkeep.transfer'),
        );
    }
    
    /**
     * Returns available types of operations
     * 
     * 
     * @return array available types of operations
     */    
    public static function getTypeVisualList () {
        return array(
            'income' => '<i class="material-icons text-success">arrow_forward</i>',
            'spend' => '<i class="material-icons text-danger">arrow_back</i>',
            'transfer' => '<i class="material-icons text-secondary">swap_horiz</i>',
        );
    }
    
    /**
     * Returns possible category icons
     * 
     * 
     * @return <type>
     */    
    public static function getCategoryIcons () {
        $arIcons = array();
        $files = scandir(public_path().'/img/categories/');
        foreach ($files as $filename) {
           $arInfo = pathinfo(public_path().'/img/categories/'.$filename); 
           if ($arInfo['extension']=='svg') {
               $arIcons[$arInfo['filename']] = '/img/categories/'.$filename;
           }
        }
        return $arIcons;
    }

}
