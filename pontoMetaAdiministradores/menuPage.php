<?php 
    include_once("classes/sessao.php");
    verificaSessao("login.php"); //Verifica a sessão caso não exista redireciona para a pagina de login

    include_once("conexao.php");
    $cpf = '';
    $erro = '';

    $resultQuery = $pdo->query("
    
    SELECT * FROM funcionarios;

    ");
    if($resultQuery != false){
        $dados =  $resultQuery->fetchall(PDO::FETCH_ASSOC);
    }

?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Inclui Estilos CSS-->
    <link rel = "stylesheet" href = "paginasSecundarias/bases/base.css">
    <link rel = "stylesheet" href = "menu.css">

    <title>Sistema Metamorfose</title>
</head>
<body>

<div name = "rodape" id = "rodape">

        <header class="cabecalho">
            
            <form method = 'POST' action = 'sair.php'>
                <input type = 'submit' value = 'Logout' id="logout"/>
            </form>
        
            <img src = "../Imagens/borboleta-laranja.png" id = "logo">      
               <nav id="navigator">
                    <center>
                        <a  href= "menuPage.php" class="linkNavegador" id = 'inicio'>Início</a>
                        <a  href= "paginasSecundarias/adicionar/adicionarFuncionario.php" class="linkNavegador" id = 'contatos'>Adicionar Funcionario</a>                    
                        <a  href= "paginasSecundarias/alterar/cpfFuncionario.php" class="linkNavegador" id = 'contatos'>Atualizar Dados</a>
                        <a  href= "paginasSecundarias/deletar/cpfFuncionario.php" class="linkNavegador" id = 'contatos'>Deletar Funcionario</a>

                    </center>
                </nav>
        </header>
</div>

<center>
    <h1 id="titulo">Funcionarios</h1>
    <p class = 'textoErro'> <?= $erro?> </p>
</center>

<?php
if(isset($dados)){


    foreach ($dados as $key => $value) {
            echo "

            <div class = 'funcionario'>
            <center>  
                <br><br>
                <p>Nome: ".$value['nome']."</p>
                <p>Cpf: ".$value['cpf']."</p>
                <p>Email: ".$value['email']."</p>

                <form method = 'POST' action = 'paginasSecundarias/mostraPontos/mostrapontos.php'>
                    <input type = 'hidden' name = 'nome' value ='".$value['nome']."'/>
                    <input type = 'hidden' name = 'cpf' value ='".$value['cpf']."'/>
                    <input type = 'submit' value = 'Ver Pontos'/>
                </form>
            </center>
        </div>";
        
    }
}
?>
<input type = 'hidden' name = 'cpf' value =''/>
</body>
</html>