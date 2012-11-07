<aside id="principal_derecho" >
	
	<!--Facebook-->
	<?php 
		//Se usa para decirle al módulo de Facebook que página mostrar.
		$nombre_fb="VideoclubArgent";
		$caras_fb="true";
	?>	
	<script language="javascript">
		function ancho_principal_derecho() {
		ancho_principal_derecho = window.getComputedStyle(document.getElementById("principal_derecho"), null).getPropertyCSSValue("width").cssText;
		caja=document.getElementById("fbbox");
		caja.setAttribute("data-width",ancho_principal_derecho);
		
		} 
	</script>

		<section class="interior_modulo">
			<div id="fb-root"></div>
				<script>(function(d, s, id) {
				  var js, fjs = d.getElementsByTagName(s)[0];
				  if (d.getElementById(id)) return;
				  js = d.createElement(s); js.id = id;
				  js.src = "//connect.facebook.net/es_LA/all.js#xfbml=1&appId=106642799431442";
				  fjs.parentNode.insertBefore(js, fjs);
				}(document, 'script', 'facebook-jssdk'));
				</script>
			<div id="fbbox" class="fb-like-box" data-href="https://www.facebook.com/<?php echo $nombre_fb ?>" data-show-faces="<?php echo $caras_fb ?>" data-stream="true" data-header="true"></div>
		</section>
	<!--Fin Facebook -->
		
<!-- fin principal_derecho -->
</aside>