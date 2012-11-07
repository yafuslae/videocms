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
	<title>Modificacion de encuestas</title>
</head>
<body>
<?php
if( (isset($_GET['id'])===false )&&(isset($_GET['modifica'])===false ) ) {
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
} else if( (isset($_GET['id'])===true )&&(isset($_GET['modifica'])===false ) ) {
$id=$_GET['id'];
?>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="get">
	<TABLE>
		<TR>
			<TD>ID:</TD>
			<TD><INPUT TYPE="text" NAME="id" SIZE="20" MAXLENGTH="30" value="<?php echo $id ?>" readonly></TD>
		</TR>
		<TR>
			<TD>textoPregunta:</TD>
			<TD><INPUT TYPE="text" NAME="textoPregunta" SIZE="20" MAXLENGTH="30"></TD>
		</TR>
	</TABLE>
	<INPUT TYPE="submit" NAME="modifica" VALUE="Modifica">
</FORM>
<?php
} else { 
$id=$_GET['id'];
$textoPregunta=$_GET['textoPregunta'];

try{
	@ $db = new mysqli('localhost', 'root', 'root1');
	if (mysqli_connect_errno() != 0)
		throw new Exception('Error conectando:'.mysqli_connect_error(), mysqli_connect_errno());
	
	$db->select_db('encuestas');
	if ($db->errno != 0)
		throw new Exception('Error seleccionando bd:'.$db->error, $db->errno);
	
	$consulta = "update encuesta set textoPregunta='".$textoPregunta."' where id='".$id."'";
	if ($db->query($consulta) === false)
		throw new ExcepcionEnTransaccion();
	$db->commit();
	
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