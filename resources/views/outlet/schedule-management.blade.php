@extends('layouts.user_type.auth')

@section('content')

<div>
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">All Schedules</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Schedule ID
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Schedule Status
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Schedule Date
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Max Quantity
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Available Quantity
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Outlet Name
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Outlet Email
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="scheduleTableBody">
                                <tr>
                                    <td colspan="8">Loading Schedules ....</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- View/Edit Schedule Create Modal-->
<div class="modal fade" id="viewSchedule" tabindex="-1" role="dialog" aria-labelledby="viewScheduleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-normal" id="viewScheduleModalLabel">View Schedule</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="false">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form id="edit-schedule-form" role="form" method="POST">
                        <div class="row">
                            <div class="col-md-6 ms-auto">
                                <h4>Outlet Details</h4>
                                <div class="form-group" id="view-schedule-outlet-name-container">
                                    <label for="view-schedule-outlet-name" class="form-control-label">Outlet Name</label>
                                    <input class="form-control" type="text" readonly id="view-schedule-outlet-name">
                                </div>
                                <div class="form-group">
                                    <label for="view-schedule-outlet-email" class="form-control-label">Outlet Email</label>
                                    <input class="form-control" type="text" readonly id="view-schedule-outlet-email">
                                </div>
                                <div class="form-group">
                                    <label for="view-schedule-outlet-phoneNo" class="form-control-label">Outlet Phone No</label>
                                    <input class="form-control" type="text" readonly id="view-schedule-outlet-phoneNo">
                                </div>
                                <div class="form-group">
                                    <label for="view-schedule-outlet-status" class="form-control-label">Outlet Status</label>
                                    <input class="form-control" type="text" readonly id="view-schedule-outlet-status">
                                </div>
                                <div class="form-group">
                                    <label for="view-schedule-outlet-address" class="form-control-label">Outlet Address</label>
                                    <input class="form-control" type="text" readonly id="view-schedule-outlet-address">
                                </div>
                            </div>
                            <div class="col-md-6 ms-auto">
                                <h4>Schedule Details</h4>
                                <div class="form-group">
                                    <label for="view-schedule-date" class="form-control-label">Schedule Date</label>
                                    <input class="form-control" type="date" readonly id="view-schedule-date">
                                </div>
                                <div class="form-group">
                                    <label for="view-schedule-max-quentity" class="form-control-label">Schedule Quentity</label>
                                    <input class="form-control" type="text" readonly id="view-schedule-max-quentity">
                                </div>
                                <div class="form-group">
                                    <label for="eviewdit-available-quentity" class="form-control-label">Available Quentity</label>
                                    <input class="form-control" type="text" readonly id="view-available-quentity">
                                </div>
                                <div class="form-group" id="view-schedule-status-container">
                                    <label for="view-available-quentity" class="form-control-label">Schedule Status</label>
                                    <input class="form-control" type="text" readonly id="view-schedule-status">
                                </div>
                            </div>
                        </div>
                    </form>
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
        $("#message-toast").toast();
        $("#viewSchedule").modal();
        loadData();
    });

    function loadData() {
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        const outletID = JSON.parse(localStorage.getItem('me')).id;
        $.ajax({
            url: '/api/v1/schedule/outlet/'+outletID,
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
        const tbody = document.querySelector('#scheduleTableBody');
        tbody.innerHTML = '';
        if (response && response.data && response.data.length > 0) {
            response.data.forEach(schedule => {
                tbody.innerHTML += `
                        <tr>
                            <td class='align-middle text-center'>${schedule.id ? schedule.id : '~none~'}</td>
                            <td class='align-middle text-center'>${schedule.status ? schedule.status : '~none~'}</td>
                            <td class='align-middle text-center'>${schedule.schedule_date ? schedule.schedule_date : '~none~'}</td>
                            <td class='align-middle text-center'>${schedule.max_quantity ? schedule.max_quantity : '~none~'}</td>
                            <td class='align-middle text-center'>${schedule.available_quantity ? schedule.available_quantity : '~none~'}</td>
                            <td class='align-middle text-center'>${schedule.name ? schedule.name : '~none~'}</td>
                            <td class='align-middle text-center'>${schedule.email ? schedule.email : '~none~'}</td>
                            <td class='align-middle text-center'>
                                <span>
                                    <i class="cursor-pointer fas fa-expand-arrows-alt text-secondary mx-3" onclick="viewSelectedSchedule(${schedule.id})"></i>
                                </span>
                            </td>
                        </tr>
                    `;
            });
        } else {
            tbody.innerHTML = '<tr><td colspan="3">No schedules found</td></tr>';
        }
    }

    function viewSelectedSchedule(scheduleID) {
        if (scheduleID) {
            getSingleSchedule(scheduleID)
                .done(function(result) {
                    if (result.data && result.data.id) {
                        $('#view-schedule-outlet-name').val(result.data.out_name);
                        $('#view-schedule-outlet-email').val(result.data.out_email);
                        $('#view-schedule-outlet-phoneNo').val(result.data.out_phone_no);
                        $('#view-schedule-outlet-status').val(result.data.out_status);
                        $('#view-schedule-outlet-address').val(result.data.out_address);

                        $('#view-schedule-date').val(result.data.schedule_date);
                        $('#view-schedule-max-quentity').val(result.data.max_quantity);
                        $('#view-available-quentity').val(result.data.available_quantity);
                        $('#view-schedule-status').val(result.data.status);

                        $("#viewSchedule").modal('toggle');
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

    function getSingleSchedule(id) {
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        return $.ajax({
            url: '/api/v1/schedule/'+id,
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
</script>

@endsection
