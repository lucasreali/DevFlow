<?php

namespace App\Middleware;

use function Core\redirect;

class GuestMiddleware
{
    /**
     * Verifica se o usuário está logado,
     * bloqueando o acesso à páginas
     * que não é permitida para usuários logados.
     * 
     * @return void
     */
    public function handle()
    {
        if (!isset($_SESSION)) {
            session_start();
        }

        if (isset($_SESSION['user'])) {
            return redirect('/', ['info' => 'You are already logged in.']);
        }
    }
}
