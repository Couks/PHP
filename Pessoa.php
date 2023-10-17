<?php
class Pessoa {
    private $pdo;
    public function __construct($dbName, $host, $user, $password) {

        try {
            $this->pdo = new PDO("mysql:dbname=" . $dbName . ";host=" . $host, $user, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new Exception("Erro com o banco de dados: " . $e->getMessage());
        } catch (Exception $e) {
            throw new Exception("Erro genérico: " . $e->getMessage());
        }
    }

    public function searchData() {

        $res = array();
        $searchAll = $this->pdo->query("SELECT * FROM pessoa ORDER BY nome");
        $res = $searchAll->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }

    public function emailExists($email) {
        $query = $this->pdo->prepare("SELECT id FROM pessoa WHERE email = :email");
        $query->bindValue(":email", $email);
        $query->execute();
        return $query->rowCount() > 0;
    }


    public function register($nome, $telefone, $email) {

        if ($this->emailExists($email)) {
            return false; //email existe
        }

        $insert = $this->pdo->prepare("INSERT INTO pessoa (nome, telefone, email) VALUES (:nome, :telefone, :email)");
        $insert->bindValue(':nome', $nome);
        $insert->bindValue(':telefone', $telefone);
        $insert->bindValue(':email', $email);
        $insert->execute();

        return true; //registro realizado
    }

    public function delete($id) {
        $query = $this->pdo->prepare("DELETE FROM pessoa WHERE id = :id");
        $query->bindValue(':id', $id);
        $query->execute();

        return $query->rowCount() > 0; // Retorna true se a exclusão for bem-sucedida
    }
}
