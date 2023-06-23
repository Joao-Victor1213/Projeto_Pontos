<?php 
     include_once("../../classes/sessao.php");
     verificaSessao("../../login.php"); //Verifica a sessão caso não exista redireciona para a pagina de login
   
     include_once("../../conexao.php");

    $sucesso = '';
    $erro = '';
    if(isset($_GET['erro'])){
        $erro = intval($_GET['erro']);

        switch ($erro) {
            case 0:
                $sucesso = 'REMOVIDO COM SUCESSO';
                break;
            case 1:
                $erro = 'CAMPO ESTAVA VAZIO';
                break;
            case 2:
                $erro = 'NÃO FOI POSSIVEL DELETAR, TALVEZ ESTE CPF NÃO EXISTA NO BANCO';
                break;
            case 3:
                $erro = 'ERRO NA COMUNICAÇÃO COM O BANCO';
                break;
            default:
                break;
    }
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
        <h1 id="titulo">Deletar Funcionario</h1>

        <?php 
            if ($sucesso != ''){
                echo "<p class = 'textoSucesso'> $sucesso </p>";
            }else if($erro != ''){
                echo "<p class = 'textoErro'> $erro </p>";
            }else{
                echo "<p></p>";
            }
        ?>

    </center>

    <form method = "POST" id = 'formNovoUsuario'action = "deletarFuncionario.php" enctype = "multipart/form-data">
            <input type = 'text' placeholder = "CPF do funcionario" class = 'campoDeTexto' name = 'cpfFuncionario'>
            
            <center>
            <input type = "submit" value = "Procurar" id = "botaoSubmit">
            </center>

        </form>
</body>
</html>