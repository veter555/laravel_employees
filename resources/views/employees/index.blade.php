@extends('layouts')

@section('content')
<h2>Сотрудники</h2>
<div class="mesage_server2"></div>
<table class="table table-bordered">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Имя</th>
            <th scope="col">Фамилия</th>
            <th scope="col">Отчество</th>
            <th scope="col">Пол</th>
            <th scope="col">Заработная плата</th>
            <th scope="col">Отделы</th>

        </tr>
    </thead>
    <tbody>
        @if (count($employees) > 0)


        @foreach ($employees as $employees_value)
        <tr data-employees_id="{{ $employees_value->id }}">
            <th scope="row">1</th>
            <td class="employees_name">{{ $employees_value->name }}</td>
            <td class="employees_surname">{{ $employees_value->surname }}</td>
            <td class="employees_patronymic">{{ $employees_value->patronymic }}</td>
            <td class="employees_gender">{{ $employees_value->gender }}</td>
            <td class="employees_wage">{{ $employees_value->wage }}</td>
            <td class="employees_department">
                @foreach ($employees_value->department as $departments_value)
                {{$departments_value->title . ', '}}
                @endforeach
            </td>
            <td>
                <button type="button" class="btn btn-warning mx-3 edit_employees"
                    data-employees_id="{{ $employees_value->id }}" data-toggle="modal" data-target="#employees"
                    data-whatever="@mdo">Редактировать</button>
                @if (count($employees_value->department) == 0)
                <button type="button" class="btn btn-danger mx-3 delete_employees"
                    data-employees_id="{{ $employees_value->id }}">Удалить</button>
                @endif
            </td>
        </tr>
        @endforeach
        @else
        <tr>
            <td class="text-center" colspan="7">К сожеленнию ненайденно сотрудников</td>
        </tr>
        @endif
    </tbody>
</table>
<div class="text-center my-5">
    <button type="button" class="btn btn-success  create_employees" data-toggle="modal" data-target="#employees"
        data-whatever="@mdo">Добавить сотрудника</button>
</div>
<div class="modal fade" id="employees" tabindex="-1" role="dialog" aria-labelledby="employeesLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="employeesLabel">New message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="mesage_server"></div>
                <form>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Имя:</label>
                        <input type="text" name="name" class="form-control" id="recipient-name">
                    </div>
                    <div class="form-group">
                        <label for="recipient-surname" class="col-form-label">Фамилия:</label>
                        <input type="text" name="surname" class="form-control" id="recipient-surname">
                    </div>
                    <div class="form-group">
                        <label for="recipient-patronymic" class="col-form-label">Отчество:</label>
                        <input type="text" name="patronymic" class="form-control" id="recipient-patronymic">
                    </div>
                    <div class="form-group">
                        <label for="recipient-gender" class="col-form-label">Пол:</label>
                        <select class="form-control" name="gender" id="recipient-gender">
                            <option>Мужской</option>
                            <option>Женский</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="recipient-wage" class="col-form-label">Заработная плата:</label>
                        <input type="number" name="wage" class="form-control" id="recipient-wage">
                        <input class="csrf-token" type="hidden" name="_token" value="{{ csrf_token() }}">
                    </div>
                    <div class="form-group checkbox-employees">

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button id="button_employees" type="button" class="btn btn-primary">Send message</button>
            </div>
        </div>
    </div>
</div>
@endsection
