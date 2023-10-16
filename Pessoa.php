<?php

$rows = array();

// Conexao com o banco

try {
    $pdo = new PDO('mysql:host=localhost;dbname=crudpdo', 'root');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "SELECT id, nome, telefone, email FROM pessoa";
    $stmt =  $pdo->query($query);
    $rows =  $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<b>Erro com o banco de dados: </b>" . $e->getMessage();
} catch (Exception $e) {
    echo "<b>Erro generico: </b>" . $e->getMessage();
}

// DELETE
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['Excluir'])) {
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        if ($id !== false) {
            $delete = $pdo->prepare("DELETE FROM pessoa WHERE id = :id");
            $delete->bindValue(":id", $id);
            $delete->execute();
            if ($delete) {
                echo 'Usuário deletado com sucesso.';
            } else {
                echo 'Erro ao deletar o usuário.';
            }
        }
    } else {
        // Se o botão "Excluir" não foi clicado, então estamos tratando de um envio de dados do formulário

        $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
        $telefone = filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

        $insert = $pdo->prepare("INSERT INTO pessoa (nome, telefone, email) VALUES (:nome, :telefone, :email)");

        $insert->bindValue(":nome", $nome);
        $insert->bindValue(":telefone", $telefone);
        $insert->bindValue(":email", $email);

        $insert->execute();

        if ($insert) {
            echo 'Dados inseridos com sucesso.';
        } else {
            echo 'Erro ao inserir os dados.';
        }
    }
}

?>