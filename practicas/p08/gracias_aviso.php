<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		<title>Registro Completado</title>
		<style type="text/css">
			body {margin: 20px; 
			background-color: #C4DF9B;
			font-family: Verdana, Helvetica, sans-serif;
			font-size: 90%;}
			h1 {color: #005825;
			border-bottom: 1px solid #005825;}
			h2 {font-size: 1.2em;
			color: #4A0048;}
		</style>
	</head>
	<body>
		<h1>MUCHAS GRACIAS</h1>

		<p>Gracias por registrar el producto &#174;. Hemos recibido la siguiente información de tu registro:</p>

		<h2>Acerca de ti:</h2>
		<ul>
			<li><strong>Nombre:</strong> <em><?php echo $_POST['name']; ?></em></li>
			<li><strong>E-mail:</strong> <em><?php echo $_POST['marca']; ?></em></li>
			<li><strong>Télefono:</strong> <em><?php echo $_POST['modelo']; ?></em></li>
			<li><strong>Télefono:</strong> <em><?php echo $_POST['precio']; ?></em></li>
			<li><strong>Télefono:</strong> <em><?php echo $_POST['unidades']; ?></em></li>
			<li><strong>Imagen:</strong> <em><?php echo $_POST['imagen']; ?></em></li>
           <img src="<?php echo $_POST['imagen']; ?>" alt="Imagen del producto" width="200">


		</ul>
		<p><strong>Descripción:</strong> <em><?php echo $_POST['detalle']; ?></em></p>


		<p>
		    <a href="http://validator.w3.org/check?uri=referer"><img
		      src="http://www.w3.org/Icons/valid-xhtml10" alt="Valid XHTML 1.0 Strict" height="31" width="88" /></a>
		</p>
	</body>
</html>