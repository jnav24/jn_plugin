<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modules extends Model
{
    protected $primaryKey = 'module_id';
    protected $fillable = [
        'module_file',
        'module_image',
    ];
}