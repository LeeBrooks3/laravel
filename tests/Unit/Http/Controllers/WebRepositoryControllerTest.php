<?php

namespace LeeBrooks3\Laravel\Tests\Unit\Http\Controllers;

use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use LeeBrooks3\Laravel\Tests\Examples\Http\Controllers\ExampleWebRepositoryController;
use LeeBrooks3\Laravel\Tests\Examples\Repositories\ExampleDatabaseModelRepository;
use LeeBrooks3\Laravel\Tests\TestCase;
use LeeBrooks3\Laravel\Tests\Examples\Models\ExampleModel;
use PHPUnit\Framework\MockObject\MockObject;

class WebRepositoryControllerTest extends TestCase
{
    /**
     * The controller instance.
     *
     * @var ExampleWebRepositoryController
     */
    private $controller;

    /**
     * A mocked redirector instance.
     *
     * @var Redirector|MockObject
     */
    private $mockRedirector;

    /**
     * A mocked repository instance.
     *
     * @var ExampleDatabaseModelRepository|MockObject
     */
    private $mockRepository;

    /**
     * A mocked request instance.
     *
     * @var Request|MockObject
     */
    private $mockRequest;

    /**
     * A mocked view factory instance.
     *
     * @var ViewFactory|MockObject
     */
    private $mockViewFactory;

    /**
     * A mocked view instance.
     *
     * @var View|MockObject
     */
    private $mockView;

    /**
     * Mocks the redirector, repository, request, and view factory instances and creates an instance of the controller.
     */
    public function setUp()
    {
        parent::setUp();

        $this->mockRedirector = $this->createMock(Redirector::class);
        $this->mockRepository = $this->createMock(ExampleDatabaseModelRepository::class);
        $this->mockRequest = $this->createMock(Request::class);
        $this->mockViewFactory = $this->createMock(ViewFactory::class);
        $this->mockView = $this->createMock(View::class);

        $this->controller = new ExampleWebRepositoryController(
            $this->mockRequest,
            $this->mockRedirector,
            $this->mockRepository,
            $this->mockViewFactory
        );
    }

    /**
     * Tests that a listing of the resource can be displayed.
     */
    public function testIndex()
    {
        $fakeParams = [];
        $fakeCollection = [];

        $this->mockRequest->expects($this->once())
            ->method('all')
            ->willReturn($fakeParams);

        $this->mockRepository->expects($this->once())
            ->method('get')
            ->with($fakeParams)
            ->willReturn($fakeCollection);

        $this->mockViewFactory->expects($this->once())
            ->method('make')
            ->with('example.index', [
                'data' => $fakeCollection,
            ])
            ->willReturn($this->mockView);

        $this->mockView->expects($this->once())
            ->method('render');

        $result = $this->controller->index();

        $this->assertInstanceOf(Response::class, $result);
    }

    /**
     * Tests that the form for creating a new resource can be shown.
     */
    public function testCreate()
    {
        $this->mockViewFactory->expects($this->once())
            ->method('make')
            ->with('example.create')
            ->willReturn($this->mockView);

        $this->mockView->expects($this->once())
            ->method('render');

        $result = $this->controller->create();

        $this->assertInstanceOf(Response::class, $result);
    }

    /**
     * Tests that a new resource can be created in storage
     */
    public function testStore()
    {
        $fakeParams = [];
        $fakeModel = new ExampleModel();
        $fakeRedirectResponse = new RedirectResponse('/');

        $this->mockRequest->expects($this->once())
            ->method('all')
            ->willReturn($fakeParams);

        $this->mockRepository->expects($this->once())
            ->method('create')
            ->with($fakeParams)
            ->willReturn($fakeModel);

        $this->mockRedirector->expects($this->once())
            ->method('back')
            ->willReturn($fakeRedirectResponse);

        $result = $this->controller->store();

        $this->assertInstanceOf(RedirectResponse::class, $result);
    }

    /**
     * Tests that the specified resource can be displayed.
     */
    public function testShow()
    {
        $fakeId = $this->faker->uuid;
        $fakeParams = [];
        $fakeModel = new ExampleModel();

        $this->mockRequest->expects($this->once())
            ->method('all')
            ->willReturn($fakeParams);

        $this->mockRepository->expects($this->once())
            ->method('find')
            ->with($fakeId, $fakeParams)
            ->willReturn($fakeModel);

        $this->mockViewFactory->expects($this->once())
            ->method('make')
            ->with('example.show', [
                'data' => $fakeModel,
            ])
            ->willReturn($this->mockView);

        $this->mockView->expects($this->once())
            ->method('render');

        $result = $this->controller->show($fakeId);

        $this->assertInstanceOf(Response::class, $result);
    }

    /**
     * Tests that the form for editing the specified resource can be shown.
     */
    public function testEdit()
    {
        $fakeId = $this->faker->uuid;
        $fakeParams = [];
        $fakeModel = new ExampleModel();

        $this->mockRequest->expects($this->once())
            ->method('all')
            ->willReturn($fakeParams);

        $this->mockRepository->expects($this->once())
            ->method('find')
            ->with($fakeId, $fakeParams)
            ->willReturn($fakeModel);

        $this->mockViewFactory->expects($this->once())
            ->method('make')
            ->with('example.edit', [
                'data' => $fakeModel,
            ])
            ->willReturn($this->mockView);

        $this->mockView->expects($this->once())
            ->method('render');

        $result = $this->controller->edit($fakeId);

        $this->assertInstanceOf(Response::class, $result);
    }

    /**
     * Tests that the specified resource can be updated in storage.
     */
    public function testUpdate()
    {
        $fakeId = $this->faker->uuid;
        $fakeParams = [];
        $fakeModel = new ExampleModel();
        $fakeRedirectResponse = new RedirectResponse('/');

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

        $this->mockRedirector->expects($this->once())
            ->method('back')
            ->willReturn($fakeRedirectResponse);

        $result = $this->controller->update($fakeId);

        $this->assertInstanceOf(RedirectResponse::class, $result);
    }

    /**
     * Tests that the specified resource can be removed from storage.
     */
    public function testDestroy()
    {
        $fakeId = $this->faker->uuid;
        $fakeModel = new ExampleModel();
        $fakeRedirectResponse = new RedirectResponse('/');

        $this->mockRepository->expects($this->once())
            ->method('find')
            ->with($fakeId)
            ->willReturn($fakeModel);

        $this->mockRepository->expects($this->once())
            ->method('delete')
            ->with($fakeModel);

        $this->mockRedirector->expects($this->once())
            ->method('back')
            ->willReturn($fakeRedirectResponse);

        $result = $this->controller->destroy($fakeId);

        $this->assertInstanceOf(RedirectResponse::class, $result);
    }
}
