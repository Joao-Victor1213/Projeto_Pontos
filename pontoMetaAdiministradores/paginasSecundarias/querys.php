<?php 
  include_once("../classes/sessao.php");
  verificaSessao("../login.php"); //Verifica a sessão caso não exista redireciona para a pagina de login

  include_once("../conexao.php");

try {

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        if(isset($_POST['tipoRequisicao'])){

         $tipoRequisicao = intval($_POST['tipoRequisicao']); // Se a requisição é 1 adiciona se é dois o codigo de altera

         switch ($tipoRequisicao) {
            case 1:

                if(isset($_POST['nomeFuncionario']) && isset($_POST['emailFuncionario']) 
                && isset($_POST['cpfFuncionario']) && isset($_POST['senhaFuncionario'])){

                    $nome = $_POST['nomeFuncionario'];
                    $email = $_POST['emailFuncionario'];
                    $cpf = $_POST['cpfFuncionario'];
                    $senha = $_POST['senhaFuncionario'];
                    $pdo->query("
            
                    INSERT INTO funcionarios(cpf, email, nome,senha) VALUES(
                        '".$cpf."',
                        '".$email."',
                        '".$nome."',
                        md5('".$senha."')
                    )
                    ");
                    header('location: adicionar/adicionarFuncionario.php');
                }

                    break;
                case 2:

                    if(isset($_POST['emailFuncionario']) && isset($_POST['senhaFuncionario'])){

                        $senha = $_POST['senhaFuncionario'];
                        $email = $_POST['emailFuncionario'];
                        $cpf = $_POST['cpfFuncionario'];

                        $pdo->query("
                            UPDATE
                                funcionarios
                            SET
                                email = '".$email."',
                                senha = md5('".$senha."'),
                                idDispositivo =  NULL,
                                modeloDispositivo = NULL
                            WHERE
                                cpf = '".$cpf."'
                        ");
                        header('location: alterar/cpfFuncionario.php?erro=0');
                    }
    
                    break;
            
                default:
                    break;
         } 
        }
     }

} catch (\Throwable $th) {
    echo 'Erro';        
}




?>