@extends('layouts')

@section('content')
<h2>Сетка</h2>
<table class="table table-bordered">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col"></th>

            @if (count($department) > 0)
                @foreach ($department as $departments_value)
                    <th scope="col">{{$departments_value->title }}</th>
                @endforeach
            @else
                <th class="text-center" colspan="7">К сожеленнию ненайденно отделов</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @if (count($employees) > 0)
            @foreach ($employees as $employees_value)
                @if (count($department) > 0)

                    @php
                        $departmentYes = [];
                    @endphp

                    @foreach ($department as $departments_value)

                        @php
                            $departmentYes[$departments_value->id] = '<td></td>';
                        @endphp

                    @endforeach
                @endif

        <tr data-employees_id="{{ $employees_value->id }}">
            <th scope="row">1</th>
            <td class="employees_name">{{ $employees_value->name . ' ' . $employees_value->surname}}</td>

                @foreach ($employees_value->department as $departments_value)

                    @if ($departments_value->department_id)

                        @php
                        $departmentYes[$departments_value->department_id] = '<td class="bg-success">Присуствует</td>';
                        @endphp

                    @endif
                @endforeach

                @php
                    echo implode('', $departmentYes);
                @endphp
            @endforeach
        </tr>
        @else
        <tr>
            <td class="text-center" colspan="7">К сожеленнию ненайденно сотрудников</td>
        </tr>
        @endif
    </tbody>
</table>
@endsection
