<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= INCLUDE_PATH_STATIC ?>css/style.css">
    <title>Cadastro de Usuário</title>
</head>
<body>
    <?php

    if (isset($_GET['delete'])) {
        $del = \Anexus\MySql::connect()->exec("DELETE FROM users WHERE id = $_GET[delete]");
        \Anexus\Utilities::alert('Usuário foi deletado com sucesso!');
        \Anexus\Utilities::redirect(INCLUDE_PATH);
    }
    ?>

    <div class="container">
        <h1>Tabela de Indicações</h1>
        <a href="<?= INCLUDE_PATH ?>cadastrar" type="button" class="btn btn-sm mb-3">+ Adicionar Usuário</a>
        <div class="table">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Indicado Esquerdo</th>
                        <th>Usuário</th>
                        <th>Pontos</th>
                        <th>Indicado Direito</th>
                        <th>Deletar</th>
                    </tr>
                </thead>

                <tbody>
                <?php
                $usersList = \Anexus\Models\UsersModel::usersList();
                foreach ($usersList as $user) {
                    $left = \Anexus\MySql::connect()->prepare("SELECT name FROM users WHERE id = ?");
                    $left->execute(array($user['left_indicated_id']));
                    $left = $left->fetch();
                    if (empty($left)) {
                        $leftName = '';
                    } else {
                        $leftName = $left['name'];
                    }

                    $right = \Anexus\MySql::connect()->prepare("SELECT name FROM users WHERE id = ?");
                    $right->execute(array($user['right_indicated_id']));
                    $right = $right->fetch();
                    if (empty($right)) {
                        $rightName = '';
                    } else {
                        $rightName = $right['name'];
                    }
                    ?>
                    <tr>
                        <td><?= $leftName ?></td>
                        <td><?= $user['name'] ?></td>
                        <td><?= $user['points'] ?></td>
                        <td><?= $rightName ?></td>
                        <td class="btn"><a href="<?= INCLUDE_PATH ?>?delete=<?= $user['id'] ?>">X</a></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
        <!-- /.form-login -->
    </div>
    <!-- /.form-container-login -->

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>