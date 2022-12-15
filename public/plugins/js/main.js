$(document).ready(function () {

    function formReset(id) {
        $('#' + id).find('.form-control').each(function (key, input) {
            window.inputss = input;
            $(input).val('').change();
        });
        $('#user_modal').find('.password-group').show();
        $('#user_form').find('[name=employee_is_active]').prop('checked', false);
        $.uniform.update();
    }

    $('#manage_users_table').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        paging: true,
        ajax: "",
        columns: [
            // {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'id', name: 'id', width: "1%"},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'phone_number', name: 'phone_number'},
            {data: 'job_title', name: 'job_title'},
            {data: 'is_active', name: 'is_active'},
            {data: 'created_at', name: 'created_at'},
            {data: 'updated_at', name: 'updated_at'},
            {
                data: 'id', name: 'id', orderable: false, searchable: false, render: function (data, type, row) {
                    return '<button class="btn default btn-xs purple-stripe modals_btn_edit_user" ' + 'aria-hidden="true" data-trigger="hover" data-placement="top" data-content="Edit user" data-container="body" data-id="' + data + '"> Edit </button>' +
                        '<a href="javascript:void(0)" class="btn default btn-xs red-stripe btn-del-user" data-id="' + data + '">Delete</a>'
                }
            },
        ],
        lengthMenu: [
            [10, 15, 20, -1],
            [10, 15, 20, "All"] // change per page values here
        ],
        // set the initial value
        pageLength: 10,
        pagingType: "bootstrap_full_number",
        language: {
            lengthMenu: "_MENU_ records",
            paginate: {
                previous: "Prev",
                next: "Next",
                last: "Last",
                first: "First"
            }
        },
    });

    $('body').on('click', '.modals_btn_add_new_user', function () {
        formReset('user_form');
        $('#user_modal').find('.modal-header').find('.modal-title').html('Add Employee')
        $('#user_form').find('.form-control').val();
        $('#user_form .alert-danger').hide();
        $('#user_modal').modal();
    });

    $('body').on('click', '.modals_btn_edit_user', function () {
        let editLink = '/hr/get-employee/' + $(this).attr('data-id');
        $('#user_modal').find('.modal-header').find('.modal-title').html('Edit Employee');
        $('#user_modal').find('.password-group').hide();
        $('#user_form .alert-danger').hide();

        $.getJSON(editLink, function (data) {
            $.each(data, function (userKey, userValue) {
                if (userKey === 'is_active') {
                    if (userValue === 1)
                        $('#user_form').find('[name=employee_is_active]').prop('checked', true);
                    else
                        $('#user_form').find('[name=employee_is_active]').prop('checked', false);
                }
                $('#user_form').find('*[name=' + userKey + ']').val(userValue);
            });
            $('#user_modal').modal();
        });
    });

    $('body').on('click', '.btn-del-user', function () {
        App.blockUI({
            target: '#user_modal',
            boxed: true
        });

        let deleteLink = '/hr/del-employee/' + $(this).attr('data-id');
        bootbox.confirm('Are you sure?', function (result) {
            if (result) {
                $.getJSON(deleteLink, function (data) {
                    App.unblockUI('#user_modal');
                    if (data.result) {
                        $('#manage_users_table').DataTable().ajax.reload(null, false);
                        App.alert({
                            type: 'success', // alert's type
                            message: data.message, // alert's message
                            closeInSeconds: 5, // auto close after defined seconds
                        });
                    } else {
                        App.alert({
                            type: 'danger', // alert's type
                            message: data.message, // alert's message
                            closeInSeconds: 5, // auto close after defined seconds
                        });
                    }
                });
            }
        });
    });

    $('.form_submit').on('click', function () {
        let target_form = $(this).attr('data-form');
        $(target_form).submit();
    });

    let form1 = $('#user_form');
    let error1 = $('.alert-danger', form1);
    let success1 = $('.alert-success', form1);


    form1.validate({
        errorElement: 'span', //default input error message container
        errorClass: 'help-block help-block-error', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        ignore: "", // validate all fields including form hidden input
        rules: {
            name: {
                required: true,
                minlength: 2
            },
            email: {
                required: true,
                email: true
            },
            phone_number: {
                required: true,
                number: true,
                minlength: 10,
                maxlength: 10
            }
        },
        invalidHandler: function (event, validator) { //display error alert on form submit
            success1.hide();
            error1.show();
            App.scrollTo(error1, -200);
        },
        highlight: function (element) { // hightlight error inputs
            $(element)
                .closest('.form-group').addClass('has-error'); // set error class to the control group
        },
        unhighlight: function (element) { // revert the change done by hightlight
            $(element)
                .closest('.form-group').removeClass('has-error'); // set error class to the control group
        },
        success: function (label) {
            label
                .closest('.form-group').removeClass('has-error'); // set success class to the control group
        },
        submitHandler: function (form1) {

            $(form1).ajaxSubmit({
                success: function (data) {
                    if (data.result) {
                        error1.hide();
                        let table = $('#manage_users_table').DataTable();
                        table.ajax.reload(null, false);
                        $('#user_modal').modal('hide');

                        if (data.action === 'add') {
                            App.alert({
                                container: '#user_modal .modal-body',
                                place: 'prepend',
                                type: 'success', // alert's type
                                message: 'Employee added successfully', // alert's message
                                close: true, // make alert closable
                                focus: 'true', // auto scroll to the alert after shown
                                closeInSeconds: 5, // auto close after defined seconds
                                icon: 'check' // put icon before the message
                            });
                        } else {
                            App.alert({
                                container: '#user_modal .modal-body',
                                place: 'prepend',
                                type: 'success', // alert's type
                                message: 'Employee modified successfully', // alert's message
                                close: true, // make alert closable
                                focus: 'true', // auto scroll to the alert after shown
                                closeInSeconds: 10, // auto close after defined seconds
                                icon: 'check' // put icon before the message
                            });
                        }

                    } else {
                        error1.hide();
                        App.alert({
                            container: '#user_modal .modal-body',
                            place: 'prepend',
                            type: 'danger', // alert's type
                            message: 'Opps! something went wrong!', // alert's message
                            close: true, // make alert closable
                            focus: 'true', // auto scroll to the alert after shown
                            closeInSeconds: 5, // auto close after defined seconds
                            icon: 'times' // put icon before the message
                        });
                    }

                },
            });
        }
    });

    let form2 = $('#user_edit_form');
    let error2 = $('.alert-danger', form2);
    let success2 = $('.alert-success', form2);
    form2.validate({
        errorElement: 'span', //default input error message container
        errorClass: 'help-block help-block-error', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        ignore: "", // validate all fields including form hidden input
        rules: {
            name: {
                required: true,
                minlength: 2
            },
            email: {
                required: true,
                email: true
            },
            phone_number: {
                required: true,
                number: true,
                minlength: 10,
                maxlength: 10
            }
        },
        invalidHandler: function (event, validator) { //display error alert on form submit
            success2.hide();
            error2.show();
            App.scrollTo(error2, -200);
        },
        highlight: function (element) { // hightlight error inputs
            $(element)
                .closest('.form-group').addClass('has-error'); // set error class to the control group
        },
        unhighlight: function (element) { // revert the change done by hightlight
            $(element)
                .closest('.form-group').removeClass('has-error'); // set error class to the control group
        },
        success: function (label) {
            label
                .closest('.form-group').removeClass('has-error'); // set success class to the control group
        },
        submitHandler: function (form2) {

            $(form2).ajaxSubmit({
                success: function (data) {
                    if (data.result) {
                        error1.hide();
                    }
                    window.location.reload();
                },
            });
        }
    });

    if ($('#user_portlet table#manage_users_table').length > 0) {
        let table = $('#user_portlet table#manage_users_table').DataTable();
        table.ajax.reload(null, false);
    }

});
