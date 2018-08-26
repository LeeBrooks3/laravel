<?php

namespace LeeBrooks3\Laravel\Tests\Unit\Repositories;

use Illuminate\Contracts\Events\Dispatcher as EventDispatcher;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use LeeBrooks3\Laravel\Tests\Examples\Database\ExampleDatabaseTable;
use LeeBrooks3\Laravel\Tests\Examples\Repositories\ExampleDatabaseModelRepository;
use LeeBrooks3\Laravel\Tests\TestCase;
use LeeBrooks3\Laravel\Tests\Examples\Models\ExampleModel;
use PHPUnit\Framework\MockObject\MockObject;

class DatabaseModelRepositoryTest extends TestCase
{
    /**
     * A mocked query builder instance.
     *
     * @var Builder|MockObject
     */
    private $mockBuilder;

    /**
     * A mocked model instance.
     *
     * @var ExampleDatabaseTable|MockObject
     */
    private $mockTable;

    /**
     * A mocked event dispatcher instance.
     *
     * @var EventDispatcher|MockObject
     */
    private $mockEventDispatcher;

    /**
     * The repository instance.
     *
     * @var ExampleDatabaseModelRepository
     */
    private $repository;

    /**
     * Mocks the client instance and creates an instance of the repository.
     */
    public function setUp()
    {
        parent::setUp();

        $this->mockBuilder = $this->createMock(Builder::class);
        $this->mockTable = $this->createMock(ExampleDatabaseTable::class);
        $this->mockEventDispatcher = $this->createMock(EventDispatcher::class);

        $this->repository = new ExampleDatabaseModelRepository($this->mockTable, $this->mockEventDispatcher);
    }

    /**
     * Tests that the resources matching the given parameters can be returned.
     */
    public function testGet()
    {
        $fakeParams = [];
        $fakeDatabaseModel = new ExampleDatabaseTable();
        $fakeCollection = new Collection([
            $fakeDatabaseModel,
        ]);

        $this->mockTable->expects($this->once())
            ->method('newQuery')
            ->willReturn($this->mockBuilder);

        $this->mockBuilder->expects($this->once())
            ->method('where')
            ->with($fakeParams)
            ->willReturnSelf();

        $this->mockBuilder->expects($this->once())
            ->method('get')
            ->willReturn($fakeCollection);

        $result = $this->repository->get($fakeParams);

        $this->assertInstanceOf(ExampleModel::class, reset($result));
    }

    /**
     * Tests that a new resource can be created.
     */
    public function testCreate()
    {
        $fakeAttributes = [];
        $fakeDatabaseModel = new ExampleDatabaseTable();

        $this->mockEventDispatcher->expects($this->once())
            ->method('dispatch');

        $this->mockTable->expects($this->once())
            ->method('newQuery')
            ->willReturn($this->mockBuilder);

        $this->mockBuilder->expects($this->once())
            ->method('create')
            ->with($fakeAttributes)
            ->willReturn($fakeDatabaseModel);

        $result = $this->repository->create($fakeAttributes);

        $this->assertInstanceOf(ExampleModel::class, $result);
    }

    /**
     * Tests that the resources matching the given parameters can be returned.
     */
    public function testFind()
    {
        $fakeId = $this->faker->randomNumber();
        $fakeParams = [];
        $fakeDatabaseModel = new ExampleDatabaseTable();

        $this->mockTable->expects($this->once())
            ->method('newQuery')
            ->willReturn($this->mockBuilder);

        $this->mockBuilder->expects($this->once())
            ->method('where')
            ->with('id', $fakeId)
            ->willReturnSelf();

        $this->mockBuilder->expects($this->once())
            ->method('orWhere')
            ->with('uuid', $fakeId)
            ->willReturnSelf();

        $this->mockBuilder->expects($this->once())
            ->method('firstOrFail')
            ->willReturn($fakeDatabaseModel);

        $result = $this->repository->find($fakeId, $fakeParams);

        $this->assertInstanceOf(ExampleModel::class, $result);
    }

    /**
     * Tests that a resource can be updated.
     */
    public function testUpdate()
    {
        $fakeAttributes = [];
        $fakeModel = new ExampleModel([
            'id' => $this->faker->randomNumber(),
        ]);

        $this->mockTable->expects($this->once())
            ->method('newQuery')
            ->willReturn($this->mockBuilder);

        $this->mockBuilder->expects($this->once())
            ->method('where')
            ->with($fakeModel->getKeyName(), $fakeModel->getKey())
            ->willReturnSelf();

        $this->mockBuilder->expects($this->once())
            ->method('update')
            ->with($fakeAttributes)
            ->willReturnSelf();

        $result = $this->repository->update($fakeModel, $fakeAttributes);

        $this->assertInstanceOf(ExampleModel::class, $result);
    }

    /**
     * Tests that a resource can be deleted.
     *
     * @throws \Exception
     */
    public function testDelete()
    {
        $fakeModel = new ExampleModel([
            'id' => $this->faker->randomNumber(),
        ]);

        $this->mockTable->expects($this->once())
            ->method('newQuery')
            ->willReturn($this->mockBuilder);

        $this->mockBuilder->expects($this->once())
            ->method('where')
            ->with($fakeModel->getKeyName(), $fakeModel->getKey())
            ->willReturnSelf();

        $this->mockBuilder->expects($this->once())
            ->method('delete');

        $this->repository->delete($fakeModel);
    }
}
