<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Options extends Model
{
    protected $primaryKey = 'option_id';
    protected $connection = 'wordpress';
    public $timestamps = false;

    public function scopeGeturl($query)
    {
        return $query->where('option_name', 'siteurl')->first(['option_value']);
    }
}