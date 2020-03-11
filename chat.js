var app = require('http').createServer(handler);
var io = require('socket.io')(app);
var fs = require('fs');

app.listen(80);

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

io.on('connection', function (socket) {
    console.log('a user connected');
    socket.on('chat message', function(msg){
        console.log('chat message: ', msg);
    });
    socket.on('disconnect', function(){
        console.log('user disconnected');
    });


});