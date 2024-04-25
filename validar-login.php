<?php

// criar sessão para variavel glonal
session_start();

//VERIFICA SE ESTA VINDO INFORMAÇÕES PARA VALIDAÇÃO DE E-MAIL E SENHA
if ($_POST) {
    //VERIFICAR SE FOI ENVIADO OS CAMPOS OBRIGATORIOS
    if (empty($_POST["email"]) || empty($_POST["senha"])) {
        $_SESSION["msg"] = "Por favor, preencha os campos obrigatórios!";
        $_SESSION["tipo"] = "warning";
        $_SESSION["title"] = "ops!";

        // var_dump($_SESSION);exit;

        header("location: login.php");
        exit;
    } else {
        //recuperar informações do formulário login 
        $email = trim($_POST['email']);
        $senha = trim($_POST['senha']);
        $remember = $_POST['remember'] ?? "off";


        include('conexao_pdo.php');

        //montar sintaxe sql para consultar no banco de dados 
        $stmt = $conn->prepare("    
        SELECT pk_usuario,nome
        FROM usuarios
        WHERE email LIKE :email
        AND senha LIKE :senha
        ");

        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha);

        $stmt->execute();
        //VERIFICA SE ENCONTROU ALGUM REGISTRO NA TABELA
        if ($stmt->rowCount() > 0) {
            //verifica se o botaão lembrar de mim foi ativado
            if ($remember == "on") {
                setcookie("email",$email);
                setcookie("senha",$senha);
            }else{
                setcookie("email");
                setcookie("senha");
            }

            //ORGANIZA OS DADOS DO BANCO COMO OBJETOS NA VARIAVEL $ROW
            $row = $stmt->fetch(PDO::FETCH_OBJ);

            //DECLARO VARIAVEL GLOBAL INFORMANDO QUE USUARIOE ESTA AUTENTICADO
            $_SESSION["autenticado"] = true;
            $_SESSION["pk_usuario"] = $row->pk_usuario;
             
            //transforma string em array, aonde tiver espaco ""
            $nome_usuario =  explode(" ",$row->nome);
            
            //concatena o primeiro nome com o sobrenome do usuario
            $_SESSION["nome_usuario"] = $nome_usuario[0] ." ". end($nome_usuario);
            $_SESSION["tempo_login"] = time();

            header('Location: ./');
            exit;
        } else {
            $_SESSION["msg"] = 'E-mail e/ou senha invalidos!';
            $_SESSION["tipo"] = 'error';
            $_SESSION["title"] = 'ops!';

            header('Location: login.php');
            exit;
        }
    }
} else {
    header('Location: ./login.php');
    exit;
}
