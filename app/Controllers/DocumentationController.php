<?php

namespace App\Controllers;

use App\Models\Documentation;
use function Core\view;
use function Core\redirect;

/**
 * Controlador DocumentationController
 * 
 * Gerencia todas as operações relacionadas à documentação de projetos, incluindo:
 * - Listagem de documentos (com filtragem)
 * - Criação de novos documentos
 * - Atualização de documentos existentes
 * - Exclusão de documentos
 */
class DocumentationController {
    /**
     * Exibe a página de documentação com uma lista de documentos
     * 
     * @param array $data Dados da rota, incluindo o projectId
     * @return mixed A visualização da página de documentação ou redirecionamento em caso de erro
     */
    public static function index($data) {
        $projectId = $data['projectId'] ?? null;
        $type = $_GET['type'] ?? null; // Obtém o tipo de filtro da query string
        $page = 'documentation';
        
        // Valida os parâmetros necessários
        if (empty($projectId)) {
            return redirect('/', ['error' => "Project ID is required", 'page' => $page]);
        }

        // Busca documentos do projeto, aplicando filtro de tipo se fornecido
        $docs = Documentation::getAllByProjectId($projectId, $type);

        // Renderiza a view com os documentos e informações de contexto
        return view('documentation', [
            'projectId' => $projectId, 
            'docs' => $docs, 
            'page' => $page,
            'selectedType' => $type // Passa o tipo selecionado para a view
        ]);
    }

    /**
     * Cria um novo documento
     * 
     * @param array $data Dados da rota, incluindo o projectId
     * @return mixed Redirecionamento com mensagem de sucesso ou erro
     */
    public static function store(array $data) {
        $title = $_POST["title"] ?? null;
        $content = $_POST["content"] ?? null;
        $type = $_POST["type"] ?? 'project'; // Tipo padrão é 'project'
        $projectId = $data["projectId"] ?? null;
        $page = 'documentation';

        // Validação de parâmetros
        // Validate all required parameters
        if (empty($projectId)) {
            return redirect('/documentation', ['error' => "Project ID is required", 'page' => $page]);
        }
        
        if (empty($title)) {
            return redirect('/documentation/' . $projectId, ['error' => "Title is required", 'page' => $page]);
        }
        
        if (empty($content)) {
            return redirect('/documentation/' . $projectId, ['error' => "Content is required", 'page' => $page]);
        }

        // Valida o formulário
        $error = self::validateForm($title, $content);
        if ($error) {
            return redirect('/documentation/' . $projectId, ['error' => $error, 'page' => $page]);
        }

        // Obtém o ID do usuário autenticado
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $userId = $_SESSION['user']['id'] ?? null;
        if (!$userId) {
            return redirect('/documentation/' . $projectId, ['error' => "User not authenticated", 'page' => $page]);
        }

        // Cria o documento no banco de dados
        $documentationId = Documentation::create($title, $content, $projectId, $userId, $type);

        // Redireciona com mensagem de sucesso ou erro
        if ($documentationId) {
            return redirect('/documentation/' . $projectId, ['success' => 'Document created successfully.', 'page' => $page]);
        } else {
            return redirect('/documentation/' . $projectId, ['error' => 'Failed to create document.', 'page' => $page]);
        }
    }

    /**
     * Valida os dados do formulário de documentação
     * 
     * @param string $title O título do documento
     * @param string $content O conteúdo do documento
     * @return string|null Uma mensagem de erro ou null se tudo estiver válido
     */
    public static function validateForm($title, $content) {
        $error = [];
        if (empty($title)) {
            $error['title'] = "Title is required";
        }

        if (empty($content)) {
            $error['content'] = "Content is required";
        }

        return !empty($error) ? implode(", ", $error) : null;
    }

    /**
     * Atualiza um documento existente
     * 
     * @param array $data Dados da rota, incluindo projectId e id do documento
     * @return mixed Redirecionamento com mensagem de sucesso ou erro
     */
    public static function update($data) {
        $id = $data['id'] ?? null;
        $projectId = $data['projectId'] ?? null;
        $title = $_POST["title"] ?? null;
        $content = $_POST["content"] ?? null;
        $type = $_POST["type"] ?? 'Projeto';
        $page = 'documentation';

        // Validate all required parameters
        if (empty($id)) {
            return redirect('/documentation/' . $projectId, ['error' => "Document ID is required", 'page' => $page]);
        }
        
        if (empty($projectId)) {
            return redirect('/documentation', ['error' => "Project ID is required", 'page' => $page]);
        }
        
        if (empty($title)) {
            return redirect('/documentation/' . $projectId, ['error' => "Title is required", 'page' => $page]);
        }
        
        if (empty($content)) {
            return redirect('/documentation/' . $projectId, ['error' => "Content is required", 'page' => $page]);
        }

        $error = self::validateForm($title, $content);

        if ($error) {
            return redirect('/documentation/' . $projectId, ['error' => $error, 'page' => $page]);
        }

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $userId = $_SESSION['user']['id'] ?? null;

        if (!$userId) {
            return redirect('/documentation/' . $projectId, ['error' => "User not authenticated", 'page' => $page]);
        }

        $doc = Documentation::getById($id);

        if (empty($doc)) {
            return redirect('/documentation/' . $projectId, ['error' => "Document not found", 'page' => $page]);
        }

        if ($doc['project_id'] != $projectId) {
            return redirect('/documentation/' . $projectId, ['error' => "Document does not belong to the specified project", 'page' => $page]);
        }

        try {
            Documentation::update($id, $title, $content, $type);
            return redirect('/documentation/' . $projectId, ['success' => 'Document updated successfully.', 'page' => $page]);
        } catch (\Exception $e) {
            return redirect('/documentation/' . $projectId, ['error' => "Failed to update document: " . $e->getMessage(), 'page' => $page]);
        }
    }

    /**
     * Exclui um documento
     * 
     * @param array $data Dados da rota, incluindo projectId e id do documento
     * @return mixed Redirecionamento com mensagem de sucesso ou erro
     */
    public static function delete($data) {
        $projectId  = $data['projectId'] ?? null;
        $id = $data['id'] ?? null;
        $page = 'documentation';

        // Validate all required parameters
        if (empty($id)) {
            return redirect('/documentation/' . $projectId, ['error' => "Document ID is required", 'page' => $page]);
        }
        
        if (empty($projectId)) {
            return redirect('/documentation', ['error' => "Project ID is required", 'page' => $page]);
        }

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $userId = $_SESSION['user']['id'] ?? null;

        if (!$userId) {
            return redirect('/documentation/' . $projectId, ['error' => "User not authenticated", 'page' => $page]);
        }

        $doc = Documentation::getById($id);

        if (empty($doc)) {
            return redirect('/documentation/' . $projectId, ['error' => "Document not found", 'page' => $page]);
        }

        if ($doc['project_id'] != $projectId) {
            return redirect('/documentation/' . $projectId, ['error' => "Document does not belong to the specified project", 'page' => $page]);
        }

        try {
            Documentation::delete($id);
            return redirect('/documentation/' . $projectId, ['success' => 'Document deleted successfully.', 'page' => $page]);
        } catch (\Exception $e) {
            return redirect('/documentation/' . $projectId, ['error' => "Failed to delete document: " . $e->getMessage(), 'page' => $page]);
        }
    }

}