@section('title', 'Customers')
@extends('Backend.Layouts.Master')
@section('content')
    @include('Backend.Components.Customers.List')
    @include('Backend.Components.Customers.Edit')
    @include('Backend.Components.Customers.Create')
@endsection

