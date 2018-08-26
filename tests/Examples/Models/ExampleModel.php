<?php

namespace LeeBrooks3\Laravel\Tests\Examples\Models;

use LeeBrooks3\Tests\Examples\Models\ExampleModel as BaseExampleModel;

class ExampleModel extends BaseExampleModel
{
    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'uuid';
    }
}
