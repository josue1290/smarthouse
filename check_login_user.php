<?php
 
include('conexion/conexionBD.php');

$user 	= $_POST['usuario'];
$passcode 	= $_POST['password'];

    $dictionary = array('A','B','C','1','D','E','2','F','G','H','3','I','J','K','4','L','M','N','5','Ñ','O','P',
    'Q','R','6','S','T','U','V','W','7','X','Y','Z','a', 'b', '8', 'c', 'd', 'e', 'f', 'g', 
    'h', '9', 'i', 'j', 'k', 'l', 'm', '0', 'n', 'ñ', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z');

    $new_dictionary = array('ei', 'bi', 'si', '|', 'di', 'i', '||', 'ef', '||i', 'eich', '|||', 'a|', '||e|', 'ke|', 
        '|V', 'e|', 'em', 'en','V','eñ','ou','p|','k|u','ar','V|','es','ti','iu','vi','daob||u',
        'V||','ecs','ua|','z||','E|', 'B|', 'V|||', 'S|', 'D|', '|', 'EF', '||I', 'E|CH', 'V|V', 
        'A|', '||EI', 'KE|', 'E|', 'EM', '0', 'EN', 'EÑ', 'OU', 'P|', 'K|U', 'AR', 'ES', 'T|', '|U',
        'V|', 'DA0B||U', 'ECS', 'UA|', 'ZEB');
   // $dictionary = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z');

    //$new_dictionary = array('!', '#', '$', '%', '&', '/', ')', '(', '=', '?', '¡', '*', '[', ']', ',', '.', '-', ';', ':', '', '{', '}', '+', '@', '~', '^');

    // 3. Convertir el input del usuario en un arreglo iterable
    $passcode_arr = str_split($passcode); // ['a', 'b', 'c', 'd', 'e', 'f', 'g']

    $encoded_pass = array(); // ['0', '1', '2', '3', '4', '5']
    // 4. Comparar el input del usuario con el diccionario
    foreach ($passcode_arr as &$passcode_val) {

    foreach ($dictionary as $dic_key => $dic_val) {
        if ($passcode_val == $dic_val) {
        array_push($encoded_pass, $new_dictionary[$dic_key]);
        }
    }
    }

    $new_pass = implode($encoded_pass);

//$queryusuario = mysqli_query($conexion,"SELECT * FROM usuario WHERE user ='$usu' and pass = '$pass'");
$consulta="SELECT*FROM usuario WHERE user='$user' and pass='$new_pass'";
$resultado=mysqli_query($conexion,$consulta);  
$filas=mysqli_fetch_array($resultado);


if($filas==true){ //Admi

    $consulta="SELECT * FROM usuario WHERE user=$user";
    $query_consulta=mysqli_query($conexion,$consulta);
    while ($consulta2=mysqli_fetch_array($query_consulta))
    {
        $user = $consulta2['user'];
    }

    session_start();
	$_SESSION['user']=$user;
     header("location:usuario/quejas.php");
}
else{
    ?>
        <script>
            alert("El Usuario o Contraseña estan incorrectos");
            window.location="paquetes.php";
        </script>
    <?php
}
mysqli_free_result($resultado);
mysqli_close($conexion);

?>
