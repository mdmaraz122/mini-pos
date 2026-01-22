@section('title', 'Orders')
@extends('Backend.Layouts.Master')
@section('content')
    @include('Backend.Components.Orders.List')
    @include('Backend.Components.Orders.Edit')
@endsection

