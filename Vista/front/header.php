<div class="header">

    <div class="container">
        <div class="row">
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col logo_section">
                <div class="full">
                    <div class="center-desk">
                        <div class="logo">
                            <a href="index.html"><img src="Recursos/img/empresa/<?= $res[1]; ?>" alt="#"></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9">
                <div class="menu-area">
                    <div class="limit-box">
                        <nav class="main-menu">
                            <ul class="menu-area-main">
                                <li class="active"> <a href="index.php">Inicio</a> </li>
                                <li><a href="login.php">Login</a></li>
                                <li><a href="tienda.php">Tienda</a></li>
                                <li> <a href="nosotros.php">Nosotros</a> </li>
                                <li class="last">
                                    <a href="#"><img src="Recursos/img/search_icon.png" alt="icon" /></a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="col-sm-5"></div>
            <div class="col-sm-5">
                <div class="location_icon_bottum">
                    <ul>
                        <li><img src="Recursos/img/icon/call.png" /><?= $res[3]; ?></li>
                        <li><img src="Recursos/img/icon/email.png" /><?= $res[2]; ?></li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="container-icon float-right">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="icon-cart">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                    </svg>
                    <div class="count-products">
                        <span id="contador-productos">0</span>
                    </div>

                    <div class="container-cart-products hidden-cart">
                        <div class="cart-product">
                            <div class="info-cart-product">
                                <span class="cantidad-producto-carrito">1</span>
                                <p class="titulo-producto-carrito">Cover 1</p>
                                <span class="precio-producto-carrito">$30.000</span>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="icon-close">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </div>
                        <div class="cart-total">
                            <h3>Total:</h3>
                            <span class="total-pagar">$200</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>