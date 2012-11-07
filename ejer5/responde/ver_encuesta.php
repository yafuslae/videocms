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
    <form action="mostrar_resultados.php" method="POST">
    <?php
        if (isset($_GET['id']) === true){
            $idEncuesta = $_GET['id'];
			echo '<h1> Encuesta '.'#'.$idEncuesta.'</h1>';
			echo '<input type="hidden" name="idEncuesta" value="'.$idEncuesta.'">';
			
			//mostrar textoPregunta
            try{
				@ $db = new mysqli('localhost', 'root', 'root1');
				if (mysqli_connect_errno() != 0)
					throw new Exception('Error conectando:'.mysqli_connect_error(), mysqli_connect_errno());
				
				$db->select_db('encuestas');
				if ($db->errno != 0)
					throw new Exception('Error seleccionando bd:'.$db->error, $db->errno);
					
				$consulta = "select textoPregunta from encuesta where id=".$idEncuesta;
				$resultado = $db->query($consulta);
				if ($db->errno != 0)
					throw new Exception('Error realizando consulta:'.$db->error, $db->errno);
				assert($resultado !== false);
				
				if ($resultado->num_rows > 0){
					while ($obj = $resultado->fetch_object()){
						LimpiaResultados($obj);
						$textoPregunta=$obj->textoPregunta;
					}
					echo '<h1> Pregunta: '.$textoPregunta.'</h1>';
				}
				else echo '<p>No hay datos que mostrar</p>';
				$resultado->free(); 
				$db->close(); 
			}catch (Exception $e){
				echo $e->getMessage();
				if (mysqli_connect_errno() == 0)
					$db->close();
				exit();
			}
			//mostrar respuestas
			try{
				@ $db = new mysqli('localhost', 'root', 'root1');
				if (mysqli_connect_errno() != 0)
					throw new Exception('Error conectando:'.mysqli_connect_error(), mysqli_connect_errno());
				
				$db->select_db('encuestas');
				if ($db->errno != 0)
					throw new Exception('Error seleccionando bd:'.$db->error, $db->errno);
					
				$consulta = 'select id, textoRespuesta from respuesta where idEncuesta='.$idEncuesta;
				$resultado = $db->query($consulta);
				if ($db->errno != 0)
					throw new Exception('Error realizando consulta:'.$db->error, $db->errno);
				assert($resultado !== false);
				
				if ($resultado->num_rows > 0){
					$primeraVez = true;
					echo '<ul>';
					while ($obj = $resultado->fetch_object()){
						LimpiaResultados($obj);
						echo '<li>';
							if ($primeraVez === true){
								echo '<input type="radio" name="id" value="'.$obj->id.'" checked />';
								$primeraVez = false;
							}
							else
								echo '<input type="radio" name="id" value="'.$obj->id.'" />';
							echo $obj->textoRespuesta;
						echo '</li>';
					}
					echo '</ul>';
				}
				else echo '<p>No hay datos que mostrar</p>';
				$resultado->free(); 
				$db->close(); 
			}catch (Exception $e){
				echo $e->getMessage();
				if (mysqli_connect_errno() == 0)
					$db->close();
				exit();
			} 
        }
	?>
		<input type="submit" name="votar" value="Votar" />
    </form>
	<?php
	include('../aspecto/pie.html');
    ?>   
    </body>
</html>
