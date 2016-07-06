<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pages extends Model
{
    protected $primaryKey = 'page_id';
    protected $fillable = [
        'page_content',
        'page_name',
        'page_url',
        'created_by',
        'modified_by',
        'created_at',
        'updated_at'
    ];
    protected $table = 'jn_plugin_pages';
}