<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Throwable;

class Handler extends ExceptionHandler
{
  /**
   * Handle unauthenticated requests
   */
  protected function unauthenticated($request, AuthenticationException $exception): JsonResponse
  {
    return response()->json(['error' => 'Unauthenticated.'], 401);
  }
}
