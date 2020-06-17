<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\EmployeesRepository;
use App\Repositories\DepartmentsRepository;

class IndexController extends Controller
{
    public $employeesRepository;
    public $departmentRepository;

    public function __construct()
    {
        $this->employeesRepository = app(EmployeesRepository::class);
        $this->departmentRepository = app(DepartmentsRepository::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = $this->employeesRepository->getAllEmployees();
        $department = $this->departmentRepository->getAll();
        return view('home', compact('employees', 'department'));
    }
}
