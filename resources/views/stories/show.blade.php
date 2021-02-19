@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ $story->title }}

                    <a href="{{ route('stories.index') }}" class="float-right">Back</a>
                </div>

                <div class="card-body">
                    <table class="table">
                        {{ $story->body }}

                        <div class="font-weight-bold">
                            Status: {{ $story->status == 1 ? 'Yes' : 'No' }}
                            Type: {{ $story->type }}
                        </div>
                    </table> 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
