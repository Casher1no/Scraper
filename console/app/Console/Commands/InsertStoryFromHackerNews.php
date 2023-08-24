<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class InsertStoryFromHackerNews extends Command
{
    protected $signature = 'insert:top-stories';
    protected $description = 'Inserts stories from hacker news';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $baseUri = 'https://hacker-news.firebaseio.com/v0/item/{id}.json?print=pretty';
        $topStories = Http::get('https://hacker-news.firebaseio.com/v0/topstories.json?print=pretty')->json();

        $existingItemIds = DB::table('stories')->pluck('item_id')->toArray();

        $insertData = [];

        $progressbar = $this->output->createProgressBar(count($topStories));
        $progressbar->start();

        foreach ($topStories as $storyId) {
            $progressbar->advance();
            if (in_array($storyId, $existingItemIds)) continue;

            $story = Http::get(str_replace('{id}', $storyId, $baseUri))->json();

            if ($story && $story['type'] === 'story') {
                $insertData[] = [
                    'item_id' => $story['id'],
                    'title' => $story['title'] ?? null,
                    'link' => $story['url'] ?? null,
                    'points' => $story['score'] ?? 0,
                    'date_created' => isset($story['time'])
                        ? Carbon::createFromTimestamp($story['time'])->toDateString()
                        : now()->toDateString(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        if (!empty($insertData)) {
            DB::table('stories')->insert($insertData);
        }
        $progressbar->finish();
    }
}
