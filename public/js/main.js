function ajax_param(url, method, data = '', callback) {
    $.ajax({
        url: url,
        method: method,
        data: data,
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        dataType: 'json',
        success: function (params) {
            callback(params);
        },
        error: function (err) {
            $('.mesage_server').html('');
            $.each(err.responseJSON.errors, function (i, error) {
                $('.mesage_server').append('<div class="alert alert-danger" role="alert">' + error[0] + '</div>');
            });
        }
    });
}

function addFormEmployeesDepartments(params) {
    $('.checkbox-employees').html('');
    if (params) {
        var textHtml = '<label for="recipient-departments" class="col-form-label">Отделы:</label>';
        for (var i = 0; i < params.length; i++) {
            textHtml += '<div class="form-check"><input class="form-check-input" name="departments[]" type="checkbox" id="inlineCheckbox' + params[i]['id'] +
                '"  value="' + params[i]['id'] + '"><label class="form-check-label" for="' + params[i]['id'] + '">' + params[i]['title'] + '</label></div>';
        }
        $('.checkbox-employees').html(textHtml);
    } else {
        $('.checkbox-employees').html('<label for="recipient-departments" class="col-form-label">Отделы:</label><div class="form-check">Нет отделлов</div>');
    }
}

function addTableEmployees(params) {
    console.log(params);
    var textHtml = '<tr data-employees_id="' + params[0]['id'] + '"><th scope="row">' + $('tr').length + '</th>';
    if (params != 'error') {
        textHtml +=
            '<td>' + params[0]['name'] + '</td>' +
            '<td>' + params[0]['surname'] + '</td>' +
            '<td>' + params[0]['patronymic'] + '</td>' +
            '<td>' + params[0]['gender'] + '</td>' +
            '<td>' + params[0]['wage'] + '</td>'
        var departments = '';
        for (var i = 0; i < params[0]['department'].length; i++) {
            departments += params[0]['department'][i]['title'] + ', ';
        }
        textHtml += '<td>' + departments + '</td>';
        textHtml += '<td><button type="button" class="btn btn-warning mx-3 edit_employees" data-employees_id="' + params[0]['id'] + '" data-toggle="modal" data-target="#employees" data-whatever="@mdo">Редактировать</button>';
        if (params[0]['department'].length == 0) {
            textHtml += '<button type="button" class="btn btn-danger mx-3 delete_employees"  data-employees_id="' + params[0]['id'] + '">Удалить</button></td>';
        }
        $('.close').click();
        $('.mesage_server2').html('');
        $('.mesage_server2').html('<div class="alert alert-success" role="alert">Удачно добавленно</div>');
        $('tbody').append(textHtml + '</tr>');
    } else {
        $('.mesage_server').html('<div class="alert alert-danger" role="alert">Данный пользователь уже сушествует!</div>');
    }
}

function editTableEmployees(params) {
    $('.mesage_server').html('');

    if (params != 'error') {
        var textHtml = '<th scope="row">' + $('tr[data-employees_id="' + params[0]['id'] + '"').index() + '</th>';
        textHtml += '<td>' + params[0]['name'] + '</td>' +
            '<td>' + params[0]['surname'] + '</td>' +
            '<td>' + params[0]['patronymic'] + '</td>' +
            '<td>' + params[0]['gender'] + '</td>' +
            '<td>' + params[0]['wage'] + '</td>';
        var departments = '';
        for (var i = 0; i < params[0]['department'].length; i++) {
            departments += params[0]['department'][i]['title'] + ', ';
        }
        textHtml += '<td>' + departments + '</td>';
        textHtml += '<td><button type="button" class="btn btn-warning mx-3 edit_employees" data-employees_id="' + params[0]['id'] + '" data-toggle="modal" data-target="#employees" data-whatever="@mdo">Редактировать</button>';
        if (params[0]['department'].length == 0) {
            textHtml += '<button type="button" class="btn btn-danger mx-3 delete_employees"  data-employees_id="' + params[0]['id'] + '">Удалить</button></td>';
        }
        $('.close').click();
        $('.mesage_server2').html('');
        $('.mesage_server2').html('<div class="alert alert-success" role="alert">Удачно отредактированый</div>');
        $('tr[data-employees_id="' + params[0]['id'] + '"').html(textHtml);
    }
}


