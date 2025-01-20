@extends('layouts.user_type.auth')

@section('content')

<div>
    <div class="row mb-4">
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
            <div class="card mx-2 mb-4 bg-gradient-info text-white text-bolder cursor-pointer">
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
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="requestTableBody">
                                <tr>
                                    <td colspan="8">Loading Gas Requests ....</td>
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
                                <select class="form-control" id="new-request-schedule-select">
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
                                <select class="form-control" id="new-request-gasType-select">
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
                            <div class="form-group">
                                <label for="new-request-consumer-select" class="form-control-label">Select Consumer Type</label>
                                <select class="form-control" id="new-request-consumer-select">
                                    <option value="CUSTOMER">Customer</option>
                                    <option value="BUSINESS">Business</option>
                                    <option value="OUTLET">Outlet</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="new-request-gas-quantity" class="form-control-label">Gas Quantity</label>
                                <input class="form-control" type="text" placeholder="" id="new-request-gas-quantity">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="admin-email-input" class="form-control-label">Consumer Email</label>
                        <input class="form-control" type="email" required placeholder="user@user.com" id="new-request-consumer-email">
                    </div>
                    <div class="form-group">
                        <label for="admin-phoneNo-input" class="form-control-label">Consumer Phone No</label>
                        <input class="form-control" type="text" required placeholder="+9471 2823427" id="new-request-consumer-phoneNo">
                    </div>
                    <div class="form-group">
                        <label for="admin-phoneNo-input" class="form-control-label">Consumer NIC</label>
                        <input class="form-control" type="text" required placeholder="199228300401 or 273618362V" id="new-request-consumer-nic">
                    </div>
                    <div class="form-group">
                        <label for="admin-phoneNo-input" class="form-control-label">Consumer Business No</label>
                        <input class="form-control" type="text" readonly placeholder="BSD-3456FG" id="new-request-consumer-businessNo">
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
        let availableScheduleList = [];
        let availableGasList = [];
        loadData();
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
        $('#new-request-consumer-select').on('change', function() {
            switch (this.value) {
                case 'BUSINESS':
                    $('#new-request-consumer-businessNo').attr("readonly", false);
                    break;
                default:
                    $('#new-request-consumer-businessNo').attr("readonly", true);
                    break;
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
                            <td class='align-middle text-center'>
                                <a href="#" class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Edit user">
                                    <i class="fas fa-user-edit text-secondary"></i>
                                </a>
                                <span>
                                    <i class="cursor-pointer fas fa-trash text-secondary"></i>
                                </span>
                            </td>
                        </tr>
                    `;
            });
        } else {
            tbody.innerHTML = '<tr><td colspan="3">No Gas found</td></tr>';
        }
    }

    $('#new-request-form').on('submit', function(e) {
        e.preventDefault();

        // Get CSRF token from meta tag
        const csrfToken = $('meta[name="csrf-token"]').attr('content');

        // Collect form data
        const con_email = $('#new-request-consumer-email').val();
        const con_phone_no = $('#new-request-consumer-phoneNo').val();
        const con_nic = $('#new-request-consumer-nic').val();
        const con_business_no = $('#new-request-consumer-businessNo').val();
        const quantity = $('#new-request-gas-quantity').val();

        const schedule_type = $('#new-request-consumer-select').val();
        const gasId = $('#new-request-gasType-select').val();
        const scheduleId = $('#new-request-schedule-select').val();
        const consumer_type = schedule_type;

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
                type: schedule_type,
                quantity: quantity,
                con_email:con_email,
                con_phone_no:con_phone_no,
                con_type:consumer_type,
                con_nic:con_nic,
                con_business_no:con_business_no
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
            },
            error: function(xhr) {
                $('#newRequestErrorMessages').show();
                if (xhr.errors) {
                    $('#newRequestErrorMessages').html("Error!   Please fill all the required fields!");
                } else {
                    $('#newRequestErrorMessages').html("Error!   New Request Create Failed!");
                }
            },
        });
    });
</script>

@endsection
