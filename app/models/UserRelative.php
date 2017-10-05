<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

/**
 *  Abstract model with special user scope
 *  User scope is necessary for most of select operations in models
 *
 *  @author   Yuriy Tokarev <yuriytok@gmail.com>
 */
class UserRelative extends Eloquent {

    /**
     * Заготовка по фильтрации пользовательских данных
     * 
     * @param <type> $query 
     * 
     * @return <type>
     */    
    public function scopeUser($query)
    {
        return $query->where('user_id', '=', Auth::id());
    }

}
