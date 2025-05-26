<?php

namespace App\Controllers;

use App\Models\Board;
use function Core\view;
use function Core\redirect;

class BoardController
{
    public function store($data) {
        try {
            $projectId = $data['projectId'] ?? null;
            $title = $data['title'] ?? null;
            $color = $data['color'] ?? null;

            // Validate all required parameters
            $errors = [];
            if (empty($projectId)) {
                return redirect('/', ['error' => 'Project ID cannot be empty']);
            }
            if (empty($title)) {
                return redirect('/dashboard/' . $projectId, ['error' => 'Board title cannot be empty']);
            }
            if (empty($color)) {
                return redirect('/dashboard/' . $projectId, ['error' => 'Board color cannot be empty']);
            }

            $possibleColors = ['red', 'blue', 'green', 'yellow', 'purple', 'orange'];

            if (!in_array($color, $possibleColors)) {
                return redirect('/dashboard/' . $projectId, ['error' => 'Invalid color selected']);
            }

            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            $userId = $_SESSION['user']['id'];

            if ($userId === null) {
                return redirect('/login', ['error' => 'User not logged in']);
            }

            $boards = Board::getAll($projectId);
            $position = count($boards) + 1;
                
            $boardId = Board::create($title,$color, $projectId, $position);

            if ($boardId === false) {
                return redirect('/dashboard/' . $projectId, ['error' => 'Failed to create board']);
            }

            return redirect('/dashboard/' . $projectId, ['success' => 'Board created successfully']);
        } catch (\Exception $e) {
            return redirect('/dashboard/' . ($projectId ?? ''), [
                'error' => 'An error occurred while creating the board: ' . $e->getMessage()
            ]);
        }
    }

    public function show() {
        try {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            $userId = $_SESSION['user']['id'];

            if ($userId === null) {
                return redirect('/login', ['error' => 'User not logged in']);
            }

            $projectId = $_GET['project'] ?? null;
            
            if (empty($projectId)) {
                return redirect('/', ['error' => 'Project ID is required']);
            }

            $boards = Board::getAll($projectId);

            return view('dashboard', ['boards' => $boards]);
        } catch (\Exception $e) {
            return redirect('/', [
                'error' => 'An error occurred while loading boards: ' . $e->getMessage()
            ]);
        }
    }
    
    public function update($data) {
        try {
            $id = $data['id'] ?? null;
            $title = $data['title'] ?? null;
            $color = $data['color'] ?? null;

            if (empty($id) || empty($title) || empty($color)) {
                return redirect('/', ['error' => 'All fields are required']);
            }

            $board = Board::getById($id);
            if (!$board) {
                return redirect('/', ['error' => 'Board not found']);
            }

            Board::update($id, $title, $color);

            // Redireciona de volta para o dashboard do projeto
            $projectId = $board['project_id'];
            return redirect('/dashboard/' . $projectId, ['success' => 'Board updated successfully']);
        } catch (\Exception $e) {
            // If we have the board ID, try to get the project ID for better redirection
            $projectId = null;
            if (!empty($id)) {
                try {
                    $board = Board::getById($id);
                    if ($board) {
                        $projectId = $board['project_id'];
                    }
                } catch (\Exception $innerException) {
                    // Ignore inner exception, we'll redirect to home
                }
            }
            
            $redirectPath = $projectId ? '/dashboard/' . $projectId : '/';
            return redirect($redirectPath, [
                'error' => 'An error occurred while updating the board: ' . $e->getMessage()
            ]);
        }
    }
    
    public function delete($data) {
        try {
            $id = $data['id'] ?? null;
            $projectId = $data['project_id'] ?? null;
            
            if (empty($id)) {
                return redirect('/dashboard/' . $projectId, ['error' => 'Board ID is required']);
            }
            
            if (empty($projectId)) {
                $board = Board::getById($id);
                if ($board) {
                    $projectId = $board['project_id'];
                } else {
                    return redirect('/', ['error' => 'Board not found']);
                }
            }
            
            // Delete the board
            Board::delete($id);
            
            return redirect('/dashboard/' . $projectId, ['success' => 'Board deleted successfully']);
        } catch (\Exception $e) {
            return redirect('/dashboard/' . ($projectId ?? ''), [
                'error' => 'An error occurred while deleting the board: ' . $e->getMessage()
            ]);
        }
    }
}