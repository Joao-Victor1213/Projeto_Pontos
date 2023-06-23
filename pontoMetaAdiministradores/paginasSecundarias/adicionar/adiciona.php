<?php 
include_once("../../classes/sessao.php");
verificaSessao("../../login.php"); //Verifica a sessão caso não exista redireciona para a pagina de login

include_once("../../conexao.php");


        $cpf = '';
        $email= '';
        $nome= '';
        $senha = '';
    

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        if(isset($_POST['cpfFuncionario'])){
            
            $cpf = $_POST['cpfFuncionario'];
            $email = $_POST['emailFuncionario'];
            $nome = $_POST['nomeFuncionario'];
            $senha = $_POST['senhaFuncionario'];
        }
        if($cpf == '' || $senha == '' || $nome == '' || $email == ''){
            header('location: adicionarFuncionario.php?erro=1');
        }else{
            try {
                    $resultQuery = $pdo->query("
        
                    INSERT INTO funcionarios(cpf, email, nome,senha) VALUES(
                        '".$cpf."',
                        '".$email."',
                        '".$nome."',
                        md5('".$senha."')
                    );        
                    ");
                    header('location: adicionarFuncionario.php?erro=0');
                } catch (\Throwable $th) {
                    header('location: adicionarFuncionario.php?erro=2');
                }
 
        }
    }else{
        header('location: adicionarFuncionarios.php');
    }

?>