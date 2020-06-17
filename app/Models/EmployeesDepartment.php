<?php

namespace App\Models;

use App\Models\Employees;
use App\Models\Department;
use Illuminate\Database\Eloquent\Model;

class EmployeesDepartment extends Model
{
    protected $fillable
    = [
        'employees_id',
        'departments_id',
    ];

}
