<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    protected $connection = "wordpress";
    protected $primaryKey = 'ID';
    protected $fillable = [];
    public $timestamps = false;
}