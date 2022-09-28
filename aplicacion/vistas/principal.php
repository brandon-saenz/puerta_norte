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
                                    <p class="title-producto sfs-15 style-normal bold-600">{{dataModal[0].nombreProducto}}</p>
                                    <p class="title-producto text-right sfs-15 style-normal bold-600">${{dataModal[0].precioProducto}}.00</p>
                                </div>
                                <p class="title-producto sfs-15 style-normal bold-400" v-if="dataModal[0].descripcionProducto!='0'">{{dataModal[0].descripcionProducto}}</p>
                            </div>
                            <div class="col s12 div-number">
                                <button class="btn btn-page waves-dark wood-bg" onclick="addNumber('-')"><i class="material-icons sfs-2">remove</i></button>
                                <span id="number-count" class="text-center sfs-15 style-normal bold-600 century wood-cl">1</span>
                                <button class="btn btn-page waves-dark wood-bg" onclick="addNumber('+')"><i class="material-icons sfs-2">add</i></button>
                            </div>
                            <div class="col s12 div-follow">
                                <button id="step-1" class="btn btn-page wood-bg century white-cl sfs-13" onclick="gotoPageModal(1)">SIGUIENTE</button>
                            </div>
                        </div>

                        <!-- AGREGAR ALGUNA NOTA ESPECIFICA -->
                        <div class="swiper-slide row">
                            <div class="div-addnote-modal col s12">
                                <div>
                                    <p class="title-producto sfs-15 style-normal bold-600">¿Deseas agregar una nota al chef?</p>
                                </div>
                                <p class="title-producto text-left sfs-13 style-normal bold-400">Si necesitas quitar o agregar un ingrediente adicional, puedes comentarlo aquí.</p>
                            </div>
                            <div id="addnote-options" class="">
                                <button class="btn btn-page btn-page-nota col wood-bg century white-cl sfs-13" onclick="gotoPageModal(2)">NO GRACIAS</button>
                                <button class="btn btn-page btn-page-nota col wood-bg century white-cl sfs-13" onclick="showInputAddNote(1)">SI NECESITO ALGO MÁS</button>
                            </div>
                            <div id="div-custom-addnote" class="input-field col s12 div-custom-textarea none">
                                <textarea id="nota_producto" class="materialize-textarea custom-textarea"></textarea>
                                <div class="col s12 div-follow">
                                    <button class="btn btn-page wood-bg century white-cl sfs-13" onclick="gotoPageModal(3)">SIGUIENTE</button>
                                </div>
                            </div>
                        </div>

                        <!-- AÑADIR A LA LISTA DE PEDIDOS -->
                        <div class="swiper-slide">
                            <div class="div-producto-modal col s12">
                                <div>
                                    <p id="step-3-nameProducto" class="title-producto sfs-15 style-normal bold-600">{{dataModal[0].nombreProducto}}</p>
                                    <p class="title-producto text-right sfs-15 style-normal bold-600">${{dataModal[0].precioProducto}}.00</p>
                                </div>
                            </div>
                            <div class="col s12">
                                <span id="label-modal-total" class="text-center sfs-15 style-normal bold-600 wood-cl century">TOTAL: $180.00</span>
                            </div>
                            <div class="col s12 div-follow">
                                <button class="btn btn-page wood-bg century white-cl sfs-13" @click="agregarProducto()">AGREGAR AL PEDIDO</button>
                            </div>
                        </div>

                        <!-- LISTA DE PEDIDOS -->
                        <div class="swiper-slide">
                            <div class="div-producto-modal col s12">
                                <div v-for="(itemListProduct, i) in lista_productos" :key="i">
                                    <p id="step-3-nameProducto" class="title-producto sfs-15 style-normal bold-600">{{itemListProduct.cantidadProducto}} X {{itemListProduct.nombreProducto}}</p>
                                    <p class="title-producto text-right sfs-15 style-normal bold-600">${{itemListProduct.precioProducto}}.00</p>
                                </div>
                            </div>
                            <div class="col s12">
                                <span id="label-modal-total" class="text-center sfs-15 style-normal bold-600 wood-cl century">TOTAL: $180.00</span>
                            </div>
                            <div class="col s12 div-follow">
                                <button class="btn btn-page wood-bg century white-cl sfs-13" @click="agregarProducto()">SOLICITAR PEDIDO</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
          
        <div class="content opacity-null">
            <ul class="div-categoria collapsible">
                <li v-for="(itemCategoria, i) in categorias" :key="i">
                    <label class="collapsible-header title-categoria sfs-15 style-italic bold-600">{{itemCategoria.name_categoria}}</label>

                    <div @click="selectProduct(i,j)" class="collapsible-body" v-for="(itemProductos, j) in productos" :key="j" 
                        v-if="itemCategoria.id_categoria==itemProductos.id_categoria">
                        <div class="div-producto">
                            <div>
                                <p class="title-producto sfs-13 style-normal bold-600">{{itemProductos.titulo}}</p>
                                <p class="title-producto text-right sfs-13 style-normal bold-600">${{itemProductos.precio}}.00</p>
                            </div>
                            <p class="title-producto sfs-13 style-normal bold-400" v-if="itemProductos.descripcion!='0'">{{itemProductos.descripcion}}</p>
                        </div>
                    </div>
                    
                </li>
            </ul>
        </div>
	</div>
	<footer>

	</footer>
</body>
<script>

document.addEventListener("DOMContentLoaded", function() {
    $('#modal-select-product').modal({
        onCloseEnd: refillModalProducto
    });
});

