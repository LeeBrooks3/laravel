<?php

namespace LeeBrooks3\Laravel\Tests\Examples\Http\Controllers;

use Illuminate\Http\Request;
use LeeBrooks3\Laravel\Http\Controllers\Api\RepositoryController as ApiRepositoryController;
use LeeBrooks3\Laravel\Tests\Examples\Repositories\ExampleApiModelRepository;
use LeeBrooks3\Tests\Examples\Transformers\ExampleModelTransformer;

class ExampleApiRepositoryController extends ApiRepositoryController
{
    /**
     * @param Request $request
     * @param ExampleApiModelRepository $repository
     * @param ExampleModelTransformer $transformer
     */
    public function __construct(
        Request $request,
        ExampleApiModelRepository $repository,
        ExampleModelTransformer $transformer
    ) {
        parent::__construct($request, $repository, $transformer);
    }
}
