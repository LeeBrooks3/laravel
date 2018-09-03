<?php

namespace LeeBrooks3\Laravel\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use LeeBrooks3\Models\ModelInterface;

interface UserInterface extends ModelInterface, Authenticatable
{
    //
}
