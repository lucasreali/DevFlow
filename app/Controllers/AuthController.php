<?

namespace App\Controllers;

class AuthController
{
    public static function github()
    {
        $clientId = $_ENV['GITHUB_CLIENT_ID'];
        $redirectUri = $_ENV['GITHUB_REDIRECT_URI'];

        $githubAuthUrl = "https://github.com/login/oauth/authorize?client_id={$clientId}&redirect_uri={$redirectUri}&scope=user";

        header("Location: $githubAuthUrl");
        exit;
    }

    public static function logout()
    {
        session_destroy();
        header('Location: /');
        exit;
    }
}