<?php

namespace App\Repositories;


use App\Models\Department as Model;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class DepartmentsRepository extends CoreRepository
{

    protected function getModelClass()
    {
        return Model::class;
    }
    public function getAll()
    {

        $result = $this
        ->startConditions()->all();

        return $result;
    }

    public function getAllDepartments()
    {

        $result = $this
        ->startConditions()
        ->select()
            ->with([
                'employees' => function ($query) {
                    $query->select('wage');
                }
            ])->get();

        return $result;
    }



    public function getAjax($id)
    {

        $result = $this
        ->startConditions()
        ->where('id', '=',$id)
        ->select()
            ->with([
                'employees' => function ($query) {
                    $query->select('wage');
                }
            ])->get();

        return $result;
    }


    public function setCreateDepartments($result){
        $departments = $this->issetDepartments($result);
        if($departments != null){
            return 'error';
        }else{
            return  $this->startConditions()->create(['title' => $result]);
        }

    }


    public function deleteDepartments($id){
         $delete = $this->startConditions()->find($id)->employees()->detach();
         $this->startConditions()->find($id)->delete();
        if($delete){
            $result = 'ok';
        }else{
            $result = 'error';
        }
        return $result;
    }



    public function editDepartments($id, $result){
        $departments = $this->issetDepartments($result['title']);
        if($departments != null){
            if($departments->id != $id){
                return 'error';
            }else{
                $this->startConditions()->find($id)->fill($result)->save();
                return $this->getAjax($id);
            }
        }else{
         $this->startConditions()->find($id)->fill($result)->save();
        return $this->getAjax($id);
        }
    }


    public function issetDepartments($title){
        return $this->startConditions()->where('title','=', $title)->first();
    }
}
