<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
    ];
    /** 
    *@param \Illuminate\Http\Request
    *@return bool
    */
    protected function TokenMatch($request){
        $token = $request->ajax() ? $requset->header('X-CSRF-TOKEN'): $request->input('_token');
        return $request->session()->token() == $token;
    }
}
