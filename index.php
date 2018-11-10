<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title> Mi Agenda </title>
    </head>
    <body>
      <div> 
          <?php
          // <!-- 
         // ............Funciones .........
          function asocArrayToString($asocArray){
              $str="";
              foreach($asocArray as $nom=>$tlf){ // recorro el array y lo voy poniendo entre comas  en el string
                  $str=$str.$nom.",".$tlf.",";
               }  
             return $str;
          }
          
          
          function stringToAsocArray($string){
            $a = explode(',', $string);// meto en un array los termino separados por comas
            $longitud = count($a);
                //Recorro todos los elementos
                for($i=0; $i<$longitud; $i++){ // introduzco la clave y el valor en el array asociativo.
                        $nom=$i;
                        $tlf=$i+1;
                        $asc[$a[$nom]]=$a[$tlf]; //$asc[clave]=valor;
                         $i++; // añado un contador mas para que se recorra cada dos valores
                      }
              return $asc; 
          }  

            
          function claveRepetida ($nombre , $array) { // con un array y una clave nos dice si existe o no
                   if (array_key_exists($nombre, $array)) {
                        return true;
                    } else {
                         return false;
                    }
                }

            function addAgenda(&$agenda,$nombre,$telefono){ 
                $agenda[$nombre]=$telefono;
            }
            
            function deleteAgenda(&$agenda, $nombre){
                unset($agenda[$nombre]);
            }
            
            function alterAgenda(&$agenda,$nombre,$telefono){
                $reemplazos=array();
                $reemplazos[$nombre]=$telefono;
                $agenda = array_replace($agenda, $reemplazos);
            }
            
            
            //mostramos la agenda
            function mosstrarAgenda($agenda){  
               echo "<div>"
                                          . "<table >"
                                          . "     <tr>"
                                          . "             <td> AGENDA DE CONTACTOS </td>"
                                          . "     </tr>"
                                           . "     <tr>"
                                          . "             <td> Nombre </td>"
                                          . "             <td> Telefono </td>"
                                          . "     </tr>" ;
                                 // for ($i=0; $i< count($array_asociativo); $i++){  } 
                                  foreach($agenda as $nom=>$tlf){

                                      echo  "     <tr>"
                                          . "             <td> $nom </td>"
                                          . "             <td> $tlf </td>"
                                          . "     </tr>";
                                      }  
              }

          
          
          // defino mi array
          $agenda = array(
              "pepe"    =>  111111111,
              "eva"     =>  222222222,
              "miguel"  =>  333333333,
              "pablo"   =>  4444444444,
              "antia"   =>  5555555555,
              "laura"   =>  666666666,
              "pedro"   =>  777777777,
              "diego"   =>  888888888,
              "carla"   =>  999999999,
              );
          $string="";// guardamos los datos
         // $array_asociativo["Nombre"]="Telefono";
        if (isset($_POST['enviar'])) { // si se presiona el boton enviar 
            $nombre = $_POST['nombre'];
            $telefono = $_POST['telefono'];
            $recuperoString=$_POST['array'];// recuperamos nuestro array en formato string
            $asc = stringToAsocArray($recuperoString) ;//a partir del str recuperado genero un array asociativo;  
            
            if (count($asc) > 1){ // si en la variable hay datos
                unset($agenda);// borramos datos de agenda
                $agenda = array(); // redefinimos agenda
                $agenda=$asc; // metemos los datos del array recuperado
            }
            
            
           if((!empty($recuperoString)) && isset($recuperoString)){
               echo '*****************************************************  VER DATOS   ******************************************************************************************* <br>';
               
                echo '----------------- Datos de recuperoArray ----------------------- <br>';
                echo 'datos del String <br>';
                echo '----------------------------------------------------------------- <br>';
                print_r($recuperoString); echo ' <br>';
                echo '----------------------------------------------------------------- <br>';
                echo 'datos de Arrayasc a partir del string <br>';
                echo '----------------------------------------------------------------- <br>';
                print_r($asc); echo ' <br>';
                echo '----------------------------------------------------------------- <br>';
                echo '---------------- Fin datos de recuperoArray ------------------- <br>';
           
                echo 'datos de AGENDA <br>';
                echo '----------------------------------------------------------------- <br>';
                print_r($agenda); echo ' <br>';
                echo '----------------------------------------------------------------- <br>';
                var_dump($agenda);  echo ' <br>';
                echo '----------------------------------------------------------------- <br>';
                 echo 'fin datos de AGENDA <br>'; 
                 
                 echo '*****************************************************  FIN VER DATOS   ******************************************************************************************* <br>';
               
                }   
                
             if((!empty($nombre)) && isset($nombre)){ // El nombre contiene datos
                 echo "el campo del nombre contiene datos"."</br>";
                 if (claveRepetida($nombre,$agenda)){// el campo del nombre esta repetido
                     echo "el campo del nombre : repetido"."</br>";
                        if((!empty($telefono)) && isset($telefono)){
                           echo "el campo del telefono contiene datos "."</br>" ;
                           alterAgenda($agenda, $nombre,$telefono);
                            echo "ACCION:: En el contacto $nombre se modifica el telefono por : $telefono "."</br>";
                        } else {
                               echo "el campo del telefono no contiene datos"."</br>";
                               echo "ACCION:: Se elimina el contacto $nombre "."</br>";
                                deleteAgenda($agenda, $nombre);
                        }       
                        
                 }else { // el campo del nombre no esta repetido , haya campo de telefono o no se añada a la agenda
                     // addAgenda(&$agenda, $nombre, $telefono);
                     echo "el campo del nombre : no_repetido"."</br>";
                     addAgenda($agenda, $nombre, $telefono);
                     echo "ACCION:: se añade el nuevo contacto $nombre : $telefono" ."</br>";
                 }

             }else{ // El campo del nombre , se dejo en blanco . Si el nombre esta en blanco muetsra una davertencia.
                 echo "Warning cubre el campo del nombre correctamente"."</br>";
              }
            $stringDatos=asocArrayToString($agenda); // convertimos nuestro array en un str para enviarlo en un hidden
            mosstrarAgenda($agenda);
             }  

