<?php
session_start();

define("caminhoURL","http://localhost/dashboard/");



if ($_SESSION["autenticado"] != true) {
   //destruir qualquer sessão existente
   session_destroy();

   header("location: ./login.php");
   exit;
} else {
   $tempo_limite = 600; //segundos
   $tempo_atual = time();

   //verificar tempo inativo do usuario
   if ($tempo_atual - $_SESSION["tempo_login"] > $tempo_limite) {
      //destruir qualquer sessão existente

      $_SESSION["tipo"] = "warning";
      $_SESSION["title"] = "Ops!";
      $_SESSION["msg"] = "Tempo de sessão esgotado!";

      header("location: ./login.php");
      exit;
   } else {
      $_SESSION["tempo_login"] = time();
   }
}

