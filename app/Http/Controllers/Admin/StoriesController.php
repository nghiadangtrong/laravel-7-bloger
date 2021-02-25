<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Story;

class StoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stories = Story::onlyTrashed()
            // ->where('user_id', auth()->user()->id)
            ->orderBy('id', 'DESC')
            ->paginate(6);
        return view('admin.stories.index', [ 'stories' => $stories ]);
    }

    public function restore (Story $deletedStory) {
        $deletedStory->restore();
        return redirect()
            ->route('admin.stories.index')
            ->with(['status' => 'Story '.$deletedStory->title.' restored successfully.']);
    }

    public function forceDelete (Story $deletedStory) {
        $deletedStory->forceDelete();
        return redirect()
            ->route('admin.stories.index')
            ->with(['status' => 'stories '.$deletedStory->title.' deleted successfully.']);
    }
}
