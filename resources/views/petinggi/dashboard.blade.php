@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<x-header-dashboard/>

<div class="grid grid-cols-4 gap-4 mb-10">
        <x-statecard
            title="Total Aktif"
            :value="$suratAprove"
            label="Peminjaman"
            border="border-l-primary-hover"
            iconBg="bg-primary-hover/10"
        >
            <x-icons.totalaktif/>
        </x-statecard>
        <x-statecard
            title="Total Selesai"
            :value="$suratDone"
            label="Peminjaman"
            border="border-l-status-green"
            iconBg="bg-status-green/10"
        >
            <x-icons.totalaktif/>
        </x-statecard>
        <x-statecard
            title="Total Pending"
            :value="$suratPending"
            label="Peminjaman"
            border="border-l-status-yellow"
            iconBg="bg-status-yellow/10"
        >
            <x-icons.totalpending/>
        </x-statecard>
        <x-statecard
            title="Total Ditolak"
            :value="$suratReject"
            label="Peminjaman"
            border="border-l-status-red"
            iconBg="bg-status-red/10"
        >
            <x-icons.totaltolak/>
        </x-statecard>
</div>

<form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit" class="text-red-500 hover:text-red-700 font-bold">
        Logout
    </button>
</form>

@endsection