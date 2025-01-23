@extends('layouts.user_type.auth')

@section('content')

<div class="row">
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Gas Requests</p>
                            <h5 class="font-weight-bolder mb-0" id="requestCount">
                                000
                            </h5>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-gradient-warning shadow text-center border-radius-md">
                            <i class="fas fa-fire-alt text-lg opacity-10" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Gas Schedules</p>
                            <h5 class="font-weight-bolder mb-0" id="scheduleCount">
                                000
                            </h5>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-gradient-warning shadow text-center border-radius-md">
                            <i class="ni ni-world text-lg opacity-10" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Outlets</p>
                            <h5 class="font-weight-bolder mb-0" id="outletCount">
                                000
                            </h5>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-gradient-warning shadow text-center border-radius-md">
                            <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="card">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Consumers</p>
                            <h5 class="font-weight-bolder mb-0" id="consumerCount">
                                000
                            </h5>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-gradient-warning shadow text-center border-radius-md">
                            <i class="ni ni-cart text-lg opacity-10" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row mt-4">
    <div class="col-3 col-md-3 mb-4">
        <a href="{{ url('admin/gas-request-management') }}">
            <div class="card bg-gradient-secondary cursor-pointer">
                <img class="card-img h-50" src="../assets/img/shapes/waves-white.svg" alt="Card image">
                <div class="card-img-overlay p-3 d-flex align-items-center justify-content-center">
                    <h4 class="text-white">Gas Request Management</h4>
                </div>
            </div>
        </a>
    </div>
    <div class="col-3 col-md-3 mb-4">
        <a href="{{ url('admin/schedule-management') }}">
            <div class="card bg-gradient-secondary cursor-pointer">
                <img class="card-img h-50" src="../assets/img/shapes/waves-white.svg" alt="Card image">
                <div class="card-img-overlay p-3 d-flex align-items-center justify-content-center">
                    <h4 class="text-white">Gas Schedule Management</h4>
                </div>
            </div>
        </a>
    </div>
    <div class="col-3 col-md-3 mb-4">
        <a href="{{ url('admin/outlet-management') }}">
            <div class="card bg-gradient-secondary cursor-pointer">
                <img class="card-img h-50" src="../assets/img/shapes/waves-white.svg" alt="Card image">
                <div class="card-img-overlay p-3 d-flex align-items-center justify-content-center">
                    <h4 class="text-white">Gas Outlet Management</h4>
                </div>
            </div>
        </a>
    </div>
    <div class="col-3 col-md-3 mb-4">
        <a href="{{ url('admin/outlet-managers') }}">
            <div class="card bg-gradient-secondary cursor-pointer">
                <img class="card-img h-50" src="../assets/img/shapes/waves-white.svg" alt="Card image">
                <div class="card-img-overlay p-3 d-flex align-items-center justify-content-center">
                    <h4 class="text-white">Gas Outlet Magesrs</h4>
                </div>
            </div>
        </a>
    </div>
    <div class="col-3 col-md-3 mb-4">
        <a href="{{ url('admin/consumer-management') }}">
            <div class="card bg-gradient-secondary cursor-pointer">
                <img class="card-img h-50" src="../assets/img/shapes/waves-white.svg" alt="Card image">
                <div class="card-img-overlay p-3 d-flex align-items-center justify-content-center">
                    <h4 class="text-white">Gas Consumer Management</h4>
                </div>
            </div>
        </a>
    </div>
    <div class="col-3 col-md-3 mb-4">
        <a href="{{ url('admin/gas-management') }}">
            <div class="card bg-gradient-secondary cursor-pointer">
                <img class="card-img h-50" src="../assets/img/shapes/waves-white.svg" alt="Card image">
                <div class="card-img-overlay p-3 d-flex align-items-center justify-content-center">
                    <h4 class="text-white">Gas Types Management</h4>
                </div>
            </div>
        </a>
    </div>
    <div class="col-3 col-md-3 mb-4">
        <a href="{{ url('admin/admin-management') }}">
            <div class="card bg-gradient-secondary cursor-pointer">
                <img class="card-img h-50" src="../assets/img/shapes/waves-white.svg" alt="Card image">
                <div class="card-img-overlay p-3 d-flex align-items-center justify-content-center">
                    <h4 class="text-white">Admin Users</h4>
                </div>
            </div>
        </a>
    </div>
</div>

<script>
    $(document).ready(function() {
        getRequestCount();
        getScheduelCount();
        getOutletCount();
        getConsumerCount();
    });

    function getRequestCount() {
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: '/api/v1/request/count',
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
                document.querySelector('#requestCount').innerHTML = response.data;
            },
            error: function(xhr) {
                return xhr;
            },
        });
    }

    function getScheduelCount() {
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: '/api/v1/schedule/count',
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
                document.querySelector('#scheduleCount').innerHTML = response.data;
            },
            error: function(xhr) {
                return xhr;
            },
        });
    }

    function getOutletCount() {
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: '/api/v1/outlet/count',
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
                document.querySelector('#outletCount').innerHTML = response.data;
            },
            error: function(xhr) {
                return xhr;
            },
        });
    }

    function getConsumerCount() {
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: '/api/v1/consumer/count',
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
                document.querySelector('#consumerCount').innerHTML = response.data;
            },
            error: function(xhr) {
                return xhr;
            },
        });
    }

    function navigate(route) {
        window.location.href = route;
    }
</script>

@endsection
