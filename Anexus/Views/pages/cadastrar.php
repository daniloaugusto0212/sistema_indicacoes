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
    <title>Cadastrar Usuário</title>
</head>
<body>
    
    <div class="sidebar">
    
    
    </div>
    <!-- /.sidebar -->
    

    <div class="form-container">

        <div class="form">
            <h3>Cadastro de Usuário!</h3>
            <form method="post">
                <input type="text" name="name" placeholder="Seu nome...">
                <input type="text" name="email" placeholder="Email...">
                <input type="password" name="password" placeholder="Senha...">
                <select name="indicated">
                    <option value="0">Selecione</option>
                    <?php
                    $usersList = \Anexus\Models\UsersModel::usersList();
                    foreach ($usersList as $user) {
                        ?>
                        <option value="<?= $user['id'] ?>"><?= $user['name'] ?></option>
                    <?php }
                    ?>
                </select>
                <input type="submit" name="cadastrar" value="Cadastrar!">
                <a href="<?= INCLUDE_PATH ?>">Home</a>
            </form>
        </div>
        <!-- /.form-login -->
    </div>
    <!-- /.form-container-login -->
</body>
</html>