// -->
         ?>
      </div>
        <div> 
            
           
            <p>   FORMULARIO                      </p>
          
            <form action=" <?php echo htmlspecialchars( $_SERVER['PHP_SELF'])?> "
              method="post" name="agenda">
            
              <!-- campo Nombre permite :  con 4 - 12 digitos de texto (mayusculas minusculas entre a-z) o el campo en blanco --->
             Nombre   :  <input type="text" name="nombre" minlength="4" maxlength="12" pattern="[A-Za-z]*"/></br>
             <!-- campo telefono  permite :  9 digitos numericos  del 0-9 o el campo en blanco --->
             Telefono : <input type="number" name="telefono" min ="100000000 " max=" 999999999" pattern="[0-9]*"/> </br>
             <input type="hidden" name="array" value=" <?php echo $stringDatos; ?>"/> </br>
              <input type="submit" value="Enviar" name="enviar" />
             </br></br>
        </div> 
        
        
    <!--
        
       <?php            
             /* Ver funcionamiento de Comprobación de datos */
             
   
         echo " <div> " ;
            echo "</br>"." El parametro : [nombre] vale : $nombre "."</br>"
                    ." compuesto por : "."</br>"
                    ."---------------------------------------------------------"."</br>";
           if(!empty($_POST['nombre'])){
                echo "  nombre : Dato"."</br>";
                } else { echo "  nombre : En_blanco"."</br>";
            }
            if(isset($_POST['nombre'])){
                echo "  nombre : variable_exist"."</br>";
                } else { echo "  nombre : variable_not_exist "."</br>";
            }
            if(is_null($_POST['nombre'])){
                echo "  nombre : null"."</br>";
                } else { echo "  nombre : not_null"."</br>";
            }
            if(is_string($_POST['nombre'])){
                echo "  nombre : string"."</br>";
                } else { echo "  nombre : not_string"."</br>";
            } 
            if(ctype_alpha($_POST['nombre'])){
                echo " nombre : alfabetico"."</br>";
                } else { echo "  nombre : not_alfabetico"."</br>";
            }
            
             
            echo "</br>"." El parametro : [telefono] vale : $telefono "."</br>"
                    ." esta compuesto por :"."</br>"
                    ."---------------------------------------------------------"."</br>";
            if(!empty($telefono)){
                echo " Telefono : Dato"."</br>";
                } else { echo " Telefono : En_BLanco"."</br>";
            }            
            
            if(isset($telefono)){
                echo " Telefono : variable_exist"."</br>";
                } else { echo " Telefono : variable_not_exist"."</br>";
            }
            if(is_null($telefono)){
                echo " Telefono : null"."</br>";
                } else { echo " Telefono : not_null"."</br>";
            }
            if(is_numeric($telefono)){
                echo " Telefono : number"."</br>";
                } else { echo " Telefono : not_number"."</br>";
            }            
            if(ctype_digit($telefono)){
                 echo " Telefono : digitos"."</br>";
                } else { echo "Telefono : not_digitos"."</br>";   
            }
           echo " </div> " ;
             
       ?>
            
    -->
        
        
        
    </body>
</html>

