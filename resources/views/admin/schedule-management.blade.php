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
                        <button type="button" class="btn bg-gradient-primary  btn-sm mb-0" data-bs-toggle="modal" data-bs-target="#newSchedule">
                            +&nbsp; New Schedule
                        </button>
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

<!-- New Schedule Create Modal-->
<div class="modal fade" id="newSchedule" tabindex="-1" role="dialog" aria-labelledby="newScheduleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-normal" id="newScheduleModalLabel">Create New Schedule</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="false">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6 ms-auto">
                            <h4>Outlet Details</h4>
                            <label for="outlet-search-input" class="form-control-label">Search by outlet name</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="outlet-search-input" placeholder="Outlet Name" aria-label="Example text with two button addons" aria-describedby="button-addon3">
                                <button class="btn btn-outline-primary mb-0 btn-icon btn-2" type="button">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                            <div class="form-group">
                                <label for="new-schedule-outlet-email" class="form-control-label">Outlet Email</label>
                                <input class="form-control" type="text" readonly id="new-schedule-outlet-email">
                            </div>
                            <div class="form-group">
                                <label for="new-schedule-outlet-phoneNo" class="form-control-label">Outlet Phone No</label>
                                <input class="form-control" type="text" readonly id="new-schedule-outlet-phoneNo">
                            </div>
                            <div class="form-group">
                                <label for="new-schedule-outlet-status" class="form-control-label">Outlet Status</label>
                                <input class="form-control" type="text" readonly id="new-schedule-outlet-status">
                            </div>
                            <div class="form-group">
                                <label for="new-schedule-outlet-address" class="form-control-label">Outlet Address</label>
                                <input class="form-control" type="text" readonly id="new-schedule-outlet-address">
                            </div>
                        </div>
                        <div class="col-md-6 ms-auto">
                            <h4>Schedule Details</h4>
                            <form id="new-schedule-form" role="form" method="POST">
                                <div class="form-group">
                                    <label for="new-schedule-date" class="form-control-label">Schedule Date</label>
                                    <input class="form-control" type="date" id="new-schedule-date">
                                </div>
                                <div class="form-group">
                                    <label for="new-schedule-quentity" class="form-control-label">Schedule Quentity</label>
                                    <input class="form-control" type="text" placeholder="200" id="new-schedule-quentity">
                                </div>
                                <button type="submit" class="btn bg-gradient-primary w-100 mt-4 mb-0">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="alert alert-danger text-white" style="display: none;" role="alert" id="newScheduleErrorMessages"></div>
            </div>
        </div>
    </div>
</div>

