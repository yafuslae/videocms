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
        <title>Valida usuario</title>
    </head>
<body>
<?php
	 if (isset($_GET['valida']) === true){
		$login=$_GET['login'];
		$password=$_GET['password'];
		try{
			@ $db = new mysqli('localhost', 'root', 'root1');
			if (mysqli_connect_errno() != 0)
				throw new Exception('Error conectando:'.mysqli_connect_error(), mysqli_connect_errno());
			
			$db->select_db('encuestas');
			if ($db->errno != 0)
				throw new Exception('Error seleccionando bd:'.$db->error, $db->errno);
				
			$consulta = "select login,password from usuario where login='".$login."' and password='".$password."'";
			$resultado = $db->query($consulta);
			if ($db->errno != 0)
				throw new Exception('Error realizando consulta:'.$db->error, $db->errno);
			assert($resultado !== false);
			
			if ($resultado->num_rows > 0){
					while ($obj = $resultado->fetch_object()){
						LimpiaResultados($obj);
						echo '<br>';echo '<br>';
						EscribeParrafo('Aplicacion web encuestas','texto_cabecera3');
					}
				}
			else 
				echo '<p>Login y password incorrectos</p>';
				
			$resultado->free(); 
			$db->close(); 
		}catch (Exception $e){
			echo $e->getMessage();
			if (mysqli_connect_errno() == 0)
				$db->close();
			exit();
		}
	}
	else{
?>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="get">
	<TABLE>
		<TR>
			<TD>Login:</TD>
			<TD><INPUT TYPE="text" NAME="login" SIZE="20" MAXLENGTH="30"></TD>
		</TR>
		<TR>
			<TD>Password:</TD>
			<TD><INPUT TYPE="text" NAME="password" SIZE="20" MAXLENGTH="30"></TD>
		</TR>
	</TABLE>
	<INPUT TYPE="submit" NAME="valida" VALUE="Valida">
</FORM>
<?php
}
include('../aspecto/pie.html');
?>
</body>
</html>
