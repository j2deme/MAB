<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use GrahamCampbell\Exceptions\ExceptionHandler as ExceptionHandler;

class Handler extends ExceptionHandler
{
  /**
   * A list of the exception types that should not be reported.
   *
   * @var array
   */
  protected $dontReport = [
    AuthorizationException::class,
    HttpException::class,
    ModelNotFoundException::class,
    ValidationException::class,
  ];

  /**
   * Report or log an exception.
   *
   * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
   *
   * @param  \Exception  $e
   * @return void
   */
  public function report(Exception $e)
  {
    parent::report($e);
  }

  /**
   * Render an exception into an HTTP response.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Exception  $e
   * @return \Illuminate\Http\Response
   */
  public function render($request, Exception $e)
  {
    if ($e instanceof AuthorizationException) {
      return $this->unauthorized($request, $e);
    }
    
    if ($e instanceof TokenMismatchException) {
      return response()
        ->view('errors.401', ['error' => 'La página ha expirado por inactividad, actualiza e intenta nuevamente'], 401);
    }
    return parent::render($request, $e);
  }

  /**
   * Returns expected response on unauthorized request
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Exception  $e
   * @return \Illuminate\Http\Response
   */
  private function unauthorized($request, Exception $exception)
  {
    if ($request->wantsJson()) {
      return response()->json(['error' => $exception->getMessage()], 403);
    }

    flash()->warning($exception->getMessage());
    return redirect()->route('home.index');
  }
}
