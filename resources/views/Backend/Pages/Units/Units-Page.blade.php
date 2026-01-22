@section('title', 'Units')
@extends('Backend.Layouts.Master')
@section('content')
    @include('Backend.Components.Units.List')
    @include('Backend.Components.Units.Edit')
    @include('Backend.Components.Units.Create')
@endsection

