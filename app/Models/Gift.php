<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gift extends Model
{
    use HasFactory;
    protected $table = 'gifts';
    public $fillable = ['name', 'parent_id'];

    public function childrenAccounts()
    {
        return $this->hasMany('App\Models\Gift', 'parent_id')->select('id', 'name', 'parent_id');
    }

    public function allChildrenAccounts()
    {
        return $this->childrenAccounts()->with('allChildrenAccounts');
    }

}
