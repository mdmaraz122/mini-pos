@section('title', 'Taxes')
@extends('Backend.Layouts.Master')
@section('content')
    @include('Backend.Components.Taxes.List')
    @include('Backend.Components.Taxes.Edit')
    @include('Backend.Components.Taxes.Create')
@endsection

