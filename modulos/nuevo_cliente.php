<link rel="stylesheet" type="text/css" href="estilos/registro_cliente.css" title="style">

<section id="registro_cliente" class="modulo">
	<li class="titulo_modulo">Registro de nuevo cliente</li>
	<!-- Comprueba que el botón Enviar está true, si no (else) pinta todo el formulario. Si está true preguntará al usuario si son los datos correctos
		después de mostrarlos -->
	<section class="interior_modulo">
	<?php
	//Mostrar resumen si Enviar ha sido pulsado y no hay errores de comprobación de datos.
		if (isset($_POST['enviar'])===true){
			$nombre = $_POST['nombre'];
			$apellido1 = $_POST['apellido1'];
			$apellido2 = $_POST['apellido2'];
			$fnacimiento = $_POST['ano']."/".$_POST['mes']."/".$_POST['dia'];
			$dni = $_POST['dni'];
			$telefono = $_POST['telefono'];
			$ciudad = $_POST['ciudad'];
			$calle = $_POST['calle'];
			$numero = $_POST['numero'];
			$puerta = $_POST['puerta'];
			$bloque= $_POST['bloque'];
	  	    $escalera= $_POST['escalera'];
			$usuario = $_POST['usuario'];
			$email = $_POST['email'];
			$remail = $_POST['repetir_email'];			
			$contrasena=$_POST['contrasena'];
			$rcontrasena=$_POST['repetir_contrasena'];
			

			//Arrays que recogen tipo de dato y su valor.
			$tipo_dato=array("Nombre","Apellido 1","Apellido 2","Fecha de nacimiento","DNI","Teléfono","Ciudad","Calle","Número","Puerta","Bloque","Escalera","Usuario","Email");
			$dato = array("$nombre","$apellido1","$apellido2","$fnacimiento","$dni","$telefono","$ciudad","$calle","$numero","$puerta","$bloque","$escalera","$usuario","$email");
			//Muestra resumen
			foreach($dato as $index=>$valor){
				print("<p>$tipo_dato[$index] : $valor  </p>");
			}//fin foreach
			
			?>
			
			<br>
			<input type="submit" name="modificar" value="Modificar" onClick='history.go(-1);' />
			<input type="submit" name="enviar_datos_a_usuario" value="Enviar" />	
			<?php
			}
		//Si no está true el botón Enviar muestrame el formulario.
		
		else{ ?>			
			<form method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>" id="form_reg_cli">
				
	            
	            <label for="nombre">Nombre</label> <input type="text" name="nombre" required />
				<br/>	            	
	            <label for="apellido1">Apellido 1º</label> <input type="text" name="apellido1" required/>
	            <br/>
	            <label for="apellido2">Apellido 2º</label> <input type="text" name="apellido2" required/>            
	            <br/>
	            <!-- Empieza el proceso para recoger la fecha de nacimiento -->
	            <label for="fecha_nacimiento">F.nacimiento</label>
	            
	            	<select name="dia">
	            		<?php
	            		for($i=1;$i<=31;$i++){
	            			
	            			?>
	            				<option value="<?php echo $i; ?>"><?php echo $i; ?> </option>
	            			<?php
	            		}
	            			?>
	
	            	</select>
	
	            	<select name="mes">
	            		<?php
	            		for($i=1;$i<=12;$i++){
	            			$meses = array("Enero", "Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	            			?>
	            				<option value="<?php echo $i; ?>"><?php echo $meses[$i - 1]; ?> </option>
	            			<?php
	            		}
	            			?>
	            	</select>
	            	
	            	<select name="ano">
	            		<?php
	            		for($i=date(Y);$i>=1900;$i--){
	            			
	            			?>
	            				<option value="<?php echo $i; ?>"><?php echo $i; ?> </option>
	            			<?php
	            		}
	            			?>
	            	</select>
	            <br>
	            	<!-- Variable que recogera la fecha en formato YYYY/mm/dd-->
	 
	            <label for="DNI">DNI</label> <input type="text" name="dni" maxlength="8" required/>            
	            <br/>
	            <label for="telefono">Teléfono</label> <input type="tel" name="telefono" required/>		            
	            <br/>           
	            <label for="ciudad">Ciudad</label >
	            <!-- Este select será sustituido por un acceso a una tabla de la base de datos donde indica que ciudades son permitidas y habrá
	             un for que irá añadiendolas una a una -->
	            <select name="ciudad">
	            	<option value="Bocairent">Bocairent</option>
	            	<option value="Ontinyent">Ontinyent</option>
	            	<option value="Albaida">Albaida</option>
	            </select><br>	            
	            <label for="calle">Calle</label> <input type="text" name="calle" required/><br/>              
	            <label for="numero">Número</label> <input type="text" name="numero" required/><br/>	            
	            <label for="puerta">Puerta</label> <input type="text" name="puerta"/><br/>            
	            <label for="bloque">Bloque</label> <input type="text" name="bloque"/><br/>                     
	            <label for="escalera">Escalera</label> <input type="text" name="escalera"/><br/><br/>        
	            <label for="usuario">Usuario</label> <input type="text" name="usuario" required/><br/>            
	            <label for="email">Email</label> <input type="email" name="email" required/><br/>
	            <label for="repetir_email">Repite el Email</label> <input type="email" name="repetir_email" required/><br/>
	            <label for="contrasena">Contraseña</label> <input type="password" name="contrasena" required/><br/>
	            <label for="repetir_contrasena">Repite la contraseña</label> <input type="password" name="repetir_contrasena" required/><br/>
	            <input type="submit" value="Enviar" name="enviar" id="enviar">
		   	    <input type="reset" value="Limpiar" name="limpiar" id="limpiar">   
			</form>
			<?php
	        }//fin else
			?>	
	</section> <!--fin interior_modulo -->
</section> <!--fin registro_cliente-->        