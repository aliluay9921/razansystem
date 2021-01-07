<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use App\Traits\sendresponse;
use Illuminate\Http\Response;
use Exception;

// هذا يخلي الايرر الي يرجعلك من يصير داخل السستم يرجع بصورة مرتبة ومفهومة

class Handler extends ExceptionHandler
{
    use sendresponse;
    protected function prepareResponse($request, Throwable $e)
    {



        if (!$this->isHttpException($e)) {
            return $this->sendresponse(
                500,
                "error in the server",
                ['error' => [$e->getMessage()]],
                []
            );
        }

        return $this->toIlluminateResponse(
            $this->renderHttpException($e),
            $e
        );
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
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {

        $this->renderable(function (Exception $e, $request) {
            return $this->sendresponse(
                500,
                "error in the server",
                ['error' => [$e->getMessage()]],
                []
            );
        });
    }
}