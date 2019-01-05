@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    {{ Session::get('jwt') }}
    <dashboard-component></dashboard-component>
@stop

