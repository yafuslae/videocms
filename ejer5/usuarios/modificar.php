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
	<title>Modificacion de usuarios</title>
</head>
<body>
<?php
if( (isset($_GET['id'])===false )&&(isset($_GET['modifica'])===false ) ) {
@ $db = mysqli_connect('localhost', 'root', 'root1');
CompruebaErrorConexionMySQL('Error conectando con la bd');
mysqli_select_db($db, 'encuestas');
CompruebaErrorMySQL('Error seleccionando la BD', $db);

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
			echo'<td align="center">'.'<a href="'. $_SERVER['PHP_SELF']."?id=".$fila['login'] .'">Modifica</a>'.'</td>';
		echo'</tr>';
	}
	echo'</table>';
}
else
	echo '<p>No hay datos que mostrar</p>';
mysqli_free_result($resultado);
mysqli_close($db);
} else if( (isset($_GET['id'])===true )&&(isset($_GET['modifica'])===false ) ) {
$login=$_GET['id'];
?>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="get">
	<input type="hidden" name="id" value="<?php echo $login ?>" />
	<TABLE>
		<TR>
			<TD>Login:</TD>
			<TD><INPUT TYPE="text" NAME="login" SIZE="20" MAXLENGTH="30" value="<?php echo $login ?>" readonly></TD>
		</TR>
		<TR>
			<TD>Password:</TD>
			<TD><INPUT TYPE="text" NAME="password" SIZE="20" MAXLENGTH="30"></TD>
		</TR>
		<TR>
			<TD>Tipousuario:</TD>
			<TD><select name="tipousuario">
					<option value="votante" selected="selected">Votante</option>
					<option value="administrador">Administrador</option>
				</select>
			</TD>
		</TR>
	</TABLE>
	<INPUT TYPE="submit" NAME="modifica" VALUE="Modifica">
</FORM>
<?php
} else { 
$login=$_GET['id'];
$password=$_GET['password'];
$tipousuario=$_GET['tipousuario'];

@ $db = mysqli_connect('localhost', 'root', 'root1');
CompruebaErrorConexionMySQL('Error conectando con la bd');
mysqli_select_db($db, 'encuestas');
CompruebaErrorMySQL('Error seleccionando la BD', $db);

mysqli_query($db,"update usuario set password='".$password."', tipoUsuario='".$tipousuario."' where login='".$login."'");
CompruebaErrorMySQL('Error realizando la consulta1', $db);

$resultado = mysqli_query($db, "select login, password, tipoUsuario from usuario");
CompruebaErrorMySQL('Error realizando la consulta2', $db);
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
			echo'<td align="center">'.'<a href="'. $_SERVER['PHP_SELF']."?id=".$fila['login'] .'">Modifica</a>'.'</td>';
		echo'</tr>';
	}
	echo'</table>';
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