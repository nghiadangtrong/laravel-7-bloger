@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ __('Deleted stories') }} 
                </div>

                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <td>Title</td>
                                <td>Type</td>
                                <td>Auth</td>
                                <td>Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($stories as $story)
                                <tr>
                                    <td>{{ $story->title }}</td>
                                    <td>{{ $story->type }}</td>
                                    <td>{{ $story->user->name }}</td>
                                    <td>
                                        <form action="{{ route('admin.stories.restore', [$story]) }}" method="POST" style="display:inline-block">
                                            @csrf
                                            @method('PATCH')
                                            <button class="btn btn-primary">Restore</button>
                                        </form>

                                        <form action="{{ route('admin.stories.focusDelete', [$story]) }}" method="POST" style="display:inline-block">
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
