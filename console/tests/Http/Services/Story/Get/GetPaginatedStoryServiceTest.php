<?php

namespace Tests\Http\Services\Story\Get;

use App\Http\Services\Story\Get\GetPaginatedStoryRequest;
use App\Http\Services\Story\Get\GetPaginatedStoryService;
use App\Models\StoryRepository;
use Illuminate\Http\JsonResponse;
use Mockery;
use Tests\TestCase;

class GetPaginatedStoryServiceTest extends TestCase
{
    public function testGetPaginatedStoryService()
    {
        $mockRepository = Mockery::mock(StoryRepository::class);

        $storiesData = [];
        $mockRepository->shouldReceive('getByPage')
            ->withArgs([Mockery::type('int'), Mockery::type('int')])
            ->andReturn($storiesData);

        $service = new GetPaginatedStoryService($mockRepository);

        $mockRequest = Mockery::mock(GetPaginatedStoryRequest::class);
        $mockRequest->shouldReceive('perPage')->andReturn(10);
        $mockRequest->shouldReceive('page')->andReturn(1);

        $response = $service($mockRequest);

        $this->assertInstanceOf(JsonResponse::class, $response);

        $responseData = json_decode($response->getContent(), true);
        $this->assertEquals($storiesData, $responseData);
    }
}
