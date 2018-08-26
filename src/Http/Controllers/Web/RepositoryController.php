<?php

namespace LeeBrooks3\Laravel\Http\Controllers\Web;

use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use LeeBrooks3\Laravel\Http\Controllers\Controller;
use LeeBrooks3\Repositories\ModelRepositoryInterface;

abstract class RepositoryController extends Controller
{
    /**
     * The folder in which the views can be found.
     *
     * @var string
     */
    protected $viewFolder;

    /**
     * A redirector instance.
     *
     * @var Redirector
     */
    private $redirector;

    /**
     * The repository instance.
     *
     * @var ModelRepositoryInterface
     */
    private $repository;

    /**
     * A view factory instance.
     *
     * @var ViewFactory
     */
    private $viewFactory;

    /**
     * @param Request $request
     * @param Redirector $redirector
     * @param ModelRepositoryInterface $repository
     * @param ViewFactory $viewFactory
     */
    public function __construct(
        Request $request,
        Redirector $redirector,
        ModelRepositoryInterface $repository,
        ViewFactory $viewFactory
    ) {
        parent::__construct($request);

        $this->redirector = $redirector;
        $this->repository = $repository;
        $this->viewFactory = $viewFactory;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() : Response
    {
        $params = $this->request->all();
        $models = $this->repository->get($params);

        $viewFolder = $this->getViewFolder();
        $view = $this->viewFactory->make("{$viewFolder}.index", [
            'data' => $models,
        ]);

        return new Response($view->render());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() : Response
    {
        $viewFolder = $this->getViewFolder();
        $view = $this->viewFactory->make("{$viewFolder}.create");

        return new Response($view->render());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response|RedirectResponse
     */
    public function store()
    {
        $params = $this->request->all();

        $this->repository->create($params);

        return $this->redirector->back(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param int|null $id
     * @return Response
     */
    public function show($id) : Response
    {
        $params = $this->request->all();
        $model = $this->repository->find($id, $params);

        $viewFolder = $this->getViewFolder();
        $view = $this->viewFactory->make("{$viewFolder}.show", [
            'data' => $model,
        ]);

        return new Response($view->render());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int|null $id
     * @return Response
     */
    public function edit($id) : Response
    {
        $params = $this->request->all();
        $model = $this->repository->find($id, $params);

        $viewFolder = $this->getViewFolder();
        $view = $this->viewFactory->make("{$viewFolder}.edit", [
            'data' => $model,
        ]);

        return new Response($view->render());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int|null $id
     * @return Response|RedirectResponse
     */
    public function update($id)
    {
        $model = $this->repository->find($id);
        $params = $this->request->all();

        $this->repository->update($model, $params);

        return $this->redirector->back(Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int|string $id
     * @return Response|RedirectResponse
     */
    public function destroy($id)
    {
        $model = $this->repository->find($id);

        $this->repository->delete($model);

        return $this->redirector->back(Response::HTTP_NO_CONTENT);
    }

    /**
     * Returns the view folder.
     *
     * @return string
     */
    protected function getViewFolder()
    {
        return $this->viewFolder;
    }
}
