<?php 
require('../aspecto/libreria.inc');
dibuja();
function LimpiaResultados($objeto){
	foreach ($objeto as $atributo => $valor)
		if(is_string($objeto->$atributo) === true)
			$objeto->$atributo = stripslashes($objeto->$atributo);
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Buscar encuestas</title>
</head>
<body>
<?php
if (isset($_GET['busca'])===false) {
?>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="get">
	<TABLE>
		<TR>
			<TD>ID Encuesta:</TD>
			<TD><INPUT TYPE="text" NAME="id" SIZE="20" MAXLENGTH="30"></TD>
		</TR>
	</TABLE>
	<INPUT TYPE="submit" NAME="busca" VALUE="Busca">
</FORM>
<?php
} else {
$idencuesta=$_GET['id']; 
try{
	@ $db = new mysqli('localhost', 'root', 'root1');
	if (mysqli_connect_errno() != 0)
		throw new Exception('Error conectando:'.mysqli_connect_error(), mysqli_connect_errno());
	
	$db->select_db('encuestas');
	if ($db->errno != 0)
		throw new Exception('Error seleccionando bd:'.$db->error, $db->errno);
		
	$consulta = "select id, textoPregunta from encuesta where id='".$idencuesta."'";
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
	else
			echo '<p>No hay datos que mostrar</p>';
	?>
	<p>[<a href="<?php echo $_SERVER['PHP_SELF'] ?>">Nueva busqueda</a>]</p>
	<?php
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
