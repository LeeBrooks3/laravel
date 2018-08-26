<?php

namespace LeeBrooks3\Laravel\Tests\Unit\Database;

use Illuminate\Database\Eloquent\FactoryBuilder;
use LeeBrooks3\Laravel\Database\ModelFactories;
use LeeBrooks3\Laravel\Database\ModelFactory;
use LeeBrooks3\Laravel\Tests\Examples\Database\ExampleDatabaseTable;
use LeeBrooks3\Laravel\Tests\Examples\Models\ExampleModel;
use LeeBrooks3\Laravel\Tests\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class ModelFactoryTest extends TestCase
{
    use ModelFactories;

    /**
     * Defines a model factory.
     */
    public function setUp()
    {
        parent::setUp();

        $this->defineFactory(ExampleModel::class, ExampleDatabaseTable::class);
    }

    /**
     * Tests defining a model factory.
     */
    public function testDefineFactory()
    {
        $this->assertInstanceOf(ModelFactory::class, $this->factories[ExampleModel::class]);
    }

    /**
     * Tests getting a model factory.
     */
    public function testFactory()
    {
        $factory = $this->factory(ExampleModel::class);

        $this->assertInstanceOf(ModelFactory::class, $factory);
    }

    /**
     * Tests getting a model factories table factory builder instance.
     */
    public function testGetBuilder()
    {
        $factory = $this->factory(ExampleModel::class);

        $this->assertInstanceOf(FactoryBuilder::class, $factory->getBuilder());
    }

    /**
     * Tests setting a model factories table factory builder instance.
     */
    public function testSetBuilder()
    {
        /** @var FactoryBuilder|MockObject $builder */
        $factory = $this->factory(ExampleModel::class);
        $builder = $this->createMock(FactoryBuilder::class);

        $factory->setBuilder($builder);

        $this->assertEquals($builder, $factory->getBuilder());
    }

    /**
     * Tests creating a model instance.
     */
    public function testCreate()
    {
        /** @var FactoryBuilder|MockObject $mockBuilder */
        $factory = $this->factory(ExampleModel::class);
        $mockBuilder = $this->createMock(FactoryBuilder::class);
        $factory->setBuilder($mockBuilder);

        $fakeDatabaseModel = new ExampleDatabaseTable();

        $mockBuilder->expects($this->once())
            ->method('create')
            ->willReturn($fakeDatabaseModel);

        $this->assertInstanceOf(ExampleModel::class, $factory->create());
    }

    /**
     * Tests making multiple model instances.
     */
    public function testMake()
    {
        /** @var FactoryBuilder|MockObject $mockBuilder */
        $factory = $this->factory(ExampleModel::class);
        $mockBuilder = $this->createMock(FactoryBuilder::class);
        $factory->setBuilder($mockBuilder);

        $fakeDatabaseModel = new ExampleDatabaseTable();

        $mockBuilder->expects($this->once())
            ->method('make')
            ->willReturn([$fakeDatabaseModel]);

        $this->assertInstanceOf(ExampleModel::class, $factory->make()[0]);
    }

    /**
     * Tests making a model instance with a callback.
     */
    public function testCallback()
    {
        $this->defineFactory(ExampleModel::class, ExampleDatabaseTable::class, function (ExampleDatabaseTable $table) {
            return new ExampleModel($table->toArray());
        });

        /** @var FactoryBuilder|MockObject $mockBuilder */
        $factory = $this->factory(ExampleModel::class);
        $mockBuilder = $this->createMock(FactoryBuilder::class);
        $factory->setBuilder($mockBuilder);

        $fakeDatabaseModel = new ExampleDatabaseTable();

        $mockBuilder->expects($this->once())
            ->method('make')
            ->willReturn($fakeDatabaseModel);

        $this->assertInstanceOf(ExampleModel::class, $factory->make());
    }

    /**
     * Tests that calling methods which don't exist are called on the table factory builder instance.
     */
    public function testMagicCall()
    {
        /** @var FactoryBuilder|MockObject $mockBuilder */
        $factory = $this->factory(ExampleModel::class);
        $mockBuilder = $this->createMock(FactoryBuilder::class);
        $factory->setBuilder($mockBuilder);

        $mockBuilder->expects($this->once())
            ->method('__call')
            ->with('states', [
                ['state'],
            ]);

        $factory->states(['state']);
    }
}
