<?php

namespace App\Models;

use App\Models\Department;
use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
    protected $fillable
    = [
        'name',
        'surname',
        'patronymic',
        'gender',
        'wage'
    ];
    public function department(){

       return $this->belongsToMany(Department::class);
    }
}
