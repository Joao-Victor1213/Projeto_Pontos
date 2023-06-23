<?php 

// Converte para o modo string da hora recebendo as horas minutos e segundos
function tempoParaString($horas,$minutos,$segundos, $negativo){
    
    $timeString = '';


    if($negativo){ // Se for negativo adiciona '=' ao inicio
      $timeString .= '-';
    }
    if($horas < 10){
      $timeString .= "0".$horas;
    }else{
      $timeString .= $horas;
    }

    if($minutos < 10){
      $timeString .= ":0".$minutos;
    }else{
      $timeString .= ":".$minutos;
    }

    if($segundos < 10){
      $timeString .= ":0".$segundos;
    }else{
      $timeString .= ":".$segundos;
    }

  return $timeString;
}
  
function segundosParaHoras($segundos){ // Recebe em segundos e transforma para hh:mm:ss

    if($segundos == NULL){
        return '';
    }
    $negativo = false;
    if($segundos < 0){
      $segundos = $segundos*-1;
      $negativo = true;
    }
    $minutos = intdiv($segundos,60);
    $segundos = $segundos%60;
    $horas = intdiv($minutos,60);
    $minutos = $minutos%60;
    return tempoParaString($horas,$minutos,$segundos, $negativo);

}

function  somaTempo($hora1, $hora2){

    if($hora2 == NULL && $hora1 == NULL){
        return '00:00:00';
    }else if($hora1 == NULL){
        return $hora2;
    }else if($hora2 == NULL){
        return $hora1;
    }
    
    try {
      $hourStart1 = DateTime::createFromFormat("H:i:s", $hora1); //Converte string para datetime
      $hourStart2 = DateTime::createFromFormat("H:i:s", $hora2);  //Converte string para datetime

      $horas1 = horasParaInt($hora1); //Pega hora e converte para inteiro
      $horas2 = horasParaInt($hora2); //Pega hora e converte para inteiro
      
      $minutos1 = minutosParaInt($hora1); //Pega minuto e converte para inteiro
      $minutos2 = minutosParaInt($hora2); //Pega minuto e converte para inteiro

      $segundos1 = segundosParaInt($hora1);//Pega segundo e converte para inteiro
      $segundos2 = segundosParaInt($hora2);//Pega segundo e converte para inteiro
      
      $minutosTotal = intdiv(($segundos1+$segundos2),60);
      $segundosTotal = ($segundos1+$segundos2)%60;
      $minutosTotal = $minutosTotal+($minutos1+$minutos2);

      $horasTotal = intdiv($minutosTotal,60);

      $minutosTotal = $minutosTotal%60;
      
      $horasTotal = $horasTotal + ($horas1+$horas2);
      
    return tempoParaString($horasTotal,$minutosTotal,$segundosTotal, false);
  } catch (\Throwable $th) {
    return '00:00:00';
  }
}



