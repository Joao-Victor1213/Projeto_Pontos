<?php 

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With, Access-Control-Allow-Origin");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Methods: GET, OPTIONS");

$banco = 'id20153422_pontometa';
$host = 'localhost';
$usuario = 'id20153422_root';
$senha = '0?D5Bznb@Em|4(u[';

try{
    $pdo = new PDO("mysql:dbname=$banco;host=$host;charset=utf8","$usuario","$senha");
}catch(Exception $e){
    header('location: login.php?erro=3'); 

}

function encontraPontos($cpf, $pdo){
    return $pdo->query("SELECT * FROM pontos WHERE fk_cpf ='".$cpf."'");
}

function deletaPontos($cpf, $mes, $pdo){
    return $pdo->query("DELETE FROM pontos WHERE mes = $mes AND fk_cpf ='".$cpf."'");
}

function deletaFuncionario($cpf,$pdo){
    try {
        $pdo->query("DELETE FROM funcionarios WHERE cpf = '".$cpf."'");
        return 0;
    } catch (Exception $e) {
        return 2;
    }
}

function existeFuncionario($cpf,$pdo){
    try {
        $result = $pdo->query("SELECT * FROM funcionarios WHERE cpf = '".$cpf."'");
        $dados = $result->fetch(PDO::FETCH_ASSOC);
        if(isset($dados['cpf'])){
            return 0;
        }else{
            return 1;
        }
    } catch (Exception $e) {
        return 2;
    }
}

function pontoManual($cpf,$pdo,$coluna){
    try {

    //Insere a linha de ponto do dia caso não exista
    $pdo->query("
                    
        insert into pontos(fk_cpf,mes,dia,dataPonto) Select '".$cpf."', month(CURRENT_TIMESTAMP),day(CURRENT_TIMESTAMP),date(CURRENT_TIMESTAMP)
        Where not exists(select * from pontos where  mes = month(CURRENT_TIMESTAMP) and dia = day(CURRENT_TIMESTAMP) and fk_cpf = '".$cpf."')
        
    ");

    $pdo->query(
    "UPDATE pontos
        SET ".$coluna." = Time(DATE_ADD(CURRENT_TIMESTAMP,INTERVAL -3 HOUR))
        WHERE mes = month(CURRENT_TIMESTAMP) and dia = day(CURRENT_TIMESTAMP) and fk_cpf = '".$cpf."'"
    );
    } catch (Exception $e) {
        return $e->getMessage();
    }

}
function dadosFuncionario($cpf,$pdo){
    try {
        $result = $pdo->query("SELECT * FROM funcionarios WHERE cpf = '".$cpf."'");
        $dados = $result->fetch(PDO::FETCH_ASSOC);
        if(isset($dados['cpf'])){
            return $dados;
        }else{
            return 1;
        }
    } catch (Exception $e) {
        return 2;
    }
}
?>