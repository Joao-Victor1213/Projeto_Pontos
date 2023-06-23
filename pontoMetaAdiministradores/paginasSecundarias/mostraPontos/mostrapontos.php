<?php 
  include_once("../../classes/sessao.php");
  verificaSessao("../../login.php"); //Verifica a sessão caso não exista redireciona para a pagina de login

  include_once("../../conexao.php");

  $erro = '';
  $sucesso = '';

  if($_SERVER['REQUEST_METHOD'] == 'POST'){ //Se o metodo de requisição foi do tipo post

    $cpf = $_POST['cpf'];
    $nome = $_POST['nome'];


  }else if(isset($_GET['cpf']) && isset($_GET['nome'])){

    $cpf = $_GET['cpf'];
    $nome = $_GET['nome'];

  }else{
    header('location: ../../menuPage.php'); 
  }

  if(isset($_GET['erro'])){
    $erro = $_GET['erro'];
    $erro = intval($_GET['erro']);

    switch ($erro) {
        case 0:
            $sucesso = 'FEITO COM SUCESSO';
            break;
        case 1:
          $erro = 'NÃO FOI POSSIVEL DELETAR OS PONTOS';
            break;
        case 3:
            $erro = 'ERRO NA COMUNICAÇÃO COM O BANCO';
            break;
        default:
            break;
  }
  
  }

  try {
    $result = encontraPontos($cpf,$pdo);
  } catch (Exception $e) {
    header('location: ../menuPage.php?erro=2'); //Erro de conexão
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
        <h1 id="titulo">Pontos do Funcionario</h1>

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


<center>
  <table border = "1px">
      
    <tr>
        <td colspan="7">
        <center>
          <?="Pontos do Empregado $nome"?>
        </center>
        </td>
    </tr>
    <tr>

      <th>Dia</th>
      <th>Mês</th>
      <th>Data</th>
      <th>Horario de Entrada</th>
      <th>Horario de Inicio do Intervalo</th>
      <th>Horario de Fim do Intervalo</th>
      <th>Horario de Saída </th>

    </tr>

    <?php 
      $dados = $result->fetchall(PDO::FETCH_ASSOC);

      foreach ($dados as $key => $linha) {
          echo "
          <tr>
          <td>".$linha['dia']."</td>
          <td>".$linha['mes']."</td>
          <td>".date('d/m/Y',strtotime($linha['dataPonto']))."</td>
          <td>".$linha['horaEntrada']."</td>
          <td>".$linha['horaEntradaAlmoco']."</td>
          <td>".$linha['horaSaidaAlmoco']."</td>
          <td>".$linha['horaSaida']."</td>

          </tr>

          ";
      }
    
    ?>


  </table>
</center>

<form method = "POST" action = "geraPlanilha.php">
  <center>
    <input type = "hidden" name = "nome" value = <?= $nome?>>
    <input type = "hidden" name = "cpf" value = <?= $cpf?>>
    <input type = "submit" name = "Button" id = "botao" value = "Gerar Excel">
  </center>
</form>

  <form method = "POST" action = "deletaPontos.php">
  <center>
    <input type = "hidden" name = "nome" value = <?= $nome?>>
    <input type = "hidden" name = "cpf" value = <?= $cpf?>>
    <input type = "submit" name = "Button" id = "botao" value = "Limpar Pontos do Funcionario">
  </center>
</form>

<form method = "POST" action = "../pontoManual/formPonto.php">
  <center>
    <input type = "hidden" name = "cpf" value = <?= $cpf?>>
    <input type = "hidden" name = "nome" value = <?= $nome?>>

    <input type = "submit" name = "Button" id = "botao" value = "Adicionar Ponto Manualmente">
  </center>
</form>

</body>
</html>