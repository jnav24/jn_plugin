<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $primaryKey = 'ID'; 
    protected $connection = 'wordpress';
    public $timestamps = false;

    public function scopeGetUser($query, $id)
    {
        return $query->find($id);
    }
}