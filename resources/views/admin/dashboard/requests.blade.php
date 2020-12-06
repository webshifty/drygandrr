@extends('layouts.main')

@section('title', 'ДРУГ: Адмін панель')

@push('states')
<script>
    window.__PAGE_STATE__.statuses = @json($data['statuses']);
</script>
@endpush

@section('content')
    <Requests />
@endsection