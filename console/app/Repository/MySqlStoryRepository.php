<?php

namespace App\Repository;

use App\Models\Story;
use App\Models\StoryRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MySqlStoryRepository implements StoryRepository
{
    public function getStory(int $itemId): ?Story
    {
        return Story::where('item_id', $itemId)->first();
    }

    public function getAllStories(): array
    {
        return DB::table('stories')->get()->toArray();
    }

    public function delete(int $itemId): bool
    {
        try {
            DB::table('stories')
                ->where('item_id', $itemId)
                ->update(['deleted_at' => now()]);

            return true;
        } catch (\Exception $e){
            Log::error($e);
            return false;
        }
    }

    public function getByPage(int $perPage, int $page): array
    {
        return Story::where('deleted_at', null)
            ->orderBy('points', 'desc')
            ->paginate($perPage, ['*'], 'page', $page)
            ->toArray();
    }
}
