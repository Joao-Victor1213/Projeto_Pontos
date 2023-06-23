<?php 
    $erro = '';
    if(isset($_GET['erro'])){
        $erro = intval($_GET['erro']);

                
        switch ($erro) {
            case 1:
                $erro = 'USUARIO NÃO ENCONTRADO';
                break;
            case 2:
                $erro = 'ERRO COM A CONEXÃO';
                break;
            case 3:
                $erro = 'OS CAMPOS NÃO PODEM FICAR EM BRANCO';
                break;
            case 4:
                $erro = 'NÃO HÁ NENHUM ADMINISTRADOR NO BANCO DE DADOS';
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
    <link rel = "stylesheet" href = "styleLogin.css">
    <title>Sistema Metamorfose</title>
</head>
<body>
    <div id = "conteudo">
        <div id = "div-logo">
            <center>
            <a href ="https://institutometamorfose.org.br/" >
               <img src = "../Imagens/borboleta-laranja.png" id = "logo">
            </a>
            <p class = 'textoErro'> <?= $erro?> </p>
            </center>
        </div id = "formulario">
            <form method = "POST" action = "verificalogin.php">
                <center>
                    <input type = "text" name = "nomeAdmin" placeholder = "Nome de Administrador" class = "login-input">
                    <input type = "password" name = "senha" placeholder = "Senha" class = "login-input">
                    <input type = "submit" name = "Button" id = "botao" value = "Entrar">
                </center>
            </form>
        </div>
</div>
</body>
</html>