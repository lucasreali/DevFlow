<div>
    <h2>Reuniões cadastradas</h2>
    <?php if (isset($reunioes) && count($reunioes) > 0): ?>
        <?php foreach ($reunioes as $r): ?>
            <p>
                <?= $r['title'] ?> - <?= $r['data_reuniao'] ?> - <?= $r['assunto'] ?>
                <a href="/reuniao/edit?id=<?= $r['id'] ?>">Editar</a>
            </p>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Nenhuma reunião cadastrada ainda.</p>
    <?php endif; ?>

    <hr>

    <h2>Criar nova reunião</h2>
    <form method="POST" action="/reuniao">
        <label for="title">Título:</label>
        <input type="text" name="title">
        <label for="date">Data:</label>
        <input type="date" name="date">
        <label for="assunto">Assunto:</label>
        <input type="text" name="assunto">
        <button type="submit">Enviar</button>
    </form>

    <?php if (isset($reuniao)): ?>
        <hr>
        <h2>Editando reunião</h2>
        <form method="POST" action="/reuniao/update">
            <input type="hidden" name="id" value="<?= $reuniao['id'] ?>">
            <label for="title">Título:</label>
            <input type="text" name="title" value="<?= $reuniao['title'] ?>">
            <label for="date">Data:</label>
            <input type="date" name="date" value="<?= $reuniao['data_reuniao'] ?>">
            <label for="assunto">Assunto:</label>
            <input type="text" name="assunto" value="<?= $reuniao['assunto'] ?>">
            <button type="submit">Atualizar</button>
        </form>
    <?php endif; ?>
</div>
