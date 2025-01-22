@extends('layouts.user_type.auth')

@section('content')

<div>
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">All Outlets</h5>
                        </div>
                        <button type="button" class="btn bg-gradient-warning  btn-sm mb-0" data-bs-toggle="modal" data-bs-target="#newOutlet">
                            +&nbsp; New Outlet
                        </button>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Outlet ID
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        email
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        name
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        address
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
                                    <td colspan="6">Loading Outlets ....</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- New Outlet Create Modal-->
<div class="modal fade" id="newOutlet" tabindex="-1" role="dialog" aria-labelledby="newOutletModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-normal" id="newOutletModalLabel">Create New Outlet</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="new-outlet-form" role="form" method="POST">
                    <div class="form-group">
                        <label for="outlet-name-input" class="form-control-label">outlet Name</label>
                        <input class="form-control" type="text" required placeholder="ADS Stores" id="new-outlet-name-input">
                    </div>
                    <div class="form-group">
                        <label for="outlet-email-input" class="form-control-label">outlet Email</label>
                        <input class="form-control" type="email" required placeholder="ADSStores@gamil.com" id="new-outlet-email-input">
                    </div>
                    <div class="form-group">
                        <label for="outlet-phoneNo-input" class="form-control-label">outlet Phone No</label>
                        <input class="form-control" type="text" required placeholder="+9471 2823427" id="new-outlet-phoneNo-input">
                    </div>
                    <div class="form-group">
                        <label for="outlet-phoneNo-input" class="form-control-label">outlet Address</label>
                        <textarea class="form-control" id="new-outlet-address-input" required></textarea>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn bg-gradient-warning w-100 mt-4 mb-0">Save</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="alert alert-danger text-white" style="display: none;" role="alert" id="newOutletErrorMessages"></div>
            </div>
        </div>
    </div>
</div>

