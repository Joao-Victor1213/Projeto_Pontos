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
    <link rel = "stylesheet" href = "adicionarFuncionario.css">

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
            <input value = '@institutometamorfose.org.br' type = 'email' placeholder = "Email" class = 'campoDeTexto' name = 'emailFuncionario'>
            <input type = 'text' pattern="[0-9]{11}" placeholder = "CPF - Numeros Somente" class = 'campoDeTexto' name = 'cpfFuncionario'>
            <input type= 'hidden' name ='tipoRequisicao' value = '1'/>
            
            <h3 class = 'textoEntradaHora'> Horario De Entrada</h3>
            <input value = '08:00' type='time' class = 'campoDeTexto' name = 'horarioEntradaFuncionario'/>
            <h3 class = 'textoEntradaHora'> Horario Da Entrada no Almoco</h3>
            <input value = '12:00'type='time' class = 'campoDeTexto' name = 'horarioEntradaAlmocoFuncionario'/>
            <h3 class = 'textoEntradaHora'> Horario Da Saida no Almoco</h3>
            <input value = '13:00'type='time' class = 'campoDeTexto' name = 'horarioSaidaAlmocoFuncionario'/>
            <h3 class = 'textoEntradaHora'> Horario De Saída</h3>
            <input value = '17:00'type='time' class = 'campoDeTexto' name = 'horarioSaidaFuncionario'/>

            <input type = 'number' placeholder = "Carga Horaria Mensal (H)" class = 'campoDeTexto' name = 'cargaHorariaFuncionario'>
            <select name="horarioDeTrabalho" class = 'campoDeTexto'>
                <option value="Segunda a Sexta">Segunda a Sexta</option>
                <option value="Segunda a Sábado">Segunda a Sábado</option>
                <option value="Finais de Semana">Finais de Semana</option>
                <option value="Todo Dia">Todo Dia</option>
                <option value="Horista">Horista</opition>
            </option>

            </select>
            <center>
             <input type = "submit" value = "Adicionar" id = "botaoSubmit">
            </center>
        </form>
    </div>
</body>
</html>