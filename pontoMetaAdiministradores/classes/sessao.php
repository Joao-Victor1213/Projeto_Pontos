<?php
    session_start();

    function verificaSessao($caminho){
        if(!isset($_SESSION['nome']) && !isset($_SESSION['nivel'])){
            header("location: ".$caminho);
            exit;
        }
    }

?>