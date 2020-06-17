<?php

namespace App\Repositories;


use App\Models\Employees as Model;
use App\Models\EmployeesDepartment;
use App\Repositories\DepartmentsRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EmployeesRepository extends CoreRepository
{

    protected function getModelClass()
    {
        return Model::class;
    }

    public function getAllEmployees()
    {

        $result = $this
            ->startConditions()
            ->select()
            ->with([
                'department' => function ($query) {
                    $query->select(['title', 'department_id']);
                }
            ])->get();

        return $result;
    }


    public function getAjax($id)
    {

        $result = $this
            ->startConditions()->where('id', '=', $id)->select()
            ->with([
                'department' => function ($query) {
                    $query->select(['title']);
                }
            ])->get();

        return $result;
    }


    public function setCreateEmployees($result)
    {
        $departments = $this->issetEmployees($result);
        if ($departments != null) {
            return 'error';
        } else {
            $employees = $this->startConditions()->create($result);

            if (!empty($result['departments'])) {
                foreach ($result['departments'] as $departments_id) {
                    $employees->department()->attach($departments_id);
                }
            } else {
            }
            return $this->getAjax($employees->id);
        }
    }


    public function deleteEmployees($id)
    {
        $delete = $this->startConditions()->find($id)->delete();
        if ($delete) {
            $result = 'ok';
        } else {
            $result = 'error';
        }
        return $result;
    }


    public function editEmployees($id, $result)
    {
        $employees = $this->issetEmployees($result);

        if ($employees != null) {
            if ($employees->id != $id) {
                return 'error';
            } else {
                $edit = $this->startConditions()->find($id)->fill($result);
                $this->startConditions()->find($id)->department()->detach();
                if (!empty($result['departments'])) {
                    foreach ($result['departments'] as $departments_id) {
                        $edit->department()->attach($departments_id);
                    }
                }
                $edit->save();
                return $this->getAjax($id);
            }
        } else {
            $edit = $this->startConditions()->find($id)->fill($result);
            $this->startConditions()->find($id)->department()->detach();
            if (!empty($result['departments'])) {
                foreach ($result['departments'] as $departments_id) {
                    $edit->department()->attach($departments_id);
                }
            }
            $edit->save();
            return $this->getAjax($id);
        }
    }


    public function issetEmployees($result)
    {

        return $this->startConditions()->where('name', '=', $result['name'])->where('surname', '=', $result['surname'])->first();
    }
}
