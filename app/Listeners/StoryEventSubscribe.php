<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class StoryEventSubscribe
{
    public function handleWritelogStoryCreated ($event) {
        Log::info('[use subscribe listen] create story "'.$event->title.'"');
    }

    public function handleWritelogStoryEdited ($event) {
        Log::info('[use subscribe listen] update story "'.$event->title.'"');
    }

    public function test ($event) {
        Log::info('test->'.$event->title);
    }

    public function subscribe ($events) {
        $events->listen(
            'App\Events\StoryCreated',
            'App\Listeners\StoryEventSubscribe@handleWritelogStoryCreated'
        );

        $events->listen(
            'App\Events\StoryEdited',
            'App\Listeners\StoryEventSubscribe@handleWritelogStoryEdited'
        );

        $events->listen(
            'App\Events\StoryEdited',
            'App\Listeners\StoryEventSubscribe@test'
        );
    }
}
