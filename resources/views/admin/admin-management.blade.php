@extends('layouts.user_type.auth')

@section('content')

<div>
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">All Admins</h5>
                        </div>
                        <button type="button" class="btn bg-gradient-primary  btn-sm mb-0" data-bs-toggle="modal" data-bs-target="#newAdmin">
                            +&nbsp; New Admin
                        </button>
                        <!-- <a href="#" class="btn bg-gradient-primary btn-sm mb-0" type="button">+&nbsp; New Admin</a> -->
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Admin ID
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Name
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Email
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Phone No
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="userTableBody">
                                <tr>
                                    <td colspan="5">Loading Admins ....</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- New Admin Create Modal-->
<div class="modal fade" id="newAdmin" tabindex="-1" role="dialog" aria-labelledby="newAdminModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-normal" id="newAdminModalLabel">Create New Admin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="new-admin-form" role="form" method="POST">
                    <div class="form-group">
                        <label for="admin-name-input" class="form-control-label">Admin Name</label>
                        <input class="form-control" type="text" required placeholder="John Snow" id="new-admin-name-input">
                    </div>
                    <div class="form-group">
                        <label for="admin-email-input" class="form-control-label">Admin Email</label>
                        <input class="form-control" type="email" required placeholder="admin@admin.com" id="new-admin-email-input">
                    </div>
                    <div class="form-group">
                        <label for="admin-phoneNo-input" class="form-control-label">Admin Phone No</label>
                        <input class="form-control" type="text" required placeholder="+9471 2823427" id="new-admin-phoneNo-input">
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn bg-gradient-primary w-100 mt-4 mb-0">Save</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="alert alert-danger text-white" style="display: none;" role="alert" id="newAdminErrorMessages"></div>
            </div>
        </div>
    </div>
</div>

<!-- Admin Edit Modal-->
<div class="modal fade show" id="editAdmin" tabindex="-1" role="dialog" aria-labelledby="editAdminModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-normal" id="editAdminModalLabel">Edit Admin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="edit-admin-form" role="form" method="PUT">
                    <div class="form-group">
                        <label for="admin-name-input" class="form-control-label">Admin Name</label>
                        <input class="form-control" type="text" required placeholder="John Snow" id="edit-admin-name-input">
                    </div>
                    <div class="form-group">
                        <label for="admin-phoneNo-input" class="form-control-label">Admin Phone No</label>
                        <input class="form-control" type="text" required placeholder="+9471 2823427" id="edit-admin-phoneNo-input">
                    </div>
                    <input type="hidden" required id="edit-admin-id-input">
                    <div class="text-center">
                        <button type="submit" class="btn bg-gradient-primary w-100 mt-4 mb-0">Save Changes</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="alert alert-danger text-white" style="display: none;" role="alert" id="editAdminErrorMessages"></div>
            </div>
        </div>
    </div>
</div>

