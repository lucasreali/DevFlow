<?php

namespace App\Middleware;

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
            header('Location: /login');
            exit;
        }
    }
}
