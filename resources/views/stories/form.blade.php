<div class="form-group">
    <label for='title'>Title</label>
        <input
            type="text" id="title" name="title"
            class="form-control @error('title') is-invalid @enderror"
            value="{{ old('title', $story->title) }}"
        />

    @error('title') 
        <span class="invalid-feedback"> {{ $message }} </span>
    @enderror
</div>

<div class="form-group">
    <label for="body">Body</label>
    <textarea
        name="body" id="body" rows="3"
        class="form-control @error('body') is-invalid @enderror"
    >{{ old('body', $story->body)}} </textarea>

    @error('body') 
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>

<div class="form-group">
    <label for="type">Type</label>
    <select
        name="type" id="type"
        class="form-control @error('type') is-invalid @enderror"
    >
        <option value="">--select option--</option>
        <option value="short" {{ old('type', $story->type) === 'short' ? 'selected' : '' }}>Short</option>
        <option value="long" {{ old('type', $story->type) === 'long' ? 'selected' : '' }}>long</option>
    </select>

    @error('type') 
        <span class="invalid-feedback">{{ $message}}</span>
    @enderror
</div>

<div class="form-group">
    <legend><h6>Status</h6></legend>
    
    <div class="form-check @error('status') is-invalid @enderror">
        <input type="radio" name='status' id='status-true' value='1'
            class="form-check-input" 
            {{ old('status', $story->status) == '1' ? 'checked' : ''}}
        />
        <label for="status-true" class="form-check-label">True</label>
    </div>

    <div class="form-check">
        <input type="radio" class="form-check-input"
            name='status' id="status-no" value='0'
            {{ old('status', $story->status) == '0' ? 'checked' : '' }}
        >
        <label for="status-no" class="form-check-label">No</label>
    </div>

    @error('status')
        <span class="invalid-feedback" role="alert">{{ $message }}</span>
    @enderror
</div>

<div class="form-group">
    <label for="image">Image</label>
    <input type="file" id="image" name="image" class="form-control @error('image') is-invalid @enderror">

    @error('image')
        <span class="invalid-feedback">{{$message}}</span>
    @enderror
</div>

<div class="form-group">
    @if($story->image)
        <img src="{{ $story->thumbnail }}" alt="">
    @endif
</div>

<div class="form-group">
    <legend>Tags</legend>

    @foreach($tags as $tag)
        <div class="form-check form-check-inline">
            <input
                type="checkbox" class="form-check-input" 
                name="tags[]" id="{{ $tag->id }}" value="{{$tag->id}}"
                {{ in_array($tag->id, old('tags', $story->tags->pluck('id')->toArray())) ? 'checked' : '' }}
            >
            <label for="{{$tag->id}}" class="form-check-label">{{ $tag->name }}</label>
        </div>
    @endforeach
</div>