<?php

namespace App\Http\Controllers;

use App\Http\Services\Story\Delete\DeleteStoryRequest;
use App\Http\Services\Story\Delete\DeleteStoryService;
use App\Http\Services\Story\Get\GetPaginatedStoryRequest;
use App\Http\Services\Story\Get\GetPaginatedStoryService;

class StoryController extends Controller
{
    public function delete(DeleteStoryService $service, int $storyId)
    {
        return $service->__invoke(
            new DeleteStoryRequest($storyId)
        );
    }

    public function getPaginatedStories(GetPaginatedStoryService $service, $page, $perPage): \Illuminate\Http\JsonResponse
    {
        return $service->__invoke(
            new GetPaginatedStoryRequest($page, $perPage)
        );
    }
}
