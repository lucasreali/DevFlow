<?php
namespace App\Middleware;

use Core\CsrfHelper;

class CsrfMiddleware
{
    public static function handle()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $csrfToken = $_POST['csrf_token'] ?? '';

            if (!CsrfHelper::validateToken($csrfToken)) {
                http_response_code(403);
                die('CSRF token inválido.');
            }
        }
    }
}