@section('title', 'Brands')
@extends('Backend.Layouts.Master')
@section('content')
    @include('Backend.Components.Brands.List')
    @include('Backend.Components.Brands.Edit')
    @include('Backend.Components.Brands.Create')
@endsection

