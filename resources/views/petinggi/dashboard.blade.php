@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<x-header-dashboard/>

<div class="space-y-8">

<form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit" class="text-red-500 hover:text-red-700 font-bold">
        Logout
    </button>
</form>

@endsection