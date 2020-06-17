<?php

namespace App\Http\Controllers;

use App\Repositories\DepartmentsRepository;
use Illuminate\Http\Request;

class DepartmentsController extends Controller
{
  private  $messages = array(
        'title.required' => 'Название отдела является обезательным',
        'title.alpha_num' => 'Название отдела может содержать только цифры и буквы',
    );
    private $rules = [
        'title' =>'required|alpha_num',
    ];
    public $departmentRepository;


    public function __construct()
    {
        $this->departmentRepository = app(DepartmentsRepository::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = $this->departmentRepository->getAllDepartments();
        return view('departments.index', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $departments = $this->departmentRepository->setCreateDepartments($request->title);
        return response()->json($departments);
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
        $departments = $this->departmentRepository->editDepartments($id, $request->all());
        return response()->json($departments);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $departments = $this->departmentRepository->deleteDepartments($id);
        return $departments;
    }
}
