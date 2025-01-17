@extends('layouts.app')

@section('auth')

    @if(\Request::is('admin-dashboard'))
        @include('layouts.navbars.auth.sidebar')
        <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg {{ (Request::is('rtl') ? 'overflow-hidden' : '') }}">
            @include('layouts.navbars.auth.nav')
            <div class="container-fluid py-4">
                @yield('content')
            </div>
        </main>
    @elseif (\Request::is('gas-request-management'))
        @include('layouts.navbars.auth.sidebar')
        <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg {{ (Request::is('rtl') ? 'overflow-hidden' : '') }}">
            @include('layouts.navbars.auth.nav')
            <div class="container-fluid py-4">
                @yield('content')
            </div>
        </main>
    @elseif (\Request::is('schedule-management'))
        @include('layouts.navbars.auth.sidebar')
        <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg {{ (Request::is('rtl') ? 'overflow-hidden' : '') }}">
            @include('layouts.navbars.auth.nav')
            <div class="container-fluid py-4">
                @yield('content')
            </div>
        </main>
    @elseif (\Request::is('admin-management'))
        @include('layouts.navbars.auth.sidebar')
        <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg {{ (Request::is('rtl') ? 'overflow-hidden' : '') }}">
            @include('layouts.navbars.auth.nav')
            <div class="container-fluid py-4">
                @yield('content')
            </div>
        </main>
    @elseif (\Request::is('outlet-management'))
        @include('layouts.navbars.auth.sidebar')
        <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg {{ (Request::is('rtl') ? 'overflow-hidden' : '') }}">
            @include('layouts.navbars.auth.nav')
            <div class="container-fluid py-4">
                @yield('content')
            </div>
        </main>
    @elseif (\Request::is('gas-management'))
        @include('layouts.navbars.auth.sidebar')
        <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg {{ (Request::is('rtl') ? 'overflow-hidden' : '') }}">
            @include('layouts.navbars.auth.nav')
            <div class="container-fluid py-4">
                @yield('content')
            </div>
        </main>
    @else
        @include('layouts.navbars.auth.sidebar')
        <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg {{ (Request::is('rtl') ? 'overflow-hidden' : '') }}">
            @include('layouts.navbars.auth.nav')
            <div class="container-fluid py-4">
                @yield('content')
            </div>
        </main>
    @endif

@endsection