<!-- View/Edit Schedule Create Modal-->
<div class="modal fade" id="viewEditSchedule" tabindex="-1" role="dialog" aria-labelledby="viewEditScheduleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-normal" id="viewEditScheduleModalLabel">View Schedule</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="false">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6 ms-auto">
                            <h4>Outlet Details</h4>
                            <label id="outlet-edit-search-input-label" style="display: none;" class="form-control-label">Search by outlet name</label>
                            <div class="input-group mb-3" style="display: none;" id="outlet-search-input-container">
                                <input type="text" class="form-control" id="outlet-edit-search-input" placeholder="Outlet Name" aria-label="Example text with two button addons" aria-describedby="button-addon3">
                                <button class="btn btn-outline-primary mb-0 btn-icon btn-2" type="button">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
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
                            <form id="edit-schedule-form" role="form" method="POST">
                                <div class="form-group">
                                    <label for="edit-schedule-date" class="form-control-label">Schedule Date</label>
                                    <input class="form-control" type="date" readonly required id="edit-schedule-date">
                                </div>
                                <div class="form-group">
                                    <label for="edit-schedule-max-quentity" class="form-control-label">Schedule Quentity</label>
                                    <input class="form-control" type="text" readonly required id="edit-schedule-max-quentity">
                                </div>
                                <div class="form-group">
                                    <label for="edit-available-quentity" class="form-control-label">Available Quentity</label>
                                    <input class="form-control" type="text" readonly id="edit-available-quentity">
                                </div>
                                <div class="form-group" id="view-schedule-status-container">
                                    <label for="edit-available-quentity" class="form-control-label">Schedule Status</label>
                                    <input class="form-control" type="text" readonly id="view-schedule-status">
                                </div>
                                <div class="form-group" style="display: none;" id="edit-schedule-status-container">
                                    <label for="outlet-phoneNo-input" class="form-control-label">Schedule Status</label>
                                    <select class="form-control" required id="edit-schedule-status">
                                        <option value="PENDING">Pending</option>
                                        <option value="APPROVED">Approved</option>
                                        <option value="REJECTED">Rejected</option>
                                    </select>
                                </div>
                                <input type="hidden" id="edit-schedule-outlet-id">
                                <div class="row">
                                    <div class="col-md-6">
                                        <button type="button" id="edit-option-view-btn" onclick="viewEditPotions(true)" class="btn bg-gradient-primary w-100 mt-4 mb-0">
                                            Edit
                                        </button>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="button" id="outlet-delete-btn" onclick="deleteSelectedSchedule()" class="btn bg-gradient-danger w-100 mt-4 mb-0">
                                            Delete
                                        </button>
                                    </div>
                                </div>
                                <div class="row" style="display: none;" id="edit-option-container">
                                    <div class="col-md-6">
                                        <button type="submit" class="btn bg-gradient-primary w-100 mt-4 mb-0">Save Changes</button>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="button" onclick="viewEditPotions(false)" class="btn bg-gradient-secondary w-100 mt-4 mb-0">Cancel</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="alert alert-danger text-white" style="display: none;" role="alert" id="viewEditScheduleErrorMessages"></div>
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
        $("#viewEditSchedule").modal();
        loadData();
    });

    function viewEditPotions(option) {
        if (option) {
            $('#edit-option-container').show();
            $('#edit-option-view-btn').hide();
            $('#outlet-delete-btn').hide();
            $('#edit-schedule-quentity').attr("readonly", false);
            $('#edit-schedule-date').attr("readonly", false);
            $('#view-schedule-outlet-name-container').hide();
            $('#outlet-search-input-container').show();
            $('#outlet-edit-search-input-label').show();
            $('#viewEditScheduleModalLabel').html('Edit Schedule');
            $('#view-schedule-status-container').hide();
            $('#edit-schedule-status-container').show();
            $('#edit-schedule-max-quentity').attr("readonly", false);
        } else {
            $('#edit-option-container').hide();
            $('#edit-option-view-btn').show();
            $('#outlet-delete-btn').show();
            $('#edit-schedule-quentity').attr("readonly", true);
            $('#edit-schedule-date').attr("readonly", true);
            $('#view-schedule-outlet-name-container').show();
            $('#outlet-search-input-container').hide();
            $('#outlet-edit-search-input-label').hide();
            $('#viewEditScheduleModalLabel').html('View Schedule');
            $('#view-schedule-status-container').show();
            $('#edit-schedule-status-container').hide();
            $('#edit-schedule-max-quentity').attr("readonly", true);
        }
    }

    function loadData() {
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: '/api/v1/schedule',
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
                        $('#edit-schedule-outlet-id').val(result.data.outlet_id);
                        $('#view-schedule-outlet-name').val(result.data.out_name);
                        $('#outlet-edit-search-input').val(result.data.out_name);
                        $('#view-schedule-outlet-email').val(result.data.out_email);
                        $('#view-schedule-outlet-phoneNo').val(result.data.out_phone_no);
                        $('#view-schedule-outlet-status').val(result.data.out_status);
                        $('#view-schedule-outlet-address').val(result.data.out_address);

                        $('#edit-schedule-date').val(result.data.schedule_date);
                        $('#edit-schedule-max-quentity').val(result.data.max_quantity);
                        $('#edit-available-quentity').val(result.data.available_quantity);
                        $('#view-schedule-status').val(result.data.status);
                        $('#edit-schedule-status').val(result.data.status);

                        $("#viewEditSchedule").modal('toggle');
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
            url: '/api/v1/schedule/' + id,
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

    function deleteSelectedSchedule() {
        const scheduleID = $('#edit-schedule-outlet-id').val();
        if (scheduleID) {
            $.confirm({
                title: 'Delete Record?',
                content: 'Are you sure You want to delete the selected Schedule?',
                type: 'white',
                buttons: {
                    ok: {
                        text: "DELETE",
                        btnClass: 'btn btn-danger',
                        keys: ['enter'],
                        action: function() {
                            deleteSingleSchedule(scheduleID)
                                .done(function(result) {
                                    $('#message-toast').toast('show');
                                    $('#message-toast').addClass("bg-success");
                                    $('#message-toast-body').html("Success!   ScheduleID Delete successfull");
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

    function deleteSingleSchedule(id) {
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        return $.ajax({
            url: '/api/v1/schedule/' + id,
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

    function viewSelectedOutlet(outletID, action = null) {
        if (outletID) {
            getSingleOutlet(outletID)
                .done(function(result) {
                    if (result.data && result.data.id) {
                        if (action === "status") {
                            $('#status-outlet-id-input').val(result.data.id);
                            $('#status-outlet-name-input').val(result.data.name);
                            $('#status-outlet-phoneNo-input').val(result.data.phone_no);
                            $('#status-outlet-address-input').val(result.data.address);
                            $('#status-outlet-status-input').val(result.data.status);
                            $("#editOutletStatus").modal('toggle');
                        } else {
                            $('#edit-outlet-id-input').val(result.data.id);
                            $('#edit-outlet-name-input').val(result.data.name);
                            $('#edit-outlet-phoneNo-input').val(result.data.phone_no);
                            $('#edit-outlet-address-input').val(result.data.address);
                            $("#editOutlet").modal('toggle');
                        }
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
</script>

@endsection
