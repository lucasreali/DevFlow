<title>Home</title>
<div>
    Home

    <br>
    <a class="btn btn-secondary" href="/login">Pagina de login</a>
    <br>
    <a class="btn btn-secondary" href="/register">Página de cadastro</a>
    <br>
    <a class="btn btn-secondary" href="/dashboard">Dashboard</a>


    <form action="/github" method="post">
        <button class="btn btn-primary" type="submit">Login</button>
    </form>
    <form action="/logout" method="post">
        <button class="btn btn-primary" type="submit">Logout</button>
    </form>


    <?php if (isset($_SESSION['user'])) : ?>
        <h1>Olá, <?= $_SESSION['user']['name'] ?></h1>
        <pre>
            <?= var_dump($_SESSION['user']) ?>
        </pre>
    <?php endif; ?>    
</div>
