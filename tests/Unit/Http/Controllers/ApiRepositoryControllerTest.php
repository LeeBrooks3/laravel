<?php

namespace LeeBrooks3\Laravel\Tests\Unit\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use LeeBrooks3\Laravel\Tests\Examples\Http\Controllers\ExampleApiRepositoryController;
use LeeBrooks3\Laravel\Tests\Examples\Repositories\ExampleApiModelRepository;
use LeeBrooks3\Laravel\Tests\TestCase;
use LeeBrooks3\Laravel\Tests\Examples\Models\ExampleModel;
use LeeBrooks3\Tests\Examples\Transformers\ExampleModelTransformer;
use PHPUnit\Framework\MockObject\MockObject;

class ApiRepositoryControllerTest extends TestCase
{
    /**
     * The controller instance.
     *
     * @var ExampleApiRepositoryController
     */
    private $controller;

    /**
     * A mocked repository instance.
     *
     * @var ExampleApiModelRepository|MockObject
     */
    private $mockRepository;

    /**
     * A mocked request instance.
     *
     * @var Request|MockObject
     */
    private $mockRequest;

    /**
     * A mocked transformer instance.
     *
     * @var ExampleModelTransformer|MockObject
     */
    private $mockTransformer;

    /**
     * Mocks the repository, request and transformer instances and creates an instance of the controller.
     */
    public function setUp()
    {
        parent::setUp();

        $this->mockRepository = $this->createMock(ExampleApiModelRepository::class);
        $this->mockRequest = $this->createMock(Request::class);
        $this->mockTransformer = $this->createMock(ExampleModelTransformer::class);

        $this->app->instance('request', $this->mockRequest);

        $this->controller = new ExampleApiRepositoryController(
            $this->mockRequest,
            $this->mockRepository,
            $this->mockTransformer
        );
    }

    /**
     * Tests that a listing of the resource can be displayed.
     */
    public function testIndex()
    {
        $fakeParams = [];
        $fakeCollection = [];
        $fakeResourceCollection = [];

        $this->mockRequest->expects($this->once())
            ->method('all')
            ->willReturn($fakeParams);

        $this->mockRepository->expects($this->once())
            ->method('get')
            ->with($fakeParams)
            ->willReturn($fakeCollection);

        $this->mockTransformer->expects($this->once())
            ->method('transform')
            ->with($fakeCollection)
            ->willReturn($fakeResourceCollection);

        $result = $this->controller->index();

        $this->assertInstanceOf(JsonResponse::class, $result);
    }

    /**
     * Tests that a new resource can be created in storage.
     */
    public function testStore()
    {
        $fakeParams = [];
        $fakeModel = new ExampleModel();
        $fakeResource = [];

        $this->mockRequest->expects($this->once())
            ->method('all')
            ->willReturn($fakeParams);

        $this->mockRepository->expects($this->once())
            ->method('create')
            ->with($fakeParams)
            ->willReturn($fakeModel);

        $this->mockTransformer->expects($this->once())
            ->method('transform')
            ->with($fakeModel)
            ->willReturn($fakeResource);

        $result = $this->controller->store();

        $this->assertInstanceOf(JsonResponse::class, $result);
    }

    /**
     * Tests that the specified resource can be displayed.
     */
    public function testShow()
    {
        $fakeId = $this->faker->uuid;
        $fakeParams = [];
        $fakeModel = new ExampleModel();
        $fakeResource = [];

        $this->mockRequest->expects($this->once())
            ->method('all')
            ->willReturn($fakeParams);

        $this->mockRepository->expects($this->once())
            ->method('find')
            ->with($fakeId, $fakeParams)
            ->willReturn($fakeModel);

        $this->mockTransformer->expects($this->once())
            ->method('transform')
            ->with($fakeModel)
            ->willReturn($fakeResource);

        $result = $this->controller->show($fakeId);

        $this->assertInstanceOf(JsonResponse::class, $result);
    }

    /**
     * Tests that the specified resource can be updated in storage.
     */
    public function testUpdate()
    {
        $fakeId = $this->faker->uuid;
        $fakeParams = [];
        $fakeModel = new ExampleModel();
        $fakeResource = [];

        $this->mockRepository->expects($this->once())
            ->method('find')
            ->with($fakeId)
            ->willReturn($fakeModel);

        $this->mockRequest->expects($this->once())
            ->method('all')
            ->willReturn($fakeParams);

        $this->mockRepository->expects($this->once())
            ->method('update')
            ->with($fakeModel, $fakeParams)
            ->willReturn($fakeModel);

        $this->mockTransformer->expects($this->once())
            ->method('transform')
            ->with($fakeModel)
            ->willReturn($fakeResource);

        $result = $this->controller->update($fakeId);

        $this->assertInstanceOf(JsonResponse::class, $result);
    }

    /**
     * Tests that the specified resource can be removed from storage.
     */
    public function testDestroy()
    {
        $fakeId = $this->faker->uuid;
        $fakeModel = new ExampleModel();

        $this->mockRepository->expects($this->once())
            ->method('find')
            ->with($fakeId)
            ->willReturn($fakeModel);

        $this->mockRepository->expects($this->once())
            ->method('delete')
            ->with($fakeModel);

        $result = $this->controller->destroy($fakeId);

        $this->assertInstanceOf(JsonResponse::class, $result);
    }
}
