<?php
	function EscribeParrafo($texto, $estilo='texto_normal') {
		echo '<div class='.$estilo.'>'.$texto.'</div>';
	}
	function DibujaMenuBotones($menu_botones_enlace, $estilo='menu_botones_enlace') {
		echo '<div class='.$estilo.'>';
			foreach ($menu_botones_enlace as $descripcion => $enlace)
				echo '<a href="'.$enlace.'"><span>'.$descripcion.'</span></a>';
		echo '</div>';
	}
	function dibuja(){
		include('../aspecto/cabecera.html');
		echo '<br>';echo '<br>';
		$menu = array('Inicio'=>'../ppal/principal.php');
		DibujaMenuBotones($menu,'menu_botones_enlace2');
		$menu = array('Validar usuario'=>'../ppal/valida_us.php');
		DibujaMenuBotones($menu,'menu_botones_enlace1');
		echo '<br>';echo '<br>';
	
		$menu = array('Alta usuario'=>'../usuarios/alta.php','Buscar usuario' =>'../usuarios/buscar.php','Eliminar usuario'=>'../usuarios/eliminar.php', 'Eliminar usuario1'=>'../usuarios/eliminar1.php', 'Ordenar usuarios'=>'../usuarios/ordenar.php', 'Modificar usuario'=>'../usuarios/modificar.php');
		DibujaMenuBotones($menu);
		echo '<br>';
		
		$menu = array('Alta encuesta'=>'../encuesta/alta_e.php','Buscar encuesta'=>'../encuesta/buscar_e.php','Eliminar encuesta'=>'../encuesta/eliminar_e.php', 'Ordenar encuesta'=>'../encuesta/ordenar_e.php', 'Modificar encuesta'=>'../encuesta/modificar_e.php');
		DibujaMenuBotones($menu);
		echo '<br>';
		
		$menu = array('Alta respuestas encuesta'=>'../respuestas/alta_encuesta_respuestas.php','Buscar respuestas encuesta'=>'../respuestas/buscar_encuesta_respuestas.php','Elimina respuestas encuesta'=>'../respuestas/eliminar_encuesta_respuestas.php','Ordenar respuestas encuesta'=>'../respuestas/ordenar_encuesta_respuestas.php','Modificar respuestas encuesta'=>'../respuestas/modificar_encuesta_respuestas.php');
		DibujaMenuBotones($menu);
		echo '<br>';
		
		$menu = array('Selecciona encuesta'=>'../responde/selecciona_encuesta.php');
		DibujaMenuBotones($menu);
		echo '<br>';
	}
?>