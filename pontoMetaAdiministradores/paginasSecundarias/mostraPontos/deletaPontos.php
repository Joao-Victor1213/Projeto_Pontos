<?php 
  include_once("../../classes/sessao.php");
  verificaSessao("../../login.php"); //Verifica a sessão caso não exista redireciona para a pagina de login

  include_once("../../conexao.php");

  if($_SERVER['REQUEST_METHOD'] == 'POST'){ //Se o metodo de requisição foi do tipo post
    if(isset($_POST['cpf']) && isset($_POST['nome'])){
      $cpf = $_POST['cpf'];
      $nome = $_POST['nome'];
    }else{
      header("Location: ../../menuPage.php");
      exit;
    }

    try {
      $result = deletaPontos($cpf, 1,$pdo);
      header("Location: ../mostraPontos/mostrapontos.php?cpf=$cpf&nome=$nome&erro=0");
    } catch (Exception $e) {
      print($e->getMessage());
      header("Location: ../mostraPontos/mostrapontos.php?cpf=$cpf&nome=$nome&erro=1");
    }

  }else{

  }


?>