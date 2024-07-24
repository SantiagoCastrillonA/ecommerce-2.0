<!DOCTYPE html>
<html lang="es">

<head>
	<title>Tienda</title>
	<?php
	include 'Vista/front/head.php';
	?>
	<style type="text/css" id="operaUserStyle"></style>
</head>

<body>
	<?php
	include 'Vista/front/header.php';
	?>
	<header>
		<h1>Tienda</h1>
	</header>
	<div class="container-items">
		<?php
		$sqlConf = 'SELECT * FROM productos p where p.estado = 1';
		$resProductos = ejecutarSQL::consultar($sqlConf);
		while ($row = mysqli_fetch_array($resProductos)) {
		?>
			<div class="item">
				<figure>
					<img src="Recursos/img/productos/<?php echo $row['foto']; ?>" alt="producto" />
				</figure>
				<div class="info-product">
					<h2><?php echo $row['nombre_producto']; ?></h2>
					<p class="price">$<?php echo $row['precio']; ?></p>
					<button>Añadir al carrito</button>
				</div>
			</div>
		<?php
		};
		?>
	</div>

	<script src="index.js"></script>
	<!-- footer -->
	<footer>
		<?php
		include 'Vista/front/footer.php';
		?>
	</footer>
	<?php
	include 'Vista/front/scripts.php';
	?>

</body>

</html>