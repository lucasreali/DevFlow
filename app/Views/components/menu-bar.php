<?php
/**
 * Componente da Barra de Menu
 * 
 * Este componente implementa a barra de navegação lateral que está presente em todas as páginas
 * após o login do usuário. Ele fornece acesso às principais funcionalidades do sistema.
 * 
 * Funcionalidades:
 * - Links para as diferentes seções do projeto
 * - Indicador visual da página atual
 * - Alternador de tema claro/escuro
 * - Menu de perfil do usuário
 * 
 * Como adicionar um novo item de menu:
 * 1. Adicione um novo elemento <li> na lista
 * 2. Use a estrutura existente, incluindo classe "menu-nav-item"
 * 3. Compare com $page para destacar o item quando estiver ativo
 * 4. Adicione um ícone representativo
 */
?>
<div class="w-auto vh-100 shadow d-flex flex-column align-items-center px-2 pt-4" style="background-color: var(--light-gray)">
    <div>
        <!-- Logo do DevFlow com suporte a modo escuro -->
        <a href="/">
            <img src="/../images/logo.svg" alt="DevFlow Logo" 
                 class="devflow-logo"
                 data-dark-src="/../images/logo.svg"
                 data-light-src="/../images/logo-light.svg"
                 style="width: 50px; height: 40px;" />
        </a>
        <!-- Lista de itens do menu -->
        <ul class="d-flex flex-column align-items-center gap-4 p-0 mt-5">
            <!-- Item do Dashboard -->
            <li>
                <a href="/dashboard/<?= $projectId ?>" class="btn <?= $page === 'boards' ? 'btn-secondary' : '' ?> menu-nav-item" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Boards">
                    <i class="fa-brands fa-trello invert-in-dark"></i>
                </a>
            </li>
            <!-- Item de Documentação -->
            <li>
                <a href="/documentation/<?= $project["id"]?>" class="btn <?= $page === 'documentation' ? 'btn-secondary' : '' ?> menu-nav-item" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Documentation">
                    <i class="fa-solid fa-book invert-in-dark"></i>
                </a>
            </li>
        </ul>
    </div>

    <!-- Menu dropdown do usuário -->
    <div class="dropdown mt-auto mb-4">
        <?php 
        $user = $_SESSION['user'];
        $attributes = 'data-bs-toggle="dropdown" aria-expanded="false"';
        include __DIR__ . '/user-avatar.php'; 
        ?>
        
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                <i class="fa-solid fa-user me-2"></i>Edit Profile</a>
            </li>
            <li><a class="dropdown-item" href="/settings"><i class="fa-solid fa-gear me-2"></i>Settings</a></li>
            <li><hr class="dropdown-divider"></li>

            <form action="/logout" method="POST">
                <li><button class="dropdown-item" href="/logout"><i class="fa-solid fa-sign-out-alt me-2"></i>Logout</button></li>
            </form>
        </ul>
    </div>
</div>

<!-- Include the profile edit modal component -->
<?php include __DIR__ . '/../components/edit-profile-modal.php'; ?>
