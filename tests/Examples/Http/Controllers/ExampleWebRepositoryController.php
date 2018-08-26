<?php

namespace LeeBrooks3\Laravel\Tests\Examples\Http\Controllers;

use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use LeeBrooks3\Laravel\Http\Controllers\Web\RepositoryController as WebRepositoryController;
use LeeBrooks3\Laravel\Tests\Examples\Repositories\ExampleDatabaseModelRepository;

class ExampleWebRepositoryController extends WebRepositoryController
{
    /**
     * @var string
     */
    protected $viewFolder = 'example';

    /**
     * @param Request $request
     * @param Redirector $redirector
     * @param ExampleDatabaseModelRepository $repository
     * @param ViewFactory $viewFactory
     */
    public function __construct(
        Request $request,
        Redirector $redirector,
        ExampleDatabaseModelRepository $repository,
        ViewFactory $viewFactory
    ) {
        parent::__construct($request, $redirector, $repository, $viewFactory);
    }
}
