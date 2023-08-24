<?php

namespace App\Http\Controllers;

use App\Http\Services\Story\Delete\DeleteStoryRequest;
use App\Http\Services\Story\Delete\DeleteStoryService;
use App\Http\Services\Story\Get\GetPaginatedStoryRequest;
use App\Http\Services\Story\Get\GetPaginatedStoryService;
use App\Models\StoryRepository;

class StoryController extends Controller
{
    private StoryRepository $repository;

    public function __construct(StoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function delete(DeleteStoryService $service, int $storyId)
    {
        return $service->__invoke(
            new DeleteStoryRequest($storyId)
        );
    }

    public function getPaginatedStories(GetPaginatedStoryService $service, $page, $perPage): \Illuminate\Http\JsonResponse
    {
        return $service->__invoke(
            new GetPaginatedStoryRequest($page,$perPage)
        );
    }
}
