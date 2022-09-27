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
	<link href="assets/css/pages/login/classic/login-4.css" rel="stylesheet" type="text/css" />
	<link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
	<link href="assets/plugins/custom/prismjs/prismjs.bundle.css" rel="stylesheet" type="text/css" />
	<link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
	<link href="assets/css/themes/layout/header/base/light.css" rel="stylesheet" type="text/css" />
	<link href="assets/css/themes/layout/header/menu/light.css" rel="stylesheet" type="text/css" />
	<link href="assets/css/themes/layout/brand/dark.css" rel="stylesheet" type="text/css" />
	<link href="assets/css/themes/layout/aside/dark.css" rel="stylesheet" type="text/css" />

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
        <div class="content opacity-null">
            <ul class="div-categoria collapsible">
                <li v-for="(itemCategoria, i) in categorias" :key="i">
                    <label class="collapsible-header title-categoria sfs-18 style-italic bold-600">{{itemCategoria.name_categoria}}</label>
                    <div class="collapsible-body" v-for="(itemProductos, j) in productos" :key="j" 
                        v-if="itemCategoria.id_categoria==itemProductos.id_categoria">
                        <div class="div-producto">
                            <div>
                                <p class="title-producto sfs-15 style-normal bold-600">{{itemProductos.titulo}}</p>
                                <p class="title-producto text-right sfs-15 style-normal bold-600">${{itemProductos.precio}}.00</p>
                            </div>
                            <p class="title-producto sfs-15 style-normal bold-400" v-if="itemProductos.descripcion!='0'">{{itemProductos.descripcion}}</p>
                        </div>
                    </div>
                    
                </li>
            </ul>
        </div>
        <!-- <div class="swiper tabs-swiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide" v-for="(itemCategoria, i) in categorias" :key="i">
                    <h5 class="">{{itemCategoria.name_categoria}}</h5>
                </div>
            </div>
        </div> -->
        <!-- <ul class="collapsible">
            <li class="" >
                <div class="collapsible-header">{{itemCategoria.name_categoria}}</div>
                <div v-for="(itemProductos, j) in productos" :key="j" 
                    v-if="itemCategoria.id_categoria==itemProductos.id_categoria" 
                    class="collapsible-body">
                    <span>{{itemProductos.titulo}}</span>
                </div>
            </li>
        </ul> -->
	</div>
	<footer>

	</footer>
</body>
<script>

var menu = new Vue({
    el: '#menu',
    name: 'menu',
    data() {
        return {
            categorias: <?php include APP.'modelos/custom/categorias.php'?>,
            productos: <?php include APP.'modelos/custom/productos.php'?>,
        }
    }, 
    created() {
        this.loadData();
        if(this.categorias){
            console.log('CATEGORÍAS VACÍO');
        }else{
            console.log('CATEGORÍAS LLENO');
        }
    },
    watch:{
        "categorias"(newValue, oldValue){
            if(newValue==null){
                console.log('CATEGORÍAS VACÍO');
            }else{
                console.log('CATEGORÍAS LLENO');
            }
        },
    },
    methods:{
        loadData(callback) {
            const VUETHIS_SUB = this;
            $.get("/puerta_norte/aplicacion/modelos/custom/categorias.php")
            .done(function(response) {
                let json_response;
                try {
                    json_response = JSON.parse(response);
                } catch (error) {
                    json_response = null;
                    console.log('ERROR: '+json_response);
                }
                if(json_response) {
                    VUETHIS_SUB.altasEmpleados = json_response;
                    if(callback)
                        callback();
                        VUETHIS_SUB.setTitleCountPage();
                    } else {
                        console.log('ERROR EN VUE 1'+JSON.stringify(json_response));
                    }
            }).fail(function() {
                console.log('ERROR EN VUE 2');
            });
        }
    }
});
</script>
</html>