<?php

namespace App\Models;

interface StoryRepository
{
    public function getStory(int $itemId): ?Story;

    public function getAllStories(): array;

    public function delete(int $itemId): bool;

    public function getByPage(int $perPage, int $page): array;
}
