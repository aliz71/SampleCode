<?php

namespace App\Exceptions;

use App\Services\ResponseService;
use Illuminate\Contracts\Container\Container;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Exception;

class Handler extends ExceptionHandler
{
    private $responseService;

    public function __construct(Container $container, ResponseService $responseService)
    {
        parent::__construct($container);
        $this->responseService = $responseService;
    }

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param \Exception $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request $request
     * @param \Exception $exception
     * @return Response|JsonResponse
     * @throws Exception
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof ValidationException && ($request->is('api/*') || $request->ajax())) {
            return $this->responseService->respond($exception->errors(), 422);
        } elseif ($exception instanceof MethodNotAllowedHttpException && ($request->is('api/*') || $request->ajax())) {
            return $this->responseService->respond(["message" => "Your request is invalid."], 405);
        } elseif ($exception instanceof \Exception && ($request->is('api/*') || $request->ajax())) {
            return $this->responseService->respond(["message" => $exception->getMessage()], 422);
        }
        return parent::render($request, $exception);
    }
}
