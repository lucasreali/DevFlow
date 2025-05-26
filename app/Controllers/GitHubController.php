<?php

namespace App\Controllers;

use App\Models\Project;
use App\Services\GitHubService;

class GitHubController
{
    public static function getRepositoryData($projectId)
    {
        if (!$projectId) {
            return [
                'commits' => [],
                'contributors' => [],
                'branches' => [],
                'pulls' => []
            ];
        }
        
        $project = Project::getById($projectId);
        if (!$project || empty($project['github_project'])) {
            return [
                'commits' => [],
                'contributors' => [],
                'branches' => [],
                'pulls' => []
            ];
        }
        
        $repo = $project['github_project'];
        $owner = $project['github_project_owner'] ?? null;
        
        return [
            'commits' => GitHubService::getCommits($repo, $owner),
            'contributors' => GitHubService::getContributors($repo, $owner),
            'branches' => GitHubService::getBranches($repo, $owner),
            'pulls' => GitHubService::getPullRequests($repo, $owner)
        ];
    }
}