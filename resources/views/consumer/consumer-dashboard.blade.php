@extends('layouts.user_type.auth')

@section('content')

<div>
    <div class="row mx-4 mb-4">
        <div class="col-3">
            <div class="card mx-2 mb-4 bg-gradient-warning text-white text-bolder cursor-pointer"
                data-bs-toggle="modal" data-bs-target="#new-request">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-center">
                        <i class="fas fa-plus-circle mx-2"></i>
                        <span>New Request</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">My Gas Requests</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Request ID
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Request Status
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Request Quantity
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Gas Type
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Schedule Date
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Schedule Status
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Outlet Name
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="requestTableBody">
                                <tr>
                                    <td colspan="7">Loading Gas Requests ....</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
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

<div class="modal fade" id="new-request" tabindex="-1" role="dialog" aria-labelledby="newRequestModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-normal" id="newRequestModalLabel">Create New Gas Request</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="new-request-form" role="form" method="POST">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="new-request-outlet-select" class="form-control-label">Select the Outlet</label>
                                <select class="form-control" id="new-request-outlet-select" required>
                                    <option value="-1">~ Schedules ~</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="new-request-seleted-schedule-quantity" class="form-control-label">Available Quantity</label>
                                <input class="form-control" type="text" readonly id="new-request-seleted-schedule-quantity">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="onew-request-gasType-select" class="form-control-label">Select Gas Type</label>
                                <select class="form-control" id="new-request-gasType-select" required>
                                    <option value="-1">~ Gas Types ~</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="new-request-seleted-gas-price" class="form-control-label">Gas Price</label>
                                <input class="form-control" type="text" readonly id="new-request-seleted-gas-price">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="new-request-gas-quantity" class="form-control-label">Gas Quantity</label>
                                <p class="text-danger my-1" id="new-request-gas-quantity-error"></p>
                                <input class="form-control" type="text" required id="new-request-gas-quantity">
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn bg-gradient-warning w-100 mt-4 mb-0">Save</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="alert alert-danger text-white w-100" style="display: none;" role="alert" id="newRequestErrorMessages"></div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        let availableOutletList = [];
        let availableGasList = [];
        loadData();
        clearFields();
        getAvailableOutlets();
        getAvailableGasTypes();
        setupSelectChangeHandlers();
    });

    function getAvailableOutlets() {
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
                if (response && response.data.length > 0) {
                    availableOutletList = response.data;
                    $.each(response.data, function(i, outlet) {
                        $('#new-request-outlet-select').append($('<option>', {
                            value: outlet.id,
                            text: outlet.name
                        }));
                    });
                } else {
                    $('#newRequestErrorMessages').show();
                    $('#newRequestErrorMessages').html("Error!  Schedules not found. Please try again.");
                }
            },
            error: function(xhr) {
                $('#newRequestErrorMessages').show();
                $('#newRequestErrorMessages').html("Error!  Schedules not found. Please try again.");
            },
        });
    }

    function getAvailableGasTypes() {
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: '/api/v1/gas',
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
                if (response && response.data.length > 0) {
                    availableGasList = response.data;
                    $.each(response.data, function(i, gas) {
                        $('#new-request-gasType-select').append($('<option>', {
                            value: gas.id,
                            text: gas.weight
                        }));
                    });
                } else {
                    $('#newRequestErrorMessages').show();
                    $('#newRequestErrorMessages').html("Error!  Gas not found. Please try again.");
                }
            },
            error: function(xhr) {
                $('#newRequestErrorMessages').show();
                $('#newRequestErrorMessages').html("Error!  Gas not found. Please try again.");
            },
        });
    }

    function setupSelectChangeHandlers() {
        $('#new-request-outlet-select').on('change', function() {
            const seletedScheduleIndexValue = this.value;
            getScheduleQuantity(seletedScheduleIndexValue);
        });
        $('#new-request-gasType-select').on('change', function() {
            const seletedIndexValue = this.value;
            let selectedGas = availableGasList.find(gas => gas.id == seletedIndexValue);
            if (selectedGas) {
                $('#new-request-seleted-gas-price').val(selectedGas.price);
            }
        });
    }

    function loadData() {
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: '/api/v1/request/user',
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
        const tbody = document.querySelector('#requestTableBody');
        tbody.innerHTML = '';
        if (response && response.data && response.data.length > 0) {
            response.data.forEach(data => {
                tbody.innerHTML += `
                        <tr>
                            <td class='align-middle text-center'>${data.request.id ? data.request.id : '~none~'}</td>
                            <td class='align-middle text-center'>${data.request.status ? data.request.status : '~none~'}</td>
                            <td class='align-middle text-center'>${data.request.quantity ? data.request.quantity : '~none~'}</td>
                            <td class='align-middle text-center'>${data.gas.weight ? data.gas.weight : '~none~'}</td>
                            <td class='align-middle text-center'>${data.schedule.schedule_date ? data.schedule.schedule_date : '~none~'}</td>
                            <td class='align-middle text-center'>${data.schedule.status ? data.schedule.status : '~none~'}</td>
                            <td class='align-middle text-center'>${data.outlet.name ? data.outlet.name : '~none~'}</td>
                        </tr>
                    `;
            });
        } else {
            tbody.innerHTML = '<tr><td colspan="7">No Gas found</td></tr>';
        }
    }

    function getScheduleQuantity(outletId) {
        $('#newRequestErrorMessages').hide();
        const csrfToken = $('meta[name="csrf-token"]').attr('content');

        return $.ajax({
            url: '/api/v1/schedule/outlet/' + outletId,
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
                if (response.data) {
                    let quantity = 0;
                    response.data.forEach(schedule => {
                        quantity += schedule.available_quantity;
                    });
                    $('#new-request-seleted-schedule-quantity').val(quantity);
                } else {
                    $('#newRequestErrorMessages').show();
                    $('#newRequestErrorMessages').html("Error!   Schedule Not Found!");
                }
            },
            error: function(xhr) {
                $('#newRequestErrorMessages').show();
                $('#newRequestErrorMessages').html("Error!   Please Try Again!");
            },
        });
    }

    $('#new-request-form').on('submit', function(e) {
        e.preventDefault();

        // Get CSRF token from meta tag
        const csrfToken = $('meta[name="csrf-token"]').attr('content');

        // Collect form data
        const consumerId = $('#new-request-consumer-id').val();
        const quantity = $('#new-request-gas-quantity').val();
        const type = $('#new-request-consumer-type').val();
        const gasId = $('#new-request-gasType-select').val();
        const scheduleId = $('#new-request-outlet-select').val();

        if (quantity <= 0) {
            $('#new-request-gas-quantity-error').html('<small>Enter valid quantity</small>');
            return;
        } else {
            $('#new-request-gas-quantity-error').html('');
        }

        // Make an AJAX POST request
        $.ajax({
            url: '/api/v1/request',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            contentType: 'application/json',
            data: JSON.stringify({
                schedule_id: scheduleId,
                gas_id: gasId,
                consumer_id: consumerId,
                type: type,
                quantity: quantity
            }),
            xhrFields: {
                withCredentials: true,
            },
            success: function(response) {
                $('#new-request').modal('toggle');
                $('#message-toast').toast('show');
                $('#message-toast').addClass("bg-success");
                $('#message-toast-body').html("Success!   New Request Successfully Creted!");
                loadData();
                clearFields();
            },
            error: function(xhr) {
                $('#newRequestErrorMessages').show();
                if (xhr.responseJSON && xhr.responseJSON.errors && xhr.responseJSON.errors.ACTIVE_REQ) {
                    $('#newRequestErrorMessages').html("Error!  " + xhr.responseJSON.errors.ACTIVE_REQ.message);
                } else {
                    $('#newRequestErrorMessages').html("Error!   New Request Create Failed!");
                }
            },
        });
    });

    function clearFields() {
        $('#new-request-consumer-type').val(null);
        $('#consumer-search-input').val(null);
        $('#new-request-gas-quantity').val(null);
    }
</script>

@endsection
