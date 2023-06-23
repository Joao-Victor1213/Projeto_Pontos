<?php 
    include_once("classes/sessao.php");
    verificaSessao("../login.php"); //Verifica a sessão caso não exista redireciona para a pagina de login
  
 class dadosAdmin
 {
    $userName = '';
    $nivel = 0;
 }
 
  $dados = new dadosAdmin;
  
// Se resultado final for 0 significa sucesso, 1 significa erro, 2 erro de conexão, 3 Expediente encerrado
$resultado = 0; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['nomeAdmin'])&& isset($_POST['senha'])){
        $nomeAdmim = $_POST['nomeAdmin'];
        $senha = $_POST['senha'];
    /*////////////Obtenção de dados Nescessarios//////////////*/
        try {            
                //Faz a conexão com o banco
                $pdo = new PDO("mysql:dbname=pontometa; host=localhost;",'root',''); 
                
                try {
                    //Verifica os dados
                    $result = $pdo->query("
                        SELECT * FROM administradores WHERE userName = '".$nomeAdmim."' and senha = md5('".$senha."')
                    ");    
                    $dados = $result->fetch(PDO::FETCH_ASSOC);
                    if(isset($dados['userName'])){
                        print_r($dados);
                        print("gg");
                    }else{
                        throw new Exception('Não é possivel encontrar este administrados');
                    }
                } 
                catch (Exception $e) {
                    $resultado = 1;
                }

            } 
        catch (Exception $e) {
                $resultado = 2;
        }


        
        echo "Resultado:".$resultado;

    }

}

?>