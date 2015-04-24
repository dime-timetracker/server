<?php

namespace Dime\Server\Model;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{

    protected $fillable = ['name', 'description', 'alias', 'rate', 'enabled'];
    protected $guarded = ['id', 'user_id'];

    public function user()
    {
        return $this->belongsTo('Dime\Server\Model\User');
    }

}
