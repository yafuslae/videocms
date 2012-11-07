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

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Eliminar respuestas encuesta</title>
</head>
<body>
<?php
if ((isset($_GET['busca'])===false)&&(isset($_GET['elimina'])===false)) {
try{
	@ $db = new mysqli('localhost', 'root', 'root1');
	if (mysqli_connect_errno() != 0)
		throw new Exception('Error conectando:'.mysqli_connect_error(), mysqli_connect_errno());
	
	$db->select_db('encuestas');
	if ($db->errno != 0)
		throw new Exception('Error seleccionando bd:'.$db->error, $db->errno);
		
	$consulta = "select id from encuesta";
	$resultado = $db->query($consulta);
	if ($db->errno != 0)
		throw new Exception('Error realizando consulta:'.$db->error, $db->errno);
	assert($resultado !== false);

	if ($resultado->num_rows > 0){
	?>
		<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="get">
				<p>IDEncuesta: 
				<select name="id">
	<?php
		while ($obj = $resultado->fetch_object()){
			LimpiaResultados($obj);
	?>
			<option value="<?php echo $obj->id ?>" ><?php echo $obj->id ?></option>		
	<?php
		}
	?>	
				</select>
				</p>
				<INPUT TYPE="submit" NAME="busca" VALUE="Busca encuesta">
		</FORM>
	<?php	
	}
	else
		echo '<p>No hay datos que mostrar</p>';
$resultado->free(); 
$db->close();
}catch (Exception $e){
	echo $e->getMessage();
	if (mysqli_connect_errno() == 0)
		$db->close();
	exit();
}
} else if((isset($_GET['busca'])===true)&&(isset($_GET['elimina'])===false)) {
$idencuesta=$_GET['id']; 
try{
	@ $db = new mysqli('localhost', 'root', 'root1');
	if (mysqli_connect_errno() != 0)
		throw new Exception('Error conectando:'.mysqli_connect_error(), mysqli_connect_errno());
	
	$db->select_db('encuestas');
	if ($db->errno != 0)
		throw new Exception('Error seleccionando bd:'.$db->error, $db->errno);
	
	$consulta = "select textoPregunta from encuesta where id=".$idencuesta;
	$resultado = $db->query($consulta);
	if ($db->errno != 0)
		throw new Exception('Error realizando consulta:'.$db->error, $db->errno);
	assert($resultado !== false);

	if ($resultado->num_rows > 0){
			echo '<table border="1">';
			echo'<tr>';echo'<th>TEXTOPREGUNTA</th>';echo'</tr>';
			while ($obj = $resultado->fetch_object()){
				LimpiaResultados($obj);
				echo'<tr>';echo'<td align="center">'.$obj->textoPregunta.'</td>';echo'</tr>';
			}
			echo'</table>';
	
			$consulta = "select textoRespuesta from respuesta where idEncuesta=".$idencuesta;
			$resultado = $db->query($consulta);
			if ($db->errno != 0)
				throw new Exception('Error realizando consulta:'.$db->error, $db->errno);
			assert($resultado !== false);

			if ($resultado->num_rows > 0){
			?>
				<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="get">
						<input type="hidden" name="id" value="<?php echo $idencuesta?>"/>
						<p>Respuestas Encuesta: 
						<select name="textoRespuesta">
			<?php
				while ($obj = $resultado->fetch_object()){
					LimpiaResultados($obj);
			?>
					<option value="<?php echo $obj->textoRespuesta ?>" ><?php echo $obj->textoRespuesta ?></option>		
			<?php
				}
			?>	
						</select>
						</p>
						<INPUT TYPE="submit" NAME="elimina" VALUE="Elimina respuesta encuesta">
				</FORM>
			<?php	
			}
			else {
				echo '<p>No hay datos que mostrar</p>';
				?><p>[<a href="<?php echo $_SERVER['PHP_SELF'] ?>">Nueva baja</a>]</p>
				<?php
			}
	}
	else {
		echo '<p>No hay datos que mostrar</p>';
		?><p>[<a href="<?php echo $_SERVER['PHP_SELF'] ?>">Nueva baja</a>]</p>
		<?php
	}
$resultado->free(); 
$db->close();
}catch (Exception $e){
	echo $e->getMessage();
	if (mysqli_connect_errno() == 0)
		$db->close();
	exit();
}
} else {
$idencuesta=$_GET['id']; 
$textoRespuesta=$_GET['textoRespuesta']; 

try{
	@ $db = new mysqli('localhost', 'root', 'root1');
	if (mysqli_connect_errno() != 0)
		throw new Exception('Error conectando:'.mysqli_connect_error(), mysqli_connect_errno());
	
	$db->select_db('encuestas');
	if ($db->errno != 0)
		throw new Exception('Error seleccionando bd:'.$db->error, $db->errno);
	
	$consulta = "delete from respuesta where idEncuesta='".$idencuesta."' and textoRespuesta='".$textoRespuesta."'";
	if ($db->query($consulta) === false)
		throw new ExcepcionEnTransaccion();
	$db->commit();
	
	$consulta = "select textoPregunta from encuesta where id=".$idencuesta;
	$resultado = $db->query($consulta);
	if ($db->errno != 0)
		throw new Exception('Error realizando consulta:'.$db->error, $db->errno);
	assert($resultado !== false);

	if ($resultado->num_rows > 0){
			echo '<table border="1">';
			echo'<tr>';echo'<th>TEXTOPREGUNTA</th>';echo'</tr>';
			while ($obj = $resultado->fetch_object()){
				LimpiaResultados($obj);
				echo'<tr>';echo'<td align="center">'.$obj->textoPregunta.'</td>';echo'</tr>';
			}
			echo'</table>';
		
		$consulta = "select idEncuesta,textoRespuesta,numeroRespuestas from respuesta where idEncuesta=".$idencuesta;
		$resultado = $db->query($consulta);
		if ($db->errno != 0)
			throw new Exception('Error realizando consulta:'.$db->error, $db->errno);
		assert($resultado !== false);

		if ($resultado->num_rows > 0){
				echo '<table border="1">';
				echo'<tr>';
					echo'<th>IDENCUESTA</th>';
					echo'<th>TEXTORESPUESTA</th>';
					echo'<th>NUMRESPUESTAS</th>';
				echo'</tr>';
				while ($obj = $resultado->fetch_object()){
					LimpiaResultados($obj);
					echo'<tr>';
						echo'<td align="center">'.$obj->idEncuesta.'</td>';
						echo'<td align="center">'.$obj->textoRespuesta.'</td>';
						echo'<td align="center">'.$obj->numeroRespuestas.'</td>';
					echo'</tr>';
				}
				echo'</table>';
		}	
		else echo '<p>No hay datos que mostrar</p>';	
	}
	else echo '<p>No hay datos que mostrar</p>';
	?>
		<p>[<a href="<?php echo $_SERVER['PHP_SELF'] ?>">Nueva baja</a>]</p>
	<?php
	$resultado->free(); 
	$db->close();
}catch (ExcepcionEnTransaccion $e){
	echo 'No se ha podido realizar la baja';
	$db->rollback();
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
