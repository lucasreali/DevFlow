<title>Home</title>
<div>
    Home

    <br>
    <a href="/login">Pagina de login</a>
    <br>
    <a href="/register">Página de cadastro</a>
    <br>
    <a href="/dashboard">Dashboard</a>


    <form action="/github" method="post">
        <button type="submit">Login</button>
    </form>
    <form action="/logout" method="post">
        <button type="submit">Logout</button>
    </form>

    <?php if (isset($_SESSION['user'])): ?>
        <p>Olá, <?= $_SESSION['user']['name'] ?></p>
    <?php endif; ?>
</div>
