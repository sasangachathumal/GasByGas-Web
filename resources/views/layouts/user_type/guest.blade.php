@extends('layouts.app')

@section('guest')
    @if(\Request::is('login/forgot-password'))
        @yield('content')
        @include('layouts.footers.guest.footer')
    @else
        @yield('content')
        @include('layouts.footers.guest.footer')
    @endif
@endsection
