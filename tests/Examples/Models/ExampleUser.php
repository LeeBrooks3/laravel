<?php

namespace LeeBrooks3\Laravel\Tests\Examples\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class ExampleUser extends ExampleModel implements AuthenticatableContract
{
    use Authenticatable;
}
