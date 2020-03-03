<?php
require_once "requete.php";
if(isset($_POST["logout"])){
  Deconnexion();
} 

?>


<!doctype html>
<html>
  <head>
    <title>Chat en-ligne</title>
      <link rel="stylesheet" type="text/css" href="css/style.css"/>
    <script src="/socket.io/socket.io.js"></script>
    <script src="https://code.jquery.com/jquery-1.11.1.js"></script>
    <script>
      $(function () {
        var socket = io();
        $('form').submit(function(e){
          e.preventDefault(); // prevents page reloading
          socket.emit('chat message', $('#m').val());
          $('#m').val('');
          return false;
        });
        socket.on('chat message', function(msg){
            $('#messages').append($('<li>').text(msg));
        });
      });
    </script>
  </head>
  <body>
    <ul id="messages"></ul>
    <form action="chat.php" methode="POST" >
      <input id="m" autocomplete="off" /><button>Send</button>
     

    </form>
    <form action="chat.php" method="POST">
    <input id="m" autocomplete="off" type="hidden" /><button>Send</button>
    <input name="logout" type="hidden" value="logout" />
    
</form>
  </body>
</html>
