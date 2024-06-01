<?php
namespace App\Traits;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

trait HandlesExceptions
{
    public function handleException(\Exception $e)
    {
        if($e instanceof ValidationException) {
            return response()->json([
                'message' => 'Validation failed',
                'erros' => $e->errors()
            ], 422);

        } elseif ($e instanceof ModelNotFoundException) {
            return response()->json([
                'message' => 'Resource not found'
            ], 404);

        } else {
            return response()->json([
                'message' => 'An unexpected error occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
