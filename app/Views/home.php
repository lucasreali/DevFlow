<title>Home</title>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f8f9fa;
    }

    .container {
        max-width: 800px;
        margin: 50px auto;
        padding: 20px;
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    h1 {
        text-align: center;
        color: #343a40;
    }

    .btn-group {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-top: 20px;
    }

    .btn {
        display: inline-block;
        padding: 10px 20px;
        text-align: center;
        text-decoration: none;
        border-radius: 5px;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
    }

    .btn-secondary {
        background-color: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
    }

    .btn-primary {
        background-color: #007bff;
        color: white;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .user-info {
        margin-top: 30px;
        padding: 15px;
        background-color: #e9ecef;
        border-radius: 8px;
    }

    .user-info h2 {
        margin-bottom: 10px;
        color: #495057;
    }

    .user-info pre {
        background-color: #f8f9fa;
        padding: 10px;
        border-radius: 4px;
        overflow-x: auto;
    }
</style>

<div class="container">
    <h1><strong>DevFlow</strong></h1>

    <div class="btn-group">
        <a class="btn btn-secondary" href="/login">Página de Login</a>
        <a class="btn btn-secondary" href="/register">Página de Cadastro</a>
        <a class="btn btn-secondary" href="/dashboard">Dashboard</a>
        <a class="btn btn-secondary" href="/documentation">Documentação</a>
    </div>

    <form action="/github" method="post" style="margin-top: 20px;">
        <button class="btn btn-primary" type="submit">Login com GitHub</button>
    </form>
    <form action="/logout" method="post" style="margin-top: 10px;">
        <button class="btn btn-primary" type="submit">Logout</button>
    </form>

    <?php if (isset($_SESSION['user'])) : ?>
        <div class="user-info">
            <h2>Olá, <?= htmlspecialchars($_SESSION['user']['name']) ?></h2>
            <pre>
                <?= var_dump($_SESSION['user']) ?>
            </pre>
        </div>
    <?php endif; ?>
</div>
