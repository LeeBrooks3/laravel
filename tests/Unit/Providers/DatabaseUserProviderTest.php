<?php

namespace LeeBrooks3\Laravel\Tests\Unit\Providers;

use Illuminate\Contracts\Hashing\Hasher;
use LeeBrooks3\Laravel\Providers\Database\UserProvider as DatabaseUserProvider;
use LeeBrooks3\Laravel\Tests\Examples\Models\ExampleUser;
use LeeBrooks3\Repositories\ModelRepositoryInterface;
use PHPUnit\Framework\MockObject\MockObject;

class DatabaseUserProviderTest extends UserProviderTest
{
    /**
     * A mocked hasher instance.
     *
     * @var Hasher|MockObject
     */
    protected $mockHasher;

    /**
     * Creates a mock model repository and hasher instance and the repository instance to test.
     */
    public function setUp()
    {
        parent::setUp();

        $model = new ExampleUser();
        $this->mockRepository = $this->createMock(ModelRepositoryInterface::class);
        $this->mockHasher = $this->createMock(Hasher::class);

        $this->userProvider = new DatabaseUserProvider($model, $this->mockRepository, $this->mockHasher);
    }

    /**
     * Tests that a users credentials can be validated.
     */
    public function testValidateCredentials()
    {
        $password = $this->faker->password;
        $user = new ExampleUser([
            'email' => $this->faker->email,
            'password' => password_hash($password, PASSWORD_BCRYPT),
        ]);
        $credentials = [
            'password' => $password,
        ];

        $this->mockHasher->expects($this->once())
            ->method('check')
            ->with($credentials['password'], $user->password)
            ->willReturn(true);

        $result = $this->userProvider->validateCredentials($user, $credentials);

        $this->assertTrue($result);
    }
}
