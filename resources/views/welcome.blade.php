<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>
    <body>
        <button id="button">Send</button>
        <input id="input" type="text">
        <div id="replies"></div>

        <script>
            let socket = new WebSocket("ws://localhost:8090");

            socket.onopen = (event) => {
                console.log("connected to server socket");
                let button = document.querySelector("#button");
                let text = document.querySelector("#input");

                button.onclick = () => {
                    console.log("sending to server: ", input.value);
                    socket.send(input.value);
                }; 
            };

            socket.onmessage = (event) => {
                let p = document.createElement('p');
                p.textContent = event.data;
                document.querySelector("#replies").append(p);
            };
        </script>
    </body>
</html>
