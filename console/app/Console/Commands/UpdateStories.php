<?php

namespace App\Console\Commands;

use App\Models\StoryRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class UpdateStories extends Command
{
    protected $signature = 'update:stories';
    protected $description = 'Updates stories from database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $baseUri = 'https://hacker-news.firebaseio.com/v0/item/{id}.json?print=pretty';

        $existingStories = DB::table('stories')->select('item_id')->get()->pluck('item_id')->toArray();

        $progressbar = $this->output->createProgressBar(count($existingStories));
        $progressbar->start();

        foreach ($existingStories as $storyId) {
            $progressbar->advance();
            $story = Http::get(str_replace('{id}', $storyId, $baseUri))->json();

            if ($story && $story['type'] === 'story') {
                DB::table('stories')
                    ->where('item_id', $storyId)
                    ->update([
                        'points' => $story['score'] ?? 0,
                    ]);
            }
        }

        $progressbar->finish();
    }
}
