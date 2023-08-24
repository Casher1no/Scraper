<?php

namespace App\Http\Services\HackerNews;

use App\Models\StoryRepository;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UpdateStoryService
{
    private $repository;
    private $baseUri = 'https://hacker-news.firebaseio.com/v0/';

    public function __construct(StoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function updateStory($storyId)
    {
        $story = $this->repository->getStory($storyId);

        if ($story) {
            try {
                $response = Http::get("{$this->baseUri}item/{$story['item_id']}.json?print=pretty");

                if ($response->successful()) {
                    $data = $response->json();

                    $this->updateStoryPoints($story, $data);

                    Log::info("Story #{$storyId} updated successfully.");
                } else {
                    $this->handleApiError($storyId, $response->status());
                }
            } catch (Exception $e) {
                $this->handleException($storyId, $e);
            }
        }
    }

    private function updateStoryPoints(&$story, $data)
    {
        $story->points = $data['score'] ?? $story->points;
        $story->save();
    }

    private function handleApiError($storyId, $statusCode)
    {
        Log::error("API call for Story #{$storyId} failed with status code {$statusCode}");
    }

    private function handleException($storyId, Exception $e)
    {
        Log::error("An error occurred while updating Story #{$storyId}: " . $e->getMessage());
    }
}
