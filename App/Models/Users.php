<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $primaryKey = 'ID'; 
    protected $connection = 'wordpress';
    public $timestamps = false;

    public function scopeGetUsername($query, $id)
    {
        return $query->where('ID', $id)->get(['user_login']);
    }
}