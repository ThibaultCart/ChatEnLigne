/*
 * Author(s)    :   Douglas
 * File         :   chat.js
 * Project      :   ChatUp
 * Description  :   JavaScript Engine | Monitors WebSockets, Access DB, Serve chat.php
 * Last modif.  :   23.03.2020 by Douglas
 */


var app = require('http').createServer(handler); // Server http
var io = require('socket.io')(app); // Socket io
var fs = require('fs'); // File System
var mysql = require('mysql');

// Database access
var con = mysql.createConnection({
    host: "localhost",
    user:"root",
    password:"",
    database:"bdchatup"
});

con.connect(function(err) {
    if (err) throw err;
    console.log("Connected!");
});



// /!\ Change 'localhost' into 'xx.xxx.x.xxx' <- Your local ip or the one of your server
app.listen(8039, 'localhost');

function handler (req, res) {
    fs.readFile(__dirname + '/chat.php',
        function (err, data) {
            if (err) {
                res.writeHead(500);
                return res.end('Error loading chat.php');
            }

            res.writeHead(200);
            res.end(data);
        });
}

// Console.log -> Console talking, can be used as references if something goes wrong with the server
console.log('Server started');

// Connection to the Node js server
io.on('connection', function (socket) {

    // Event 0 : User just connected, this part sends historic only to this client
    /*con.query("SELECT ContenuMessage, DateMessage, user.username FROM message JOIN user WHERE message.idUser=user.idUser", function
        (err, result, fields) {
        if (err) throw err;
        console.log(result);
    });*/

    socket.emit("Welcome !");
    // Event 0 : Connection (look l. 24)
    console.log('a user connected');


    // Event 1 : Chat message + Add to DB
    socket.on('chat message', function(msg){
        console.log('chat message: ', msg);

        // Prep query
        var date = new Date().toISOString().slice(0, 19).replace('T', ' ');
        // Send query (notice the usage of placeholders, it's like bindParams in JS apparently)
        // Source -> https://stackoverflow.com/questions/35600813/when-to-use-and-as-placeholders-in-node-mysql-for-building-a-query
        con.query("INSERT INTO message (dateMessage, contentMessage , idUser) " +
            "VALUES (?, ?, ?)",
            [
                date.toString(),
                msg.replace(/"/g, '\\"'),
                '2'
            ],

            function (err, result) {
                if (err) throw err;
                console.log("1 record inserted");
            });



        // Emits the message to all clients the new msg + the username + date
        io.sockets.emit('chat message', msg);

    });

    // Event 2 : Disconnected
    socket.on('disconnect', function(){
        console.log('user disconnected');
    });
});

