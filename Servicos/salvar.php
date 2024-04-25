<?php
include("../verificar_aut.php");
include("../conexao_pdo.php");


if ($_POST) {
    if (empty($_POST["servico"])) {
        $_SESSION["tipo"] = 'warning';
        $_SESSION["title"] = 'OPS!';
        $_SESSION["msg"] = 'Por favor, preencha os campos obrigatórios';

        header("location: ./");
        exit;
    } else {
        $pk_servico = trim($_POST["pk_servico"]);
        $servico = trim($_POST["servico"]);

        try {
            if (empty($pk_servico)) {
                $sql = "
            INSERT INTO servicos(servico) VALUES
            (:servico)
            ";

                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':servico', $servico);
            } else {
                $sql = "
                UPDATE servicos SET 
                servico = :servico
                WHERE pk_servico = :pk_servico
            ";

                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':servico', $servico);
                $stmt->bindParam(':pk_servico', $pk_servico);
            }
            $stmt->execute();

            $_SESSION["tipo"] = 'success';
            $_SESSION["title"] = 'Oba!';
            $_SESSION["msg"] = 'Registro salvo';
            header("location: ./");
            exit;
        } catch (PDOException $ex) {
            $_SESSION["tipo"] = 'error';
            $_SESSION["title"] = 'OPS!';
            $_SESSION["msg"] = $ex;
            header("location: ./");
            exit;
        }
    }
}
