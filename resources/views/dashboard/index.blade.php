@extends('layouts.app')

@section('content')
<main role="main">

    <section class="jumbotron text-center">
      <div class="container">
        <h1 class="jumbotron-heading">Album example</h1>
        <p class="lead text-muted">Something short and leading about the collection below—its contents, the creator, etc. Make it short and sweet, but not too short so folks don't simply skip over it entirely.</p>
        <p>
          <a href="{{ route('dashboard.index') }}" class="btn btn-primary my-2">All</a>
          <a href="{{ route('dashboard.index', ['type' => 'short']) }}" class="btn btn-secondary my-2">Short</a>
          <a href="{{ route('dashboard.index', ['type' => 'long']) }}" class="btn btn-secondary my-2">Long</a>
        </p>
      </div>
    </section>

    <div class="album py-5 bg-light">
      <div class="container">
        <div class="row">
          @foreach($stories as $story)
          <div class="col-md-4">
            <div class="card mb-4 box-shadow">
              <img class="card-img-top" data-src="{{ $story->thumbnail }}" src={{ $story->thumbnail }} alt="Card image cap">
              <div class="card-body">
                <p class="card-text">
                  {{ $story->title }}
                </p>
                <br/>
                @foreach ($story->tags as $tag)
                  <button class="btn btn-sm btn-outline-primary">{{ $tag->name }}</button>
                @endforeach
                <div class="d-flex justify-content-between align-items-center">
                  <div class="btn-group">
                    <a type="button" class="btn btn-sm btn-outline-secondary" href="{{route('dashboard.show', [$story])}}">View</a>
                  </div>
                  <small class="text-muted">{{ $story->name }}</small>
                </div>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>

  </main>

  <footer class="text-muted">
    <div class="container">
      <p>Album example is &copy; Bootstrap, but please download and customize it for yourself!</p>
    </div>
  </footer>

@endsection

{{-- {{ dd(DB::getQueryLog()) }} --}}

@section('styles')
    <link href="{{ asset('css/homepage.css') }}" rel="stylesheet">
@endsection