function addEmployeesForm(id) {
    $('input[name="name"]').val($('tr[data-employees_id="' + id + '"]').children('.employees_name').text());
    $('input[name="surname"]').val($('tr[data-employees_id="' + id + '"]').children('.employees_surname').text());
    $('input[name="patronymic"]').val($('tr[data-employees_id="' + id + '"]').children('.employees_patronymic').text());
    $('input[name="gender"]').val($('tr[data-employees_id="' + id + '"]').children('.employees_gender').text());
    $('input[name="wage"]').val($('tr[data-employees_id="' + id + '"]').children('.employees_wage').text());

    var departmentsCheck = $('tr[data-employees_id="' + id + '"]').children('.employees_department').text().split(', ');
    for (var i = 0; i < departmentsCheck.length; i++) {
        for (var j = 0; j < $('.form-check-label').length; j++) {
            if ($('.form-check-label').eq(j).text() == departmentsCheck[i].replace(/ +/g, ' ').trim()) {
                $('.form-check-label').eq(j).siblings('input').attr('checked', true);
            }

        }
    }
}
function addTableDepartment(params) {
    $('.mesage_server').html('');
    if (params != 'error') {
        var textHtml = '<tr data-departments_id="' + params['id'] + '"><th scope="row">' + $('tr').length + '</th>';
        textHtml +=
            '<td class="department-name">' + params['title'] + '</td>' +
            '<td></td>' +
            '<td></td>';
        textHtml += '<td><button type="button" class="btn btn-warning mx-3 edit_departments" data-departments_id="' + params['id'] + '" data-toggle="modal" data-target="#departments" data-whatever="@mdo">Редактировать</button>';

        textHtml += '<button type="button" class="btn btn-danger mx-3 delete_departments"  data-departments_id="' + params['id'] + '">Удалить</button></td>';

        $('tbody').append(textHtml + '</tr>');
        $('.close').click();
        $('.mesage_server2').html('');
        $('.mesage_server2').html('<div class="alert alert-success" role="alert">Удачно добавленно</div>');
    } else {
        $('.mesage_server').html('<div class="alert alert-danger" role="alert">Данный отделл сушествует!</div>');
    }
}
function editTableDepartment(params) {
    $('.mesage_server').html('');
    if (params != 'error') {
        var textHtml = '<th scope="row">' + $('tr[data-departments_id="' + params[0]['id'] + '"').index() + '</th>';

        textHtml += '<td class="department-name">' + params[0]['title'] + '</td>' +
            '<td>' + params[0]['employees'].length + '</td>';
        var employees = new Array();
        if (params[0]['employees'].length > 0) {
            for (var i = 0; i < params[0]['employees'].length; i++) {
                employees.push(params[0]['employees'][i]['wage']);
            }
            textHtml += '<td>' + Math.max(...employees) + '</td>';
        } else {
            textHtml += '<td>0</td>';
        }

        textHtml += '<td><button type="button" class="btn btn-warning mx-3 edit_departments" data-departments_id="' + params[0]['id'] + '" data-toggle="modal" data-target="#departments" data-whatever="@mdo">Редактировать</button>';

        textHtml += '<button type="button" class="btn btn-danger mx-3 delete_departments"  data-departments_id="' + params[0]['id'] + '">Удалить</button></td>';

        $('tr[data-departments_id="' + params[0]['id'] + '"').html(textHtml);
        $('.close').click();
        $('.mesage_server2').html('');
        $('.mesage_server2').html('<div class="alert alert-success" role="alert">Удачно отредактированно</div>');
    } else {
        $('.mesage_server').html('<div class="alert alert-danger" role="alert">Данный отделл сушествует!</div>');
    }
}
function deleteTableParam() {
    $('.mesage_server2').html('');
    $('.mesage_server2').html('<div class="alert alert-success" role="alert">Удачно удаленно</div>');
}

$(document).ready(function () {

    /*
    // start Employees block code
    */

    //add employees
    $('.create_employees').click(function () {
        var params = ajax_param('/employees/create', 'GET', '', addFormEmployeesDepartments);
        $('#button_departments').removeClass('update_employees');
        $('#button_employees').addClass('add_employees');
    });

    $('#employees').on('click', '.add_employees', function () {
        console.log($('#employees form').serializeArray());
        ajax_param('/employees/store', 'POST', $('#employees form').serializeArray(), addTableEmployees);
    });
    // end add employees

    //edit employees
    $('table').on('click', '.edit_employees', function () {
        $('input').val('');
        ajax_param('/employees/create', 'GET', '', addFormEmployeesDepartments);
        $('.hiiden-block').remove();
        $('input[name="name"]').after('<input class="hiiden-block" type="hidden" name="id" value="' + $(this).data('employees_id') + '">');
        $('input[name="id"]').val($(this).data('employees_id'));
        $('#button_departments').removeClass('add_employees');
        $('#button_employees').addClass('update_employees');
        setTimeout(addEmployeesForm, 1000, $(this).data('employees_id'));
    });
    $('#employees').on('click', '.update_employees', function () {
        var params = ajax_param('/employees/' + $('input[name="id"]').val(), 'PUT', $('#employees form').serializeArray(), editTableEmployees);
    });

    $('table').on('click', '.delete_employees', function () {
        console.log($('.delete_employees').data('employees_id'));
        ajax_param('/employees/' + $(this).data('employees_id'), 'DELETE', '', deleteTableParam);

        $(this).parent().parent('tr').remove();

    });
    //end edit employees
    /*
    // end Employees block code
    */


    /*
    // start Departments block code
    */
    $('table').on('click', '.edit_departments', function () {
        $('.hiiden-block').remove();
        $('input[name="title"]').val($(this).parent().parent('tr').children('.department-name').text()).after('<input class="hiiden-block" type="hidden" name="id" value="' + $(this).data('departments_id') + '">');
        $('#button_departments').addClass('update_departments');
        $('#button_departments').removeClass('add_departments');
    });

    $('.create_departments').click(function () {
        $('#button_departments').removeClass('update_departments');
        $('#departments #button_departments').addClass('add_departments');
    });

    $('#departments').on('click', '.add_departments', function () {
        var params = ajax_param('/departments/store', 'POST', $('#departments form').serialize(), addTableDepartment);
    });

    $('table').on('click', '.delete_departments', function () {
        ajax_param('/departments/' + $('.delete_departments').data('departments_id'), 'DELETE', deleteTableParam);

        $(this).parent().parent('tr').remove();

    });
    $('#departments').on('click', '.update_departments', function () {
        ajax_param('/departments/' + $('input[name="id"]').val(), 'PUT', $('#departments form').serialize(), editTableDepartment);
    });

    /*
    // end Departments block code
    */
});
