<?php 
  include_once("../../classes/sessao.php");
  verificaSessao("../../login.php"); //Verifica a sessão caso não exista redireciona para a pagina de login

  include_once("../../conexao.php");
  include_once("../../classes/operacoes.php");

  

  $erro = '';
  $sucesso = '';

  $tamanhoTabela = 8;
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
    $dados = dadosFuncionario($cpf,$pdo);
    $cargaHoraria = $dados['cargaHoraria'].":00:00";

  } catch (Exception $e) {
    header('location: ../menuPage.php?erro=2'); //Erro de conexão
    exit;
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
  <table border = "1px" align = 'center'>
      
    <tr>
        <th align = 'center' bgcolor = 'Red' colspan= <?=$tamanhoTabela+1?>>
          <?="Pontos do Empregado $nome"?>
        </th>
    </tr>

    <tr>

      <th bgcolor = 'Gainsboro' colspan="2">Horario de Entrada</th>
      <th bgcolor = 'Gainsboro' colspan="2">Horario de Entrada e Saida do Almoco</th>
      <th bgcolor = 'Gainsboro' colspan="2">Horario de Saida</th>
      <th bgcolor = 'Gainsboro' colspan="2">Horario de Trabalho</th>
      <th bgcolor = 'Gainsboro' colspan="2">Carga Horaria Mensal</th>

    </tr>
    <tr>
        <td colspan="2" align = 'center'><?=$dados['horarioEntrada'];?></td>
        <td align = 'center'><?=$dados['horarioEntradaAlmoco'];?></td>
        <td align = 'center'><?=$dados['horarioSaidaAlmoco'];?></td>
        <td colspan="2" align = 'center'><?=$dados['horarioSaida'];?></td>
        <td colspan="2" align = 'center'><?=$dados['horarioDeTrabalho'];?></td>
        <td rowspan = '4' align = 'center'><?=$cargaHoraria;?></td>

    </tr>

    <tr>

      <th bgcolor = 'Gainsboro'>Dia</th>
      <th bgcolor = 'Gainsboro'>Mês</th>
      <th bgcolor = 'Gainsboro'>Data</th>
      <th bgcolor = 'Gainsboro'>Horario de Entrada</th>
      <th bgcolor = 'Gainsboro'>Horario de Inicio do Intervalo</th>
      <th bgcolor = 'Gainsboro'>Horario de Fim do Intervalo</th>
      <th bgcolor = 'Gainsboro'>Horario de Saída </th>
      <th bgcolor = 'Gainsboro'>Horas Trabalhadas </th>

    </tr>

    <?php 
      $dadosPontos = $result->fetchall(PDO::FETCH_ASSOC);

      $horasTrabalhadasMês = '00:00:00';
      $ultimoMes = 0;
      $primeiraLinha = true;

      foreach ($dadosPontos as $key => $linha) {

        if($primeiraLinha){
          $ultimoMes = $linha['mes'];
          $primeiraLinha = false;
        }
        if($ultimoMes != $linha['mes']){ // Se mudou de Mês
          echo "
            <tr>
              <th bgcolor = 'Gray' colspan='$tamanhoTabela' align = 'center'> Mês $ultimoMes</td>
            </tr> 
            <tr>
              <th bgcolor = 'Gainsboro' colspan='".intdiv($tamanhoTabela,2)."' align = 'center'>Horas Trabalhadas</td>
              <th bgcolor = 'Gainsboro' colspan='".($tamanhoTabela - intdiv($tamanhoTabela,2))."' align = 'center'>Saldo de Horas</td>
            </tr>
            <tr>
              <td colspan='".intdiv($tamanhoTabela,2)."' align = 'center'>".$horasTrabalhadasMês."</td>
              <td colspan='".intdiv($tamanhoTabela,2)."' align = 'center'>".subtraiTempo($horasTrabalhadasMês,$cargaHoraria)."</td>
            </tr>

            <tr><td colspan = '$tamanhoTabela' rowspan = '1'></td></tr>
            <tr>
            <th bgcolor = 'Gainsboro'>Dia</th>
            <th bgcolor = 'Gainsboro'>Mês</th>
            <th bgcolor = 'Gainsboro'>Data</th>
            <th bgcolor = 'Gainsboro'>Horario de Entrada</th>
            <th bgcolor = 'Gainsboro'>Horario de Inicio do Intervalo</th>
            <th bgcolor = 'Gainsboro'>Horario de Fim do Intervalo</th>
            <th bgcolor = 'Gainsboro'>Horario de Saída </th>
            <th bgcolor = 'Gainsboro'>Horas Trabalhadas </th>  
            </tr>
          ";
          $ultimoMes = $linha['mes'];
          $horasTrabalhadasMês = '00:00:00';
        }

          if(isset($dadosPontos[$key - 1])){
              $linhaAnt = $dadosPontos[$key - 1];
              if($linhaAnt['mes'] == $linha['mes'] && $linha['dia'] - $linhaAnt['dia'] > 1){
                $diasPassadosSemPonto = $linha['dia'] - $dadosPontos[$key - 1]['dia'] -1;
                for($i = 1; $i <= $diasPassadosSemPonto;$i++){
                    echo "

                    <tr>
                      <td>".strval(intval($linhaAnt['dia'])+$i)."</td>
                      <td>".$linha['mes']."</td>
                      <td>".strval(intval($linhaAnt['dia'])+$i)."/".date('m/Y',strtotime($linha['dataPonto']))."</td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td>00:00:00</td>
                    </tr>
                    ";     
                }
              }
          }

          //Pega o valor de horas trabalhadas na linha
          if(
          (($linha['horaSaida'] != NULL 
          || $linha['horaEntradaAlmoco'] != NULL) 
          && $linha['horaEntrada'] != NULL) 
          ){
            if($linha['horaSaida'] == NULL && $linha['horaEntradaAlmoco'] != NULL){
              $horasTrabalhadas = subtraiTempo($linha['horaEntradaAlmoco'],$linha['horaEntrada']);  
            }else{
              $horasTrabalhadas = subtraiTempo(
                subtraiTempo($linha['horaSaida'],$linha['horaEntrada']),
                subtraiTempo($linha['horaSaidaAlmoco'],$linha['horaEntradaAlmoco'])
              );
            }
          }else{ 
            //Se a hora de saida ou a hora de entrada no almoco e a hora de entrada for for vazia não contabiliza horas
            $horasTrabalhadas = '00:00:00';
          }
          ////////////////////////////////////////////

          if($horasTrabalhadas[0] == '-'){
            $horasTrabalhadas =  substr($horasTrabalhadas,1,strlen($horasTrabalhadas)); //Retira o - do inicio
          }

          $horasTrabalhadasMês = somaTempo($horasTrabalhadasMês, $horasTrabalhadas); 
            echo "
            <tr>
            <td>".$linha['dia']."</td>
            <td>".$linha['mes']."</td>
            <td>".date('d/m/Y',strtotime($linha['dataPonto']))."</td>
            <td>".$linha['horaEntrada']."</td>
            <td>".$linha['horaEntradaAlmoco']."</td>
            <td>".$linha['horaSaidaAlmoco']."</td>
            <td>".$linha['horaSaida']."</td>
            <td>".$horasTrabalhadas."</td>
            </tr>
          ";
      }

      echo "
      <tr>
      <th bgcolor = 'Gray' colspan='$tamanhoTabela' align = 'center'> Mês $ultimoMes</td>
    </tr>
    <tr>
      <th bgcolor = 'Gainsboro' colspan='".intdiv($tamanhoTabela,2)."' align = 'center'>Horas Trabalhadas</td>
      <th bgcolor = 'Gainsboro' colspan='".intdiv($tamanhoTabela,2)."' align = 'center'>Saldo de Horas</td>
    </tr>
      <tr>
        <td colspan='".intdiv($tamanhoTabela,2)."' align = 'center'>".$horasTrabalhadasMês."</td>
        <td colspan='".intdiv($tamanhoTabela,2)."' align = 'center'>".subtraiTempo($horasTrabalhadasMês,$cargaHoraria)."</td>
      </tr>";
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