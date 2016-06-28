<?php
namespace App\Models;

use \WeDevs\ORM\Eloquent\Model as Model;

class Options extends Model
{
    protected $primaryKey = 'option_id';
    public $timestamps = false;

    public function scopeGeturl($query)
    {
        return $query->where('option_name', 'siteurl')->first(['option_value']);
    }
}