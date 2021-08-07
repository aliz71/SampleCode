<?php

namespace App\Http\Controllers;

use App\Http\Requests\Book\CSVExportRequest;
use App\Http\Requests\Book\DeleteRequest;
use App\Http\Requests\Book\StoreRequest;
use App\Http\Requests\Book\UpdateRequest;
use App\Http\Requests\Book\XMLExportRequest;
use App\Repositories\Interfaces\BookRepositoryInterface;
use App\Services\ExportService;
use App\Services\ResponseService;
use Illuminate\Http\JsonResponse;

class BookController extends Controller
{
    private $bookRepository, $responseService, $exportService;

    public function __construct(BookRepositoryInterface $bookRepository,
                                ResponseService $responseService,
                                ExportService $exportService)
    {
        $this->bookRepository = $bookRepository;
        $this->responseService = $responseService;
        $this->exportService = $exportService;
    }

    public function index(): JsonResponse
    {
        $books = $this->bookRepository->all();
        return $this->responseService->respond($books);
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $this->bookRepository->create($request->all());
        return $this->responseService->respond();
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

    public function cvsExport(CSVExportRequest $request)
    {
        $columns = explode(',', $request->columns);
        $books = $this->bookRepository->getSelectedColumns($columns);
        $csvData = $this->exportService->csv('books', $columns, $books->toArray());
        return $this->responseService->csvDownload($csvData['callback'], $csvData['headers']);
    }

    public function xmlExport(XMLExportRequest $request)
    {
        $columns = explode(',', $request->columns);
        $books = $this->bookRepository->getSelectedColumns($columns);
        $xmlData = $this->exportService->xml('books', $books->toArray());
        return $this->responseService->xmlDownload($xmlData['xmlData'], $xmlData['headers']);
    }
}
