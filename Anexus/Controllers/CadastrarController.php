<?php

namespace Anexus\Controllers;

class CadastrarController
{
    public function index()
    {
        if (isset($_POST['cadastrar'])) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $indicated = $_POST['indicated'];

            if (empty($name)) {
                \Anexus\Utilities::alert('O nome não pode ser vazio!');
                \Anexus\Utilities::redirect(INCLUDE_PATH . 'cadastrar');
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                \Anexus\Utilities::alert('E-mail inválido!');
                \Anexus\Utilities::redirect(INCLUDE_PATH . 'cadastrar');
            } elseif (\Anexus\Models\UsersModel::emailExists($email)) {
                \Anexus\Utilities::alert('Já existe esse email cadastrado!');
                \Anexus\Utilities::redirect(INCLUDE_PATH . 'cadastrar');
            } elseif (strlen($password) < 6) {
                \Anexus\Utilities::alert('A senha precisa ter mais de 6 caracteres.');
                \Anexus\Utilities::redirect(INCLUDE_PATH . 'cadastrar');
            } elseif ($indicated == '0') {
                \Anexus\Utilities::alert('Selecione por quem você foi indicado!');
                \Anexus\Utilities::redirect(INCLUDE_PATH . 'cadastrar');
            } else {
                //Cadastrar

                $verify = \Anexus\MySql::connect()->prepare("SELECT * FROM users WHERE id = ?");
                $verify->execute(array($indicated));
                $verify = $verify->fetch();


                if ($verify['right_indicated_id'] > 0) {
                    \Anexus\Utilities::alert('Não há mais indicações para este usuário!');
                    \Anexus\Utilities::redirect(INCLUDE_PATH . 'cadastrar');
                } else {
                    $password = \Anexus\Bcrypt::hash($password);
                    $insert = \Anexus\MySql::connect()->prepare('INSERT INTO users VALUES (null, ?, ?, ?, null, null, null)');
                    $insert->execute(array($name, $email, $password));

                    $lastId = \Anexus\MySql::connect()->lastInsertId();

                    if ($verify['left_indicated_id'] == 0) {
                        $indicatedId = 'left_indicated_id = ?';
                        $addPoint = 200;
                    } else {
                        $indicatedId = 'right_indicated_id = ?';
                        $addPoint = 100;
                        
                    }
                    $points = $verify['points'] + $addPoint;

                    //Procura onde tem o id do usuário que indicou, à direira ou esquerda
                    $selectPoints = \Anexus\MySql::connect()->prepare("SELECT id, points FROM users WHERE left_indicated_id = ? OR  right_indicated_id = ?");
                    $selectPoints->execute(array($indicated, $indicated));
                    $selectPoints = $selectPoints->fetchAll();
                    foreach ($selectPoints as $value) {
                        $id = $value['id'];
                        $pointsAbove = $value['points'] + $addPoint;

                        $updateIndicatorAbove = \Anexus\MySql::connect()->prepare("UPDATE users SET points = ? WHERE id = ?");
                        $updateIndicatorAbove->execute(array($pointsAbove, $id));
                    }

                    $updateIndicator = \Anexus\MySql::connect()->prepare("UPDATE users SET $indicatedId, points = ? WHERE id = ?");
                    $updateIndicator->execute(array($lastId, $points, $indicated));

                    \Anexus\Utilities::alert('Cadastrado com sucesso!');
                    \Anexus\Utilities::redirect(INCLUDE_PATH);
                }
            }
        }
        \Anexus\Views\MainView::render('cadastrar');
    }
}
