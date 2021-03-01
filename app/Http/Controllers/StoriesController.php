<?php

namespace App\Http\Controllers;

use App\Events\StoryCreated;
use App\Events\StoryEdited;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoryRequest;
use App\Story;
use App\Tag;
use Intervention\Image\Facades\Image;

class StoriesController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Story::class, 'story');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stories = Story::where('user_id', auth()->user()->id)
            ->orderBy('id', 'DESC')
            ->paginate(6);
        return view('stories.index', [ 'stories' => $stories ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $this->authorize('create');
        // fix bug: Dung chung form edit
        $story = new Story;
        $tags = Tag::get();
        return view('stories.create', [
            'story' => $story,
            'tags' => $tags
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoryRequest $request)
    {
        // Tao thong qua ORM 
        // Tu dong them user_id boi id user hien tai
        $story = auth()->user()->stories()->create($request->all());

        // save relation may-to-may
        $story->tags()->sync($request->tags);

        // upload file
        $this->uploadFile($request, $story);
        
        // Dispatch event
        event( new StoryCreated($story->title));

        return redirect()->route('stories.index')->with(['status' => 'Created Story Successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Story $story)
    {
        return view('stories.show', ['story' => $story]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Story $story)
    {
        // Gate::authorize('story-edit', $story); // Dinh nghia authorize trong AuthServiceProvider
        // $this->authorize('update', $story); // Dung policy
        $tags = Tag::get();
        return view('stories.edit', ['story' => $story, 'tags' => $tags]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoryRequest $request, Story $story)
    {
        // $this->authorize('update', $story); // Dung policy
        // $story->update($request->data());
        $story->update($request->all());

        $story->tags()->sync($request->tags);

        $this->uploadFile($request, $story);

        event(new StoryEdited($story->title));

        return redirect()->route('stories.index')->with(['status' => 'Update Story Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Story $story)
    {
        // $this->authorize('update', $story); // Dung policy 
        $story->delete();
        return redirect()->route('stories.index')->with(['status' => 'Delete Story Successfully']);
    }

    private function uploadFile($request, $story) {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName = time().'.'.$image->getClientOriginalExtension();
            
            Image::make($image)->resize(300, 200)->save(public_path('storage/'.$fileName));
            $story->image = $fileName;
            $story->save();
        }
    }
}
