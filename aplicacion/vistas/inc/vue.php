<script>
document.addEventListener("DOMContentLoaded", function() {
    //initWS();
    $('#modal-select-product').modal({
        onCloseEnd: refillModalProducto
    });
});


function modalOpen(){
    console.log('modalOpen'+menu.base_url);
}

function gotoPageModal(index){
    slideToIndex(modal_product_swiper, index, 500);
    console.log('gotoPageModal: '+index);
    
    //STEP - 1 | SELECCIONAR CANTIDAD DE PRODUCTOS (- 1 +)
    if(index==0){
    }
    
    
    //STEP - 2 | IR A - DESEAS AGREGAR UNA NOTA AL CHEF
        //NO A NOTA
        //SI A NOTA

    // ACTION TO INDEX 1 | PREPARAR LA INFORMACIÓN DE STEP - 3
    else if(index==1){
        let step_3_subtotal=document.getElementById('step-3-subtotal');
        let step_3_nameProducto=document.getElementById('step-3-nameProducto');
        
        menu.dataModal[0].subtotal=menu.dataModal[0].precioProducto*menu.dataModal[0].cantidadProducto;
        step_3_subtotal.innerHTML='SUB TOTAL: $'+menu.dataModal[0].subtotal+'.00';
        step_3_nameProducto.innerHTML=menu.dataModal[0].cantidadProducto+' X '+menu.dataModal[0].nombreProducto;

    }
    //STEP - 3 | IR A - RESUMEN DE LO QUE QUIERO PEDIR (INDIVIDUALMENTE) / SUB TOTAL
    // ACTION TO INDEX 2 | PREPARAR LA INFORMACIÓN DE STEP - 4
    else if(index==2){
        
    }
    
    //STEP - 4 | IR A - LISTADO DE LA ORDEN GENERAL
    else if(index==3){
        
    }
    
    else if(index==4){
        
    }

    //EVENT - 5 | IR A - ORDENAR
}



