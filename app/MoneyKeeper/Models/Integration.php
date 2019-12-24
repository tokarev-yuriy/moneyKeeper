<?php
namespace App\MoneyKeeper\Models;
use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

/**
 *  Integration model
 *
 *  @author   Yuriy Tokarev <yuriytok@gmail.com>
 */
class Integration extends UserRelative {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'integrations';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('user_id');

}
