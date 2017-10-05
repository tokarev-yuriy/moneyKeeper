<?php

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

}
