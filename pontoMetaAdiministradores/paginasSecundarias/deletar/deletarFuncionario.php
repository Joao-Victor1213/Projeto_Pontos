<?php 
     include_once("../../classes/sessao.php");
     verificaSessao("../../login.php"); //Verifica a sessão caso não exista redireciona para a pagina de login
   
     include_once("../../conexao.php");
    

    $cpf = '';
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        if(isset($_POST['cpfFuncionario'])){
            
            $cpf = $_POST['cpfFuncionario'];

        }
        if($cpf == ''){
            header('location: cpfFuncionario.php?erro=1');
        }else{
            if(existeFuncionario($cpf,$pdo) == 0){
                $resultQuery = deletaFuncionario($cpf,$pdo);
                if($resultQuery == 1){
                    header('location: cpfFuncionario.php?erro=2');
                }else{
                    header('location: cpfFuncionario.php?erro=0');
                }
            }else if(existeFuncionario($cpf,$pdo) == 1){
                header('location: cpfFuncionario.php?erro=2');
            }else{
                header('location: cpfFuncionario.php?erro=3');
            }
            

        }
    }else{
        header('location: cpfFuncionario.php');
    }
?>
