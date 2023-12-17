<?php

namespace Abather\MiniAccounting\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class DuplicateEntryException extends Exception
{
    /**
     * Create a new exception instance.
     *
     * @param  string  $message
     * @param  int  $code
     * @param  Exception|null  $previous
     */
    public function __construct($message = "Duplicate entry", $code = 400, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * Report or log the exception.
     *
     * @return void
     */
    public function report()
    {
        // You can log the exception if needed
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function render($request)
    {
        if ($request->expectsJson()) {
            // If the request expects JSON, return a JSON response
            return new JsonResponse(['error' => $this->getMessage()], 400);
        }

        // Otherwise, you can customize the response for non-JSON requests
        return response()->view('errors.duplicate_entry', [], 400);
    }
}
