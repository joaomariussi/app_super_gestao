<?php

namespace App\Http\Middleware;

use App\Models\LogAcesso;
use Closure;
use Illuminate\Http\Request;

class LogAcessoMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

//        // Obtendo o endereço IP do cliente
//        $ip = $request->ip();
//
//        // Obtendo a rota requisitada
//        $rota = $request->getRequestUri();
//
//        // Registrando o acesso no log
//        LogAcesso::create(['log' => "IP $ip requisitou a rota $rota"]);

        // Passando a requisição para o próximo middleware
        return $next($request);
    }
}
