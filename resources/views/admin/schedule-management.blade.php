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
                        <button type="button" class="btn bg-gradient-warning  btn-sm mb-0" data-bs-toggle="modal" data-bs-target="#newSchedule">
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
                    <form id="new-schedule-form" role="form" method="POST">
                        <div class="row">
                            <div class="col-md-6 ms-auto">
                                <h4>Outlet Details</h4>
                                <label for="outlet-search-input" class="form-control-label">Search by outlet name</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="typeahead form-control" id="outlet-search-input" placeholder="Outlet Name" aria-label="Example text with two button addons" aria-describedby="button-addon3" required>
                                    <button class="btn btn-outline-warning mb-0 btn-icon btn-2" type="button" onclick="searchOutlet(true)">
                                        <i class="fas fa-search"></i> Search
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
                                <div class="form-group">
                                    <label for="new-schedule-date" class="form-control-label">Schedule Date</label>
                                    <input class="form-control" required type="date" id="new-schedule-date">
                                </div>
                                <div class="form-group">
                                    <label for="new-schedule-quentity" class="form-control-label">Schedule Quentity</label>
                                    <input class="form-control" required type="text" placeholder="200" id="new-schedule-quentity">
                                </div>
                                <input type="hidden" id="new-schedule-outlet-id">
                                <button type="submit" class="btn bg-gradient-warning w-100 mt-4 mb-0">Save</button>
                            </div>
                        </div>
                    </form>
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
                                    <label for="edit-schedule-date" class="form-control-label">Schedule Date</label>
                                    <input class="form-control" type="date" readonly id="edit-schedule-date">
                                </div>
                                <div class="form-group">
                                    <label for="edit-schedule-max-quentity" class="form-control-label">Schedule Quentity</label>
                                    <input class="form-control" type="text" readonly id="edit-schedule-max-quentity">
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
                                    <select class="form-control" id="edit-schedule-status">
                                        <option value="PENDING">Pending</option>
                                        <option value="APPROVED">Approved</option>
                                        <option value="REJECTED">Rejected</option>
                                    </select>
                                </div>
                                <input type="hidden" id="edit-schedule-id">
                                <div class="row">
                                    <div class="col-md-6">
                                        <button type="button" id="edit-option-view-btn" onclick="viewEditPotions(true)" class="btn bg-gradient-warning w-100 mt-4 mb-0">
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
                                        <button type="submit" class="btn bg-gradient-warning w-100 mt-4 mb-0">Save Changes</button>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="button" onclick="viewEditPotions(false)" class="btn bg-gradient-secondary w-100 mt-4 mb-0">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
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
        clearInputs(true);
        clearInputs(false);
    });

    function viewEditPotions(option) {
        if (option) {
            $('#edit-option-container').show();
            $('#edit-option-view-btn').hide();
            $('#outlet-delete-btn').hide();
            $('#edit-schedule-quentity').attr("readonly", false);
            $('#edit-schedule-date').attr("readonly", false);
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
                        $('#edit-schedule-id').val(result.data.id);

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
        const scheduleID = $('#edit-schedule-id').val();
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
                                    $("#viewEditSchedule").modal('toggle');
                                    $('#message-toast').toast('show');
                                    $('#message-toast').addClass("bg-success");
                                    $('#message-toast-body').html("Success!   ScheduleID Delete successfull");
                                    clearInputs(false);
                                    loadData();
                                })
                                .fail(function() {
                                    $("#viewEditSchedule").modal('toggle');
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

    function searchOutlet(isNew = true) {
        let name = null;
        if (isNew) {
            $('#newScheduleErrorMessages').hide();
            name = $('#outlet-search-input').val();
        } else {
            $('#viewEditScheduleErrorMessages').hide();
            name = $('#outlet-edit-search-input').val();
        }
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        return $.ajax({
            url: '/api/v1/outlet/search?search=' + name,
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
                if (response.data && response.data.length > 0) {
                    if (isNew) {
                        $('#new-schedule-outlet-id').val(response.data[0].id);
                        $('#new-schedule-outlet-email').val(response.data[0].email);
                        $('#new-schedule-outlet-phoneNo').val(response.data[0].phone_no);
                        $('#new-schedule-outlet-status').val(response.data[0].status);
                        $('#new-schedule-outlet-address').val(response.data[0].address);
                    }
                } else {
                    if (isNew) {
                        $('#newScheduleErrorMessages').show();
                        $('#newScheduleErrorMessages').html("Error!   Outlet Not Found!");
                    }
                }
            },
            error: function(xhr) {
                if (isNew) {
                    $('#newScheduleErrorMessages').show();
                    $('#newScheduleErrorMessages').html("Error!   Please Try Again!");
                }
            },
        });
    }

    $('#new-schedule-form').on('submit', function(e) {
        e.preventDefault();

        // Get CSRF token from meta tag
        const csrfToken = $('meta[name="csrf-token"]').attr('content');

        // Collect form data
        const date = $('#new-schedule-date').val();
        const quentity = $('#new-schedule-quentity').val();
        const id = $('#new-schedule-outlet-id').val();

        // Make an AJAX POST request
        $.ajax({
            url: '/api/v1/schedule',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            contentType: 'application/json',
            data: JSON.stringify({
                schedule_date: date,
                max_quantity: quentity,
                outlet_id: id
            }),
            xhrFields: {
                withCredentials: true,
            },
            success: function(response) {
                $('#newSchedule').modal('toggle');
                $('#message-toast').toast('show');
                $('#message-toast').addClass("bg-success");
                $('#message-toast-body').html("Success!   New Schedule Successfully Updated!");
                loadData();
                clearInputs(true);
            },
            error: function(xhr) {
                $('#newScheduleErrorMessages').show();
                if (xhr.errors) {
                    $('#newScheduleErrorMessages').html("Error!   Please fill all the required fields!");
                } else {
                    $('#newScheduleErrorMessages').html("Error!   New Schedule Update Failed!");
                }
            },
        });
    });

    $('#edit-schedule-form').on('submit', function(e) {
        e.preventDefault();

        // Get CSRF token from meta tag
        const csrfToken = $('meta[name="csrf-token"]').attr('content');

        // Collect form data
        const date = $('#edit-schedule-date').val();
        const quentity = $('#edit-schedule-max-quentity').val();
        const status = $('#edit-schedule-status').val();
        const id = $('#edit-schedule-id').val();

        // Make an AJAX POST request
        $.ajax({
            url: '/api/v1/schedule/'+id,
            method: 'PUT',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            contentType: 'application/json',
            data: JSON.stringify({
                schedule_date: date,
                max_quantity: quentity,
                status: status
            }),
            xhrFields: {
                withCredentials: true,
            },
            success: function(response) {
                $('#viewEditSchedule').modal('toggle');
                $('#message-toast').toast('show');
                $('#message-toast').addClass("bg-success");
                $('#message-toast-body').html("Success!   New Schedule Successfully Created!");
                loadData();
                clearInputs(false);
                viewEditPotions(false);
            },
            error: function(xhr) {
                $('#viewEditScheduleErrorMessages').show();
                if (xhr.errors) {
                    $('#viewEditScheduleErrorMessages').html("Error!   Please fill all the required fields!");
                } else {
                    $('#viewEditScheduleErrorMessages').html("Error!   New Schedule Creation Failed!");
                }
            },
        });
    });

    function clearInputs(isNew = true) {
        if (isNew) {
            $('#outlet-search-input').val(null);
            $('#new-schedule-outlet-email').val(null);
            $('#new-schedule-outlet-phoneNo').val(null);
            $('#new-schedule-outlet-status').val(null);
            $('#new-schedule-outlet-address').val(null);
            $('#new-schedule-outlet-id').val(null);
            $('#new-schedule-date').val(null);
            $('#new-schedule-quentity').val(null);
        } else {
            $('#outlet-edit-search-input').val(null);
            $('#view-schedule-outlet-name').val(null);
            $('#view-schedule-outlet-email').val(null);
            $('#view-schedule-outlet-phoneNo').val(null);
            $('#view-schedule-outlet-status').val(null);
            $('#view-schedule-outlet-address').val(null);
            $('#edit-schedule-date').val(null);
            $('#edit-schedule-max-quentity').val(null);
            $('#edit-available-quentity').val(null);
            $('#view-schedule-status').val(null);
            $('#edit-schedule-status').val(null);
            $('#edit-schedule-id').val(null);
        }
    }
</script>

@endsection
