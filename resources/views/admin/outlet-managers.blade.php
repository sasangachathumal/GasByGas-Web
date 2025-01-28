@extends('layouts.user_type.auth')

@section('content')

<div>
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">All Outlet Manages</h5>
                        </div>
                        <button type="button" class="btn bg-gradient-warning  btn-sm mb-0" data-bs-toggle="modal" data-bs-target="#newManager">
                            +&nbsp; New Outlet Manager
                        </button>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Manager ID
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
                                        Outlet Name
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="userTableBody">
                                <tr>
                                    <td colspan="6">Loading Admins ....</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="newManager" tabindex="-1" role="dialog" aria-labelledby="newManagerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-normal" id="newManagerModalLabel">Create New Outlet Manager</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="new-manager-form" role="form" method="POST">
                    <div class="form-group">
                        <label for="new-manager-outlet-select" class="form-control-label">Select the outlet</label>
                        <select class="form-control" id="new-manager-outlet-select">
                            <option value="-1">~ Outlet name ~</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="admin-name-input" class="form-control-label">Manager Name</label>
                        <input class="form-control" type="text" required placeholder="John Snow" id="new-manager-name">
                    </div>
                    <div class="form-group">
                        <label for="admin-email-input" class="form-control-label">Manager Email</label>
                        <input class="form-control" type="email" required placeholder="admin@admin.com" id="new-manager-email">
                    </div>
                    <div class="form-group">
                        <label for="admin-phoneNo-input" class="form-control-label">Manager Phone No</label>
                        <input class="form-control" type="text" required placeholder="+9471 2823427" id="new-manager-phoneNo">
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn bg-gradient-warning w-100 mt-4 mb-0">Save</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="alert alert-danger text-white" style="display: none;" role="alert" id="newManagerErrorMessages"></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade show" id="editManager" tabindex="-1" role="dialog" aria-labelledby="editManagerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-normal" id="editManagerModalLabel">Edit Outlet Manager</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="edit-manager-form" role="form" method="PUT">
                    <div class="form-group">
                        <label for="admin-email-input" class="form-control-label">Manager Email</label>
                        <input class="form-control" type="email" readonly placeholder="admin@admin.com" id="edit-manager-email">
                    </div>
                    <div class="form-group">
                        <label for="admin-email-input" class="form-control-label">Manager Outlet</label>
                        <input class="form-control" type="text" readonly id="edit-manager-outlet">
                    </div>
                    <div class="form-group">
                        <label for="admin-name-input" class="form-control-label">Manager Name</label>
                        <input class="form-control" type="text" id="edit-manager-name">
                    </div>
                    <div class="form-group">
                        <label for="admin-phoneNo-input" class="form-control-label">Manager Phone No</label>
                        <input class="form-control" type="text" id="edit-manager-phoneNo">
                    </div>
                    <input type="hidden" required id="edit-manager-id">
                    <div class="text-center">
                        <button type="submit" class="btn bg-gradient-warning w-100 mt-4 mb-0">Save Changes</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="alert alert-danger text-white" style="display: none;" role="alert" id="editManagerErrorMessages"></div>
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
        $("#editManager").modal();
        loadData();
        clearInputs();
    });

    function loadData() {
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        const access_token = JSON.parse(localStorage.getItem('access_token'));
        $.ajax({
            url: '/api/v1/outletManager',
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'Authorization': `Bearer ${access_token}`
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
        $.ajax({
            url: '/api/v1/outlet',
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'Authorization': `Bearer ${access_token}`
            },
            contentType: 'application/json',
            xhrFields: {
                withCredentials: true,
            },
            success: function(response) {
                loadOutletSelect(response);
            },
            error: function(xhr) {
                $('#message-toast').toast('show');
                $('#message-toast').addClass("bg-danger");
                $('#message-toast-body').html("Error!   Please try again");
            },
        });
    }

    function loadOutletSelect(response) {
        if (!response || !response.data || response.data.length <= 0) {
            $('#message-toast').toast('show');
            $('#message-toast').addClass("bg-danger");
            $('#message-toast-body').html("Error!   Please try again");
            return;
        }
        const outletSelect = $('#all-outlets-select')
        $.each(response.data, function(i, item) {
            $('#all-outlets-select').append($('<option>', {
                value: item.id,
                text: item.name
            }));
            $('#new-manager-outlet-select').append($('<option>', {
                value: item.id,
                text: item.name
            }));
        });
    }

    function loadDataToTable(response) {
        let returnData = '';
        const tbody = document.querySelector('#userTableBody');
        tbody.innerHTML = '';
        if (response && response.data && response.data.length > 0) {
            response.data.forEach(manager => {
                tbody.innerHTML += `
                        <tr>
                            <td class='align-middle text-center'>${manager.id ? manager.id : '~none~'}</td>
                            <td class='align-middle text-center'>${manager.name ? manager.name : '~none~'}</td>
                            <td class='align-middle text-center'>${manager.user_email ? manager.user_email : '~none~'}</td>
                            <td class='align-middle text-center'>${manager.phone_no ? manager.phone_no : '~none~'}</td>
                            <td class='align-middle text-center'>${manager.outlet_name ? manager.outlet_name : '~none~'}</td>
                            <td class='align-middle text-center'>
                                <span>
                                    <i class="cursor-pointer fas fa-pencil-alt text-secondary mx-3" onclick="viewSelectedManager(${manager.id})"></i>
                                </span>
                                <span>
                                    <i class="cursor-pointer fas fa-trash text-danger mx-3" onclick="deleteSelectedManager(${manager.id})"></i>
                                </span>
                            </td>
                        </tr>
                    `;
            });
        } else {
            tbody.innerHTML = '<tr><td colspan="3">No Managers found</td></tr>';
        }
    }

    function viewSelectedManager(managerID) {
        if (managerID) {
            getSingleManager(managerID)
                .done(function(result) {
                    if (result.data && result.data.id) {
                        $('#edit-manager-name').val(result.data.name);
                        $('#edit-manager-email').val(result.data.user_email);
                        $('#edit-manager-phoneNo').val(result.data.phone_no);
                        $('#edit-manager-outlet').val(result.data.outlet_name);
                        $('#edit-manager-id').val(result.data.id);
                        $("#editManager").modal('toggle');
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

    function deleteSelectedManager(managerID) {
        if (managerID) {
            $.confirm({
                title: 'Delete Record?',
                content: 'Are you sure You want to delete the selected manager?',
                type: 'white',
                buttons: {
                    ok: {
                        text: "DELETE",
                        btnClass: 'btn btn-danger',
                        keys: ['enter'],
                        action: function() {
                            deleteSingleManager(managerID)
                                .done(function(result) {
                                    $('#message-toast').toast('show');
                                    $('#message-toast').addClass("bg-success");
                                    $('#message-toast-body').html("Success!   Nabager Delete successfull");
                                    loadData();
                                    clearInputs(false);
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

    function getSingleManager(id) {
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        const access_token = JSON.parse(localStorage.getItem('access_token'));
        return $.ajax({
            url: '/api/v1/outletManager/' + id,
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'Authorization': `Bearer ${access_token}`
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

    function deleteSingleManager(id) {
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        const access_token = JSON.parse(localStorage.getItem('access_token'));
        return $.ajax({
            url: '/api/v1/outletManager/' + id,
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'Authorization': `Bearer ${access_token}`
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

    $('#new-manager-form').on('submit', function(e) {
        e.preventDefault();

        // Get CSRF token from meta tag
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        const access_token = JSON.parse(localStorage.getItem('access_token'));

        // Collect form data
        const outlet = $('#new-manager-outlet-select').val();
        const name = $('#new-manager-name').val();
        const email = $('#new-manager-email').val();
        const phoneNo = $('#new-manager-phoneNo').val();

        // Make an AJAX POST request
        $.ajax({
            url: '/api/v1/outletManager',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'Authorization': `Bearer ${access_token}`
            },
            contentType: 'application/json',
            data: JSON.stringify({
                outlet_id: outlet,
                name: name,
                email: email,
                phone_no: phoneNo,
            }),
            xhrFields: {
                withCredentials: true,
            },
            success: function(response) {
                $('#newManager').modal('toggle');
                $('#message-toast').toast('show');
                $('#message-toast').addClass("bg-success");
                $('#message-toast-body').html("Success!   New Manager Successfully Created!");
                loadData();
                clearInputs(true);
            },
            error: function(xhr) {
                $('#newManagerErrorMessages').show();
                $('#newManagerErrorMessages').html("Error!   New Manager Creation Failed!");
            },
        });
    });

    $('#edit-manager-form').on('submit', function(e) {
        e.preventDefault();

        // Get CSRF token from meta tag
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        const access_token = JSON.parse(localStorage.getItem('access_token'));

        // Collect form data
        const name = $('#edit-manager-name').val();
        const phoneNo = $('#edit-manager-phoneNo').val();
        const id = $('#edit-manager-id').val();

        // Make an AJAX POST request
        $.ajax({
            url: '/api/v1/outletManager/' + id,
            method: 'PUT',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'Authorization': `Bearer ${access_token}`
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
                $('#editManager').modal('toggle');
                $('#message-toast').toast('show');
                $('#message-toast').addClass("bg-success");
                $('#message-toast-body').html("Success!!   Manager Update Successfull!");
                loadData();
                clearInputs();
            },
            error: function(xhr) {
                $('#editManagerErrorMessages').show();
                $('#editManagerErrorMessages').html("Error!!   Manager Update Failed!");
            },
        });
    });

    function clearInputs() {
        $('#all-outlets-select').val('-1');
        $('#edit-manager-name').val(null);
        $('#edit-manager-phoneNo').val(null);
        $('#edit-manager-outlet').val(null);
        $('#edit-manager-email').val(null);
        $('#new-manager-outlet-select').val('-1');
        $('#new-manager-name').val(null);
        $('#new-manager-email').val(null);
        $('#new-manager-phoneNo').val(null);
    }
</script>

@endsection
