<?php

@session_start();


// ISSET = VERIFICA SE AS VARIÁVEIS FORAM CRIADAS 
if (isset($_SESSION["tipo"]) && isset($_SESSION["title"]) && isset($_SESSION["msg"])) {
    echo"
    <script>
    $(function(){
       var Toast = Swal.mixin({
            toast: true,
            position:'center',
            showConfirmButtom: false,
            timer: 1000
       });
       Toast.fire({
        icon: '".$_SESSION["tipo"]."',
        title: '".$_SESSION["title"]."',
        text: '".$_SESSION["msg"]."'
       });
    
    
    });
    </script>
    ";

    unset($_SESSION["title"]);
    unset($_SESSION["tipo"]);
    unset($_SESSION["msg"]);

}
?>