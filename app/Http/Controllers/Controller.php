<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

abstract class Controller
{
    protected function extractBearerToken(Request $request): ?string
    {
        $authHeader = $request->header('Authorization');

        return $authHeader && str_starts_with($authHeader, 'Bearer ')
            ? substr($authHeader, 7)
            : null;
    }

}
