<!DOCTYPE html>
<html lang="en">
<head>
	<base href="<?php echo STASIS; ?>/">
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Puerta Norte</title>

	<script
		src="https://code.jquery.com/jquery-3.6.1.js"
		integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI="
		crossorigin="anonymous"></script>

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css"/>
	<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js">Vue.config.silent = true</script>

    <link href="assets/css/materialize.css" rel="stylesheet" type="text/css" />
    <script src="assets/js/materialize.js" type="text/javascript"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

	<script src="assets/js/script.js" type="text/javascript"></script>
	<link href="assets/css/style.css" rel="stylesheet" type="text/css" />

	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />

</head>
<body>
	<div id="menu">
		<div class="intro div-center">
			<svg class="logo opacity-null" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 136.12">
				<path class="draw-logo" d="M22.7,58.1s-9.13-2-10.14-7.1,1-8.11,1-8.11S19.66,29.7,37.92,24.63s34.48-6.08,39.56,6.09-9,27.2-9,27.2S40.38,90.49,16.61,78.39"/>
				<path class="draw-logo" d="M8.5,104.76s26.37-45.64,47.67-68"/>
				<path class="draw-logo" d="M71.9,68.76s-4.06,5.07-2,9.12S92.18,67.74,92.18,67.74l1.2-.83.16.16-2.32,2L88.71,71.6s-2.61,5.27-.58,9.33,7.1,1.72,7.1,1.72l18.25-9.84v5.07A15.32,15.32,0,0,0,121.56,75c4.8-3.42,3.08-6.26,3.08-6.26s-2-5.08-6.08-1-5.08,10.14-5.08,10.14-1,7.11,9.13,6.09,20.57-9.17,20.57-9.17L140.87,84,152,72.81s7.1-7.1,6.09-1,6.08,6.08,6.08,6.08,12.17,1,20.29-1c0,0,30.43-40.57,66.95-66.95,0,0-41.59,30.43-65.94,68,0,0-6.08,8.12,4.06,4.06s25.36-8.11,25.36-8.11l-3,3s-6,8.35,3,6.09c5.3-1.33,11-5.25,14.37-7.81,1.77-1.36,2.87-2.34,2.87-2.34s4.06-7.1-4-6.08a22.33,22.33,0,0,0-13.19,7.1"/>
				<path class="draw-logo" d="M229.29,75.15l5.92-4.37s.76-.61.78.39S231.43,77,231.43,77s-3.84,5.16,1.21,5.46,24.82-11.33,24.82-11.33"/>
				<path class="draw-logo" d="M168.58,37.93s41.22-14.56,93.51-1.13"/>
				<path class="draw-logo" d="M313.57,24,276.39,98.66s.43,2,2.1.62S290,82.51,290,82.51s8.5-15.42,38.33-40.84,24.34-10.56,24.34-10.56-15.52,29.63-32.17,71L313,122.43s-.3,3.21.6,4.42"/>
				<path class="draw-logo" d="M355,68.63l-3.35,1.67s-8.77,8.49-.88,11S360,71.77,360,71.77l-4.77-2.86.13-.17a52.43,52.43,0,0,0,13.35,5C376.31,75.42,384,72.2,384,72.2l-2.65,9.07,6.76-5.84,3.21-2.86s8-8.82,6.68,0,27.22,4,27.22,4"/>
				<path class="draw-logo" d="M492,8.77S476,17.4,443.25,55.12A138.3,138.3,0,0,0,426.8,74.38c-7.62,10.93,1.3,8,1.3,8l21-4.11s17.46-4.21,15.95-9-6.22-2.61-6.22-2.61S448.07,75.48,455,82.76s32.3-8.58,32.3-8.58"/>
				<path class="draw-logo" d="M410,37.93s41.22-14.56,93.51-1.13"/>
				<text class="slogan-logo opacity-null" transform="translate(35.8 114.81)">cocina y tradición</text>
			</svg>
			<div class="loader-spin center opacity-null"><span></span></div>
		</div>
        <div id="modal-select-product" class="modal bottom-sheet">
            <div class="modal-content">
                <div class="swiper modal-product-swiper">
                    <div class="swiper-wrapper">

                        <!-- SELECCIONAR PLATILLO O BEBIDA -->
                        <div class="swiper-slide row">
                            <div class="div-producto-modal col s12">
                                <div>
                                    <p class="title-producto sfs-14 style-normal bold-600">{{dataModal[0].nombreProducto}}</p>
                                    <p class="title-producto text-right sfs-14 style-normal bold-600">${{dataModal[0].precioProducto}}.00</p>
                                </div>
                                <p class="title-producto descripcion-producto sfs-15 style-normal bold-400" v-if="dataModal[0].descripcionProducto!='0'">{{dataModal[0].descripcionProducto}}</p>
                            </div>
                            <div class="col s12 div-follow">
                                <div class="col s12 div-number div-center">
                                    <button class="btn btn-page btn-plus waves-dark wood-bg" onclick="addNumber('-')"><i class="material-icons sfs-2">remove</i></button>
                                    <span id="number-count" class="text-center sfs-15 style-normal bold-600 century wood-cl">1</span>
                                    <button class="btn btn-page btn-plus waves-dark wood-bg" onclick="addNumber('+')"><i class="material-icons sfs-2">add</i></button>
                                </div>
                                <button id="step-1" class="btn btn-page wood-bg century white-cl sfs-13" onclick="gotoPageModal(1)">SIGUIENTE</button>
                            </div>
                        </div>

                        <!-- AGREGAR ALGUNA NOTA ESPECIFICA -->
                        <div class="swiper-slide row">
                            <button class="btn btn-back waves-dark white-bg" onclick="gotoPageModal(0)"><i class="material-icons sfs-3 wood-cl">chevron_left</i></button>
                            <div class="div-addnote-modal col s12">
                                <div>
                                    <p class="title-producto sfs-15 style-normal bold-600">¿Deseas agregar una nota al chef?</p>
                                </div>
                                <p id="describe-nota" class="title-producto text-left sfs-13 style-normal bold-400">Si necesitas quitar o agregar un ingrediente adicional, puedes comentarlo aquí.</p>
                            </div>
                            <div id="addnote-options" class="">
                                <button id="no-add-nota" class="btn btn-page btn-page-nota col wood-bg century white-cl sfs-13" @click="noAddNota()">NO GRACIAS</button>
                                <button id="si-add-nota" class="btn btn-page btn-page-nota col wood-bg century white-cl sfs-13" @click="siAddNota()">SI NECESITO ALGO MÁS</button>
                                <textarea id="nota-producto" class="materialize-textarea custom-textarea none"></textarea>
                                <button id="follow-nota" class="btn btn-page btn-page-nota col wood-bg century white-cl sfs-13 none" onclick="gotoPageModal(2)">SIGUIENTE</button>
                            </div>
                        </div>

                        <!-- VISTA PARA AÑADIR AL RESUMEN DE ORDEN -->
                        <div class="swiper-slide row">
                            <button class="btn btn-back waves-dark white-bg" onclick="gotoPageModal(1)"><i class="material-icons sfs-3 wood-cl">chevron_left</i></button>
                            <div class="div-resume-modal col s12">
                                <div>
                                    <p id="step-3-nameProducto" class="title-producto sfs-15 style-normal bold-600">{{dataModal[0].nombreProducto}}</p>
                                    <p class="title-producto text-right sfs-15 style-normal bold-600">${{dataModal[0].precioProducto}}.00</p>
                                </div>
                                <p class="title-producto sfs-13 style-italic bold-400" v-if="dataModal[0].quiero_agregar_nota!='0'">
                                    <span class="sfs-13 style-normal bold-600">Nota: </span>"{{dataModal[0].nota}}"</p>
                            </div>
                            <div class="col s12 text-center" style="margin-block: 2rem;">
                                <span id="step-3-subtotal" class="text-center sfs-15 style-normal bold-600 wood-cl century"></span>
                            </div>
                            <div class="col s12 div-follow">
                                <button class="btn btn-page col wood-bg century white-cl sfs-13" @click="agregarProducto()">AGREGAR A LA ORDEN</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="modal-alert" class="modal">
            <div class="modal-content">
                <div class="col s12 div-center">
                    <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                        <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
                        <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                    </svg>
                </div>
                <p class="col s12 century wood-cl sfs-15 text-center">SE AGREGÓ A TU ORDEN</p>
            </div>
        </div>
          
        <div class="content opacity-null">
            <div style="position: fixed; width: 100%; z-index: 900;">
                <nav>
                    <a href="#" data-target="slide-main" class="sidenav-trigger"><i class="material-icons">menu</i></a>
                    <a href="#" class="div-center">
                        <svg class="nav-logo" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 136.12">
                            <path class="draw-logo" d="M22.7,58.1s-9.13-2-10.14-7.1,1-8.11,1-8.11S19.66,29.7,37.92,24.63s34.48-6.08,39.56,6.09-9,27.2-9,27.2S40.38,90.49,16.61,78.39"/>
                            <path class="draw-logo" d="M8.5,104.76s26.37-45.64,47.67-68"/>
                            <path class="draw-logo" d="M71.9,68.76s-4.06,5.07-2,9.12S92.18,67.74,92.18,67.74l1.2-.83.16.16-2.32,2L88.71,71.6s-2.61,5.27-.58,9.33,7.1,1.72,7.1,1.72l18.25-9.84v5.07A15.32,15.32,0,0,0,121.56,75c4.8-3.42,3.08-6.26,3.08-6.26s-2-5.08-6.08-1-5.08,10.14-5.08,10.14-1,7.11,9.13,6.09,20.57-9.17,20.57-9.17L140.87,84,152,72.81s7.1-7.1,6.09-1,6.08,6.08,6.08,6.08,12.17,1,20.29-1c0,0,30.43-40.57,66.95-66.95,0,0-41.59,30.43-65.94,68,0,0-6.08,8.12,4.06,4.06s25.36-8.11,25.36-8.11l-3,3s-6,8.35,3,6.09c5.3-1.33,11-5.25,14.37-7.81,1.77-1.36,2.87-2.34,2.87-2.34s4.06-7.1-4-6.08a22.33,22.33,0,0,0-13.19,7.1"/>
                            <path class="draw-logo" d="M229.29,75.15l5.92-4.37s.76-.61.78.39S231.43,77,231.43,77s-3.84,5.16,1.21,5.46,24.82-11.33,24.82-11.33"/>
                            <path class="draw-logo" d="M168.58,37.93s41.22-14.56,93.51-1.13"/>
                            <path class="draw-logo" d="M313.57,24,276.39,98.66s.43,2,2.1.62S290,82.51,290,82.51s8.5-15.42,38.33-40.84,24.34-10.56,24.34-10.56-15.52,29.63-32.17,71L313,122.43s-.3,3.21.6,4.42"/>
                            <path class="draw-logo" d="M355,68.63l-3.35,1.67s-8.77,8.49-.88,11S360,71.77,360,71.77l-4.77-2.86.13-.17a52.43,52.43,0,0,0,13.35,5C376.31,75.42,384,72.2,384,72.2l-2.65,9.07,6.76-5.84,3.21-2.86s8-8.82,6.68,0,27.22,4,27.22,4"/>
                            <path class="draw-logo" d="M492,8.77S476,17.4,443.25,55.12A138.3,138.3,0,0,0,426.8,74.38c-7.62,10.93,1.3,8,1.3,8l21-4.11s17.46-4.21,15.95-9-6.22-2.61-6.22-2.61S448.07,75.48,455,82.76s32.3-8.58,32.3-8.58"/>
                            <path class="draw-logo" d="M410,37.93s41.22-14.56,93.51-1.13"/>
                            <text class="slogan-logo opacity-null" transform="translate(35.8 114.81)">cocina y tradición</text>
                        </svg>
                    </a>
                    <a href="#" data-target="slide-ordenes" class="sidenav-trigger">
                        <i id="icon-badge-cantidad-productos" class="material-icons">restaurant_menu</i>
                        <span id="badge-cantidad-productos" class="badge-data"></span>
                    </a>
                </nav>
                <nav class="div-tab-categoria">
                    <div id="into-div-tab">
                        <span v-bind:id="'tab_categoria-'+i" class="tab-categoria sfs-11 bold-600" 
                            v-for="(tabCategoria, i) in tabs_categorias" :key="i" @click="selectTab(i)">
                            {{tabCategoria.title_tab}}
                        </span>
                    </div>
                </nav>
            </div>

            <nav></nav>
            <section class="div-tab-categoria"></section>

            <ul id="slide-main" class="sidenav">
              <li><a href="#!">OPCION 1</a></li>
              <li><div class="divider"></div></li>
              <li><a class="subheader">OPCION 2</a></li>
              <li><a class="waves-effect" href="#!">OPCION 3</a></li>
            </ul>

            <ul id="slide-ordenes" class="sidenav">
                <li><p class="wood-cl century sfs-13 text-center">RESUMEN DE ORDEN</p></li>
                <li><div class="divider"></div></li>

                <div class="swiper side-orden">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            
                            <!-- LABEL EN CASO DE QUE ESTÉ LA ORDEN VACÍA -->
                            <div v-if="total_orden==0" class="div-center side-text-vertical-center">
                                <p class="wood-cl century sfs-11 text-center">LOS PLATILLOS QUE AGREGUES SE MOSTRARÁN AQUÍ</p>
                            </div>
            
                            <!-- LISTA DE PRODUCTOS AGREGADOS -->
                            <div class="li-orden-producto" v-if="total_orden!=0">
                                <div class="div-orden-producto" v-for="(itemListProduct, i) in lista_productos" :key="i">
                                    <p class="title-producto sfs-12 style-normal bold-500">{{itemListProduct.cantidadProducto}} X {{itemListProduct.nombreProducto}}</p>
                                    <p class="title-producto text-right sfs-12 style-normal bold-500">${{itemListProduct.precioProducto}}.00</p>
                                </div>
                            </div>
                            <div v-if="total_orden!=0"><div class="divider"></div></div>
                            
                            <!-- PRECIO TOTAL DE LA ORDEN -->
                            <div>
                                <p id="step-4-total" class="text-center sfs-15 style-normal bold-600 wood-cl century"></p>
                            </div>
                            
                            <!-- BOTON PARA CONTINUAR CON LA ORDEN -->
                            <div class="div-continuar-orden" v-if="total_orden!=0">
                                <button class="btn btn-page wood-bg century white-cl sfs-10" @click="cancelarResumenOrden()">CANCELAR</button>
                                <br>
                                <button class="btn btn-page wood-bg century white-cl sfs-10" onclick="slideToIndex(side_orden_swiper, 1, 500)">CONTINUAR</button>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            
                        </div>
                    </div>
                </div>
            </ul>

            <div class="swiper tabs-swiper">
                <div class="swiper-wrapper">

                    <!-- LISTA DE PLATILLOS -->
                    <div class="swiper-slide" v-for="(tabCategoria, i) in tabs_categorias" :key="i">
                        <div v-for="(itemCategoria, j) in categorias" :key="j" 
                            v-if="itemCategoria.id_tab==tabCategoria.id_tab">
                            <p class="title-categoria sfs-15 style-italic bold-600">{{itemCategoria.name_categoria}}</p>
                            
                            <!-- LISTA POR CATEGORÍA -->
                            <div class="swiper lista-productos-swiper">
                                <div class="swiper-wrapper">
                                    <div @click="selectProduct(j,k)" class="swiper-slide" v-for="(itemProductos, k) in productos" :key="k" 
                                        v-if="itemCategoria.id_categoria==itemProductos.id_categoria">
                                        <div class="div-producto">
                                            <div>
                                                <p class="title-producto sfs-12 style-normal bold-600">{{itemProductos.titulo}}</p>
                                                <p class="title-producto text-right sfs-11 style-normal bold-600">${{itemProductos.precio}}.00</p>
                                            </div>
                                            <p class="title-producto sfs-11 style-normal bold-400" v-if="itemProductos.descripcion!='0'">{{itemProductos.descripcion}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                            </div>
                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>
	<footer>

	</footer>
</body>
<?php include_once(APP . 'vistas/js/js-principal.php'); ?>
</html>