<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Throwable;

class Handler extends ExceptionHandler
{
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
        'current_password',
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

        // $this->reportable(function (Throwable $e) {
        //     try {
        //         if (request()->ip() != '127.0.0.1') {
        //             if ($e instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
        //             } else if ($e instanceof \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException) {
        //             } else if ($e instanceof \Illuminate\Auth\AuthenticationException) {
        //             } else if ($e instanceof \Illuminate\Validation\ValidationException) {
        //             } else if ($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
        //             } else if ($e instanceof \Symfony\Component\HttpKernel\Exception\HttpException) {
        //             } else {
        //                 Log::channel('slack')->critical($e, [
        //                     'Environment'  => app()->environment(),
        //                     'Request url'  => request()->method() . ' ' . request()->url(),
        //                     'User'         => (auth()->check() ? (currentUser()->name .  ' (' . auth()->id() . ')') : 'Anonymous') . ' (' . request()->ip() . ')',
        //                     'Request Body' => [json_encode(request()->all())]
        //                 ]);
        //             }
        //         }
        //     } catch (\Throwable $th) {
        //         //throw $th;
        //     }
        // });
    }

    public function render($request, Throwable $e)
    {
        try {
            $response = parent::render($request, $e);
            if (in_array($response->getStatusCode(), [404, 500])) {
                //change any error to be 200 instead of 500
                return response($response->getContent(), 200);
            } else {
                return $response;
            }
        } catch (\Throwable $th) {
            return parent::render($request, $e);
        }
    }
}
