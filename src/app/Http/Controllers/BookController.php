<?php

namespace App\Http\Controllers;

use App\Http\Requests\Book\DeleteRequest;
use App\Http\Requests\Book\StoreRequest;
use App\Http\Requests\Book\UpdateRequest;
use App\Repositories\Interfaces\BookRepositoryInterface;
use App\Services\ResponseService;
use Illuminate\Http\JsonResponse;

class BookController extends Controller
{
    private $bookRepository, $responseService;

    public function __construct(BookRepositoryInterface $bookRepository,
                                ResponseService $responseService)
    {
        $this->bookRepository = $bookRepository;
        $this->responseService = $responseService;
    }

    public function index(): JsonResponse
    {
        $books = $this->bookRepository->all();
        return $this->responseService->respond($books);
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $book = $this->bookRepository->create($request->all());
        return $this->responseService->respond($book->toArray());
    }

    public function update(UpdateRequest $request, int $id): JsonResponse
    {
        $this->bookRepository->update($request->all(), $id);
        return $this->responseService->respond();
    }

    public function destroy(DeleteRequest $request, int $id): JsonResponse
    {
        $this->bookRepository->delete($id);
        return $this->responseService->respond();
    }
}
