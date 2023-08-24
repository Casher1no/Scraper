<?php

namespace Tests\Http\Services\Story\Delete;

use App\Http\Services\Story\Delete\DeleteStoryRequest;
use App\Http\Services\Story\Delete\DeleteStoryService;
use App\Models\StoryRepository;
use Illuminate\Http\Response;
use Mockery;
use Tests\TestCase;

class DeleteStoryServiceTest extends TestCase
{
    public function testDeleteStoryService()
    {
        $mockRepository = Mockery::mock(StoryRepository::class);

        $storyId = 1;
        $mockRepository->shouldReceive('delete')
            ->withArgs([$storyId])
            ->once();

        $service = new DeleteStoryService($mockRepository);

        $mockRequest = Mockery::mock(DeleteStoryRequest::class);
        $mockRequest->shouldReceive('storyId')->andReturn($storyId);

        $response = $service($mockRequest);

        $this->assertInstanceOf(Response::class, $response);

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertEquals('{"message":"success"}', $response->getContent());
    }
}
