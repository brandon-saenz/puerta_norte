<script>
document.addEventListener("DOMContentLoaded", function() {
    console.log('ADMIN OK');
});

var loopRequestOrdenes;

function onNotificacion(){
    var audio=document.getElementById('audio-notificacion');
    audio.play();
}

var menu = new Vue({
    el: '#admin',
    name: 'admin',
    data() {
        return {
            ordenes: [],
            socketOrdenes: [],
            base_url: '/puerta_norte/aplicacion/modelos',
        }
    }, 
    created() {
        this.loadOrdenes();
    },
    watch:{
        "base_url"(newValue, oldValue){
        }
    },
    methods:{
        loadOrdenes(callback) {
            const VUETHIS_SUB = this;
            $.get(this.base_url+"/get/ordenes.php")
            .done(function(response) {
                let json_response;
                try {
                    json_response = JSON.parse(response);
                } catch (error) {
                    json_response = null;
                    console.log('ERROR: '+json_response);
                }
                if(json_response) {
                    VUETHIS_SUB.ordenes = json_response;
                    if(callback)
                        callback();
                        loopRequestOrdenes=setInterval(function(){
                            VUETHIS_SUB.loadSocketOrdenes();
                        },1000);
                    } else {
                        console.log('ERROR EN VUE 1'+JSON.stringify(json_response));
                    }
            }).fail(function() {
                console.log('ERROR EN VUE 2');
            });
        },
        stopLoop(){
            // clearInterval(loopRequestOrdenes);
            // console.log('STOP = loopRequestOrdenes');
        },
        goOrden(){
            console.log('goOrden()');
        },
        //EMULANDO WEB SOCKET
        loadSocketOrdenes(callback){
            const VUETHIS_SUB = this;
            $.get(this.base_url+"/get/ordenes.php")
            .done(function(response) {
                let json_response;
                try {
                    json_response = JSON.parse(response);
                } catch (error) {
                    json_response = null;
                    console.log('ERROR: '+json_response);
                }
                if(json_response) {
                    VUETHIS_SUB.socketOrdenes = json_response;
                    if(callback)
                        callback();
                        if(VUETHIS_SUB.socketOrdenes.length>VUETHIS_SUB.ordenes.length){
                            VUETHIS_SUB.ordenes=VUETHIS_SUB.socketOrdenes;

                            //ALERTA DE QUE EXISTE UNA NUEVA ORDEN
                            onNotificacion();
                            M.toast({
                                html: '<div onclick="menu.goOrden()" class="toast-btn">NUEVA ORDEN AÑADIDA</div>', 
                                classes: 'rounded green darken-3 div-center', displayLength: 4000
                            });
                        }
                        console.log('SOCKET DONE');

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