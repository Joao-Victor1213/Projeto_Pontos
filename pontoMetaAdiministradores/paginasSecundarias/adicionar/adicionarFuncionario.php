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
                $sucesso = 'ADICIONADO COM SUCESSO';
                break;
            case 1:
                $erro = 'ALGUM DOS CAMPOS ESTAVA VAZIO';
                break;
            case 2:
                $erro = 'NÃO FOI POSSIVEL ADICIONAR, TALVEZ ESTE CPF OU NOME JÁ ESTEJAM NO BANCO';
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
        <h1 id="titulo">Adicionar Funcionario</h1>

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
    <div>
        <form method = "POST" id = 'formNovoUsuario'action = "adiciona.php" enctype = "multipart/form-data">
            <input type = 'text' placeholder = "Nome do Funcionario" class = 'campoDeTexto' name = 'nomeFuncionario'>
            <input type = 'password' placeholder = "Senha" class = 'campoDeTexto' name = 'senhaFuncionario'>
            <input type = 'email' placeholder = "Email" class = 'campoDeTexto' name = 'emailFuncionario'>
            <input type = 'text' pattern="[0-9]{11}" placeholder = "CPF - Numeros Somente" class = 'campoDeTexto' name = 'cpfFuncionario'>
            <input type= 'hidden' name ='tipoRequisicao' value = '1'/>

            <center>
             <input type = "submit" value = "Adicionar" id = "botaoSubmit">
            </center>
        </form>
    </div>
</body>
</html>