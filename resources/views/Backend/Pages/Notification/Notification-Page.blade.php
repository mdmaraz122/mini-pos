@section('title', 'Notification')
@extends('Backend.Layouts.Master')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    Notification
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    @foreach($notifications as $notifiy)
                                        <div class="col-md-12">
                                            <a href="{{ $notifiy['url'] }}" style="text-decoration: none">
                                                <div class="card p-3" style="box-shadow: 0px 0px 3px 0px red;">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <h6 class="text-danger">Stock Alert</h6>
                                                        </div>
                                                        <div class="col-md-6 text-right">
                                                            <span class="text-dark">
                                                                <i class="fas fa-clock text-danger"></i>
                                                                {{ $notifiy->created_at->diffForHumans() }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <p>{{ $notifiy->message }}</p>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <p>
                                            Showing {{ $notifications->firstItem() }} to {{ $notifications->lastItem() }}
                                            of {{ $notifications->total() }} results
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mt-3 text-right">
                                            @if ($notifications->onFirstPage())
                                                <button class="btn btn-outline-secondary" disabled><</button>
                                            @else
                                                <a href="{{ $notifications->previousPageUrl() }}" class="btn btn-outline-danger"><</a>
                                            @endif

                                            @for ($i = 1; $i <= $notifications->lastPage(); $i++)
                                                <a href="{{ $notifications->url($i) }}"
                                                   class="btn btn-md {{ $notifications->currentPage() == $i ? 'btn-danger' : 'btn-outline-danger' }}">
                                                    {{ $i }}
                                                </a>
                                            @endfor

                                            @if ($notifications->hasMorePages())
                                                <a href="{{ $notifications->nextPageUrl() }}" class="btn btn-outline-danger">></a>
                                            @else
                                                <button class="btn btn-outline-secondary" disabled>></button>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

