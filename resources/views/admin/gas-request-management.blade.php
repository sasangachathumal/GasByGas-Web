@extends('layouts.user_type.auth')

@section('content')

<div>
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">All Gas Requests</h5>
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
                                        Outlet Name
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

<div class="modal fade" id="viewGasRequest" tabindex="-1" role="dialog" aria-labelledby="viewGasRequestModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-normal" id="viewGasRequestModalLabel">View Request Details</h5>
                <button type="button" class="btn-close btn-light" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="false">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-4 ms-auto">
                            <h4>Request Details</h4>
                            <div class="form-group" id="view-schedule-outlet-name-container">
                                <label for="view-schedule-outlet-name" class="form-control-label">Request Type</label>
                                <input class="form-control" type="text" readonly id="view-request-type">
                            </div>
                            <div class="form-group">
                                <label for="view-schedule-outlet-email" class="form-control-label">Request Status</label>
                                <input class="form-control" type="text" readonly id="view-srequest-status">
                            </div>
                            <div class="form-group">
                                <label for="view-schedule-outlet-phoneNo" class="form-control-label">Request Quantity</label>
                                <input class="form-control" type="text" readonly id="view-request-quantity">
                            </div>
                            <div class="form-group">
                                <label for="view-schedule-outlet-status" class="form-control-label">Request Expired Date</label>
                                <input class="form-control" type="text" readonly id="view-request-expired">
                            </div>
                            <h4 class="mt-2">Gas Details</h4>
                            <div class="form-group">
                                <label for="edit-schedule-date" class="form-control-label">Gas Weight</label>
                                <input class="form-control" type="text" readonly id="view-gas-weight">
                            </div>
                            <div class="form-group">
                                <label for="edit-schedule-max-quentity" class="form-control-label">Gas Price</label>
                                <input class="form-control" type="text" readonly id="view-gas-price">
                            </div>
                        </div>
                        <div class="col-md-4 ms-auto">
                            <h4>Consumer Details</h4>
                            <div class="form-group">
                                <label for="edit-schedule-date" class="form-control-label">Consumer Type</label>
                                <input class="form-control" type="text" readonly id="view-consumer-type">
                            </div>
                            <div class="form-group">
                                <label for="edit-schedule-date" class="form-control-label">Consumer Email</label>
                                <input class="form-control" type="text" readonly id="view-consumer-email">
                            </div>
                            <div class="form-group">
                                <label for="edit-schedule-date" class="form-control-label">Consumer Phone Number</label>
                                <input class="form-control" type="text" readonly id="view-consumer-phoneNo">
                            </div>
                            <div class="form-group">
                                <label for="edit-schedule-max-quentity" class="form-control-label">Consumer NIC</label>
                                <input class="form-control" type="text" readonly id="view-consumer-nic">
                            </div>
                            <div class="form-group">
                                <label for="edit-schedule-date" class="form-control-label">Consumer Business Number</label>
                                <input class="form-control" type="text" readonly id="view-consumer-businessNo">
                            </div>
                        </div>
                        <div class="col-md-4 ms-auto">
                            <h4>Schedule Details</h4>
                            <div class="form-group">
                                <label for="edit-schedule-date" class="form-control-label">Schedule Status</label>
                                <input class="form-control" type="text" readonly id="view-schedule-status">
                            </div>
                            <div class="form-group">
                                <label for="edit-schedule-max-quentity" class="form-control-label">Schedule Date</label>
                                <input class="form-control" type="text" readonly id="view-schedule-date">
                            </div>
                            <div class="form-group">
                                <label for="edit-schedule-date" class="form-control-label">Schedule Max Quantity</label>
                                <input class="form-control" type="text" readonly id="view-schedule-max">
                            </div>
                            <div class="form-group">
                                <label for="edit-schedule-date" class="form-control-label">Schedule Available Quantity</label>
                                <input class="form-control" type="text" readonly id="view-schedule-available">
                            </div>
                            <h4 class="mt-2">Outlet Details</h4>
                            <div class="form-group">
                                <label for="edit-schedule-date" class="form-control-label">Outlet Name</label>
                                <input class="form-control" type="text" readonly id="view-outlet-name">
                            </div>
                            <div class="form-group">
                                <label for="edit-schedule-max-quentity" class="form-control-label">Outlet Email</label>
                                <input class="form-control" type="text" readonly id="view-outlet-email">
                            </div>
                            <div class="form-group">
                                <label for="edit-schedule-date" class="form-control-label">Outlet Phone Number</label>
                                <input class="form-control" type="text" readonly id="view-outlet-phoneNo">
                            </div>
                        </div>
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

