<?php 
  include_once("../../classes/sessao.php");
  verificaSessao("../../login.php"); //Verifica a sessão caso não exista redireciona para a pagina de login

  include_once("../../conexao.php");

  include_once("../../classes/operacoes.php");

  if($_SERVER['REQUEST_METHOD'] == 'POST'){ //Se o metodo de requisição foi do tipo post

    $cpf = $_POST['cpf'];
    $nome = $_POST['nome'];
    $tamanhoTabela = 9;

    try {
        $result = encontraPontos($cpf,$pdo);
        $dados = dadosFuncionario($cpf,$pdo);
        $cargaHoraria = $dados['cargaHoraria'].":00:00";

    } catch (Exception $e) {
      header('location: ../menuPage.php'); 
    }

  }else{
        header('location: ../menuPage.php');    
  }


  $arquivo = "Pontos do ".$nome.".xls";
  $html ='';

  $html .= "
  <center>
  <table border = '1px' align='center'>
      <tr>
        <th bgcolor = 'Red' colspan= '$tamanhoTabela'>
          Pontos do Empregado $nome
      </th>
    </tr>
    <tr>
    
      <th bgcolor = 'Gainsboro' colspan='2'>Horario de Entrada</th>
      <th bgcolor = 'Gainsboro' colspan='2'>Horario de Entrada e Saida do Almoco</th>
      <th bgcolor = 'Gainsboro' colspan='2'>Horario de Saida</th>
      <th bgcolor = 'Gainsboro' colspan='2'>Horario de Trabalho</th>
      <th bgcolor = 'Gainsboro' colspan='1'>Carga Horaria Mensal</th>

    </tr>

    <tr>
    <td colspan='2' align = 'center'>".$dados['horarioEntrada']."</td>
    <td align = 'center'>".$dados['horarioEntradaAlmoco']."</td>
    <td align = 'center'>".$dados['horarioSaidaAlmoco']."</td>
    <td colspan='2' align = 'center'>".$dados['horarioSaida']."</td>
    <td colspan='2' align = 'center'>".$dados['horarioDeTrabalho']."</td>
    <td rowspan = '1' align = 'center'>".$cargaHoraria."</td>

    </tr>
    ";
    
    $html .="
  <tr>
    <th bgcolor = 'Gainsboro'>Dia</th>
    <th bgcolor = 'Gainsboro'>Mês</th>
    <th bgcolor = 'Gainsboro'>Data</th>
    <th bgcolor = 'Gainsboro'>Dia da Semana</th>
    <th bgcolor = 'Gainsboro'>Horario de Entrada</th>
    <th bgcolor = 'Gainsboro'>Horario de Inicio do Intervalo</th>
    <th bgcolor = 'Gainsboro'>Horario de Fim do Intervalo</th>
    <th bgcolor = 'Gainsboro'>Horario de Saída </th>
    <th bgcolor = 'Gainsboro'>Horas Trabalhadas </th>  
  </tr>
    ";
    $linhaPlanilha = 5;

    $horasTrabalhadasMês = '00:00:00';
    $ultimoMes = 0;
    $primeiraLinha = true;

    $dadosPontos = $result->fetchall(PDO::FETCH_ASSOC);

    foreach ($dadosPontos as $key => $linha) {

        if($primeiraLinha){ //Mudado
          $ultimoMes = $linha['mes'];
          $primeiraLinha = false;
        }
        if($ultimoMes != $linha['mes']){ //SE mudou de mes printa um novo cabeçalho
          $html .= "
              <tr>
                <th bgcolor = 'Gray' colspan='$tamanhoTabela' align = 'center'> =CONCAT(".'"Mês de "'.";PROPER(TEXT(C".($linhaPlanilha-1).";".'"mmmm"'."))) </td>
              </tr> 

              <tr>
                <th bgcolor = 'Gainsboro' colspan='".intdiv($tamanhoTabela,2)."' align = 'center'>Horas Trabalhadas</td>
                <th bgcolor = 'Gainsboro' colspan='".($tamanhoTabela - intdiv($tamanhoTabela,2))."' align = 'center'>Saldo de Horas</td>
              </tr>
              <tr>
                <td colspan='".intdiv($tamanhoTabela,2)."' align = 'center'>".$horasTrabalhadasMês."</td>
                <td colspan='".($tamanhoTabela - intdiv($tamanhoTabela,2))."' align = 'center'>".subtraiTempo($horasTrabalhadasMês,$cargaHoraria)."</td>
              </tr>

              <tr><td colspan = '$tamanhoTabela' rowspan = '1'></td></tr>

              <tr>
                <th bgcolor = 'Red' colspan= '$tamanhoTabela'>
                  Pontos do Empregado $nome
                </th>
              </tr>

              <tr>
              
                <th bgcolor = 'Gainsboro' colspan='2'>Horario de Entrada</th>
                <th bgcolor = 'Gainsboro' colspan='2'>Horario de Entrada e Saida do Almoco</th>
                <th bgcolor = 'Gainsboro' colspan='2'>Horario de Saida</th>
                <th bgcolor = 'Gainsboro' colspan='2'>Horario de Trabalho</th>
                <th bgcolor = 'Gainsboro' colspan='1'>Carga Horaria Mensal</th>

              </tr>

              <tr>
              <td colspan='2' align = 'center'>".$dados['horarioEntrada']."</td>
              <td align = 'center'>".$dados['horarioEntradaAlmoco']."</td>
              <td align = 'center'>".$dados['horarioSaidaAlmoco']."</td>
              <td colspan='2' align = 'center'>".$dados['horarioSaida']."</td>
              <td colspan='2' align = 'center'>".$dados['horarioDeTrabalho']."</td>
              <td rowspan = '1' align = 'center'>".$cargaHoraria."</td>

              </tr>

              <tr>
                <th bgcolor = 'Gainsboro'>Dia</th>
                <th bgcolor = 'Gainsboro'>Mês</th>
                <th bgcolor = 'Gainsboro'>Data</th>
                <th bgcolor = 'Gainsboro'>Dia da Semana</th>
                <th bgcolor = 'Gainsboro'>Horario de Entrada</th>
                <th bgcolor = 'Gainsboro'>Horario de Inicio do Intervalo</th>
                <th bgcolor = 'Gainsboro'>Horario de Fim do Intervalo</th>
                <th bgcolor = 'Gainsboro'>Horario de Saída </th>
                <th bgcolor = 'Gainsboro'>Horas Trabalhadas </th>  
              </tr>
          ";
          $ultimoMes = $linha['mes'];
          $horasTrabalhadasMês = '00:00:00';
          $linhaPlanilha = $linhaPlanilha+8;  
        }
      
        if(isset($dadosPontos[$key - 1])){ //Se existe uma linha anterior

            $linhaAnt = $dadosPontos[$key - 1]; //Recebe Linha anterior

            if($linhaAnt['mes'] == $linha['mes'] && $linha['dia'] - $linhaAnt['dia'] > 1){ //Se passou mais de 1 dia sem ponto

              $diasPassadosSemPonto = $linha['dia'] - $dadosPontos[$key - 1]['dia'] -1; //Calcula Quantos dias passarão sem ponto

              //Para cada linha dia sem ponto printa uma linha vazia
              for($i = 1; $i <= $diasPassadosSemPonto;$i++){ 
                  $html .= "
                  <tr>
                    <td>".strval(intval($linhaAnt['dia'])+$i)."</td>
                    <td>=PROPER(TEXT(C$linhaPlanilha; ".'"mmmm"'."))</td>
                    <td>".strval(intval($linhaAnt['dia'])+$i)."/".date('m/Y',strtotime($linha['dataPonto']))."</td>
                    <td>=PROPER(TEXT(C$linhaPlanilha; ".'"dddd"'."))</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td align = 'center' >00:00:00</td> 
                  </tr>
                  ";   
                  $linhaPlanilha = $linhaPlanilha+1;  
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

          if($horasTrabalhadas[0] == '-'){ // Se por algum motivo horas trabalhadas vier negativa torna positiva
               $horasTrabalhadas =  substr($horasTrabalhadas,1,strlen($horasTrabalhadas)); //Retira o - do inicio
          }

          $horasTrabalhadasMês = somaTempo($horasTrabalhadasMês, $horasTrabalhadas); 
            $html .= "
              <tr>
                <td>".$linha['dia']."</td>
                <td>=PROPER(TEXT(C$linhaPlanilha; ".'"mmmm"'."))</td>
                <td>".date('d/m/Y',strtotime($linha['dataPonto']))."</td>
                <td>=PROPER(TEXT(C$linhaPlanilha; ".'"dddd"'."))</td>
                <td>".$linha['horaEntrada']."</td>
                <td>".$linha['horaEntradaAlmoco']."</td>
                <td>".$linha['horaSaidaAlmoco']."</td>
                <td>".$linha['horaSaida']."</td>
                <td align = 'center'>".$horasTrabalhadas."</td>
              </tr>
            ";

        $linhaPlanilha = $linhaPlanilha+1;
      }

      $html .= "
          <tr>
            <th bgcolor = 'Gray' colspan='$tamanhoTabela' align = 'center'> =CONCAT(".'"Mês de "'.";PROPER(TEXT(C".($linhaPlanilha-1).";".'"mmmm"'."))) </td>
          </tr> 
          <tr>
            <th bgcolor = 'Gainsboro' colspan='".intdiv($tamanhoTabela,2)."' align = 'center'>Horas Trabalhadas</td>
            <th bgcolor = 'Gainsboro' colspan='".($tamanhoTabela - intdiv($tamanhoTabela,2))."' align = 'center'>Saldo de Horas</td>
            </tr>
          <tr>
            <td colspan='".intdiv($tamanhoTabela,2)."' align = 'center'>".$horasTrabalhadasMês."</td>
            <td colspan='".($tamanhoTabela - intdiv($tamanhoTabela,2))."' align = 'center'>".subtraiTempo($horasTrabalhadasMês,$cargaHoraria)."</td>
          </tr>
      ";

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