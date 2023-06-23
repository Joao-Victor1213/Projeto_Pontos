<?php
  include_once("../../classes/sessao.php");
  verificaSessao("../../login.php"); //Verifica a sessão caso não exista redireciona para a pagina de login

  include_once("../../conexao.php");

  if($_SERVER['REQUEST_METHOD'] == 'POST'){ //Se o metodo de requisição foi do tipo post

    if(isset($_POST['cpf']) && isset($_POST['nome'])){
        $cpf = $_POST['cpf'];
        $nome = $_POST['nome'];
    }

    try {
        $result = encontraPontos($cpf,$pdo);
    } catch (Exception $e) {
      header('location: ../../menuPage.php?erro=2'); 
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

    <?php
        include('../cabecalho/cabecalho.php');
    ?> 
    <center>
        <h1 id="titulo">Ponto Manual</h1>
        <h2 id="titulo"><?= $nome?></h2>
    </center>
    <form method = "POST" action = "adicionaPonto.php">
    <select name="coluna" class = "campoDeTexto">
        <option value="horaEntrada">Entrada</option>
        <option value="horaEntradaAlmoco">Entrada do Almoço</option>
        <option value="horaSaidaAlmoco">Saída do Almoço</option>
        <option value="horaSaida">Saída</option>
    </select>
    <input type = 'hidden' name = 'cpf' value = <?="'".$cpf."'";?>/>
    <input type = 'hidden' name = 'nome' value = <?= "'".$nome."'" ?>/>
    <center>
            <input type = "submit" value = "Adicionar Ponto" id = "botaoSubmit">
    </center>
    </form>
</head>
<body>
    
</body>
</html>