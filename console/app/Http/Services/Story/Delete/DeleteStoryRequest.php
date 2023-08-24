<?php

namespace App\Http\Services\Story\Delete;

class DeleteStoryRequest
{
    private int $storyId;

    public function __construct(int $storyId)
    {
        $this->storyId = $storyId;
    }

    public function storyId(): int
    {
        return $this->storyId;
    }
}
