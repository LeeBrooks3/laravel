<?php

namespace LeeBrooks3\Laravel\Models;

use Illuminate\Auth\Authenticatable;

abstract class User implements UserInterface
{
    use Authenticatable;
}
