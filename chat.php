<!--
 * Author(s)    :   Thibault, Douglas, Mayara
 * File         :   chat.php
 * Project      :   ChatUp
 * Description  :   Chat | View | JavaScript Only
 * Last modif.  :   23.03.2020 by Douglas
-->
<!DOCTYPE html>
<html>
<head>
    <script
            src="https://code.jquery.com/jquery-3.4.1.js"
            integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
            crossorigin="anonymous"></script>
    <script src="/socket.io/socket.io.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>
        // Initialize client

        var socket = io.connect();

        // Submission of new message
        $(function () {

            $("#chat-input").keypress(function (e) {
                if(e.which == 13) {
                    //submit form via ajax, this is not JS but server side scripting so not showing here
                    $('form').submit();
                }
            });


            // When submit button is pressed
            $('form').submit(function(e){
                // Prevent page reloading
                e.preventDefault();
                // Send event 'chat message' with the input as a value (Client)
                socket.emit('chat message', $('#chat-input').val());
                // Empty the input
                $('#chat-input').val(' ');
            });

            // When a client has sent a message
            socket.on('chat message', function(msg){
                // Display message in chatbox
                var li = $('<li></li>');
                li.text(msg);
                $('#chat-container').append(li);
            });

            socket.on('disconnect', function(msg){
                // Display message in chatbox
                var b = $('<b></b>');
                b.text('A user has disconnected.');
                $('#chat-container').append(b);
            });

            socket.on('connection', function(msg){
                // Display message in chatbox
                var b = $('<b></b>');
                b.text('A user has disconnected.');
                $('#chat-container').append(b);
            });

        });

    </script>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- No idea why, link and routing of php doesn't work, no time to think about it so... hardcoding -->
    <style>
        *{
            font-family: Arial, Helvetica, sans-serif;
            background-color:rgb(23, 101, 125);
        }
        body{
            height:500px;
            overflow: hidden;
            margin:10%;
            min-height: 500px;
        }
        form{
            margin:auto;
            height: 80%;

        }

        fieldset h2{
            text-align: center;
            color:white;
            background-color:inherit;
        }
        fieldset{
            margin:auto;
            left: 0;
            top: 0;
            width: 70%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */

            border:1px solid white;
            border-radius: 1px;
            background-color:rgb(43,43,43);

            padding: 15px;
        }

        .msg, .msg *{

            text-decoration: none;
            font-style:normal;
            list-style: none;

            background-color:papayawhip;
        }
        .message-odd{
            text-align:left;
        }

        .username{
            font-style:italic;
            font-weight: bold;
        }
        .date{
            font-stretch: condensed;
            font-weight:lighter;
        }

        #chat-input{
            width:100%;
            height:10%;
            padding:0px;
            margin-top:1px;
            margin-bottom: 1px;
            border-radius: 5px;
            resize: vertical;
            max-height: 60px;
            background-color: white;

        }
        #chat-submit{
            border:1px solid black;
            text-align: center;
            outline:0;
            min-width: 130px;
            height: 10%;
            width:100%;
            margin:0px;
            padding:0px;
            background-color: white;
            transition:0.3s;
        }

        #chat-submit:hover{
            background-color: #0c0c0c;
            color:white;

        }

        #chat-container{
            width:100%;
            height:60%;
            background-color:whitesmoke;
            overflow: auto;
            border:1px solid white;
            border-radius: 5px;
            margin:0px;
        }
        #side-container li{
            list-style:none;
            padding: 2px;
            width: 100%;
            background-color:rgb(43,43,43);
            text-decoration: none;
            display:block;
        }
        .msg-content{
            color:gray();
        }
        nav{
            width: auto;
        }
        nav ul{
            list-style: none;

            background-color: black;
        }
        nav ul li{
            list-style-type: none;
            padding:10px;
            background-color: black;
            display: block;
        }
        nav ul li a{
            background-color: black;
            color: white;
            font-style:normal;
            text-decoration: none;
        }
    </style>
</head>
<body>
<nav>
    <ul>
        <li><a href="http://192.168.1.131/index.php">Connexion</a></li>
    </ul>
</nav>

<form>
    <fieldset>
        <h2>Chat</h2>
        <div id="chat-container">
            <li class="msg message-odd ">
                <span><i class="username">Sony</i> <i class="date"> (10.03.2020 - 13:36)</i></span>
                <br>
                <i class="msg-content ">I ain't your bruh, mate.</i>
            </li>

        </div>
        <textarea  id="chat-input"></textarea>
        <input type="submit" id="chat-submit" value="Send">
    </fieldset>

</form>
</body>
</html>

