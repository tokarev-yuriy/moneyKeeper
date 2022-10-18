<?php
namespace App\MoneyKeeper\Models;

use MoneyKeeper\Accounting\Entities\AccountEntity;
use MoneyKeeper\Accounting\ValueObjects\AccountDescriptionValue;

/**
 *  Account model
 *
 *  @author   Yuriy Tokarev <yuriytok@gmail.com>
 */
class Account extends UserRelative {

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
	 * Convert model to Entity
	 *
	 * @return AccountEntity
	 */
	public function toEntity(): AccountEntity
	{
		return new AccountEntity(
			$this->id ? $this->id : null, 
			new AccountDescriptionValue(
				$this->name,
				$this->icon ?? '',
				$this->color ?? '',
				$this->sort
			),
			$this->start ?? 0,
			$this->group_id ?? null,
			$this->active ? true : false
		);
	}

}
