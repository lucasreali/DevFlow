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
            error_log("GitHub API cURL error: $error for URL: $url");
            return [];
        }

        // Handle different status codes appropriately
        if ($http_status >= 200 && $http_status < 300) {
            // Success response
            return json_decode($response, true);
        } else if ($http_status == 404) {
            // Not found - return empty result instead of throwing exception
            error_log("GitHub API 404 Not Found for: $url");
            return [];
        } else if ($http_status == 409) {
            // Conflict - often happens with empty repos or other conflicts
            error_log("GitHub API 409 Conflict for: $url - This might be an empty repository");
            return [];
        } else if ($http_status == 401 || $http_status == 403) {
            // Authentication or permission issue
            error_log("GitHub API Authentication error ($http_status) for: $url");
            return [];
        } else {
            // Log other errors but don't throw exceptions
            error_log("GitHub API error: Status HTTP $http_status for: $url");
            error_log("Response: " . substr($response, 0, 500)); // Log first 500 chars of response
            return [];
        }
    }

    public static function getRepositories()
    {
        return self::request("users/" . self::getUserId() . "/repos");
    }

    public static function getRepository($repo, $owner = null)
    {
        $repoOwner = $owner ?? self::getUserId();
        return self::request("repos/" . $repoOwner . "/$repo");
    }

    public static function getBranches($repo, $owner = null)
    {
        $repoOwner = $owner ?? self::getUserId();
        return self::request("repos/" . $repoOwner . "/$repo/branches");
    }

    public static function getCommits($repo, $owner = null)
    {
        $repoOwner = $owner ?? self::getUserId();
        $allCommits = [];
        $page = 1;
        $perPage = 100; // Maximum allowed by GitHub API
        
        while (true) {
            $commits = self::request(
                "repos/" . $repoOwner . "/$repo/commits", 
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

    public static function getContributors($repo, $owner = null)
    {
        $repoOwner = $owner ?? self::getUserId();
        return self::request("repos/" . $repoOwner . "/$repo/contributors");
    }

    public static function getPullRequests($repo, $owner = null)
    {
        $repoOwner = $owner ?? self::getUserId();
        return self::request("repos/" . $repoOwner . "/$repo/pulls");
    }
    
    public static function getParticipatingRepositories()
    {
        return self::request("user/repos", [
            'affiliation' => 'collaborator,organization_member,owner',
            'sort' => 'updated',
            'direction' => 'desc',
            'per_page' => 100
        ]);
    }

    // Get information about repository ownership
    public static function getRepoOwnerInfo($repoName)
    {
        $repos = self::getParticipatingRepositories();
        foreach ($repos as $repo) {
            if ($repo['name'] === $repoName) {
                return [
                    'owner' => $repo['owner']['login'],
                    'is_owner' => ($repo['owner']['login'] === self::getUserId())
                ];
            }
        }
        return null;
    }
}
