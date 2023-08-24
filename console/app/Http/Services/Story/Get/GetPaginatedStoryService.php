<?php

namespace App\Http\Services\Story\Get;

use App\Models\StoryRepository;

class GetPaginatedStoryService
{
    private StoryRepository $repository;

    public function __construct(StoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(GetPaginatedStoryRequest $request)
    {
        $stories = $this->repository->getByPage($request->perPage(), $request->page());

        return response()->json($stories);
    }
}
