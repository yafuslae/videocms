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
	<title>Eliminar usuarios</title>
</head>
<body>
<?php
if (isset($_GET['elimina'])===false) {
@ $db = mysqli_connect('localhost', 'root', 'root1');
CompruebaErrorConexionMySQL('Error conectando con la bd');
mysqli_select_db($db, 'encuestas');
CompruebaErrorMySQL('Error seleccionando la BD', $db);
$resultado = mysqli_query($db,"select login from usuario");
CompruebaErrorMySQL('Error realizando la consulta', $db);

if (mysqli_num_rows($resultado) > 0){
?>
	<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="get">
			<p>Login: 
			<select name="login">
<?php
	while ($fila = mysqli_fetch_assoc($resultado)){
		LimpiaResultados($fila);
?>
			<option value="<?php echo $fila['login'] ?>" ><?php echo $fila['login'] ?></option>		
<?php
	}
?>	
			</select>
			</p>
			<INPUT TYPE="submit" NAME="elimina" VALUE="Elimina usuario">
		</FORM>
<?php	
}
else
	echo '<p>No hay datos que mostrar</p>';
} else {
$login=$_GET['login']; 

@ $db = mysqli_connect('localhost', 'root', 'root1');
CompruebaErrorConexionMySQL('Error conectando con la bd');
mysqli_select_db($db, 'encuestas');
CompruebaErrorMySQL('Error seleccionando la BD', $db);

mysqli_query($db,"delete from usuario where login='".$login."'");
CompruebaErrorMySQL('Error realizando la baja', $db);
$resultado = mysqli_query($db, "select login, password, tipoUsuario from usuario");
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
	<p>[<a href="<?php echo $_SERVER['PHP_SELF'] ?>">Nueva baja</a>]</p>
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
