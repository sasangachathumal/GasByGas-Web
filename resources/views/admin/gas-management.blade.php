@extends('layouts.user_type.auth')

@section('content')

<div>
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">All Gas</h5>
                        </div>
                        <button type="button" class="btn bg-gradient-warning  btn-sm mb-0" data-bs-toggle="modal" data-bs-target="#new-gas-modal">
                            +&nbsp; New Gas
                        </button>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        ID
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Weight
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Price (LKR)
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="gasTableBody">
                                <tr>
                                    <td colspan="4">Loading Gas ....</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- New Gas Create Modal-->
<div class="modal fade" id="new-gas-modal" tabindex="-1" role="dialog" aria-labelledby="newGasModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-normal" id="newGasModalLabel">Create New Gas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="new-gas-form" role="form" method="POST">
                    <div class="form-group">
                        <label for="new-gas-weight-input" class="form-control-label">Gas Weight</label>
                        <input class="form-control" type="text" required placeholder="2.5KG" id="new-gas-weight-input">
                    </div>
                    <div class="form-group">
                        <label for="new-gas-price-input" class="form-control-label">Gas Price (LKR)</label>
                        <input class="form-control" type="text" required placeholder="200" id="new-gas-price-input">
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn bg-gradient-warning w-100 mt-4 mb-0">Save</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="alert alert-danger text-white" style="display: none;" role="alert" id="newGasErrorMessages"></div>
            </div>
        </div>
    </div>
</div>

