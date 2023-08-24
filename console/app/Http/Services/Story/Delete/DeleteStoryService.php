<?php

namespace App\Http\Services\Story\Delete;

use App\Models\StoryRepository;

class DeleteStoryService
{
    private StoryRepository $repository;

    public function __construct(StoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(DeleteStoryRequest $request)
    {
        $this->repository->delete($request->storyId());

        return \response(['message' => 'success']);
    }
}
