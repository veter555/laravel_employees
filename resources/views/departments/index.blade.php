@extends('layouts')

@section('content')
<h2>ОТделы</h2>
<div class="mesage_server2"></div>
<table class="table table-bordered">
    <thead>
        <tr>
            <th scope="col"></th>
            <th scope="col">Название отдела</th>
            <th scope="col">Количество сотрудников</th>
            <th scope="col">Максимальная заработная плата среди сотрудников отдела</th>

        </tr>
    </thead>
    <tbody>
        @if (!empty($departments))


        <?php $i = 1; ?>
        @foreach ($departments as $departments_value)
        <tr data-departments_id="{{ $departments_value->id }}">
            <th scope="row">{{ $i++ }}</th>
            <td class="department-name">{{ $departments_value->title }}</td>
            <td>{{ count($departments_value->employees) }}</td>
            <?php $count_employees = [];?>
            @foreach ($departments_value->employees as $employees_value)
            <?php $count_employees[] = $employees_value->wage;?>

            @endforeach
            @if (!empty($count_employees))
            <td>{{ max($count_employees) }}</td>
            @else
            <td>0</td>

            @endif

            <td>
                <button type="button" class="btn btn-warning mx-3 edit_departments"
                    data-departments_id="{{ $departments_value->id }}" data-toggle="modal" data-target="#departments"
                    data-whatever="@mdo">Редактировать</button>
                <button type="button" class="btn btn-danger mx-3 delete_departments"
                    data-departments_id="{{ $departments_value->id }}">Удалить</button>
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
    <button type="button" class="btn btn-success  create_departments" data-toggle="modal" data-target="#departments"
        data-whatever="@mdo">Добавить отдел</button>
</div>
<div class="modal fade" id="departments" tabindex="-1" role="dialog" aria-labelledby="departmentsLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="departmentsLabel">New message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="mesage_server"></div>
                <form>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Название отдела:</label>
                        <input type="text" name="title" class="form-control" id="recipient-name">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button id="button_departments" type="button" class="btn btn-primary" data-departments="">Send
                    message</button>
            </div>
        </div>
    </div>
</div>

@endsection
