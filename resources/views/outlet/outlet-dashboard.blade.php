@extends('layouts.user_type.auth')

@section('content')

<div>
    <div class="row mx-4 mt-4 mb-6">
        <div class="col-3 col-md-3 mb-4">
            <a href="{{ url('outlet/schedule') }}">
                <div class="card bg-gradient-secondary text-white text-bolder cursor-pointer">
                    <div class="card-body p-3 d-flex align-items-center justify-content-center">
                        <div class="d-flex align-items-center justify-content-center">
                            <i class="fas fa-th-list mx-2"></i>
                            <span>View Gas Schedule</span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-3 col-md-3 mb-4">
            <a href="{{ url('admin/outlet-manager') }}">
                <div class="card bg-gradient-secondary text-white text-bolder cursor-pointer">
                    <div class="card-body p-3 d-flex align-items-center justify-content-center">
                        <div class="d-flex align-items-center justify-content-center">
                            <i class="fas fa-users-cog mx-2"></i>
                            <span>Gas Outlet Magesrs</span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
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
        <div class="col-3">
            <div class="card mx-2 mb-4 bg-gradient-info text-white text-bolder cursor-pointer"
                data-bs-toggle="modal" data-bs-target="#request-payment-mark">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-center">
                        <i class="fas fa-money-check-alt mx-2"></i>
                        <span>Empty / Payments</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card mx-2 mb-4 bg-gradient-success text-white text-bolder cursor-pointer">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-center">
                        <i class="fas fa-check-double mx-2"></i>
                        <span>Pickups</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card mx-2 mb-4 bg-gradient-danger text-white text-bolder cursor-pointer">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-center">
                        <i class="fas fa-user-plus mx-2"></i>
                        <span>Reassign Consumer</span>
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
                            <h5 class="mb-0">Current Gas Requests</h5>
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
                                        Request Type
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Request Quantity
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Gas Type
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Consumer Email
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Consumer Phone No
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
                                <label for="new-request-schedule-select" class="form-control-label">Select the Schedule</label>
                                <select class="form-control" id="new-request-schedule-select" required>
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
                        <div class="col-6">
                            <label for="consumer-search-input" class="form-control-label">Search by consumer email</label>
                            <div class="input-group mb-3">
                                <input type="text" class="typeahead form-control" id="consumer-search-input" placeholder="user@user.com">
                                <button class="btn btn-outline-warning mb-0 btn-icon btn-2" type="button" onclick="searchConsumerByNIC()">
                                    <i class="fas fa-search"></i> Search
                                </button>
                            </div>
                            <input type="hidden" id="new-request-consumer-id" required>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="new-request-gas-quantity" class="form-control-label">Consumer Type</label>
                                <input class="form-control" type="text" readonly id="new-request-consumer-type">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="admin-email-input" class="form-control-label">Consumer Email</label>
                                <input class="form-control" type="email" readonly placeholder="user@user.com" id="new-request-consumer-email">
                            </div>
                            <div class="form-group">
                                <label for="admin-phoneNo-input" class="form-control-label">Consumer Phone No</label>
                                <input class="form-control" type="text" readonly placeholder="+9471 2823427" id="new-request-consumer-phoneNo">
                            </div>
                        </div>
                        <dic class="col-6">
                            <div class="form-group">
                                <label for="admin-phoneNo-input" class="form-control-label">Consumer NIC</label>
                                <input class="form-control" type="text" readonly placeholder="199228300401 or 273618362V" id="new-request-consumer-nic">
                            </div>
                            <div class="form-group">
                                <label for="admin-phoneNo-input" class="form-control-label">Consumer Business No</label>
                                <input class="form-control" type="text" readonly placeholder="BSD-3456FG" id="new-request-consumer-businessNo">
                            </div>
                        </dic>
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

