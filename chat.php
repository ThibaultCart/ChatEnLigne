<?php
?>

<!DOCTYPE html>
<html>
    <head>
        <script
            src="https://code.jquery.com/jquery-3.4.1.js"
            integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
            crossorigin="anonymous"></script>
        <script src="/socket.io/socket.io.js"></script>
        <script>

            var socket = io('http://localhost');
            socket.emit('chat message', 'emission works');
            // This doesn't work.. why ?
            $(function () {
                $('form').submit(function(e){
                    e.preventDefault(); // prevents page reloading

                    //$('#m').val('');
                    return false;
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

            fieldset h2{
                text-align: center;
                color:white;
                background-color:inherit;
            }
            fieldset{
                margin:auto;
                left: 0;
                top: 0;
                width: 100%; /* Full width */
                height: 100%; /* Full height */
                overflow: auto; /* Enable scroll if needed */
                background-color: rgb(0,0,0); /* Fallback color */
                background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
                padding-top: 60px;
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
            .message-even{
                text-align:right;
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
                width:86%;
                height:50px;
                border:1px solid white;
                border-radius: 5px;
                resize: vertical;
                max-height: 60px;

            }
            #chat-submit{
                width:11%;
                min-width: 130px;
                height: 50px;
            }
            #chat-container{
                width:86%;
                height:80%;
                background-color:whitesmoke;
                overflow: auto;
                border:1px solid white;
                border-radius: 5px;
            }
            fieldset{
                width: 70%;
                padding: 15px;
                border:1px solid yellow;
                background-color:rgb(43,43,43);
                border:1px solid white;
                border-radius: 1px;
            }
            #side-container {

                float:right;
                color:white;
                width:12%;
                font-size:70%;
                margin:0px;
                background-color:rgb(43,43,43);
            }
            #side-container ul{
                width: 100%;
                padding: 0px;
                margin:0px;
                background-color:rgb(43,43,43);

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

        </style>
    </head>
    <body>
    <ul id="messages"></ul>
    <form action="">
        <input id="m" autocomplete="off" /><button>Send</button>
    </form>
    <!--
        <form>
            <fieldset>
                <h2>Chat</h2>
                <div id="side-container">
                    <ul>
                        <li>User : JBL</li>
                        <li>Messages : 132</li>
                        <li></li>
                    </ul>
                </div>
                <div id="chat-container">
                 If another user sent the msg
                 The message is shown on the left

                    <li class="msg message-even">
                        <span><i class="username">JBL</i><br><i class="date"> (10.03.2020 - 13:36)</i> </span>
                        <br>
                            <i class="msg-content">Bruh do you even lift</i>
                    </li>


                     If the user sent the message
                     The message is shown on the right


                    <li class="msg message-odd ">
                        <span><i class="username">Sony</i> <i class="date"> (10.03.2020 - 13:36)</i></span>
                        <br>
                        <i class="msg-content ">I ain't your bruh, mate.</i>
                    </li>

                </div>
                <textarea  id="chat-input"></textarea>
                <input type="submit" id="chat-submit">
            </fieldset>

        </form>-->
    </body>
</html>

