<link rel="stylesheet" type="text/css" href="estilos/registro_cliente.css" title="style">

<section id="registro_cliente" class="modulo">
	<li class="titulo_modulo">Registro de nuevo cliente</li>
	<!-- Comprueba que el botón Enviar está true, si no (else) pinta todo el formulario. Si está true preguntará al usuario si son los datos correctos
		después de mostrarlos -->
	<section class="interior_modulo">
		<?php

	   //Comprobaciones de campos
	   
	   //Variables globales 
	   $error = false;
	   $nombre_error = "";
	   $apellido1_error = "";
	   $apellido2_error = "";
	   //--> Aquí variable fnacimiento
	   $dni_error= "";
	   $telefono_error= "";
	   $calle_error= "";
	   $numero_error= "";
	   $puerta_error= "";
	   $bloque_error= "";
	   $escalera_error= "";
	   $letra_error= "";
	   $escalera_error= "";
	   $usuario_error= "";
	   $email_error = "";
	   $remail_error = "";	   
	   $contrasena_error="";
	   $rcontrasena_error="";
	   
	   
	   //Al pulsar enviar comprobará uno a uno que no tengan un error de formato.
	   if (isset($_POST['enviar'])){
			$nombre = $_POST['nombre'];
			$apellido1 = $_POST['apellido1'];
			$apellido2 = $_POST['apellido2'];
			//$dato = $_POST['fecha_nacimiento'];
			$dni = $_POST['dni'];
			$telefono = $_POST['telefono'];
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
			
		  
		  //Nombre 
	      if (trim($nombre) == ""){
	         $nombre_error = "El campo Nombre no puede estar vacio.";
	         $error = true;
	      }else
	         $nombre_error = "";
		  
		  //Apellido1
		  if (trim($apellido1) == ""){
	         $apellido1_error = "El campo Apellido 1º no puede estar vacio.";
	         $error = true;
	      }else
	         $apellido1_error = "";
	      
		  //Apellido2   
		  if (trim($apellido2) == ""){
	         $apellido2_error = "El campo Apellido 2º no puede estar vacio.";
	         $error = true;
	      }else
	         $apellido2_error = "";		
		  
		  //Aquí ira fnacimiento y será largo.
		  
		  //DNI
		  if (!preg_match("^[0-9]{8}+$^", $dni)){
			 $dni_error="DNI no valido.";
			 $error=true;
		  }else
			    $dni_error = "";
		  
		  //Teléfono
		  if (!preg_match("^[0-9]{8}+$^", $telefono)){
			 $telefono_error="Teléfono no valido.";
			 $error=true;
		  }else
			    $telefono_error = "";		
		  
		  //Calle
		  if (trim($calle) == ""){
			 $calle_error="El campo Calle no puede estar vacio.";
			 $error=true;
		  }else
			    $calle_error = "";
		  	
		  //Número	  
		  if (!preg_match("^[0-9]{1,4}+$^", $numero)){
			 $numero_error="Número no valido.";
			 $error=true;
		  }else
			    $numero_error = "";	
		  
		  //Puerta	   
		  if (!preg_match("^[a-zA-Z0-9]{0,3}+$^", $puerta)){
			 $puerta_error="Puerta no valida.";
			 $error=true;
		  }else
			    $puerta_error = "";		
		
		  //Bloque			    
		  if (!preg_match("^[a-zA-Z0-9]{0,2}+$^", $bloque)){
			 $bloque_error="Formato no valido .";
			 $error=true;
		  }else
			    $bloque_error = "";	
		  
		  //Escalera		    
		  if (!preg_match("^[a-zA-Z0-9]{0,1}+$^", $escalera)){
			 $escalera_error="Formato no valido.";
			 $error=true;
		  }else
			    $escalera_error = "";		
		
		  //Usuario con doble comprobación
		  if (!preg_match("^[a-zA-Z0-9_\.\-]{3,}+$^", $usuario)){
			 $usuario_error="No valido. Contiene menos de 3 carácteres.";
			 $error=true;
		  }else
			    $usuario_error = "";
		  
		  //ereg está deprecated
		  //Email
		  if (!preg_match("^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$^", $email)){
			 $email_error="Email no valido.";
			 $error=true;
		  }else{
			 if($email!==$remail){
			  $remail_error="El email no coincide.";	
			 }else{
			 	$remail_error = "";
			 }		  	
			 $email_error = "";	
			 
		  }
		  //Contraseña
		  if (!preg_match("^[a-zA-Z0-9_\.\-]{6,}+$^", $contrasena)){
			 $contrasena_error="No valido.Es menor de 6 carácteres.";
			 $error=true;
		  }else{
			 if($contrasena!==$rcontrasena){
			  $rcontrasena_error="La contraseña no coincide.";	
			 }else{
			 	$rcontrasena_error = "";
			 }	
			 $contrasena_error = "";	
		  }
		  	    		   
	   } //Fin del if de comprobaciones de campos

	   //Fin comprobaciones de campos
	   
		//Mostrar resumen si Enviar ha sido pulsado y no hay errores de comprobación de datos.
		if (isset($_POST['enviar'])===true && $error==false){
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
			}
			
			?>
			
			<br>
			<input type="submit" name="modificar" value="Modificar" onClick='history.go(-1);' />
			<input type="submit" name="enviar_datos_a_usuario" value="Enviar" />

			<?php
			
			
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
?>			<?php
			if(isset($_POST['enviar_datos_a_usuario'])===true){
				echo "Conseguido";
				@ $db = mysqli_connect('127.0.0.1', 'root', 'root');
				CompruebaErrorConexionMySQL('Error conectando con la bd');
				mysqli_select_db($db, 'videocms');
				CompruebaErrorMySQL('Error seleccionando la BD', $db);
				/*mysqli_query($db,"insert into usuarios(nombre,apellido1,apellido2,fnacimiento,dni,telefono,ciudad,calle,numero,puerta,usuario,email,contrasena,tipo_usuario) 
				values('nombre','apellido1','apellido2','1985/2/10','48600517','12345678','ciudad','calle','1','6','usuariuuuu','email','contrasena','admin')");*/
				mysqli_query($db,"insert into a values('n5555887564ombre')");
				CompruebaErrorMySQL('Error realizando el alta', $db);
				
			}
			else{
				echo $fnacimiento;
			}
			
		}//fin if de mostrar resumen de datos.
		
		//Si no está true el botón Enviar muestrame el formulario.
		else{ ?>
		
		
			<form method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>" id="form_reg_cli">
				
	            
	            <label for="nombre">Nombre</label> <input type="text" name="nombre" />
		            <?php
						if ($nombre_error != "")
				    		print ("$nombre_error");
					?>
				<br/>	            	
	            <label for="apellido1">Apellido 1º</label> <input type="text" name="apellido1"/>
	            	<?php
						if ($apellido1_error != "")
				    		print ("$apellido1_error");
					?>
	            <br/>
	            <label for="apellido2">Apellido 2º</label> <input type="text" name="apellido2"/>
	            	<?php
						if ($apellido2_error != "")
				    		print ("$apellido2_error");
					?>	            
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
	 
	            <label for="DNI">DNI</label> <input type="text" name="dni" maxlength="8"/>
	            	<?php
						if ($dni_error != "")
				    		print ("$dni_error");
					?>	            
	            <br/>
	            <label for="telefono">Teléfono</label> <input type="tel" name="telefono"/>
	            	<?php
						if ($telefono_error != "")
				    		print ("$telefono_error");
					?>		            
	            <br/>           
	            <label for="ciudad">Ciudad</label>
	            <!-- Este select será sustituido por un acceso a una tabla de la base de datos donde indica que ciudades son permitidas y habrá
	             un for que irá añadiendolas una a una -->
	            <select name="ciudad">
	            	<option value="Bocairent">Bocairent</option>
	            	<option value="Ontinyent">Ontinyent</option>
	            	<option value="Albaida">Albaida</option>
	            </select><br>	            
	            <label for="calle">Calle</label> <input type="text" name="calle"/>
					<?php
						if ($calle_error != "")
				    		print ("$calle_error");
					?>	            
	            <br/>              
	            <label for="numero">Número</label> <input type="text" name="numero"/>
					<?php
						if ($numero_error != ""){
				    		print ("$numero_error");
						}
					?><br/>	            
	            <label for="puerta">Puerta</label> <input type="text" name="puerta"/>
	            	<?php
						if ($puerta_error != "")
				    		print ("$puerta_error");
					?>	
					<br/>            
	            <label for="bloque">Bloque</label> <input type="text" name="bloque"/>
	            	<?php
						if ($bloque_error != "")
				    		print ("$bloque_error");
					?>	   
					<br/>                     
	            <label for="escalera">Escalera</label> <input type="text" name="escalera"/>
	            	<?php
						if ($escalera_error != "")
				    		print ("$escalera_error");
					?>	    
					<br/><br/>        
	            <label for="usuario">Usuario</label> <input type="text" name="usuario"/>
	            	<?php
						if ($usuario_error != "")
				    		print ("$usuario_error");
					?>	
					<br/>            
	            <label for="email">Email</label> <input type="email" name="email"/>
	            	<?php
						if ($email_error != ""){
				    		print ("$email_error");
						}
					?><br/>
	            <label for="repetir_email">Repite el Email</label> <input type="email" name="repetir_email"/>
	            	<?php
						if ($remail_error != "")
				    		print ("$remail_error");
					?>		            
	            <br/>
	            <label for="contrasena">Contraseña</label> <input type="password" name="contrasena"/>
	            	<?php
						if ($contrasena_error != "")
				    		print ("$contrasena_error");
					?>	
	            <br/>
	            <label for="repetir_contrasena">Repite la contraseña</label> <input type="password" name="repetir_contrasena"/>
	            	<?php
						if ($rcontrasena_error != "")
				    		print ("$rcontrasena_error");
					?>	
	            <br/>
	            <input type="submit" value="Enviar" name="enviar" id="enviar">
		   	    <input type="reset" value="Limpiar" name="limpiar" id="limpiar">   
	        </form>
	        <?php
	        }//fin else
			?>
	</section><!--fin class="interior_modulo" -->
</section> <!--fin id="registro_cliente" -->
