<?php

namespace Dime\Server\Model;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'name', 'description', 'alias', 'enabled',
        'rate', 'budget_price', 'budget_time', 'is_budget_fixed',
        'customer_id'
    ];
    protected $guarded = ['id', 'user_id'];

    public function customer()
    {
        return $this->belongsTo('Dime\Server\Model\Customer');
    }

    public function user()
    {
        return $this->belongsTo('Dime\Server\Model\User');
    }

    public function deepload()
    {
        $this->customer = Customer::find($this->customer_id);
    }

}
