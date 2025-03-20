<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Página Inicial' ?></title>
</head>
<body>
    <h1>Bem-vindo à Home!</h1>


    <?php if ($_SESSION['user'] ?? false) {        
        echo '<a class="btn btn-primary" href="/auth/logout">Logout</a>';
    } else {
        echo '
        <a href="/auth/login">
            <button class="btn btn-primary">
                <i class="fa-brands fa-github"></i>
            </button>
        </a>';
    }
    ?>
</body>
</html>
