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
			<div class="item">
				<figure>
					<img
						src="images\1.PNG"
						alt="producto"
					/>
				</figure>
				<div class="info-product">
					<h2>Cover coraline</h2>
					<p class="price">$30.000</p>
					<button>Añadir al carrito</button>
				</div>
			</div>
			<div class="item">
				<figure>
					<img
						src="images\2.PNG"
						alt="producto"
					/>
				</figure>
				<div class="info-product">
					<h2>Cover peluche</h2>
					<p class="price">$20.000</p>
					<button>Añadir al carrito</button>
				</div>
			</div>
			<div class="item">
				<figure>
					<img
						src="images\3.PNG"
						alt="producto"
					/>
				</figure>
				<div class="info-product">
					<h2>Cover tornasol</h2>
					<p class="price">$50.000</p>
					<button>Añadir al carrito</button>
				</div>
			</div>
			<div class="item">
				<figure>
					<img
						src="images\4.PNG"
						alt="producto"
					/>
				</figure>
				<div class="info-product">
					<h2>Cover corazón</h2>
					<p class="price">$20.000</p>
					<button>Añadir al carrito</button>
				</div>
			</div>
			<div class="item">
				<figure>
					<img
						src="images\5.PNG"
						alt="producto"
					/>
				</figure>
				<div class="info-product">
					<h2>Cover Karolg</h2>
					<p class="price">$50.000</p>
					<button>Añadir al carrito</button>
				</div>
			</div>

            <div class="item">
				<figure>
					<img
						src="images\6.PNG"
						alt="producto"
					/>
				</figure>
				<div class="info-product">
					<h2>Cover Karolg</h2>
					<p class="price">$50.000</p>
					<button>Añadir al carrito</button>
				</div>
			</div>

            <div class="item">
				<figure>
					<img
						src="images\7.PNG"
						alt="producto"
					/>
				</figure>
				<div class="info-product">
					<h2>Cover 2Pac</h2>
					<p class="price">$50.000</p>
					<button>Añadir al carrito</button>
				</div>
			</div>

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