<div class="toast-container position-fixed top-2 end-0 p-3">
    <div id="message-toast" class="toast align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body text-white text-bolder" id="message-toast-body"></div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#message-toast").toast();
        $("#editAdmin").modal();
        loadData();
    });

    function loadData() {
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: '/api/v1/admin',
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            contentType: 'application/json',
            xhrFields: {
                withCredentials: true,
            },
            success: function(response) {
                loadDataToTable(response);
            },
            error: function(xhr) {
                loadDataToTable(xhr);
            },
        });
    }

    function loadDataToTable(response) {
        let returnData = '';
        const tbody = document.querySelector('#userTableBody');
        tbody.innerHTML = '';
        if (response && response.data && response.data.length > 0) {
            response.data.forEach(admin => {
                tbody.innerHTML += `
                        <tr>
                            <td class='align-middle text-center'>${admin.id ? admin.id : '~none~'}</td>
                            <td class='align-middle text-center'>${admin.name ? admin.name : '~none~'}</td>
                            <td class='align-middle text-center'>${admin.email ? admin.email : '~none~'}</td>
                            <td class='align-middle text-center'>${admin.phone_no ? admin.phone_no : '~none~'}</td>
                            <td class='align-middle text-center'>
                                <span>
                                    <i class="cursor-pointer fas fa-user-edit text-secondary mx-3" onclick="viewSelectedAdmin(${admin.id})"></i>
                                </span>
                                <span>
                                    <i class="cursor-pointer fas fa-trash text-secondary mx-3" onclick="deleteSelectedAdmin(${admin.user_id})"></i>
                                </span>
                            </td>
                        </tr>
                    `;
            });
        } else {
            tbody.innerHTML = '<tr><td colspan="3">No admins found</td></tr>';
        }
    }

    function viewSelectedAdmin(adminID) {
        if (adminID) {
            getSingleAdmin(adminID)
                .done(function(result) {
                    if (result.data && result.data.id) {
                        $('#edit-admin-id-input').val(result.data.id);
                        $('#edit-admin-name-input').val(result.data.name);
                        $('#edit-admin-phoneNo-input').val(result.data.phone_no);
                        $("#editAdmin").modal('toggle');
                    } else {
                        $('#message-toast').toast('show');
                        $('#message-toast').addClass("bg-danger");
                        $('#message-toast-body').html("Error!   Please try again");
                    }
                })
                .fail(function() {
                    $('#message-toast').toast('show');
                    $('#message-toast').addClass("bg-danger");
                    $('#message-toast-body').html("Error!   Please try again");
                });
        } else {
            $('#message-toast').toast('show');
            $('#message-toast').addClass("bg-danger");
            $('#message-toast-body').html("Error!   Please try again");
        }
    }

    function deleteSelectedAdmin(adminID) {
        if (adminID) {
            $.confirm({
                title: 'Delete Record?',
                content: 'Are you sure You want to delete the selected admin?',
                type: 'white',
                buttons: {
                    ok: {
                        text: "DELETE",
                        btnClass: 'btn btn-danger',
                        keys: ['enter'],
                        action: function() {
                            deleteSingleAdmin(adminID)
                                .done(function(result) {
                                    $('#message-toast').toast('show');
                                    $('#message-toast').addClass("bg-success");
                                    $('#message-toast-body').html("Success!   Admin Delete successfull");
                                    loadData();
                                })
                                .fail(function() {
                                    $('#message-toast').toast('show');
                                    $('#message-toast').addClass("bg-danger");
                                    $('#message-toast-body').html("Error!   Please try again");
                                })
                        }
                    },
                    cancel: function() {
                        console.log('the user clicked cancel');
                    }
                }
            });
        } else {
            $('#message-toast').toast('show');
            $('#message-toast').addClass("bg-danger");
            $('#message-toast-body').html("Error!   Please try again");
        }
    }

    function getSingleAdmin(id) {
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        return $.ajax({
            url: '/api/v1/admin/' + id,
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            contentType: 'application/json',
            xhrFields: {
                withCredentials: true,
            },
            success: function(response) {
                return response;
            },
            error: function(xhr) {
                return xhr;
            },
        });
    }

    function deleteSingleAdmin(id) {
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        return $.ajax({
            url: '/api/v1/admin/' + id,
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            contentType: 'application/json',
            xhrFields: {
                withCredentials: true,
            },
            success: function(response) {
                return response;
            },
            error: function(xhr) {
                return xhr;
            },
        });
    }

    $('#new-admin-form').on('submit', function(e) {
        e.preventDefault();

        // Get CSRF token from meta tag
        const csrfToken = $('meta[name="csrf-token"]').attr('content');

        // Collect form data
        const name = $('#new-admin-name-input').val();
        const email = $('#new-admin-email-input').val();
        const phoneNo = $('#new-admin-phoneNo-input').val();

        // Make an AJAX POST request
        $.ajax({
            url: '/api/v1/admin',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            contentType: 'application/json',
            data: JSON.stringify({
                name: name,
                email: email,
                phone_no: phoneNo,
            }),
            xhrFields: {
                withCredentials: true,
            },
            success: function(response) {
                $('#newAdmin').modal('toggle');
                $('#message-toast').toast('show');
                $('#message-toast').addClass("bg-success");
                $('#message-toast-body').html("Success!   New Admin Successfully Created!");
                loadData();
            },
            error: function(xhr) {
                $('#newAdminErrorMessages').show();
                $('#newAdminErrorMessages').html("Error!   New Admin Creation Failed!");
            },
        });
    });

    $('#edit-admin-form').on('submit', function(e) {
        e.preventDefault();

        // Get CSRF token from meta tag
        const csrfToken = $('meta[name="csrf-token"]').attr('content');

        // Collect form data
        const id = $('#edit-admin-id-input').val();
        const name = $('#edit-admin-name-input').val();
        const phoneNo = $('#edit-admin-phoneNo-input').val();

        // Make an AJAX POST request
        $.ajax({
            url: '/api/v1/admin/' + id,
            method: 'PUT',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            contentType: 'application/json',
            data: JSON.stringify({
                name: name,
                phone_no: phoneNo,
            }),
            xhrFields: {
                withCredentials: true,
            },
            success: function(response) {
                $('#editAdmin').modal('toggle');
                $('#message-toast').toast('show');
                $('#message-toast').addClass("bg-success");
                $('#message-toast-body').html("Success!!   Admin Update Successfull!");
                loadData();
            },
            error: function(xhr) {
                $('#editAdminErrorMessages').show();
                $('#editAdminErrorMessages').html("Error!!   Admin Update Failed!");
            },
        });
    });
</script>

@endsection
