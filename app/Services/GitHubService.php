<?php

namespace App\Services;


class GitHubService
{
    private static function request($endpoint)
    {
        if (!isset($_SESSION['user']['username'])) {
            throw new \Exception("Error: GitHub user not found in session");
        }

        $access_token = $_SESSION['user']['access_token'] ?? null;
        $url = "https://api.github.com/$endpoint";

        $ch = curl_init($url);

        // Opções do cURL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "User-Agent: DevFlow",
            $access_token ? "Authorization: token $access_token" : "" 
        ]);

        $response = curl_exec($ch);
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);

        curl_close($ch);

        if ($error) {
            throw new \Exception("Erro cURL: $error");
        }

        if ($http_status !== 200) {
            throw new \Exception("Erro: Status HTTP $http_status");
        }

        return json_decode($response, true);
    }

    public static function getRepositories()
    {
        $username = $_SESSION['user']['username'];
        return self::request("users/$username/repos");
    }

    public static function getRepository($repo)
    {
        $username = $_SESSION['user']['username'];
        return self::request("repos/$username/$repo");
    }

    public static function getBranches($repo)
    {
        $username = $_SESSION['user']['username'];
        return self::request("repos/$username/$repo/branches");
    }

    public static function getCommits($repo)
    {
        $username = $_SESSION['user']['username'];
        return self::request("repos/$username/$repo/commits");
    }

    public static function getContributors($repo)
    {
        $username = $_SESSION['user']['username'];
        return self::request("repos/$username/$repo/contributors");
    }

    public static function getPullRequests($repo)
    {
        $username = $_SESSION['user']['username'];
        return self::request("repos/$username/$repo/pulls");
    }
}
