<?php

namespace LeeBrooks3\Laravel\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use LeeBrooks3\Laravel\Http\Controllers\Controller;
use LeeBrooks3\Repositories\ModelRepositoryInterface;
use LeeBrooks3\Transformers\TransformerInterface;

abstract class RepositoryController extends Controller
{
    /**
     * The repository instance.
     *
     * @var ModelRepositoryInterface
     */
    private $repository;

    /**
     * The transformer instance.
     *
     * @var TransformerInterface
     */
    private $transformer;

    /**
     * @param Request $request
     * @param ModelRepositoryInterface $repository
     * @param TransformerInterface $transformer
     */
    public function __construct(
        Request $request,
        ModelRepositoryInterface $repository,
        TransformerInterface $transformer
    ) {
        parent::__construct($request);

        $this->repository = $repository;
        $this->transformer = $transformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index() : JsonResponse
    {
        $params = $this->request->all();
        $models = $this->repository->get($params);

        return new JsonResponse($this->transformer->transform($models));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return JsonResponse
     */
    public function store() : JsonResponse
    {
        $params = $this->request->all();
        $model = $this->repository->create($params);

        return new JsonResponse($this->transformer->transform($model), JsonResponse::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param int|null $id
     * @return JsonResponse
     */
    public function show($id) : JsonResponse
    {
        $params = $this->request->all();
        $model = $this->repository->find($id, $params);

        return new JsonResponse($this->transformer->transform($model));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int|null $id
     * @return JsonResponse
     */
    public function update($id) : JsonResponse
    {
        $model = $this->repository->find($id);
        $params = $this->request->all();

        $model = $this->repository->update($model, $params);

        return new JsonResponse($this->transformer->transform($model));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int|string $id
     * @return JsonResponse
     */
    public function destroy($id) : JsonResponse
    {
        $model = $this->repository->find($id);

        $this->repository->delete($model);

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
