@section('title', 'Categories')
@extends('Backend.Layouts.Master')
@section('content')
    @include('Backend.Components.Categories.List')
    @include('Backend.Components.Categories.Edit')
    @include('Backend.Components.Categories.Create')
@endsection

