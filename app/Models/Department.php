<?php

namespace App\Models;

use App\Models\EmployeesDepartment;
use Illuminate\Database\Eloquent\Model;
use App\Models\Employees;

class Department extends Model
{
    protected $fillable
    = [
        'title',
    ];
    public function employees(){
      return  $this->belongsToMany(Employees::class);
    }
}
