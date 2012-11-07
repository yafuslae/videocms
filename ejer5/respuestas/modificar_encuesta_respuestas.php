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
	<title>Modificacion de respuestas de encuesta</title>
</head>
<body>
<?php
if( (isset($_GET['id'])===false )&&(isset($_GET['id1'])===false )&&(isset($_GET['modifica'])===false ) ) {
try{
	@ $db = new mysqli('localhost', 'root', 'root1');
	if (mysqli_connect_errno() != 0)
		throw new Exception('Error conectando:'.mysqli_connect_error(), mysqli_connect_errno());
	
	$db->select_db('encuestas');
	if ($db->errno != 0)
		throw new Exception('Error seleccionando bd:'.$db->error, $db->errno);
		
	$consulta = "select id,textoPregunta from encuesta";
	$resultado = $db->query($consulta);
	if ($db->errno != 0)
		throw new Exception('Error realizando consulta:'.$db->error, $db->errno);
	assert($resultado !== false);
	
	if ($resultado->num_rows > 0){
			echo '<table border="1">';
			echo'<tr>';
				echo'<th>IDENCUESTA</th>';
				echo'<th>TEXTOPREGUNTA</th>';
			echo'</tr>';
			while ($obj = $resultado->fetch_object()){
				LimpiaResultados($obj);
				echo'<tr>';
					echo'<td align="center">'.$obj->id.'</td>';
					echo'<td align="center">'.$obj->textoPregunta.'</td>';
					echo'<td align="center">'.'<a href="'. $_SERVER['PHP_SELF']."?id=".$obj->id .'">Modifica</a>'.'</td>';
				echo'</tr>';
			}
			echo'</table>';
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
} else if( (isset($_GET['id'])===true )&&(isset($_GET['id1'])===false )&&(isset($_GET['modifica'])===false ) ) {
$idencuesta=$_GET['id'];
try{
	@ $db = new mysqli('localhost', 'root', 'root1');
	if (mysqli_connect_errno() != 0)
		throw new Exception('Error conectando:'.mysqli_connect_error(), mysqli_connect_errno());
	
	$db->select_db('encuestas');
	if ($db->errno != 0)
		throw new Exception('Error seleccionando bd:'.$db->error, $db->errno);
		
	$consulta = "select id,idEncuesta,textoRespuesta,numeroRespuestas from respuesta where idEncuesta=".$idencuesta;
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
						echo'<td align="center">'.'<a href="'. $_SERVER['PHP_SELF']."?id1=".$obj->id .'">Modifica</a>'.'</td>';
					echo'</tr>';
				}
				echo'</table>';
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
} else if( (isset($_GET['id1'])===true )&&(isset($_GET['modifica'])===false ) ) {
$idrespuesta=$_GET['id1'];
?>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="get">
	<input type="hidden" name="idrespuesta" value="<?php echo $idrespuesta?>"/>
	<TABLE>
		<TR>
			<TD>TextoRespuesta:</TD>
			<TD><INPUT TYPE="text" NAME="textoRespuesta" SIZE="20" MAXLENGTH="30"></TD>
		</TR>
	</TABLE>
	<INPUT TYPE="submit" NAME="modifica" VALUE="Modifica">
</FORM>
<?php
} else  {
$idrespuesta=$_GET['idrespuesta'];
$textoRespuesta=$_GET['textoRespuesta'];

try{
	@ $db = new mysqli('localhost', 'root', 'root1');
	if (mysqli_connect_errno() != 0)
		throw new Exception('Error conectando:'.mysqli_connect_error(), mysqli_connect_errno());
	
	$db->select_db('encuestas');
	if ($db->errno != 0)
		throw new Exception('Error seleccionando bd:'.$db->error, $db->errno);
	
	$consulta = "update respuesta set textoRespuesta='".$textoRespuesta."' where id='".$idrespuesta."'";
	if ($db->query($consulta) === false)
		throw new ExcepcionEnTransaccion();
	$db->commit();
	
	$consulta = "select idEncuesta from respuesta where id='".$idrespuesta."'";
	$resultado = $db->query($consulta);
	if ($db->errno != 0)
		throw new Exception('Error realizando consulta:'.$db->error, $db->errno);
	assert($resultado !== false);
	
	if ($resultado->num_rows > 0){
				while ($obj = $resultado->fetch_object()){
					LimpiaResultados($obj);
					$rdo=$obj->idEncuesta;
				}
				echo'</table>';
	}	
	else echo '<p>No hay datos que mostrar</p>';
	
	$consulta = "select idEncuesta,textoRespuesta,numeroRespuestas from respuesta where idEncuesta=".$rdo;
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
	<p>[<a href="<?php echo $_SERVER['PHP_SELF'] ?>">Nueva modificacion</a>]</p>
	<?php
	$resultado->free(); 
	$db->close(); 
}catch (ExcepcionEnTransaccion $e){
	echo 'No se ha podido realizar al alta';
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