function  subtraiTempo($hora1, $hora2){
    if($hora2 == NULL && $hora1 == NULL){ //Se os dois forem nulos retorn tempo vazio
        return '00:00:00';
    }else if($hora1 == NULL){ //Se hora 1 for Nula retorn hora 2
        return $hora2;
    }else if($hora2 == NULL){ //Se hora 2 for NUla retorn hora 1
        return $hora1;
    }

    if($hora2 == '' && $hora1 == ''){//Se os dois forem vazios retorn tempo vazio
        return '00:00:00';
    }else if($hora1 == ''){ //Se hora 1 for vazia retorn hora 2
        return $hora2;
    }else if($hora2 == ''){ //Se hora 2 for vazia retorn hora 1
        return $hora1;
    }
    try {
    
      $hourStart1 = DateTime::createFromFormat("H:i:s", $hora1); //Converte string para datetime
      $hourStart2 = DateTime::createFromFormat("H:i:s", $hora2);  //Converte string para datetime

      $horas1 = horasParaInt($hora1); //Pega hora e converte para inteiro
      $horas2 = horasParaInt($hora2); //Pega hora e converte para inteiro
      
      $minutos1 = minutosParaInt($hora1); //Pega minuto e converte para inteiro
      $minutos2 = minutosParaInt($hora2); //Pega minuto e converte para inteiro

      $segundos1 = segundosParaInt($hora1);//Pega segundo e converte para inteiro
      $segundos2 = segundosParaInt($hora2);//Pega segundo e converte para inteiro
      
      $horasResto = 0; // Ira Guarda o resto da subtracao entre as horas
      if($horas2 > $horas1){ // Se a hora  2 que ira subtrair da hora 1 for maior que hora 1
        $horasResto = $horas2 - $horas1; // Ira pegar o resto da subtraçao para depois se subtraido nos minutos de hora1
        $horasTotal = 0; // As horas de hora 1 serão zeradas
      }else{
        $horasTotal = $horas1-$horas2; // Se horas1 for maior que a hora 2 faz a subtração normalmente
      }
      // Soma em minutos o que não deu para subtrair de horas
      $minutos2 = $minutos2 + $horasResto*60; //Vezes 60 para converter horas em minutos
      

      $minutosResto = 0; //Cria a variavel que irá guardar quantos minutos não deu para subtrair inicialmente
      if($minutos2 > $minutos1){ // Se o valor a ser subtraido for menor que o que ira subtrair
          $minutosResto = $minutos2 - $minutos1; //Obtém quanto não se deu para subtrair
          $minutosTotal = 0; // Zera os minutos
      }else{  // Se o valor a ser subtraido for maior
        $minutosTotal = $minutos1 - $minutos2; //subtrai normalmente
      }

      $segundos2 += $minutosResto*60; //Soma em segundos que irá subtrair o que que não deu para subtrair de minutos
      
      if($segundos2 > $segundos1){ // Se segundos a ser subtraido for menor que o que irá subtrair
          //Pega o quanto que não deu para subtrair em segundos, subtraindo o segundos maior que iria subtrair
          //ao final, assim obtendo quanto faltou em segundos para subtrair e transforma em negativo
          $segundosTotal = (-1)*(($segundos2) - $segundos1);
      }else{
          // Subtrai os segundos normalmente mesmo que fique negativo pois a próxima parte ira compensar tudo
          // e caso não dê para compensar retorna o valor negativo
          // Compensar seria retirar das horas ou dos minutos somando nos segundo até que a variavel de segundos 
          // fique positiva.
          $segundosTotal = $segundos1 - ($segundos2);
      }
      //Se segundos ao final for negativo, ou seja se ao final não deu para subtrair tudo e faltou algo e
      //não tiver nem minutos nem horas para suprir
      if($segundosTotal < 0 && $minutosTotal == 0 && $horasTotal == 0){ 
        
        return segundosParaHoras($segundosTotal); //converte segundos para horas e minutos
      }else{
          while ($segundosTotal < 0) { // Enquanto segundos não for positivo
              //Se tiver minutos para suprir retira de minutos e soma em segundos 
              //(*60 para converter de minutos para segundos)
              if($minutosTotal > 0){ 
                      $minutosTotal -= 1;
                      $segundosTotal += 60;
          
                  }else
                  if($horasTotal > 0){
                      //Se tiver horas para suprir retira de horas e soma em minutos e de minutos soma em segundos 
                      //(*60 para converter de minutos para segundos ou de horas para minutos)
                      $horasTotal -= 1;
                      $minutosTotal += 59;
                      $segundosTotal += 60;
                  }else{
                      //Se não tiver horas nem minutos para suprir transforma em horas negativas
                      return segundosParaHoras($segundosTotal);
                  }
            }
          // Se segundos se tornou positivo converte para string somente
          return tempoParaString($horasTotal,$minutosTotal,$segundosTotal,false); //falso para negativo
    }
  } catch (\Throwable $th) {
    return '00:00:00';
  }
}


//Recebe uma string nesse modelo 'hh:mm:ss' e retorna as horas em inteiro
function horasParaInt($tempoString){ 

  if($tempoString == NULL){ // Se for nulo retorna nulo
    return NULL;
  }

  try {
    $horasString = '';
    $i = 0;
    while($tempoString[$i] != ':'){ //Enquanto não encontrar o primeiro ':' 
      //soma todos os valores a string que guarda a hora
      $horasString .= $tempoString[$i];
      $i++;
    }

    $horas = intval($horasString); //Transforma a string em inteiro
    return $horas; //retorna o valor inteiro
  } catch (\Throwable $th) {
    return NULL;
  }
}


//Recebe uma string nesse modelo 'hh:mm:ss' e retorna os minutos em inteiro
function minutosParaInt($tempoString){ 

  if($tempoString == NULL){ // Se for nulo retorna nulo
    return NULL;
  }

  try {
    $minutosString = '';
    $i = 0;
    while($tempoString[$i] != ':'){ //Enquanto não encontrar o primeiro ':' 
      $i++;
    }
      
    $i++; //Sai da posicao onde detem o primeiro ':'

    while($tempoString[$i] != ':'){ //Enquanto não encontrar o segundo ':' 
      //soma todos os valores a string que guarda a hora
      $minutosString .= $tempoString[$i];
      $i++;
    }

    $minutos = intval($minutosString); //Transforma a string em inteiro
    return $minutos; //retorna o valor inteiro
  } catch (\Throwable $th) {
    return NULL;
  }
}


//Recebe uma string nesse modelo 'hh:mm:ss' e retorna os segundos em inteiro
function segundosParaInt($tempoString){ 

  if($tempoString == NULL){ // Se for nulo retorna nulo
    return NULL;
  }

  try {
    $segundosString = '';
    $i = 0;
    while($tempoString[$i] != ':'){ //Enquanto não encontrar o primeiro ':' 
      $i++;
    }
      
    $i++; //Sai da posicao que detem o primeiro ':'

    while($tempoString[$i] != ':'){ //Enquanto não encontrar o segundo ':' 
      $i++;
    }
      
    $i++; //Sai da posicao que detem o segundo ':'
    while($i < strlen($tempoString)){ //Enquanto não chegar ao final da string 
      //soma todos os valores a string que guarda os segundos
      $segundosString .= $tempoString[$i];
      $i++;
    }

    $segundos = intval($segundosString); //Transforma a string em inteiro
    return $segundos; //retorna o valor inteiro
  } catch (\Throwable $th) {
    return NULL;
  }
}
?>