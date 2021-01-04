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
        $arIcons = [];
        $arIcons['car'] = 'fas fa-car';
        $arIcons['tv'] = 'fas fa-tv';
        $arIcons['shopping-basket'] = 'fas fa-shopping-basket';
        $arIcons['child'] = 'fas fa-child';
        $arIcons['phone'] = 'fas fa-phone';
        $arIcons['plane'] = 'fas fa-plane';
        $arIcons['gift'] = 'fas fa-gift';
        $arIcons['utensils'] = 'fas fa-utensils';
        $arIcons['pump-soap'] = 'fas fa-pump-soap';
        $arIcons['tshirt'] = 'fas fa-tshirt';
        $arIcons['glass-cheers'] = 'fas fa-glass-cheers';
        $arIcons['hand-holding-medical'] = 'fas fa-hand-holding-medical';
        $arIcons['laptop-house'] = 'fas fa-laptop-house';
        $arIcons['couch'] = 'fas fa-couch';
        $arIcons['user-tie'] = 'fas fa-user-tie';
        $arIcons['tools'] = 'fas fa-tools';
        $arIcons['swimmer'] = 'fas fa-swimmer';
        $arIcons['cocktail'] = 'fas fa-cocktail';
        $arIcons['globe'] = 'fas fa-globe';
        $arIcons['code'] = 'fas fa-code';
        $arIcons['laptop-code'] = 'fas fa-laptop-code';
        $arIcons['diagnoses'] = 'fas fa-diagnoses';
        $arIcons['hands'] = 'fas fa-hands';
        $arIcons['wrench'] = 'fas fa-wrench';
        $arIcons['weight-hanging'] = 'fas fa-weight-hanging';
        $arIcons['certificate'] = 'fas certificate';
        $arIcons['magic'] = 'fas magic';
        $arIcons['female'] = 'fas female';
        return $arIcons;
    }

}
