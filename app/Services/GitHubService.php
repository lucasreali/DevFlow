<?php

namespace App\Services;

class GitHubService
{

    public static function getRepositories() {
        if (!isset($_SESSION['user']['username'])) {
            die("Error: User not logged in with github");
        }
    
        $username = $_SESSION['user']['username'];
        $access_token = $_SESSION['user']['access_token'] ?? null;
        $url = "https://api.github.com/users/$username/repos";
    
        $ch = curl_init($url);
    
        // Define as opções do cURL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "User-Agent: DevFlow",
            $access_token ? "Authorization: token $access_token" : "" // Header opcional
        ]);
        
        // Executa a requisição
        $response = curl_exec($ch);
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
        if (curl_errno($ch)) {
            echo "Erro cURL: " . curl_error($ch);
            curl_close($ch);
            return null;
        }
    
        curl_close($ch);
    
        // Verifica o status HTTP
        if ($http_status !== 200) {
            echo "Erro: Status HTTP $http_status";
            return null;
        }
    
        $repositories = json_decode($response, true);
    
        // Retorna a lista de repositórios
        return $repositories;
    }
    

    public static function getRepositoryDetails($repo) {
        $access_token = $_SESSION['user']['access_token'] ?? null;
        $username = $_SESSION['user']['username'];
        $url = "https://api.github.com/repos/$username/$repo";

        $ch = curl_init($url);

        // Define as opções do cURL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "User-Agent: DevFlow",
            $access_token ? "Authorization: token $access_token" : "" // Header opcional
        ]);

        // Executa a requisição
        $response = curl_exec($ch);
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) {
            echo "Erro cURL: " . curl_error($ch);
            curl_close($ch);
            return null;
        }

        curl_close($ch);

        // Verifica o status HTTP
        if ($http_status !== 200) {
            echo "Erro: Status HTTP $http_status";
            return null;
        }

        $repoDetails = json_decode($response, true);

        // Retorna os detalhes do repositório
        return $repoDetails;
    }

    public static function getBranches($repo) {
        $access_token = $_SESSION['user']['access_token'] ?? null;
        $username = $_SESSION['user']['username'];
        $url = "https://api.github.com/repos/$username/$repo/branches";

        $ch = curl_init($url);

        // Define as opções do cURL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "User-Agent: DevFlow",
            $access_token ? "Authorization: token $access_token" : "" // Header opcional
        ]);

        // Executa a requisição
        $response = curl_exec($ch);
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) {
            echo "Erro cURL: " . curl_error($ch);
            curl_close($ch);
            return null;
        }

        curl_close($ch);

        // Verifica o status HTTP
        if ($http_status !== 200) {
            echo "Erro: Status HTTP $http_status";
            return null;
        }

        // Retorna a lista de branches
        return json_decode($response, true);
    }

    public static function getCommits($repo) {
        $access_token = $_SESSION['user']['access_token'] ?? null;
        $username = $_SESSION['user']['username'];
        $url = "https://api.github.com/repos/$username/$repo/commits";

        $ch = curl_init($url);

        // Define as opções do cURL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "User-Agent: DevFlow",
            $access_token ? "Authorization: token $access_token" : "" // Header opcional
        ]);

        // Executa a requisição
        $response = curl_exec($ch);
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) {
            echo "Erro cURL: " . curl_error($ch);
            curl_close($ch);
            return null;
        }

        curl_close($ch);

        // Verifica o status HTTP
        if ($http_status !== 200) {
            echo "Erro: Status HTTP $http_status";
            return null;
        }

        // Retorna a lista de commits
        return json_decode($response, true);
    }
}
