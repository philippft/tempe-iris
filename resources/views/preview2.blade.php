@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<x-header-dashboard/>
<div class="grid grid-cols-2 gap-4 mb-10">
<x-stat-card
    variant="red"
    label="Peminjaman Ditolak"
    number="12"
/>
<x-stat-card
    variant="red"
    label="Peminjaman Ditolak"
    number="12"
/>
</div>


@endsection