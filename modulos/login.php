<section class="modulo">
	<link rel="stylesheet" type="text/css" href="estilos/login.css" title="style">
	<li class="titulo_modulo">Menú de usuario </li>
		<div id="login" class="interior_modulo">
			<form>
				<p>Usuario</p>
				<input class="text_input" type="text" name="usuario" value=""  />
				<p>Contraseña</p>
				<input class="text_input" type="password" name="password" /> 
				<br>
				<input type="submit" value="Conectarse">
				<p id="recordar_password"><a href="www.google.es">He olvidado mi contraseña</a></p>
				<p id="registrarse">¿Aún no tiene cuenta?<br>Puede registrase <a onclick="$('#escaparate').load('modulos/nuevo_cliente.php');">aquí.</a></p>
			</form>
		<!--fin login-->	
		</div>
	<!-- fin modulo -->
</section>
<!--notas:
	Hacer un send password.
-->