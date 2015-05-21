<?php

namespace Dime\Server\Model;

use Illuminate\Database\Eloquent\Model;
/**
 * AccessToken
 *
 * @author Danilo Kuehn <dk@nogo-software.de>
 */
class Access extends Model
{
    protected $table = 'access';

    protected $fillable = [ 'user_id', 'client' ];
    protected $guarded = [ 'token' ];
    protected $hidden = [ 'token' ];
    
    public function user()
    {
        return $this->belongsTo('Dime\Server\Model\User');
    }

    /**
     * Compare updated_at with strtotime('-' . $period).
     *
     * @param string $period will be strtotime
     * @return boolean
     */
    public function expired($period)
    {
        return strtotime('-' . $period) >= strtotime($this->updated_at);
    }
}