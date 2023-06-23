<?php 
  include_once("../../classes/sessao.php");
  verificaSessao("../../login.php"); //Verifica a sessão caso não exista redireciona para a pagina de login

  include_once("../../conexao.php");
  if($_SERVER['REQUEST_METHOD'] == 'POST'){ //Se o metodo de requisição foi do tipo post

    $cpf = $_POST['cpf'];
    $nome = $_POST['nome'];
    try {
        $result = encontraPontos($cpf,$pdo);
    } catch (Exception $e) {
      header('location: ../menuPage.php'); 
    }

  }else{
        header('location: ../menuPage.php');    
  }



  $dados = $result->fetchall(PDO::FETCH_ASSOC);

  $arquivo = "Pontos do ".$nome.".xls";
  $html ='';
  $html .= "
  <tr>
          <td colspan='7'>
                  <center>
                          Pontos do Empregado $nome
                  </center>
          </td>
  </tr>
  ";
  $html .= "
  <center>
  <table border = '1px'>
      
    <tr>
        <td colspan='7'>
        <center>
          <?='Pontos do Empregado $nome'?>
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
    ";

    foreach ($dados as $key => $linha) {
          $html .="
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
    $html .= "
    </table>
    </center>
    ";
  // Configurações header para forçar o download
  header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
  header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
  header ("Cache-Control: no-cache, must-revalidate");
  header ("Pragma: no-cache");
  header ("Content-type: application/x-msexcel");
  header ("Content-Disposition: attachment; filename=\"{$arquivo}\"" );
  header ("Content-Description: PHP Generated Data" );
  
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Metamorfose</title>
</head>
<body>
        <?php 
        // Envia o conteúdo do arquivo
        echo $html;
        exit;

        ?>
</body>
</html>