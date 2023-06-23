<?php 
    session_start();
    include_once("conexao.php");
    
    if(isset($_SESSION['nome']) && isset($_SESSION['nivel'])){
        header('location: menuPage.php');
        exit; 
    }


    if($_SERVER['REQUEST_METHOD'] == 'POST'){ //Se o metodo de requisição foi do tipo post

        if(isset($_POST['nomeAdmin']) && isset($_POST['senha'])){
            $nomeAdmin = $_POST['nomeAdmin'];
            $senha = $_POST['senha'];

            if($nomeAdmin == '' || $senha == ''){ //Se estiver vazio
                session_destroy(); 
                header('location: login.php?erro=3'); 
                exit; 

            }else{

                try {
                    $result = $pdo->query("
                        SELECT * FROM administradores WHERE userName = '".$nomeAdmin."' and senha = md5('".$senha."')
                    ");
                    if($result != false){
                        $dados = $result->fetch(PDO::FETCH_ASSOC);
                    }else{
                        header("location: login.php?erro=4"); 
                        exit; 
                    }

                } catch (\Throwable $th) {
                    session_destroy();
                    header("location: login.php?erro=2");
                    exit; 
                }


                if( isset($dados['userName']) && isset($dados['nivel'])){
                    $_SESSION["nome"] = $dados['userName'];
                    $_SESSION["nivel"] = intval($dados['nivel']);
                    header('location: menuPage.php'); 
                    exit;
                }else{
                    session_destroy();
                    header('location: login.php?erro=1'); 
                }
            }
        }
    }else{
        header('location: login.php'); 
    }
?>