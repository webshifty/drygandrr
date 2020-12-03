@extends('layouts.main')

@section('title', 'ДРУГ: Адмін панель')

@section('sidebar')
	@include('admin.dashboard.components.sidebar', ['userInfo' => $data['userInfo']])
@endsection

@section('top')
	@include('admin.dashboard.components.top')
@endsection

@section('content')
	@yield('content')
@endsection

@prepend('modals')
<div class="modal">
	@yield('modal')
</div>
<div class="overlay"></div>
@endprepend