<div class="modal fade" id="request-payment-mark" tabindex="-1" role="dialog" aria-labelledby="requestPaymentMarktModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-normal" id="requestPaymentMarkModalLabel">Mark Empty and Payments</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="new-request-form" role="form" method="POST">
                    <div class="row">
                        <div class="col-6">
                            <label for="mark-payment-search-token" class="form-control-label">Search by request token</label>
                            <div class="input-group mb-3">
                                <input type="text" class="typeahead form-control" id="mark-payment-search-token" placeholder="Enter Token">
                                <button class="btn btn-outline-warning mb-0 btn-icon btn-2" type="button" onclick="searchRequestByToken()">
                                    <i class="fas fa-search"></i> Search
                                </button>
                            </div>
                            <input type="hidden" id="mark-payment-request-search-id" required>
                        </div>
                        <div class="col-6">
                            <p class="text-danger mt-4" id="mark-payment-request-search-error"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label for="mark-payment-consumer-type" class="form-control-label">Cunsumer Type</label>
                                <input class="form-control" type="text" readonly id="mark-payment-consumer-type">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="mark-payment-consumer-email" class="form-control-label">Cunsumer Email</label>
                                <input class="form-control" type="text" readonly id="mark-payment-consumer-email">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="mark-payment-consumer-nic" class="form-control-label">Cunsumer NIC</label>
                                <input class="form-control" type="text" readonly id="mark-payment-consumer-nic">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="mark-payment-consumer-phoneNo" class="form-control-label">Cunsumer Phone No</label>
                                <input class="form-control" type="text" readonly id="mark-payment-consumer-phoneNo">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="mark-payment-consumer-businessNo" class="form-control-label">Cunsumer Business No</label>
                                <input class="form-control" type="text" readonly id="mark-payment-consumer-businessNo">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label for="mark-payment-outlet-name" class="form-control-label">Outlet Name</label>
                                <input class="form-control" type="text" readonly id="mark-payment-outlet-name">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="mark-payment-schedule-data" class="form-control-label">Schedule Date</label>
                                <input class="form-control" type="text" readonly id="mark-payment-schedule-date">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="mark-payment-schedule-status" class="form-control-label">Schedule Status</label>
                                <input class="form-control" type="text" readonly id="mark-payment-schedule-status">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label for="mark-payment-gas-type" class="form-control-label">Gas Type</label>
                                <input class="form-control" type="text" readonly id="mark-payment-gas-type">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="mark-payment-gas-quantity" class="form-control-label">Quantity</label>
                                <input class="form-control" type="text" readonly id="mark-payment-gas-quantity">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="mark-payment-total-price" class="form-control-label">Total Price</label>
                                <input class="form-control" type="text" readonly id="mark-payment-total-price">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="form-check form-check-info text-left">
                                <input class="form-check-input" type="checkbox" required id="mark-payment-got-empty">
                                <label class="form-check-label" for="mark-payment-got-empty">
                                    Empty cylinders handovered.
                                </label>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-check form-check-info text-left">
                                <input class="form-check-input" type="checkbox" required id="mark-payment-got-payment">
                                <label class="form-check-label" for="mark-payment-got-payment">
                                    Total payment is done
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" id="mark-payment-submit-button" class="btn bg-gradient-warning w-100 mt-4 mb-0">Mark Empty and Payment</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="alert alert-danger text-white w-100" style="display: none;" role="alert" id="requestPaymentMarkErrorMessages"></div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        let availableScheduleList = [];
        let availableGasList = [];
        loadData();
        clearFields();
        getAvailableSchedules();
        getAvailableGasTypes();
        setupSelectChangeHandlers();
    });

    function getAvailableSchedules() {
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        const outletID = JSON.parse(localStorage.getItem('me')).id;
        $.ajax({
            url: '/api/v1/schedule/outlet/' + outletID,
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
                    availableScheduleList = response.data;
                    $.each(response.data, function(i, schedule) {
                        $('#new-request-schedule-select').append($('<option>', {
                            value: schedule.id,
                            text: schedule.schedule_date
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
        $('#new-request-schedule-select').on('change', function() {
            const seletedScheduleIndexValue = this.value;
            let selectedSchedule = availableScheduleList.find(schedule => schedule.id == seletedScheduleIndexValue);
            if (selectedSchedule) {
                $('#new-request-seleted-schedule-quantity').val(selectedSchedule.available_quantity);
            }
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
            url: '/api/v1/request',
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
                            <td class='align-middle text-center'>${data.request.type ? data.request.type : '~none~'}</td>
                            <td class='align-middle text-center'>${data.request.quantity ? data.request.quantity : '~none~'}</td>
                            <td class='align-middle text-center'>${data.gas.weight ? data.gas.weight : '~none~'}</td>
                            <td class='align-middle text-center'>${data.consumer.email ? data.consumer.email : '~none~'}</td>
                            <td class='align-middle text-center'>${data.consumer.phone_no ? data.consumer.phone_no : '~none~'}</td>
                        </tr>
                    `;
            });
        } else {
            tbody.innerHTML = '<tr><td colspan="7">No Gas found</td></tr>';
        }
    }

    function searchConsumerByNIC() {
        $('#newRequestErrorMessages').hide();
        const search = $('#consumer-search-input').val();
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        return $.ajax({
            url: '/api/v1/consumer/search?search=' + search,
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
                    $('#new-request-consumer-id').val(response.data.id);
                    $('#new-request-consumer-email').val(response.data.user_email ? response.data.user_email : '~ none ~');
                    $('#new-request-consumer-nic').val(response.data.nic ? response.data.nic : '~ none ~');
                    $('#new-request-consumer-phoneNo').val(response.data.phone_no ? response.data.phone_no : '~ none ~');
                    $('#new-request-consumer-businessNo').val(response.data.business_no ? response.data.business_no : '~ none ~');
                    $('#new-request-consumer-type').val(response.data.type ? response.data.type : '~ none ~');
                    $('#new-request-gas-quantity').val('1');
                } else {
                    $('#newRequestErrorMessages').show();
                    $('#newRequestErrorMessages').html("Error!   Outlet Not Found!");
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
        const scheduleId = $('#new-request-schedule-select').val();

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

    function searchRequestByToken() {
        const csrfToken = $('meta[name="csrf-token"]').attr('content');

        const outletID = JSON.parse(localStorage.getItem('me')).outlet_id;

        const token = $('#mark-payment-search-token').val();

        if (!token) {
            $('#mark-payment-request-search-error').html('<small>Token is required</small>');
            return;
        } else {
            $('#mark-payment-request-search-error').html('');
            $('#mark-payment-got-empty').prop('disabled', false);
            $('#mark-payment-got-payment').prop('disabled', false);
        }

        $.ajax({
            url: '/api/v1/request/token/' + token,
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
                if (response && response.data && response.data.consumer && response.data.gas && response.data.outlet && response.data.schedule && response.data.request) {
                    $('#mark-payment-submit-button').prop('disabled', false);
                    $('#mark-payment-consumer-type').val(response.data.consumer.type ? response.data.consumer.type : '~ none ~');
                    $('#mark-payment-consumer-email').val(response.data.consumer.email ? response.data.consumer.email : '~ none ~');
                    $('#mark-payment-consumer-nic').val(response.data.consumer.nic ? response.data.consumer.nic : '~ none ~');
                    $('#mark-payment-consumer-phoneNo').val(response.data.consumer.phone_no ? response.data.consumer.phone_no : '~ none ~');
                    $('#mark-payment-consumer-businessNo').val(response.data.consumer.business_no ? response.data.consumer.business_no : '~ none ~');

                    $('#mark-payment-outlet-name').val(response.data.outlet.name ? response.data.outlet.name : '~ none ~');

                    $('#mark-payment-schedule-date').val(response.data.schedule.schedule_date ? response.data.schedule.schedule_date : '~ none ~');
                    $('#mark-payment-schedule-status').val(response.data.schedule.status ? response.data.schedule.status : '~ none ~');

                    $('#mark-payment-gas-type').val(response.data.gas.weight ? response.data.gas.weight : '~ none ~');

                    $('#mark-payment-gas-quantity').val(response.data.request.quantity ? response.data.request.quantity : '~ none ~');

                    $('#mark-payment-total-price').val((response.data.gas.price * response.data.request.quantity));

                    $('#mark-payment-request-search-id').val(response.data.request.id ? response.data.request.id : '~ none ~');

                    if (response.data.outlet.id === outletID) {
                        $('#mark-payment-submit-button').prop('disabled', true);
                        $('#mark-payment-got-empty').prop('disabled', true);
                        $('#mark-payment-got-payment').prop('disabled', true);
                        $('#mark-payment-request-search-error').html('<small>Request not linked with this outlet.</small>');
                    }

                    if (response.data.schedule.status === 'PENDING') {
                        $('#mark-payment-submit-button').prop('disabled', true);
                        $('#mark-payment-got-empty').prop('disabled', true);
                        $('#mark-payment-got-payment').prop('disabled', true);
                        $('#mark-payment-request-search-error').html('<small>Schedule is not confirmed yet.</small>');
                    }
                } else {
                    clearFields();
                    $('#requestPaymentMarkErrorMessages').show();
                    $('#requestPaymentMarkErrorMessages').html("Error!  Request not found. Please try again.");
                }
            },
            error: function(xhr) {
                clearFields();
                $('#requestPaymentMarkErrorMessages').show();
                $('#requestPaymentMarkErrorMessages').html("Error!  Request not found. Please try again.");
            },
        });
    }

    function clearFields() {
        $('#new-request-consumer-type').val(null);
        $('#consumer-search-input').val(null);
        $('#new-request-gas-quantity').val(null);
        $('#mark-payment-consumer-type').val(null);
        $('#mark-payment-consumer-email').val(null);
        $('#mark-payment-consumer-nic').val(null);
        $('#mark-payment-consumer-phoneNo').val(null);
        $('#mark-payment-consumer-businessNo').val(null);
        $('#mark-payment-outlet-name').val(null);
        $('#mark-payment-schedule-date').val(null);
        $('#mark-payment-schedule-status').val(null);
        $('#mark-payment-gas-type').val(null);
        $('#mark-payment-gas-quantity').val(null);
        $('#mark-payment-total-price').val(null);
        $('#mark-payment-request-search-id').val(null);
    }
</script>

@endsection
