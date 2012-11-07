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
        <title>Selecciona encuesta</title>
    </head>
<body>
<h1>SELECCIONA UNA ENCUESTA</h1>
<?php
try{
	@ $db = new mysqli('localhost', 'root', 'root1');
	if (mysqli_connect_errno() != 0)
		throw new Exception('Error conectando:'.mysqli_connect_error(), mysqli_connect_errno());
	
	$db->select_db('encuestas');
	if ($db->errno != 0)
		throw new Exception('Error seleccionando bd:'.$db->error, $db->errno);
		
	$consulta = "select id,textoPregunta from encuesta where id IN (select idEncuesta from respuesta)";
	$resultado = $db->query($consulta);
	if ($db->errno != 0)
		throw new Exception('Error realizando consulta:'.$db->error, $db->errno);
	assert($resultado !== false);
	
	if ($resultado->num_rows > 0){
			echo '<ul>';
			while ($obj = $resultado->fetch_object()){
				LimpiaResultados($obj);
				echo '<li>';
					echo '#'.$obj->id.' ';
					echo '<a href="ver_encuesta.php?id='.$obj->id.'">'.$obj->textoPregunta.'</a>';
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
include('../aspecto/pie.html');
?>
</body>
</html>
