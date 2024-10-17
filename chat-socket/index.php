<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function(event) {
            let conn = new WebSocket("ws://localhost:8080");    // Conectar al servidor
            conn.onopen = function(event) {
                console.log("Conectado...");
            }
            conn.onmessage = function(event) {
                let respuesta = JSON.parse(event.data);
                $("#chatContainer").append('<div class="message message-received">' + respuesta.message + '</div>');
            }

            $('#sendMessage').click(function (event) {
                let msg = $('#messageInput').val();
                let data = {
                    message: msg
                }
                conn.send(JSON.stringify(data));
                $("#chatContainer").append('<div class="message message-sent">' + msg + '</div>');
                $('#messageInput').val('');
            });
        });
    </script>
</head>
<body>
<div class="container mt-5">
    <div class="row">
        <div class="col-md-4 d-none d-md-block">
            <div class="list-group">
                <a href="#" class="list-group-item list-group-item-action active" aria-current="true">
                    Juan Pérez
                </a>
                <a href="#" class="list-group-item list-group-item-action">
                    María García
                </a>
                <a href="#" class="list-group-item list-group-item-action">
                    Carlos Rodríguez
                </a>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    Chat Con Juan Pérez
                </div>
                <!-- Contenido del chat -->
                <div class="card-body chat-container" id="chatContainer">
<!--                    <div class="message message-received"></div>-->
<!--                    <div class="message message-sent"></div>-->
                </div>
                <div class="card-footer">
                    <div class="input-group">
                        <input type="text" class="form-control" id="messageInput" placeholder="Escribe tu mensaje...">
                        <button class="btn btn-primary" id="sendMessage">Enviar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

