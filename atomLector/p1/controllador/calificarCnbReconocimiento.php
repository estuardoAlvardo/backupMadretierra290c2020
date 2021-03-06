<?php 

session_start();
require("../../../conection/conexion.php");
$fecha_actual=date("d/m/Y");
$hora_actual=date('h:i:s');
$fundamento='cnb';

//seleccionar items para poder calificar
$sq1 = ("SELECT *  FROM atomolector as lectura join cuestionario as cues on lectura.idLectura=cues.idLectura join itemopcionmultiple as item on item.idCuestionario=cues.idCuestionario where lectura.idLectura=:idLectura AND fundamento=:fundamento");
    $obtenerCuestionario = $dbConn->prepare($sq1);
     $obtenerCuestionario->bindparam(':idLectura',$_POST['idLecturaEnviado'],PDO::PARAM_INT);
     $obtenerCuestionario->bindparam(':fundamento', $fundamento,PDO::PARAM_STR);
    $obtenerCuestionario->execute();
    $hayItems=$obtenerCuestionario->rowCount();




//insertar respuestas del alumno 
$sql1 = ("INSERT INTO registropruebacomprension3p(idLectura,idUsuario,tiempo,fechaRegistro,horaRegistro,rPregunta1,rPregunta2,rPregunta3,rPregunta4,rPregunta5,rPregunta6,rPregunta7,rPregunta8,rPregunta9,input1,input2,input3,totalObtenido,intento) VALUES (:idLectura,:idUsuario,:tiempo,:fechaRegistro,:horaRegistro,:rPregunta1,:rPregunta2,:rPregunta3,:rPregunta4,:rPregunta5,:rPregunta6,:rPregunta7,:rPregunta8,:rPregunta9,:input1,:input2,:input3,:totalObtenido,:intento)");
$insertarQuiz3p = $dbConn->prepare($sql1);

$sql2=('SELECT * FROM registropruebacomprension3p where idLectura=:idLectura and idUsuario=:idUsuario');
$verIntentos = $dbConn->prepare($sql2);
$verIntentos->bindParam(':idLectura',$_POST['idLecturaEnviado'], PDO::PARAM_INT);
$verIntentos->bindParam(':idUsuario',$_SESSION['idUsuario'], PDO::PARAM_INT);
$verIntentos->execute(); 
$hayIntentos=$verIntentos->rowCount();
$hayIntentos+=1;



 while(@$row1=$obtenerCuestionario->fetch(PDO::FETCH_ASSOC)){
  

  if($row1['respuestaCorrecta']!=0){
    @$m+=1;
      $_SESSION['punteoItem'.$m]=$row1['punteoItem'];
      $_SESSION['respuestaCorrecta'.$m]=$row1['respuestaCorrecta'];
      
      
    } 

    if($row1['respuestaCorrecta']==0){
       @$j+=1;
       $_SESSION['matriz'.$j]=$row1['matrizComparativa'];
       

    }   

 }

 //echo '#RespuestaCorrecta1'.' punteo '.$_SESSION['respuestaCorrecta'.$m].'<br>';
  

