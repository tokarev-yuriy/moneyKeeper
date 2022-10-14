<?php
namespace App\MoneyKeeper\Models;

use MoneyKeeper\Accounting\Entities\AccountGroupEntity;

/**
 *  AccountGroup model
 *
 *  @author   Yuriy Tokarev <yuriytok@gmail.com>
 */
class AccountGroup extends UserRelative {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'wallets_groups';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('user_id');

	/**
	 * Convert model to Entity
	 *
	 * @return AccountGroupEntity
	 */
	public function toEntity(): AccountGroupEntity
	{
		return new AccountGroupEntity($this->id ? $this->id : null, $this->name, $this->sort);
	}

}
