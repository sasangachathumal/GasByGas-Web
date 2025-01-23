<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 overflow-hidden" id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
        <a class="align-items-center d-flex m-0 navbar-brand text-wrap" href="{{ url('admin/dashboard') }}">
            <img src="../assets/img/logo-ct.png" class="navbar-brand-img h-100" alt="...">
            <span class="ms-3 font-weight-bold">GasByGas Dashboard</span>
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse w-auto h-100" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link me-auto {{ (Request::is('admin/dashboard') ? 'active' : '') }}" href="{{ url('admin/dashboard') }}">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem;" class="fas fa-lg fa-house ps-2 pe-2 text-center text-dark {{ (Request::is('admin/dashboard') ? 'text-white' : 'text-dark') }} " aria-hidden="true"></i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>
            <li class="nav-item pb-2">
                <a class="nav-link me-auto {{ (Request::is('admin/gas-request') ? 'active' : '') }}" href="{{ url('admin/gas-request') }}">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem;" class="fas fa-lg fa-clipboard ps-2 pe-2 text-center text-dark {{ (Request::is('admin/gas-request') ? 'text-white' : 'text-dark') }} " aria-hidden="true"></i>
                    </div>
                    <span class="nav-link-text ms-1">Request Management</span>
                </a>
            </li>
            <li class="nav-item pb-2">
                <a class="nav-link me-auto {{ (Request::is('admin/schedule') ? 'active' : '') }}" href="{{ url('admin/schedule') }}">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem;" class="fas fa-lg fa-calendar-alt ps-2 pe-2 text-center text-dark {{ (Request::is('admin/schedule') ? 'text-white' : 'text-dark') }} " aria-hidden="true"></i>
                    </div>
                    <span class="nav-link-text ms-1">Schedule Management</span>
                </a>
            </li>
            <li class="nav-item pb-2">
                <a class="nav-link me-auto {{ (Request::is('admin/consumer') ? 'active' : '') }}" href="{{ url('admin/consumer') }}">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem;" class="fas fa-lg fa-users ps-2 pe-2 text-center text-dark {{ (Request::is('admin/consumer') ? 'text-white' : 'text-dark') }} " aria-hidden="true"></i>
                    </div>
                    <span class="nav-link-text ms-1">Consumer Management</span>
                </a>
            </li>
            <li class="nav-item pb-2">
                <a class="nav-link me-auto {{ (Request::is('admin/outlet') ? 'active' : '') }}" href="{{ url('admin/outlet') }}">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem;" class="fas fa-lg fa-store ps-2 pe-2 text-center text-dark {{ (Request::is('admin/outlet') ? 'text-white' : 'text-dark') }} " aria-hidden="true"></i>
                    </div>
                    <span class="nav-link-text ms-1">Outlet Management</span>
                </a>
            </li>
            <li class="nav-item pb-2">
                <a class="nav-link me-auto {{ (Request::is('admin/outlet-manager') ? 'active' : '') }}" href="{{ url('admin/outlet-manager') }}">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem;" class="fas fa-lg fa-users ps-2 pe-2 text-center text-dark {{ (Request::is('admin/outlet-manager') ? 'text-white' : 'text-dark') }} " aria-hidden="true"></i>
                    </div>
                    <span class="nav-link-text ms-1">Outlet Managers</span>
                </a>
            </li>
            <li class="nav-item pb-2">
                <a class="nav-link me-auto {{ (Request::is('admin/admin') ? 'active' : '') }}" href="{{ url('admin/admin') }}">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem;" class="fas fa-lg fa-users ps-2 pe-2 text-center text-dark {{ (Request::is('admin/admin') ? 'text-white' : 'text-dark') }} " aria-hidden="true"></i>
                    </div>
                    <span class="nav-link-text ms-1">Admin Management</span>
                </a>
            </li>
            <li class="nav-item pb-2">
                <a class="nav-link me-auto {{ (Request::is('admin/gas') ? 'active' : '') }}" href="{{ url('admin/gas') }}">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem;" class="fas fa-lg fa-burn ps-2 pe-2 text-center text-dark {{ (Request::is('admin/gas') ? 'text-white' : 'text-dark') }} " aria-hidden="true"></i>
                    </div>
                    <span class="nav-link-text ms-1">Gas Management</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
