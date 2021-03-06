@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ __('Stories') }} 

                    <a href="{{route('stories.create')}}" class="float-right">Add story</a>
                </div>

                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <td>Title</td>
                                <td>Type</td>
                                <td>Status</td>
                                <td>Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($stories as $story)
                                <tr>
                                    <td>{{ $story->title }}</td>
                                    <td>{{ $story->type }}</td>
                                    <td>{{ $story->status ? 'Yes' : 'No' }}</td>
                                    <td>
                                        <a href="{{ route('stories.show', [$story]) }}" class="btn btn-secondary">View</a>
                                        <a href="{{ route('stories.edit', [$story]) }}" class="btn btn-secondary">Edit</a>
                                        <form action="{{ route('stories.destroy', [$story]) }}" method="POST" style="display:inline-block">
                                            @csrf 
                                            @method('DELETE')
                                            <button class="btn btn-danger" >Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table> 

                    {{ $stories->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
