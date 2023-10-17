<?php
require_once 'Pessoa.php';
$p = new Pessoa("crudpdo", "localhost", "root", "");
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-4">
                <div class="rounded p-4 bg-light">
                    <h1 class="mb-4">Cadastro</h1>
                    <form method="post">
                        <?php
                        if (isset($_POST['nome'])) {
                            $nome = htmlspecialchars($_POST['nome']);
                            $telefone = filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_NUMBER_INT);
                            $email = htmlspecialchars($_POST['email']);

                            if (!empty($nome) && !empty($telefone) && !empty($email)) {
                                if (!$p->register($nome, $telefone, $email)) {
                                    echo '<div class="alert alert-secondary" role="alert">E-mail já cadastrado.</div>';
                                }
                            } else {
                                echo "<div class='alert alert-danger' role='alert'>Preencha todos os campos!</div>";
                            }
                        }
                        ?>
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="nome" name="nome" placeholder="Digite seu nome" required>
                        </div>
                        <div class="mb-3">
                            <label for="telefone" class="form-label">Telefone</label>
                            <input type="tel" class="form-control" id="telefone" name="telefone" size="15" placeholder="Digite seu telefone" required>
                        </div>
                        <div class="mb-4">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="text" class="form-control" id="email" name="email" placeholder="Digite seu e-mail" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100" name="Enviar">Enviar</button>
                    </form>
                </div>
            </div>
            <div class="col-md-8">
                <div class="container">
                    <div class="rounded" style=" max-height: 70vh; overflow-y: auto">
                        <table class="table table-striped table-bordered table-hover">
                            <thead class="table-primary">
                                <tr>
                                    <th>Nome</th>
                                    <th>Telefone</th>
                                    <th>Email</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $dados = $p->searchData();

                                if (count($dados) > 0) {
                                    foreach ($dados as $dado) : ?>
                                        <tr>
                                            <td><?php echo $dado['nome']; ?></td>
                                            <td><?php echo $dado['telefone']; ?></td>
                                            <td><?php echo $dado['email']; ?></td>
                                            <td>
                                                <form method="post">
                                                    <input type="hidden" name="id" value="<?php echo $dado['id']; ?>">
                                                    <button type="submit" class="btn btn-danger" name="Excluir">Excluir</button>
                                                    <input type="hidden" name="id" value="<?php echo $dado['id']; ?>">
                                                    <button type="submit" class="btn btn-warning" name="Editar">Editar</button>
                                                </form>
                                            </td>
                                        </tr>
                                <?php endforeach;
                                } else {
                                    echo '<div class="alert alert-warning" role="alert">Ainda não há pessoas cadastradas!</div>';
                                }
                                ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>