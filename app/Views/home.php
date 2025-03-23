<?php

use App\Services\GitHubService;


?><title>Home</title>
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
        <?php foreach ($_SESSION['user'] as $key => $value): ?>
            <p><strong><?= ucfirst($key) ?>:</strong> <?= htmlspecialchars($value, ENT_QUOTES, 'UTF-8') ?></p>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['user'])): ?>
        <ul>
            <?php foreach (GitHubService::getRepositories() as $repository): ?>
                <li>
                    <p><?= $repository['name'] ?></p>
                </l>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <?php if (isset($_SESSION['user'])): ?>
        <ul>
    <?php 
        $commits = GitHubService::getCommits('DevFlow');
        
        foreach ($commits as $commit): 
        ?>
            <ul>
    <?php 
    $commits = GitHubService::getCommits('DevFlow');
    
    foreach ($commits as $commit): 
        $isMerge = count($commit['parents']) > 1;
    ?>
        <li>
            <p><strong>Mensagem:</strong> <?= htmlspecialchars($commit['commit']['message'], ENT_QUOTES, 'UTF-8') ?></p>
            <p><strong>Autor:</strong> <?= htmlspecialchars($commit['commit']['author']['name'], ENT_QUOTES, 'UTF-8') ?></p>
            <p><strong>Data:</strong> <?= htmlspecialchars($commit['commit']['author']['date'], ENT_QUOTES, 'UTF-8') ?></p>
            <?php if ($isMerge): ?>
                <p><strong>Tipo:</strong> Merge Commit</p>
            <?php else: ?>
                <p><strong>Tipo:</strong> Regular Commit</p>
            <?php endif; ?>
        </li>
    <?php endforeach; ?>
</ul>

    <?php endforeach; ?>
</ul>

    <?php endif; ?>
</div>