<script>
    $(document).ready(function() {
        loadData();
    });

    function loadData() {
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        const access_token = JSON.parse(localStorage.getItem('access_token'));
        $.ajax({
            url: '/api/v1/request',
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
                            <td class='align-middle text-center'>${data.outlet.phone_no ? data.outlet.name : '~none~'}</td>
                            <td class='align-middle text-center'>
                                <span>
                                    <i class="cursor-pointer fas fa-expand-arrows-alt text-secondary mx-3" onclick="viewSelectedGasRequest(${data.request.id})"></i>
                                </span>
                                <span>
                                    <i class="cursor-pointer fas fa-trash text-danger mx-3" onclick="deleteSelectedRequest(${data.request.id})"></i>
                                </span>
                            </td>
                        </tr>
                    `;
            });
        } else {
            tbody.innerHTML = '<tr><td colspan="3">No Gas found</td></tr>';
        }
    }

    function viewSelectedGasRequest(requestID) {
        if (requestID) {
            getSingleGasRequest(requestID)
                .done(function(response) {
                    if (response.data && response.data) {
                        const result = response.data;
                        $('#view-request-type').val(result.request.type ? result.request.type : '~none~');
                        $('#view-srequest-status').val(result.request.status ? result.request.status : '~none~');
                        $('#view-request-quantity').val(result.request.quantity ? result.request.quantity : '~none~');
                        $('#view-request-expired').val(result.request.expired_at ? result.request.expired_at : '~none~');

                        $('#view-gas-weight').val(result.gas.weight ? result.gas.weight : '~none~');
                        $('#view-gas-price').val(result.gas.price ? result.gas.price : '~none~');

                        $('#view-consumer-email').val(result.consumer.email ? result.consumer.email : '~none~');
                        $('#view-consumer-nic').val(result.consumer.nic ? result.consumer.nic : '~none~');
                        $('#view-consumer-phoneNo').val(result.consumer.phone_no ? result.consumer.phone_no : '~none~');
                        $('#view-consumer-businessNo').val(result.consumer.business_no ? result.consumer.business_no : '~none~');
                        $('#view-consumer-type').val(result.consumer.type ? result.consumer.type : '~none~');

                        $('#view-schedule-status').val(result.schedule.status ? result.schedule.status : '~none~');
                        $('#view-schedule-date').val(result.schedule.schedule_date ? result.schedule.schedule_date : '~none~');
                        $('#view-schedule-max').val(result.schedule.max_quantity ? result.schedule.max_quantity : '~none~');
                        $('#view-schedule-available').val(result.schedule.available_quantity ? result.schedule.available_quantity : '~none~');

                        $('#view-outlet-name').val(result.outlet.name ? result.outlet.name : '~none~');
                        $('#view-outlet-email').val(result.outlet.email ? result.outlet.email : '~none~');
                        $('#view-outlet-phoneNo').val(result.outlet.phone_no ? result.outlet.phone_no : '~none~');

                        $("#viewGasRequest").modal('toggle');
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

    function getSingleGasRequest(id) {
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        const access_token = JSON.parse(localStorage.getItem('access_token'));
        return $.ajax({
            url: '/api/v1/request/' + id,
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

    function deleteSelectedRequest(requestID) {
        if (requestID) {
            $.confirm({
                title: 'Delete Record?',
                content: 'Are you sure You want to delete the selected Request?',
                type: 'white',
                buttons: {
                    ok: {
                        text: "DELETE",
                        btnClass: 'btn btn-danger',
                        keys: ['enter'],
                        action: function() {
                            deleteSingleRequest(requestID)
                                .done(function(result) {
                                    $('#message-toast').toast('show');
                                    $('#message-toast').addClass("bg-success");
                                    $('#message-toast-body').html("Success!   Request Delete successfull");
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

    function deleteSingleRequest(id) {
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        const access_token = JSON.parse(localStorage.getItem('access_token'));
        return $.ajax({
            url: '/api/v1/request/' + id,
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
</script>

@endsection
