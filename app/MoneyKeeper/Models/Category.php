<?php
namespace App\MoneyKeeper\Models;
use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use MoneyKeeper\Accounting\Entities\CategoryEntity;
use MoneyKeeper\Accounting\ValueObjects\CategoryDescriptionValue;
use MoneyKeeper\Accounting\ValueObjects\TransactionTypeValue;

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
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'types' => 'array',
    ];

    /**
	 * Convert model to Entity
	 *
	 * @return CategoryEntity
	 */
	public function toEntity(): CategoryEntity
	{
        $types = [];
        foreach($this->types as $type) {
			if ($type) {
            	$types[] = new TransactionTypeValue($type);
			}
        }
		return new CategoryEntity(
			$this->id ? $this->id : null, 
			new CategoryDescriptionValue(
				$this->name,
				$this->icon ?? '',
				$this->sort
			),
			$types
		);
	}

}
