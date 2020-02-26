// Basic JS server
var express = require('express')();
//var app = express();
var http = require('http').createServer(express);
// Passing http as a parameter in the implementation of socket io
var io = require('socket.io')(http);


//express.use(express.static(__dirname + 'public'));

// Sends the chat page as the return page
express.get('/', function(req, res){
    res.sendFile(__dirname + '/chat.php');
});


// Listener
http.listen(80, function(){
  console.log('listening on *:80');
});



io.on('connection', function(socket){

    console.log('a user connected');

    socket.on('connection', function(){
        io.emit('new user connected');
    });
    
    socket.on('chat message', function(msg){
        io.emit('chat message', msg);
    });
    socket.on('disconnect', function(){
      console.log('user disconnected');
    });

    socket.on('chat message', function(msg){
        console.log('message: ' + msg);
    });
});

io.emit('some event', { 
    someProperty: 'some value', 
    otherProperty: 'other value' 
}); // This will emit the event to all connected sockets


/*

Améliorations possibles :

- Persistence des messages
- Utilisateur
- Annonces : <Utiliseur> a rejoint le chat / quitter le chat
- Time Stamp
- Afficher le dernier message (scroll always en bas par défaut)
- Designe



*/