function addNumber(type){
    let number_count=document.getElementById('number-count');
    let counter=number_count.innerHTML;
    let step_1=document.getElementById('step-1');
    if(type=='+'){
        counter++;
        number_count.innerHTML=counter;
        menu.dataModal[0].cantidadProducto=counter;
        // sumaModalProducto(counter);
        step_1.classList.remove('disabled');
    }else if(counter>0){
        counter--;
        number_count.innerHTML=counter;
        menu.dataModal[0].cantidadProducto=counter;
        // sumaModalProducto(counter);
        if(counter==0){
            step_1.classList.add('disabled');
        }
    }
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

function ordenar(){
        console.log('ORDENAR'+menu.lista_productos.length);
        var set_id_orden=parseInt(menu.last_id_orden)+1;
        
        $.ajax({ 
            type: "GET",
            url: menu.base_url+'/post/guardar_orden.php',
            data: { 
                total: menu.total_orden,
                nombre_ordenante: "Brandon"
            },
            beforeSend: function (params) {
                console.log('EN PROCESO...'+this.data);
            },
            success: function(data){
                for(var i=0; i<=menu.lista_productos.length-1; i++){
                    $.ajax({ 
                        type: "GET",
                        url: menu.base_url+'/post/guardar_item_orden.php',
                        data: { 
                            id_orden: set_id_orden,
                            id_producto: menu.lista_productos[i].idProducto,
                            cantidad: menu.lista_productos[i].cantidadProducto,
                            nota: 'menu.lista_productos[i].nota',
                            subtotal: menu.lista_productos[i].subtotal
                        },
                        beforeSend: function (params) {
                            console.log('EN PROCESO...'+this.data);
                        },
                        success: function(data){
                            console.log('SUCCESS');
                        },
                        complete:function(){
                            console.log('FIN DEL PROCESO');
                        },
                        error:function(data){
                            console.log('VALIÓ MALLE: 2'+data);
                        }  
                    });
                }
            },
            complete:function(){
                console.log('FIN DEL PROCESO');
            },
            error:function(data){
                console.log('VALIÓ MALLE: '+data);
            }  
        });
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
                    'idProducto': 0,
                    'nombreProducto': 'nombre',
                    'descripcionProducto': 'descripcion',
                    'precioProducto': 'precio',
                    'cantidadProducto': 1,
                    'quiero_agregar_nota': 0,
                    'subtotal':0,
                }
            ],
            lista_productos:[],
            sumatoria: [],
            total_orden: 0,
            last_id_orden: 0,
            base_url: '/puerta_norte/aplicacion/modelos/',
        }
    }, 
    created() {
        this.loadCategorias();
        this.loadLastIdOrdenes();
    },
    watch:{
        "total_orden"(newValue, oldValue){
            let step_4_total=document.getElementById('step-4-total');
            step_4_total.innerHTML='TOTAL: $'+newValue+'.00';
        },
    },
    methods:{
        agregarProducto(){
            console.log('agregarProducto');
            // $('#modal-select-product').modal('close');
            // refillModalProducto();

            //JSON CON LOS DATOS INDIVIDUALES DE UN PRODUCTO
            var obj = new Object();
            obj.idProducto = this.dataModal[0].idProducto;
            obj.nombreProducto = this.dataModal[0].nombreProducto;
            obj.descripcionProducto  = this.dataModal[0].descripcionProducto;
            obj.precioProducto = this.dataModal[0].precioProducto;
            obj.cantidadProducto = this.dataModal[0].cantidadProducto;
            obj.subtotal = this.dataModal[0].subtotal;

            //AGREGANDO EL JSON A UNA LISTA DE OBJETOS - PARA COLECCIONAR LA LISTA DE PRODUCTOS AGREGADOS POR EL CLIENTE
            this.lista_productos.push(obj);
            console.log('Data: '+JSON.stringify(this.lista_productos));
            
            //SUMATORIA DE TODOS LOS SUB TOTALES DE CADA PRODUCTO QUE AGREGA EL CLIENTE
            this.sumatoria.push(this.dataModal[0].subtotal);
            this.total_orden = this.sumatoria.reduce((a, b) => a + b, 0);
            
            console.log('SUMATORIA: '+this.total_orden);

            gotoPageModal(3);
        },
        selectProduct(iCategoria,iProducto){
            var step_3_nameProducto=document.getElementById('step-3-nameProducto');
            // console.log('selectProduct: '+this.categorias[iCategoria].name_categoria+'|'+JSON.stringify(this.productos[iProducto]));
            console.log('selectProduct: '+this.categorias[iCategoria].name_categoria+'|'+this.productos[iProducto].titulo);
            this.dataModal[0].idProducto=this.productos[iProducto].id_producto;
            this.dataModal[0].nombreProducto=this.productos[iProducto].titulo;
            this.dataModal[0].descripcionProducto=this.productos[iProducto].descripcion;
            this.dataModal[0].precioProducto=this.productos[iProducto].precio;
            step_3_nameProducto.innerHTML=this.dataModal[0].cantidadProducto+' X '+this.dataModal[0].nombreProducto;
            $('#modal-select-product').modal('open');
        },
        siAddNota(){
            showInputAddNote(1);
            this.dataModal[0].quiero_agregar_nota=1;
            console.log('SI QUISO AGREGAR NOTA');
        },
        noAddNota(){
            gotoPageModal(2);
            this.dataModal[0].quiero_agregar_nota=0;
            console.log('NO QUISO AGREGAR NOTA');
        },
        loadCategorias(callback) {
            const VUETHIS_SUB = this;
            $.get(this.base_url+"/get/categorias.php")
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
            $.get(this.base_url+"/get/productos.php")
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
        },
        loadLastIdOrdenes(callback){
            const VUETHIS_SUB = this;
            $.get(this.base_url+"/get/last_id_ordenes.php")
            .done(function(response) {
                let json_response;
                try {
                    json_response = JSON.parse(response);
                } catch (error) {
                    json_response = null;
                    console.log('ERROR: '+json_response);
                }
                if(json_response) {
                    VUETHIS_SUB.last_id_orden = json_response[0].id;
                    if(callback)
                        callback();
                        console.log('LAST ID: '+VUETHIS_SUB.last_id_orden);
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