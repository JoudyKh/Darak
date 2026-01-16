<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{

    public function handle(Request $request, Closure $next)
    {
        $isAdmin =auth('sanctum')->user();
        if(!$isAdmin){
            App::setLocale($request->header('locale')); 
            abort_if(!in_array($request->header('locale'),['ar','en']),422,'invalid local ');

        }
        
        return $next($request);
    
    }
}
