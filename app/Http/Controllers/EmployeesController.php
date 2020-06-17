<?php

namespace App\Http\Controllers;

use App\Repositories\EmployeesRepository;
use App\Repositories\DepartmentsRepository;
use Illuminate\Http\Request;

class EmployeesController extends Controller
{
   private  $messages = array(
        'name.required' => 'Поле "Имя" является обезательным',
        'surname.required' => 'Поле "Фамилия" является обезательным',
        'name.alpha_num' => 'Поле "Имя" может содержать только цифры и буквы',
        'surname.alpha_num' => 'Поле "Фамилия" может содержать только цифры и буквы',
        'patronymic.alpha_num' => 'Поле "Отчество" может содержать только цифры и буквы',
        'wage.integer' => 'Поле "Зарплата" может содержать только целые числа',
    );
   private  $rules = [
        'name' =>'required|alpha_num',
        'surname' =>'required|alpha_num',
        'patronymic' =>'sometimes|nullable|alpha_num',
        'wage' =>'sometimes|nullable|integer',
    ];
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
        return view('employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       $departments = $this->departmentRepository->getAllDepartments();
        return response()->json($departments);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->rules, $this->messages);

        $employees = $this->employeesRepository->setCreateEmployees($request->all());
        return response()->json($employees);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, $this->rules, $this->messages);
        $employees = $this->employeesRepository->editEmployees($id, $request->all());
        return response()->json($employees);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $employees = $this->employeesRepository->deleteEmployees($id);
        return $employees;
    }
}
