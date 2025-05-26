<?php

namespace App\Controllers\Page;

use App\Models\Friendship;
use App\Models\Project;
use App\Services\GitHubService;
use function Core\redirect;
use function Core\view;

class HomeController
{
    public static function index(array $data)
    {
        $user = $_SESSION['user'] ?? null;
        $error = $data['error'] ?? null;
        $success = $data['success'] ?? null;

        if (!$user) {
            return redirect('/login', ['error' => 'User not logged in']);
        }

        // Projetos criados pelo usuário
        $userProjects = Project::getAll($user['id']);
        
        // Inicializar array de projetos final
        $projects = $userProjects;
        
        // Adicionar informação de que é o dono do projeto
        foreach ($projects as &$project) {
            $project['is_owner'] = true;
        }
        
        // Verificar repositórios GitHub em que o usuário participa
        if (isset($user['username']) && !empty($user['access_token'])) {
            try {
                // Buscar repositórios em que o usuário é colaborador (não é o dono)
                $repos = GitHubService::getParticipatingRepositories();
                
                // Filtrar apenas repositórios dos quais o usuário não é dono
                $collabRepos = array_filter($repos, function($repo) use ($user) {
                    return $repo['owner']['login'] !== $user['username'];
                });
                
                // Para cada repositório, verificar se existe um projeto correspondente
                foreach ($collabRepos as $repo) {
                    $repoProjects = Project::findByGitHubProject($repo['name']);
                    
                    foreach ($repoProjects as $repoProject) {
                        // Verificar se já não é um projeto do usuário
                        if ($repoProject['user_id'] != $user['id']) {
                            // Adicionar flag para identificar que é um projeto em que participa
                            $repoProject['is_owner'] = false;
                            $repoProject['is_collaborator'] = true;
                            $repoProject['repo_owner'] = $repo['owner']['login'];
                            
                            // Adicionar à lista de projetos
                            $projects[] = $repoProject;
                        }
                    }
                }
            } catch (\Exception $e) {
                // Se houver algum erro na API do GitHub, apenas logar e continuar
                error_log('Erro ao acessar GitHub API: ' . $e->getMessage());
            }
        }

        $friendsRelenshionship = Friendship::getFriends($user['id']);

        $friends = [];

        foreach ($friendsRelenshionship as &$friend) {
            if ($friend['status'] === "rejected") {
                continue;
            }

            if ($friend['user_id'] == $user['id']) {
                $friends[] = [
                    'id' => $friend['friend_id'],
                    'name' => $friend['friend_name'],
                    'username' => $friend['friend_username'],
                    'avatar_url' => $friend['friend_avatar'],
                    'status' => $friend['status'],
                    'invited' => false
                ];
            } else {
                $friends[] = [
                    'id' => $friend['user_id'],
                    'name' => $friend['user_name'],
                    'username' => $friend['user_username'],
                    'avatar_url' => $user['avatar'],
                    'status' => $friend['status'],
                    'invited' => true
                ];
            }
        }

        return view('home', [
            'user' => $user,
            'projects' => $projects,
            'friends' => $friends,
            'error' => $error,
            'success' => $success,
        ]);
    }
}