<!-- outlet Edit Modal-->
<div class="modal fade show" id="editOutlet" tabindex="-1" role="dialog" aria-labelledby="editOutletModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-normal" id="editOutletModalLabel">Edit Outlet</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="edit-outlet-form" role="form" method="PUT">
                    <div class="form-group">
                        <label for="outlet-name-input" class="form-control-label">Outlet Name</label>
                        <input class="form-control" type="text" required placeholder="John Snow" id="edit-outlet-name-input">
                    </div>
                    <div class="form-group">
                        <label for="outlet-phoneNo-input" class="form-control-label">Outlet Phone No</label>
                        <input class="form-control" type="text" required placeholder="+9471 2823427" id="edit-outlet-phoneNo-input">
                    </div>
                    <div class="form-group">
                        <label for="outlet-phoneNo-input" class="form-control-label">outlet Address</label>
                        <textarea class="form-control" id="edit-outlet-address-input" required></textarea>
                    </div>
                    <input type="hidden" required id="edit-outlet-id-input">
                    <div class="text-center">
                        <button type="submit" class="btn bg-gradient-warning w-100 mt-4 mb-0">Save Changes</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="alert alert-danger text-white" style="display: none;" role="alert" id="editOutletErrorMessages"></div>
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
        $("#editOutlet").modal();
        loadData();
        clearInputs();
    });

    function loadData() {
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: '/api/v1/outlet',
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
            response.data.forEach(outlet => {
                tbody.innerHTML += `
                        <tr>
                            <td class='align-middle text-center'>${outlet.id ? outlet.id : '~none~'}</td>
                            <td class='align-middle text-center'>${outlet.email ? outlet.email : '~none~'}</td>
                            <td class='align-middle text-center'>${outlet.name ? outlet.name : '~none~'}</td>
                            <td class='align-middle text-center'>${outlet.address ? outlet.address : '~none~'}</td>
                            <td class='align-middle text-center'>${outlet.phone_no ? outlet.phone_no : '~none~'}</td>
                            <td class='align-middle text-center'>
                                <span>
                                    <i class="cursor-pointer fas fa-pencil-alt text-secondary mx-3" onclick="viewSelectedOutlet(${outlet.id})"></i>
                                </span>
                                <span>
                                    <i class="cursor-pointer fas fa-trash text-danger mx-3" onclick="deleteSelectedOutlet(${outlet.id})"></i>
                                </span>
                            </td>
                        </tr>
                    `;
            });
        } else {
            tbody.innerHTML = '<tr><td colspan="3">No users found</td></tr>';
        }
    }

    function viewSelectedOutlet(outletID, action = null) {
        if (outletID) {
            getSingleOutlet(outletID)
                .done(function(result) {
                    if (result.data && result.data.id) {
                        $('#edit-outlet-id-input').val(result.data.id);
                        $('#edit-outlet-name-input').val(result.data.name);
                        $('#edit-outlet-phoneNo-input').val(result.data.phone_no);
                        $('#edit-outlet-address-input').val(result.data.address);
                        $("#editOutlet").modal('toggle');
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

    function deleteSelectedOutlet(outletID) {
        if (outletID) {
            $.confirm({
                title: 'Delete Record?',
                content: 'Are you sure You want to delete the selected outlet?',
                type: 'white',
                buttons: {
                    ok: {
                        text: "DELETE",
                        btnClass: 'btn btn-danger',
                        keys: ['enter'],
                        action: function() {
                            deleteSingleOutlet(outletID)
                                .done(function(result) {
                                    $('#message-toast').toast('show');
                                    $('#message-toast').addClass("bg-success");
                                    $('#message-toast-body').html("Success!   Outlet Delete successfull");
                                    loadData();
                                    clearInputs();
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

    function getSingleOutlet(id) {
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        return $.ajax({
            url: '/api/v1/outlet/' + id,
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

    function deleteSingleOutlet(id) {
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        return $.ajax({
            url: '/api/v1/outlet/' + id,
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

    $('#new-outlet-form').on('submit', function(e) {
        e.preventDefault();

        // Get CSRF token from meta tag
        const csrfToken = $('meta[name="csrf-token"]').attr('content');

        // Collect form data
        const name = $('#new-outlet-name-input').val();
        const email = $('#new-outlet-email-input').val();
        const phoneNo = $('#new-outlet-phoneNo-input').val();
        const address = $('#new-outlet-address-input').val();

        // Make an AJAX POST request
        $.ajax({
            url: '/api/v1/outlet',
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
                address: address
            }),
            xhrFields: {
                withCredentials: true,
            },
            success: function(response) {
                $('#newOutlet').modal('toggle');
                $('#message-toast').toast('show');
                $('#message-toast').addClass("bg-success");
                $('#message-toast-body').html("Success!   New Outlet Successfully Created!");
                loadData();
                clearInputs();
            },
            error: function(xhr) {
                $('#newOutletErrorMessages').show();
                $('#newOutletErrorMessages').html("Error!   New Outlet Creation Failed!");
            },
        });
    });

    $('#edit-outlet-form').on('submit', function(e) {
        e.preventDefault();

        // Get CSRF token from meta tag
        const csrfToken = $('meta[name="csrf-token"]').attr('content');

        // Collect form data
        const id = $('#edit-outlet-id-input').val();
        const name = $('#edit-outlet-name-input').val();
        const phoneNo = $('#edit-outlet-phoneNo-input').val();
        const address = $('#edit-outlet-address-input').val();

        // Make an AJAX POST request
        $.ajax({
            url: '/api/v1/outlet/' + id,
            method: 'PUT',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            contentType: 'application/json',
            data: JSON.stringify({
                name: name,
                phone_no: phoneNo,
                address: address
            }),
            xhrFields: {
                withCredentials: true,
            },
            success: function(response) {
                $('#editOutlet').modal('toggle');
                $('#message-toast').toast('show');
                $('#message-toast').addClass("bg-success");
                $('#message-toast-body').html("Success!!   Outlet Update Successfull!");
                loadData();
                clearInputs();
            },
            error: function(xhr) {
                $('#editOutletErrorMessages').show();
                $('#editOutletErrorMessages').html("Error!!   Outlet Update Failed!");
            },
        });
    });

    function clearInputs() {
        $('#new-outlet-name-input').val(null);
        $('#new-outlet-email-input').val(null);
        $('#new-outlet-phoneNo-input').val(null);
        $('#new-outlet-address-input').val(null);
        $('#edit-outlet-name-input').val(null);
        $('#edit-outlet-phoneNo-input').val(null);
        $('#edit-outlet-address-input').val(null);
        $('#edit-outlet-id-input').val(null);
    }
</script>

@endsection
