<?php namespace Dime\Server\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Model implements UserInterface, RemindableInterface {

    use UserTrait, RemindableTrait;

    public function activities()
    {
        return $this->hasMany('Dime\Server\Model\Activity');
    }

    public function customers()
    {
        return $this->hasMany('Dime\Server\Model\Customer');
    }

    public function projects()
    {
        return $this->hasMany('Dime\Server\Model\Project');
    }

    public function services()
    {
        return $this->hasMany('Dime\Server\Model\Service');
    }

    public function tags()
    {
        return $this->hasMany('Dime\Server\Model\Tags');
    }

    public function timeslices()
    {
        return $this->hasMany('Dime\Server\Model\Timeslice');
    }
}
