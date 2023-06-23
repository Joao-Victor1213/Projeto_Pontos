<?php 

    include_once("../conexao.php");
    $cpf = '16027334360';
    
    try {
        $result = $pdo->query("SELECT * FROM pontos WHERE fk_cpf ='".$cpf."'");
    } catch (\Throwable $th) {
        header('location: ../menuPage'); 
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PontoMeta Administrador</title>
</head>
<body>

<table border = "1px">
    
  <tr>
    <td colspan="7">Pontos</td>
  </tr>
  <tr>

    <th>Mês</th>
    <th>Dia</th>
    <th>Horario de Entrada</th>
    <th>Horario de Inicio do Intervalo</th>
    <th>Horario de Fim do Intervalo</th>
    <th>Horario de Saída </th>
    <th>Data</th>

  </tr>

  <?php 
    $dados = $result->fetchall(PDO::FETCH_ASSOC);

    foreach ($dados as $key => $linha) {
        echo "
        <tr>
        <td>".$linha['mes']."</td>
        <td>".$linha['dia']."</td>
        <td>".$linha['horaEntrada']."</td>
        <td>".$linha['horaEntradaAlmoco']."</td>
        <td>".$linha['horaSaidaAlmoco']."</td>
        <td>".$linha['horaSaida']."</td>
        <td>".date('d/m/Y',strtotime($linha['dataPonto']))."</td>

        </tr>

        ";
    }
  
  ?>


</table>


</body>
</html>