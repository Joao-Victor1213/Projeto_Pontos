<?php 
include_once("../../classes/sessao.php");
verificaSessao("../../login.php"); //Verifica a sessão caso não exista redireciona para a pagina de login

include_once("../../conexao.php");


        $cpf = '';
        $email= '';
        $nome= '';
        $senha = '';
        $horarioEntradaFuncionario = '';
        $horarioEntradaAlmocoFuncionario = '';
        $horarioSaidaAlmocoFuncionario = '';
        $horarioSaidaFuncionario = '';
        $cargaHorariaFuncionario = 0;
        $horarioDeTrabalho = '';
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        if(isset($_POST['cpfFuncionario'])){
            
            $cpf = $_POST['cpfFuncionario'];
            $email = $_POST['emailFuncionario'];
            $nome = $_POST['nomeFuncionario'];
            $senha = $_POST['senhaFuncionario'];

            $horarioEntradaFuncionario = $_POST['horarioEntradaFuncionario'];
            $horarioEntradaAlmocoFuncionario = $_POST['horarioEntradaAlmocoFuncionario'];
            $horarioSaidaAlmocoFuncionario = $_POST['horarioSaidaAlmocoFuncionario'];
            $horarioSaidaFuncionario = $_POST['horarioSaidaFuncionario'];
            $cargaHorariaFuncionario = $_POST['cargaHorariaFuncionario'];
            $horarioDeTrabalho = $_POST['horarioDeTrabalho'];
            
        }
        if($cpf == '' || $senha == '' || $nome == '' || $email == '' 
        || $horarioEntradaFuncionario == '' || $horarioEntradaAlmocoFuncionario == '' 
        || $horarioSaidaAlmocoFuncionario == '' || $horarioSaidaFuncionario == '' 
        || $cargaHorariaFuncionario == 0 || $horarioDeTrabalho == ''){

            header('location: adicionarFuncionario.php?erro=1');
        
        }else{
            try {
                    $resultQuery = $pdo->query("
        
                    INSERT INTO funcionarios(cpf, email, nome,senha,horarioEntrada,
                    horarioEntradaAlmoco,horarioSaidaAlmoco,horarioSaida,cargaHoraria,horarioDeTrabalho) 
                    VALUES(
                        '".$cpf."',
                        '".$email."',
                        '".$nome."',
                        md5('".$senha."'),
                        '".$horarioEntradaFuncionario.":00',
                        '".$horarioEntradaAlmocoFuncionario.":00',
                        '".$horarioSaidaAlmocoFuncionario.":00',
                        '".$horarioSaidaFuncionario.":00',
                        '".$cargaHorariaFuncionario."',
                        '".$horarioDeTrabalho."'

                    );  

                    ");
                    header('location: adicionarFuncionario.php?erro=0');
                } catch (\Throwable $th) {
                    print_r($th);
                }
 
        }
    }else{
        header('location: adicionarFuncionarios.php');
    }

?>