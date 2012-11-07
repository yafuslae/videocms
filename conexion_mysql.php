<?php
	function conectar_a_bd(){
	@ $db = mysqli_connect('127.0.0.1', 'root', 'root');
	mysqli_select_db($db, 'videocms');
	mysqli_query($db,"insert into a values('n5555887564ombre')");
	}
?>