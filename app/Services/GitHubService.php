<?php

namespace App\Services;

class GitHubService
{
    private static function getUserId()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user']['username'])) {
            throw new \Exception("Error: GitHub user not found in session");
        }

        return $_SESSION['user']['username'];
    }

    private static function request($endpoint, $params = [])
    {
        $access_token = $_SESSION['user']['access_token'] ?? null;
        $url = "https://api.github.com/$endpoint";
        
        // Add query parameters if provided
        if (!empty($params)) {
            $url .= '?' . http_build_query($params);
        }

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
        return self::request("users/" . self::getUserId() . "/repos");
    }

    public static function getRepository($repo)
    {
        return self::request("repos/" . self::getUserId() . "/$repo");
    }

    public static function getBranches($repo)
    {
        return self::request("repos/" . self::getUserId() . "/$repo/branches");
    }

    public static function getCommits($repo)
    {
        $allCommits = [];
        $page = 1;
        $perPage = 100; // Maximum allowed by GitHub API
        
        while (true) {
            $commits = self::request(
                "repos/" . self::getUserId() . "/$repo/commits", 
                ['page' => $page, 'per_page' => $perPage]
            );
            
            if (empty($commits) || !is_array($commits)) {
                break;
            }
            
            $allCommits = array_merge($allCommits, $commits);
            
            // If we received fewer commits than requested per page, we've reached the end
            if (count($commits) < $perPage) {
                break;
            }
            
            $page++;
        }
        
        return $allCommits;
    }

    public static function getContributors($repo)
    {
        return self::request("repos/" . self::getUserId() . "/$repo/contributors");
    }

    public static function getPullRequests($repo)
    {
        return self::request("repos/" . self::getUserId() . "/$repo/pulls");
    }
}
