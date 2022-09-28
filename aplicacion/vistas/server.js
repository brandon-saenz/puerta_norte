const path=require("path");
const express=require("express");
const cors=require("cors");
const app=express();
const server = require("http").Server(app);
const WebSocketServer=require("websocket").server;

app.set("puerto", 3000);
app.use(cors());
app.use(express.json());
// app.use(express.static(path.join(_dirname, "./public")));
// app.use(express.static(path.join(_dirname, "./aplicacion/vistas")));
app.use(express.static(path.join(__dirname)));


const wsServer=new WebSocketServer({
    httpServer: server,
    autoAcceptConnections: true,
});

wsServer.on("request", (request)=>{
    const connection=request.accept(null, request.origin);
    connection.on("message", (message)=>{
        console.log('Mensaje recibido: '+message.utf8Data);
        connection.sendUTF("recibido> "+message.utf8Data);
    });
    connection.on("close", (reasonCode, description)=>{
        console.log('El cliente se desconectó');
    });
});

server.listen(app.get("puerto"), ()=>{
    console.log('Servidor iniciado en el puerto> '+app.get("puerto"));
});

