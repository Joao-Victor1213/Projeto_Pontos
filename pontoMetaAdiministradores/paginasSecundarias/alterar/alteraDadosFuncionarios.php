<?php 
     include_once("../../classes/sessao.php");
     verificaSessao("../../login.php"); //Verifica a sessão caso não exista redireciona para a pagina de login
   
     include_once("../../conexao.php");

    $cpf = '';
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        if(isset($_POST['cpfFuncionario'])){
            
            $cpf = $_POST['cpfFuncionario'];

        }
        if($cpf == ''){
            header('location: cpfFuncionario.php?erro=1');
        }else{

            if(existeFuncionario($cpf,$pdo) == 1){
                header('location: cpfFuncionario.php?erro=2');
            }else if(existeFuncionario($cpf,$pdo) == 2){
                header('location: cpfFuncionario.php?erro=3');
            }

        }
    }else{
        header('location: cpfFuncionario.php');
    }

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel = "stylesheet" href = "../bases/base.css">
    <title>Sistema Metamorfose</title>
</head>
<body>

    <?php
        include('../cabecalho/cabecalho.php');
    ?> 

    <center>
        <h1 id="titulo">Atualizar Dados</h1>
    </center>
    <form method = "POST" id = 'formNovoUsuario'action = "../querys.php" enctype = "multipart/form-data">
            <input type = 'password' placeholder = "Senha" class = 'campoDeTexto' name = 'senhaFuncionario'>
            <input type = 'email' placeholder = "Email" class = 'campoDeTexto' name = 'emailFuncionario'>
            <input type = 'hidden' name = 'cpfFuncionario' value = <?= "'".$cpf."'"?>/>
            <input type= 'hidden' name ='tipoRequisicao' value = '2'/>
            <center>
            <input type = "submit" value = "Atualizar" id = 'botaoSubmit'>
            </center>

    </form>
</body>
</html>