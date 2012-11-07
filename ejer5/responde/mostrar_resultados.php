<?php 
require('../aspecto/libreria.inc');
dibuja();
function LimpiaResultados($objeto){
	foreach ($objeto as $atributo => $valor)
		if(is_string($objeto->$atributo) === true)
			$objeto->$atributo = stripslashes($objeto->$atributo);
}
class ExcepcionEnTransaccion extends Exception{
	public function __construct(){}
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <title></title>
    </head>
    <body>
    <?php
        if (isset($_POST['votar']) === true){
            $id = $_POST['id'];
            $idEncuesta = $_POST['idEncuesta'];
			
			//incrementaNumRespuestas($id)
			try{
				@ $db = new mysqli('localhost', 'root', 'root1');
				if (mysqli_connect_errno() != 0)
					throw new Exception('Error conectando:'.mysqli_connect_error(), mysqli_connect_errno());
				
				$db->select_db('encuestas');
				if ($db->errno != 0)
					throw new Exception('Error seleccionando bd:'.$db->error, $db->errno);
				
				$consulta = "update respuesta set numeroRespuestas=numeroRespuestas+1 where id=".$id;
				if ($db->query($consulta) === false)
					throw new ExcepcionEnTransaccion();
				$db->commit();
				$db->close(); 
			}catch (ExcepcionEnTransaccion $e){
				echo 'No se ha podido realizar la modificacion';
				$db->rollback();
				$db->close();
			}catch (Exception $e){
				echo $e->getMessage();
				if (mysqli_connect_errno() == 0)
					$db->close();
				exit();
			}
			
			echo '<h1>RESULTADOS ENCUESTA #'.$idEncuesta;
			//textoPregunta
            //numRespuestas
			//respuestas
			try{
				@ $db = new mysqli('localhost', 'root', 'root1');
				if (mysqli_connect_errno() != 0)
					throw new Exception('Error conectando:'.mysqli_connect_error(), mysqli_connect_errno());
				
				$db->select_db('encuestas');
				if ($db->errno != 0)
					throw new Exception('Error seleccionando bd:'.$db->error, $db->errno);
				
				$consulta1 = 'select textoPregunta from encuesta where id='.$idEncuesta;
				$resultado = $db->query($consulta1);
				if ($db->errno != 0)
					throw new Exception('Error realizando consulta1:'.$db->error, $db->errno);
				assert($resultado !== false);
				if ($resultado->num_rows > 0){
					while ($obj = $resultado->fetch_object()){
						LimpiaResultados($obj);
						$textoPregunta = $obj->textoPregunta;
					}
				}else echo '<p>No hay datos que mostrar</p>';
				$resultado->free();
				
				$consulta2 = 'select sum(numeroRespuestas) as sumaNumRespuestas from respuesta where idEncuesta='.$idEncuesta;
				$resultado = $db->query($consulta2);
				if ($db->errno != 0)
					throw new Exception('Error realizando consulta2:'.$db->error, $db->errno);
				assert($resultado !== false);
				if ($resultado->num_rows > 0){
					while ($obj = $resultado->fetch_object()){
						LimpiaResultados($obj);
						$numRespuestas = $obj->sumaNumRespuestas;
					}
				}else echo '<p>No hay datos que mostrar</p>';
				$resultado->free();
				
				$consulta3 = 'select id, textoRespuesta, numeroRespuestas from respuesta where idEncuesta='.$idEncuesta;
				$resultado = $db->query($consulta3);
				if ($db->errno != 0)
					throw new Exception('Error realizando consulta3:'.$db->error, $db->errno);
				assert($resultado !== false);
				if ($resultado->num_rows > 0){
					$respuestas = $resultado;
						
					echo '<table border="1">';
					echo '<tr>';echo '<th>'.$textoPregunta.'</th><th>Total votaciones: '.$numRespuestas.'</th>';echo '</tr>';
					while ($respuesta = $respuestas->fetch_object()){
						$porcentaje = number_format($respuesta->numeroRespuestas * 100 / $numRespuestas, 2, ',', ' ');
						echo '<tr>';
							echo '<td>'.$respuesta->textoRespuesta.'</td>';
							echo '<td>'.$porcentaje.' % ('.$respuesta->numeroRespuestas.' votos)</td>';
						echo '</tr>';
					}
					echo '</table>';
				}else echo '<p>No hay datos que mostrar</p>';
				$resultado->free();
				
				$db->close(); 
			}catch (Exception $e){
				echo $e->getMessage();
				if (mysqli_connect_errno() == 0)
					$db->close();
				exit();
			}
        }
	include('../aspecto/pie.html');
    ?>
    </body>
</html>