<!-- Gas Edit Modal-->
<div class="modal fade show" id="edit-gas-modal" tabindex="-1" role="dialog" aria-labelledby="editGasModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-normal" id="editGasModalLabel">Edit Gas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="edit-gas-form" role="form" method="PUT">
                    <div class="form-group">
                        <label for="edit-gas-weight-input" class="form-control-label">Gas Weight</label>
                        <input class="form-control" type="text" required placeholder="2.5KG" id="edit-gas-weight-input">
                    </div>
                    <div class="form-group">
                        <label for="edit-gas-price-input" class="form-control-label">Gas Price (LKR)</label>
                        <input class="form-control" type="text" required placeholder="200" id="edit-gas-price-input">
                    </div>
                    <input type="hidden" required id="edit-gas-id-input">
                    <div class="text-center">
                        <button type="submit" class="btn bg-gradient-warning w-100 mt-4 mb-0">Save Changes</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="alert alert-danger text-white" style="display: none;" role="alert" id="editGasErrorMessages"></div>
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
        $("#edit-gas-modal").modal();
        loadData();
        clearInputs();
    });

    function loadData() {
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        const access_token = JSON.parse(localStorage.getItem('access_token'));
        $.ajax({
            url: '/api/v1/gas',
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
    }

    function loadDataToTable(response) {
        let returnData = '';
        const tbody = document.querySelector('#gasTableBody');
        tbody.innerHTML = '';
        if (response && response.data && response.data.length > 0) {
            response.data.forEach(gas => {
                tbody.innerHTML += `
                        <tr>
                            <td class='align-middle text-center'>${gas.id ? gas.id : '~none~'}</td>
                            <td class='align-middle text-center'>${gas.weight ? gas.weight : '~none~'}</td>
                            <td class='align-middle text-center'>${gas.price ? gas.price : '~none~'}</td>
                            <td class='align-middle text-center'>
                                <span>
                                    <i class="cursor-pointer fas fa-pencil-alt text-secondary mx-3" onclick="viewSelectedGas(${gas.id})"></i>
                                </span>
                                <span>
                                    <i class="cursor-pointer fas fa-trash text-danger mx-3" onclick="deleteSelectedGas(${gas.id})"></i>
                                </span>
                            </td>
                        </tr>
                    `;
            });
        } else {
            tbody.innerHTML = '<tr><td colspan="3">No Gas found</td></tr>';
        }
    }

    function viewSelectedGas(gasID) {
        if (gasID) {
            getSingleGas(gasID)
                .done(function(result) {
                    if (result.data && result.data.id) {
                        $('#edit-gas-id-input').val(result.data.id);
                        $('#edit-gas-weight-input').val(result.data.weight);
                        $('#edit-gas-price-input').val(result.data.price);
                        $("#edit-gas-modal").modal('toggle');
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

    function deleteSelectedGas(gasID) {
        if (gasID) {
            $.confirm({
                title: 'Delete Record?',
                content: 'Are you sure You want to delete the selected gas?',
                type: 'white',
                buttons: {
                    ok: {
                        text: "DELETE",
                        btnClass: 'btn btn-danger',
                        keys: ['enter'],
                        action: function() {
                            deleteSingleGas(gasID)
                                .done(function(result) {
                                    $('#message-toast').toast('show');
                                    $('#message-toast').addClass("bg-success");
                                    $('#message-toast-body').html("Success!   Gas Delete successfull");
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

    function getSingleGas(id) {
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        const access_token = JSON.parse(localStorage.getItem('access_token'));
        return $.ajax({
            url: '/api/v1/gas/' + id,
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

    function deleteSingleGas(id) {
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        const access_token = JSON.parse(localStorage.getItem('access_token'));
        return $.ajax({
            url: '/api/v1/gas/' + id,
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

    $('#new-gas-form').on('submit', function(e) {
        e.preventDefault();

        // Get CSRF token from meta tag
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        const access_token = JSON.parse(localStorage.getItem('access_token'));

        // Collect form data
        const weight = $('#new-gas-weight-input').val();
        const price = $('#new-gas-price-input').val();

        // Make an AJAX POST request
        $.ajax({
            url: '/api/v1/gas',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'Authorization': `Bearer ${access_token}`
            },
            contentType: 'application/json',
            data: JSON.stringify({
                weight: weight,
                price: price
            }),
            xhrFields: {
                withCredentials: true,
            },
            success: function(response) {
                $('#new-gas-modal').modal('toggle');
                $('#message-toast').toast('show');
                $('#message-toast').addClass("bg-success");
                $('#message-toast-body').html("Success!   New Gas Successfully Created!");
                loadData();
                clearInputs();
            },
            error: function(xhr) {
                $('#newGasErrorMessages').show();
                $('#newGasErrorMessages').html("Error!   New Gas Creation Failed!");
            },
        });
    });

    $('#edit-gas-form').on('submit', function(e) {
        e.preventDefault();

        // Get CSRF token from meta tag
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        const access_token = JSON.parse(localStorage.getItem('access_token'));

        // Collect form data
        const id = $('#edit-gas-id-input').val();
        const weight = $('#edit-gas-weight-input').val();
        const price = $('#edit-gas-price-input').val();

        // Make an AJAX POST request
        $.ajax({
            url: '/api/v1/gas/' + id,
            method: 'PUT',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'Authorization': `Bearer ${access_token}`
            },
            contentType: 'application/json',
            data: JSON.stringify({
                weight: weight,
                price: price
            }),
            xhrFields: {
                withCredentials: true,
            },
            success: function(response) {
                $('#edit-gas-modal').modal('toggle');
                $('#message-toast').toast('show');
                $('#message-toast').addClass("bg-success");
                $('#message-toast-body').html("Success!!   Gas Update Successfull!");
                loadData();
                clearInputs();
            },
            error: function(xhr) {
                $('#editGasErrorMessages').show();
                $('#editGasErrorMessages').html("Error!!   Gas Update Failed!");
            },
        });
    });

    function clearInputs() {
        $('#new-gas-weight-input').val(null);
        $('#new-gas-price-input').val(null);
        $('#edit-gas-weight-input').val(null);
        $('#edit-gas-price-input').val(null);
        $('#edit-gas-id-input').val(null);
    }
</script>

@endsection
