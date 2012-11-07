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
	<title>Alta respuestas encuesta</title>
</head>
<body>
<?php
if ((isset($_GET['establecer'])===false)&&(isset($_GET['enviar'])===false)) {
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
				<label>Número de respuestas de la nueva encuesta: </label>
				<input type="text" name="numeroRespuestas" />
				<INPUT TYPE="submit" NAME="establecer" VALUE="Establecer">
		</FORM>
	<?php	
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
}else if ((isset($_GET['establecer'])===true)&&(isset($_GET['enviar'])===false)) {
$id=$_GET['id'];
$numeroRespuestas=$_GET['numeroRespuestas'];
?>
	<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="get">
		<input type="hidden" name="id" value="<?php echo $id?>"/>
		<input type="hidden" name="numeroRespuestas" value="<?php echo $numeroRespuestas?>"/>
		<p>Número de respuestas de la nueva encuesta: <?php echo $numeroRespuestas?></p>
		<?php
			$textosRespuesta = array();
			for ($i = 0;$i < $numeroRespuestas;$i++){
				echo '<label>Respuesta '.sprintf("%02d", $i+1).': </label>';
				if ($textosRespuesta != null)
					echo '<input type="text" name="textoRespuesta'.$i.'" value="'.stripslashes($textosRespuesta[$i]).'" size="100"/>';
				else
					echo '<input type="text" name="textoRespuesta'.$i.'" value="" size="100"/>';
				echo '<br/>';
			}
		?>
        <input type="submit" name="enviar" value="Enviar"/>
    </form>
<?php
} else {
$id=$_GET['id'];
$numeroRespuestas=$_GET['numeroRespuestas'];
$textosRespuesta = array();
for ($i = 0;$i < $numeroRespuestas;$i++)
    $textosRespuesta[] = addslashes($_GET['textoRespuesta'.$i]);
try{
	@ $db = new mysqli('localhost', 'root', 'root1');
	if (mysqli_connect_errno() != 0)
		throw new Exception('Error conectando:'.mysqli_connect_error(), mysqli_connect_errno());
	
	$db->select_db('encuestas');
	if ($db->errno != 0)
		throw new Exception('Error seleccionando bd:'.$db->error, $db->errno);
	
	if ($db->autocommit(false) === false)
		throw new Exception('El motor no admite transacciones');
	for ($i = 0; $i < $numeroRespuestas;$i++){
        $consulta = "insert into respuesta(idEncuesta, textoRespuesta, numeroRespuestas) values (".$id.", '".$textosRespuesta[$i]."', 0)";
        if ($db->query($consulta) === false)
			throw new ExcepcionEnTransaccion();
    }
	$db->commit();
	
	$consulta = "select idEncuesta,textoRespuesta,numeroRespuestas from respuesta where idEncuesta=".$id;
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
	?>
	<p>[<a href="<?php echo $_SERVER['PHP_SELF'] ?>">Nueva alta</a>]</p>
	<?php
	$resultado->free(); 
	$db->close(); 
}catch (ExcepcionEnTransaccion $e){
	echo 'No se ha podido realizar el alta';
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
