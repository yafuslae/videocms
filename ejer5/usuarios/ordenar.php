<?php 
require('../aspecto/libreria.inc');
dibuja();
function LimpiaResultados(&$fila){
	foreach ($fila as $campo => $valor)
		if(is_string($valor) === true)
		$fila[$campo] = stripslashes($fila[$campo]);
}
function CompruebaErrorConexionMySQL($mensaje){
	if (mysqli_connect_errno() != 0){
		echo $mensaje.' :'.mysqli_connect_error();
		exit();
	}
}
function CompruebaErrorMySQL($mensaje, $conexion){
	if (mysqli_errno($conexion) != 0){
		echo $mensaje.' :'.mysqli_error($conexion);
		mysqli_close($conexion);
		exit();
	}
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Ordenar usuarios</title>
</head>
<body>
<?php
if (isset($_GET['ordena'])===false) {
?>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="get">
	<p>Ordena por: 
	<select name="criterio_ord">
			<option value="login" >login</option>	
			<option value="tipoUsuario" >tipousuario</option>			
	</select>
	</p>
	<INPUT TYPE="submit" NAME="ordena" VALUE="Ordena">
</FORM>
<?php
} else {
$criterio_ord=$_GET['criterio_ord']; 
@ $db = mysqli_connect('localhost', 'root', 'root1');
CompruebaErrorConexionMySQL('Error conectando con la bd');
mysqli_select_db($db, 'encuestas');
CompruebaErrorMySQL('Error seleccionando la BD', $db);

$resultado = mysqli_query($db, "select login, password, tipoUsuario from usuario order by ".$criterio_ord);
CompruebaErrorMySQL('Error realizando la consulta', $db);
assert($resultado !== false);
if (mysqli_num_rows($resultado) > 0){
	echo '<table border="1">';
	echo'<tr>';
		echo'<th>Login</th>';
		echo'<th>Password</th>';
		echo'<th>TipoUsuario</th>';
	echo'</tr>';
	while ($fila = mysqli_fetch_assoc($resultado)){
		LimpiaResultados($fila);
		echo'<tr>';
			echo'<td align="center">'.$fila['login'].'</td>';
			echo'<td align="center">'.$fila['password'].'</td>';
			echo'<td align="center">'.$fila['tipoUsuario'].'</td>';
		echo'</tr>';
	}
	echo'</table>';
?>
	<p>[<a href="<?php echo $_SERVER['PHP_SELF'] ?>">Nueva ordenacion</a>]</p>
<?php
}
else
	echo '<p>No hay datos que mostrar</p>';
mysqli_free_result($resultado);
mysqli_close($db);
}
include('../aspecto/pie.html');
?>
</body>
</html>
