@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ $story->title }} by {{ $story->user->name }}

                    <a href="{{ route('dashboard.index') }}" class="float-right">Back</a>
                </div>

                <div class="card-body">
                    <img class="card-img-top" data-src="{{ $story->thumbnail }}" src={{ $story->thumbnail }} alt="Card image cap">
                    <br/>
                    <br/>
                    {{ $story->body }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
