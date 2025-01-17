@extends('layouts.user_type.auth')

@section('content')

<div>
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">All Admins</h5>
                        </div>
                        <a href="#" class="btn bg-gradient-primary btn-sm mb-0" type="button">+&nbsp; New Admin</a>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Admin ID
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Name
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Email
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Phone No
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="userTableBody">
                                <tr>
                                    <td colspan="5">Loading Admins ....</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        loadData();

        function loadData() {
            const csrfToken = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: '/api/v1/admin',
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
            const tbody = document.querySelector('#userTableBody');
            tbody.innerHTML = '';
            if (response && response.data && response.data.length > 0) {
                response.data.forEach(admin => {
                    tbody.innerHTML += `
                        <tr>
                            <td class='align-middle text-center'>${admin.id ? admin.id : '~none~'}</td>
                            <td class='align-middle text-center'>${admin.name ? admin.name : '~none~'}</td>
                            <td class='align-middle text-center'>${admin.email ? admin.email : '~none~'}</td>
                            <td class='align-middle text-center'>${admin.phone_no ? admin.phone_no : '~none~'}</td>
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
                tbody.innerHTML = '<tr><td colspan="3">No admins found</td></tr>';
            }
        }
    });
</script>

@endsection
