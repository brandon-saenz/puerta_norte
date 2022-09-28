<script>
document.addEventListener("DOMContentLoaded", function() {
    initWS();
    $('#modal-select-product').modal({
        onCloseEnd: refillModalProducto
    });
});

function enviarTexto(event){
    event.preventDefault();
    event.stopPropagation();

    var campo=event.target.texto;

    doSend(campo.value);
    campo.value="";

}

function initWS(){
    wsConnect();
}

function wsConnect(){
    websocket=new WebSocket("ws://localhost:3000");

    //asignacion de los Callbacks
    websocket.onopen=function(evt){
        onOpen(evt);
    }
    websocket.onclose=function(evt){
        onClose(evt);
    }
    websocket.onmessage=function(evt){
        onMessage(evt);
    }
    websocket.onerror=function(evt){
        onError(evt);
    }
}

function onOpen(evt){
    console.log('OPEN WS CONNECTION'+evt);
    doSend("Mensaje desde el cliente");
}

function onClose(evt){
    console.log('CLOSE WS CONNECTION'+evt);
    setTimeout(function(){
        wsConnect();
    }, 2000);
}

function onMessage(evt){
    console.log('MESSAGE FROM WS CONNECTION'+evt);
}

function onError(evt){
    console.log('TRONÓ WS CONNECTION'+evt);
}

function doSend(mensaje){
    websocket.send(mensaje);
}

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