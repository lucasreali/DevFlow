<?php

namespace App\Middleware;

use function Core\redirect;

class AuthMiddleware
{
    /**
     * Verifica se o usuário está logado,
     * bloqueando o acesso à páginas que necessitam
     * de autenticação.
     * 
     * @return void
     */
    public function handle()
    {

        if (!isset($_SESSION['user'])) {
            return redirect('/login', ['error' => 'Please login to access this page.']);
        }
    }
}
