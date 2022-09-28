<script>
    
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
</script>