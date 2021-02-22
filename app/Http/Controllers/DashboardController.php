<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Story;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

use App\Mail\NotifyAdmin;
use App\Mail\NotifyAdminMarkdown;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // DB::enableQueryLog();
        $query = Story::where('status', 1);
        $type = $request->input('type');

        if (in_array($type, ['short', 'long'])) {
            $query->where('type', $type);
        }

        $stories = $query->orderBy('id', 'DESC')->paginate(6);

        return view('dashboard.index', [ 'stories' => $stories ]);
    }

    public function show(Story $activeStory)
    {
        return view('dashboard.show', ['story' => $activeStory]);
    }

    public function email() {
        // Cach 1:
        // Mail::raw('This is content test mail', function ($message) {
        //     $message->to('shanksn92@gmail.com')
        //         ->subject('Send mail test');
        // });

        // Cach 2:
        Mail::send(new NotifyAdminMarkdown('Test send mail'));

        return '<div>Send Mail Success</div>';
    }
}