function modalOpen(){
    console.log('modalOpen'+menu.base_url);
}

function gotoPageModal(index){
    slideToIndex(modal_product_swiper, index, 500);
    var label_modal_total=document.getElementById('label-modal-total');
    label_modal_total.innerHTML='TOTAL: $'+menu.dataModal[0].precioProducto*menu.dataModal[0].cantidadProducto+'.00';
}

function addNumber(type){
    let number_count=document.getElementById('number-count');
    let counter=number_count.innerHTML;
    let step_1=document.getElementById('step-1');
    if(type=='+'){
        counter++;
        number_count.innerHTML=counter;
        sumaModalProducto(counter);
        step_1.classList.remove('disabled');
    }else{
        counter--;
        number_count.innerHTML=counter;
        sumaModalProducto(counter);
        if(counter==0){
            step_1.classList.add('disabled');
        }
    }
}

function sumaModalProducto(counter){
    menu.dataModal[0].cantidadProducto=counter;
    let label_modal_total=document.getElementById('label-modal-total');
    let step_3_nameProducto=document.getElementById('step-3-nameProducto');

    label_modal_total.innerHTML='TOTAL: $'+menu.dataModal[0].precioProducto*menu.dataModal[0].cantidadProducto+'.00';
    step_3_nameProducto.innerHTML=menu.dataModal[0].cantidadProducto+' X '+menu.dataModal[0].nombreProducto;
    // cantidadProducto
}

function showInputAddNote(bool){

    let div_addnote_modal=document.querySelector('.div-addnote-modal');
    
    let div_custom_addnote=document.getElementById('div-custom-addnote');
    let addnote_options=document.getElementById('addnote-options');

    if(bool==1){
        div_custom_addnote.classList.remove('none');
        addnote_options.classList.add('none');
        div_addnote_modal.classList.add('div-addnote-modal-none');
        
    }else{
        div_custom_addnote.classList.add('none');
        addnote_options.classList.remove('none');
        div_addnote_modal.classList.remove('div-addnote-modal-none');
    }
}

function refillModalProducto(){
    menu.dataModal[0].cantidadProducto=1;
    var number_count=document.getElementById('number-count');
    number_count.innerHTML=1;
    showInputAddNote(0);
    gotoPageModal(0);
}

var menu = new Vue({
    el: '#menu',
    name: 'menu',
    data() {
        return {
            categorias: [],
            productos: [],
            dataModal: [
                {
                    'nombreProducto': 'nombre',
                    'descripcionProducto': 'descripcion',
                    'precioProducto': 'precio',
                    'cantidadProducto': 1
                }
            ],
            lista_productos:[],
            base_url: '/puertanorte/aplicacion/modelos/custom',
        }
    }, 
    created() {
        this.loadCategorias();
    },
    watch:{
        "categorias"(newValue, oldValue){
            
        },
    },
    methods:{
        agregarProducto(){
            console.log('agregarProducto');
            // $('#modal-select-product').modal('close');
            // refillModalProducto();

            var obj = new Object();
            obj.nombreProducto = this.dataModal[0].nombreProducto;
            obj.descripcionProducto  = this.dataModal[0].descripcionProducto;
            obj.precioProducto = this.dataModal[0].precioProducto;
            obj.cantidadProducto = this.dataModal[0].cantidadProducto;

            this.lista_productos.push(obj);
            console.log('Data: '+JSON.stringify(this.lista_productos));

            gotoPageModal(4);
        },
        selectProduct(iCategoria,iProducto){
            var step_3_nameProducto=document.getElementById('step-3-nameProducto');
            // console.log('selectProduct: '+this.categorias[iCategoria].name_categoria+'|'+JSON.stringify(this.productos[iProducto]));
            console.log('selectProduct: '+this.categorias[iCategoria].name_categoria+'|'+this.productos[iProducto].titulo);
            this.dataModal[0].nombreProducto=this.productos[iProducto].titulo;
            this.dataModal[0].descripcionProducto=this.productos[iProducto].descripcion;
            this.dataModal[0].precioProducto=this.productos[iProducto].precio;
            step_3_nameProducto.innerHTML=this.dataModal[0].cantidadProducto+' X '+this.dataModal[0].nombreProducto;
            $('#modal-select-product').modal('open');
        },
        loadCategorias(callback) {
            const VUETHIS_SUB = this;
            $.get(this.base_url+"/categorias.php")
            .done(function(response) {
                let json_response;
                try {
                    json_response = JSON.parse(response);
                } catch (error) {
                    json_response = null;
                    console.log('ERROR: '+json_response);
                }
                if(json_response) {
                    VUETHIS_SUB.categorias = json_response;
                    if(callback)
                        callback();
                        console.log('loadCategorias - OK');
                        VUETHIS_SUB.loadProductos();
                    } else {
                        console.log('ERROR EN VUE 1'+JSON.stringify(json_response));
                    }
            }).fail(function() {
                console.log('ERROR EN VUE 2');
            });
        },
        loadProductos(callback) {
            const VUETHIS_SUB = this;
            $.get(this.base_url+"/productos.php")
            .done(function(response) {
                let json_response;
                try {
                    json_response = JSON.parse(response);
                } catch (error) {
                    json_response = null;
                    console.log('ERROR: '+json_response);
                }
                if(json_response) {
                    VUETHIS_SUB.productos = json_response;
                    if(callback)
                        callback();
                        console.log('loadProductos - '+VUETHIS_SUB.productos.length);
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