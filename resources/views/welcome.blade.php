<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <script
            src="https://code.jquery.com/jquery-3.5.1.min.js"
            integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
            crossorigin="anonymous">
        </script>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>
    <body>
        <button id="send">Send request</button><br>
        <button id="button">Send</button>
        <input id="input" type="text">
        <div id="replies"></div>

        <script>
            //let socket = new WebSocket("ws://localhost:8090");

            // socket.onopen = (event) => {
            //     console.log("connected to server socket");
            //     let button = document.querySelector("#button");
            //     let text = document.querySelector("#input");

            //     button.onclick = () => {
            //         console.log("sending to server: ", input.value);
            //         socket.send(input.value);
            //     }; 
            // };

            // socket.onmessage = (event) => {
            //     let p = document.createElement('p');
            //     p.textContent = event.data;
            //     document.querySelector("#replies").append(p);
            // };

            //-------------

            let send = document.querySelector("#send");
            send.onclick = async() => {
                let token_response = await fetch("/android/token");
                let token = await token_response.text();

                let response = await fetch("/android/locations",{
                    headers: { 
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token,
                    }, 
                    method: "post",
                    body: JSON.stringify({
                        "name": "test",
                        "description": "descr...",
                        "address": "siauliai",
                        "lat": 0.0,
                        "lng": 0.0,
                        "user_id": 0,
                        "text": "Hello World!",
                    }),
                });

                if(response.status == 500) console.log(await response.text());
                else console.log(await response.json());
            }; 
        </script>
    </body>
</html>
