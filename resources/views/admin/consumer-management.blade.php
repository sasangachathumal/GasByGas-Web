@extends('layouts.user_type.auth')

@section('content')

<div>
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">All Consumers</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Consumer ID
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Consumer Email
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Consumer Type
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Consumer Status
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Consumer Phone No
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Consumer NIC
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Consumer Business No
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

<div class="modal fade" id="viewConsumer" tabindex="-1" role="dialog" aria-labelledby="viewConsumerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-normal" id="viewConsumerModalLabel">View Consumer Details</h5>
                <button type="button" class="btn-close btn-light" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="false">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="form-group">
                        <label for="view-consumer-email" class="form-control-label">Consumer email</label>
                        <input class="form-control" type="text" readonly id="view-consumer-email">
                    </div>
                    <div class="form-group">
                        <label for="view-schedule-outlet-name" class="form-control-label">Consumer Type</label>
                        <input class="form-control" type="text" readonly id="view-consumer-type">
                    </div>
                    <div class="form-group">
                        <label for="view-schedule-outlet-name" class="form-control-label">Consumer Status</label>
                        <input class="form-control" type="text" readonly id="view-consumer-status">
                    </div>
                    <div class="form-group">
                        <label for="view-schedule-outlet-name" class="form-control-label">Consumer Phone No</label>
                        <input class="form-control" type="text" readonly id="view-consumer-phoneNo">
                    </div>
                    <div class="form-group">
                        <label for="view-schedule-outlet-name" class="form-control-label">Consumer NIC</label>
                        <input class="form-control" type="text" readonly id="view-consumer-nic">
                    </div>
                    <div class="form-group">
                        <label for="view-schedule-outlet-name" class="form-control-label">Consumer Business No</label>
                        <input class="form-control" type="text" readonly id="view-consumer-businessNo">
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
        $.ajax({
            url: '/api/v1/consumer',
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
                            <td class='align-middle text-center'>${data.id ? data.id : '~none~'}</td>
                            <td class='align-middle text-center'>${data.user_email ? data.user_email : '~none~'}</td>
                            <td class='align-middle text-center'>${data.type ? data.type : '~none~'}</td>
                            <td class='align-middle text-center'>${data.status ? data.status : '~none~'}</td>
                            <td class='align-middle text-center'>${data.phone_no ? data.phone_no : '~none~'}</td>
                            <td class='align-middle text-center'>${data.nic ? data.nic : '~none~'}</td>
                            <td class='align-middle text-center'>${data.business_no ? data.business_no : '~none~'}</td>
                            <td class='align-middle text-center'>
                                <span>
                                    <i class="cursor-pointer fas fa-expand-arrows-alt text-secondary mx-3" onclick="viewSelectedConsumer(${data.id})"></i>
                                </span>
                                <span>
                                    <i class="cursor-pointer fas fa-trash text-danger mx-3" onclick="deleteSelectedConsumer(${data.id})"></i>
                                </span>
                            </td>
                        </tr>
                    `;
            });
        } else {
            tbody.innerHTML = '<tr><td colspan="3">No Gas found</td></tr>';
        }
    }

    function viewSelectedConsumer(consumerID) {
        if (consumerID) {
            getSingleConsumer(consumerID)
                .done(function(response) {
                    if (response.data && response.data) {
                        const result = response.data;
                        $('#view-consumer-businessNo').val(result.business_no ? result.business_no : '~none~');
                        $('#view-consumer-nic').val(result.nic ? result.nic : '~none~');
                        $('#view-consumer-phoneNo').val(result.phone_no ? result.phone_no : '~none~');
                        $('#view-consumer-status').val(result.status ? result.status : '~none~');
                        $('#view-consumer-type').val(result.type ? result.type : '~none~');
                        $('#view-consumer-email').val(result.user_email ? result.user_email : '~none~');

                        $("#viewConsumer").modal('toggle');
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

    function getSingleConsumer(id) {
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        return $.ajax({
            url: '/api/v1/consumer/' + id,
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

    function deleteSelectedConsumer(consumerID) {
        if (consumerID) {
            $.confirm({
                title: 'Delete Record?',
                content: 'Are you sure You want to delete the selected Consumer?',
                type: 'white',
                buttons: {
                    ok: {
                        text: "DELETE",
                        btnClass: 'btn btn-danger',
                        keys: ['enter'],
                        action: function() {
                            deleteSingleConsumer(consumerID)
                                .done(function(result) {
                                    $('#message-toast').toast('show');
                                    $('#message-toast').addClass("bg-success");
                                    $('#message-toast-body').html("Success!   Consumer Delete successfull");
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

    function deleteSingleConsumer(id) {
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        return $.ajax({
            url: '/api/v1/consumer/' + id,
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
</script>

@endsection