foreach($_POST as $nombre_campo => $valor){ 
 
   $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; 

 if($nombre_campo=='idLecturaEnviado'){
      $_SESSION['idLectura_g']=$valor; 
      $insertarQuiz3p->bindParam(':idLectura',$_SESSION['idLectura_g'], PDO::PARAM_INT);
   }

   if($nombre_campo=='idUsuario'){
     $_SESSION['idUsuario_g']=$valor; 
     $insertarQuiz3p->bindParam(':idUsuario',$_SESSION['idUsuario_g'], PDO::PARAM_INT);

   }

   if($nombre_campo=='tiempo'){
    $_SESSION['tiempo_g']=$valor; 
     $insertarQuiz3p->bindParam(':tiempo', $_SESSION['tiempo_g'], PDO::PARAM_STR);

   }

     $insertarQuiz3p->bindParam(':fechaRegistro', $fecha_actual, PDO::PARAM_STR);
   $insertarQuiz3p->bindParam(':horaRegistro', $hora_actual, PDO::PARAM_STR);
  

   if(strpos($nombre_campo, 'multiple')!== false){
    @$i+=1;    
      $insertar1='rPregunta'.$i;
    //echo $insertar;
      
      if($insertar1=='rPregunta1'){
        //almacenamos respuesta
        $_SESSION['oki1']=$valor;
         $insertarQuiz3p->bindParam($insertar1, $_SESSION['oki1'], PDO::PARAM_INT);
         //echo 'pregunta= '.$insertar1.' respuesta= '.$_SESSION['oki1'].'<br>';
         //verificamos respuesta y sumamos al total

         if($_SESSION['respuestaCorrecta1']==$_SESSION['oki1']){
          
             @$sumaCorrectas+=$_SESSION['punteoItem1'];
         }else{
         $punteoOb=0;
         @$sumaCorrectas+=$punteoOb;
         }

                
      }

       if($insertar1=='rPregunta2'){
         $_SESSION['new1']=$valor;
         $insertarQuiz3p->bindParam($insertar1, $_SESSION['new1'], PDO::PARAM_INT);
         //echo 'pregunta= '.$insertar1.' respuesta= '.$_SESSION['new1'].'<br>';
         if($_SESSION['respuestaCorrecta2']==$_SESSION['new1']){
          
             @$sumaCorrectas+=$_SESSION['punteoItem2'];
         }else{
         $punteoOb=0;
         @$sumaCorrectas+=$punteoOb;
         }
      }


       if($insertar1=='rPregunta3'){
        $_SESSION['lem1']=$valor;
         $insertarQuiz3p->bindParam($insertar1, $_SESSION['lem1'], PDO::PARAM_INT);
         //echo 'pregunta= '.$insertar1.' respuesta= '.$_SESSION['lem1'].'<br>';
         if($_SESSION['respuestaCorrecta3']==$_SESSION['lem1']){
          
             @$sumaCorrectas+=$_SESSION['punteoItem3'];
         }else{
         $punteoOb=0;
         @$sumaCorrectas+=$punteoOb;
         }         

      }



       if($insertar1=='rPregunta4'){
        $_SESSION['almacenar4']=$valor;
         $insertarQuiz3p->bindParam($insertar1, $_SESSION['almacenar4'], PDO::PARAM_INT);
         //echo 'pregunta= '.$insertar1.' respuesta= '.$_SESSION['almacenar4'].'<br>';
         if($_SESSION['respuestaCorrecta4']==$_SESSION['almacenar4']){
          
             @$sumaCorrectas+=$_SESSION['punteoItem4'];
         }else{
         $punteoOb=0;
         @$sumaCorrectas+=$punteoOb;
         } 

          
      }
       if($insertar1=='rPregunta5'){
        $_SESSION['almacenar5']=$valor;
         $insertarQuiz3p->bindParam($insertar1, $_SESSION['almacenar5'], PDO::PARAM_INT);
         //echo 'pregunta= '.$insertar1.' respuesta= '.$_SESSION['almacenar5'].'<br>';
         if($_SESSION['respuestaCorrecta5']==$_SESSION['almacenar5']){
          
             @$sumaCorrectas+=$_SESSION['punteoItem5'];
         }else{
         $punteoOb=0;
         @$sumaCorrectas+=$punteoOb;
         } 

        
      }
       if($insertar1=='rPregunta6'){
        $_SESSION['almacenar6']=$valor;
         $insertarQuiz3p->bindParam($insertar1, $_SESSION['almacenar6'], PDO::PARAM_INT);
         //echo 'pregunta= '.$insertar1.' respuesta= '.$_SESSION['almacenar6'].'<br>';
         if($_SESSION['respuestaCorrecta6']==$_SESSION['almacenar6']){
          
             @$sumaCorrectas+=$_SESSION['punteoItem6'];
         }else{
         $punteoOb=0;
         @$sumaCorrectas+=$punteoOb;
         }

        
      }
       if($insertar1=='rPregunta7'){
        $_SESSION['almacenar7']=$valor;
         $insertarQuiz3p->bindParam($insertar1, $_SESSION['almacenar7'], PDO::PARAM_INT);
         //echo 'pregunta= '.$insertar1.' respuesta= '.$_SESSION['almacenar7'].'<br>';

         if($_SESSION['respuestaCorrecta7']==$_SESSION['almacenar7']){
          
             @$sumaCorrectas+=$_SESSION['punteoItem7'];
         }else{
         $punteoOb=0;
         @$sumaCorrectas+=$punteoOb;
         }

       
      }
       if($insertar1=='rPregunta8'){
        $_SESSION['almacenar8']+=$valor;
         $insertarQuiz3p->bindParam($insertar1, $_SESSION['almacenar8'], PDO::PARAM_INT);
         //echo 'pregunta= '.$insertar1.' respuesta= '.$_SESSION['almacenar8'].'<br>';

          if($_SESSION['respuestaCorrecta8']==$_SESSION['almacenar8']){
          
             @$sumaCorrectas+=$_SESSION['punteoItem8'];
         }else{
         $punteoOb=0;
         @$sumaCorrectas+=$punteoOb;
         }

      }
       if($insertar1=='rPregunta9'){
        $_SESSION['almacenar9']=$valor;
         $insertarQuiz3p->bindParam($insertar1, $_SESSION['almacenar9'], PDO::PARAM_INT);
         //echo 'pregunta= '.$insertar1.' respuesta= '.$_SESSION['almacenar9'].'<br>';
         if($_SESSION['respuestaCorrecta9']==$_SESSION['almacenar9']){
          
             @$sumaCorrectas+=$_SESSION['punteoItem9'];
         }else{
         $punteoOb=0;
         @$sumaCorrectas+=$punteoOb;
         }  


      }

   

   }

   if(strpos($nombre_campo, 'input')!== false){
     @$o+=1;
    $insertar='input'.$o;
    //echo $insertar;
    $_SESSION['almacenar'.$o]=$valor;
    $insertarQuiz3p->bindParam($insertar, $_SESSION['almacenar'.$o], PDO::PARAM_STR);
    //echo 'pregunta '.$insertar.'-----Respuesta ya comparada---'.$_SESSION['resultado'.$o].'<br>';
     $porcentaje=similar_text($_SESSION['almacenar'.$o], $_SESSION['matriz'.$o]);

      //echo 'Pregunta------'.$o.' =sistema= '. $porcentaje.'<br><br>';

      if($porcentaje>=50){
        @$sumaCorrectas+=8;
      }

      if($porcentaje>=20 and $porcentaje<=49){
        @$sumaCorrectas+=4;
      }

      if($porcentaje>=0 and $porcentaje<=10){
         @$sumaCorrectas+=1;
      }

   }

echo @$sumaCorrectas;

  
   


   if($nombre_campo=='intento'){
   
     $insertarQuiz3p->bindParam(':intento', $hayIntentos, PDO::PARAM_INT);

   }

   

}


   
     $insertarQuiz3p->bindParam(':totalObtenido', @$sumaCorrectas, PDO::PARAM_INT);




 $insertarQuiz3p->execute();
header("location:../resultadoCnb3p.php?idLectura=".$_POST['idLecturaEnviado']."&idUsuario=".$_POST['idUsuario'].'&gradoB='.$_POST['gradoB']);

?>