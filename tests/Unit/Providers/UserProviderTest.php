<?php

namespace LeeBrooks3\Laravel\Tests\Unit\Providers;

use Illuminate\Contracts\Auth\UserProvider as UserProviderContract;
use LeeBrooks3\Laravel\Tests\Examples\Models\ExampleUser;
use LeeBrooks3\Laravel\Tests\TestCase;
use LeeBrooks3\Repositories\ModelRepositoryInterface;
use PHPUnit\Framework\MockObject\MockObject;

abstract class UserProviderTest extends TestCase
{
    /**
     * A mocked model repository instance.
     *
     * @var ModelRepositoryInterface|MockObject
     */
    protected $mockRepository;

    /**
     * A repository instance.
     *
     * @var UserProviderContract
     */
    protected $userProvider;

    /**
     * Tests that a user can be retrieved by id.
     */
    public function testRetrieveById()
    {
        $id = $this->faker->uuid;

        $this->mockRepository->expects($this->once())
            ->method('find')
            ->with($id)
            ->willReturn(new ExampleUser());

        $this->userProvider->retrieveById($id);
    }

    /**
     * Tests that a user can be retrieved by token.
     */
    public function testRetrieveByToken()
    {
        $id = $this->faker->uuid;
        $token = $this->faker->uuid;

        $this->mockRepository->expects($this->once())
            ->method('get')
            ->with([
                'id' => $id,
                'remember_token' => $token,
            ])
            ->willReturn([]);

        $this->userProvider->retrieveByToken($id, $token);
    }

    /**
     * Tests that a remember token can be updated.
     */
    public function testUpdateRememberToken()
    {
        $user = new ExampleUser();
        $token = $this->faker->uuid;

        $this->mockRepository->expects($this->once())
            ->method('update')
            ->with($user, [
                'remember_token' => $token,
            ]);

        $this->userProvider->updateRememberToken($user, $token);
    }

    /**
     * Tests that a user can be retrieved by credentials.
     */
    public function testRetrieveByCredentials()
    {
        $username = $this->faker->email;
        $password = $this->faker->password;

        $this->mockRepository->expects($this->once())
            ->method('get')
            ->with([
                'email' => $username,
            ])
            ->willReturn([]);

        $this->userProvider->retrieveByCredentials([
            'email' => $username,
            'password' => $password,
        ]);
    }

    /**
     * Tests that a user wont be retrieved by credentials if none passed.
     */
    public function testRetrieveByCredentialsWithoutCredentials()
    {
        $result = $this->userProvider->retrieveByCredentials([]);

        $this->assertNull($result);
    }
}
