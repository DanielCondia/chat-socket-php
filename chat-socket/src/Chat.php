<?php

namespace MyApp;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Chat implements MessageComponentInterface
{

    protected $clients;
    
    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
        echo "Servidor iniciado!\n";
    }

    /**
     * Esta función se ejecuta cuando se abre una nueva conexión.
     *
     * @param ConnectionInterface $conn La conexión que se ha abierto.
     */
    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);
        echo "Nueva Conexión! ({$conn->resourceId})\n";
    }

    /**
     * Recibe un mensaje y lo envía a todas las conexiones que se encuentran abiertas.
     *
     * @param ConnectionInterface $from La conexión que ha enviado el mensaje.
     * @param string $msg El mensaje que se ha enviado.
     */
    public function onMessage(ConnectionInterface $from, $msg)
    {
        /*
        * Envía el mensaje a todas las conexiones excepto la que lo ha enviado.
        * Para hacer esto, iteramos sobre todas las conexiones y comprobamos
        * si la conexión actual es diferente a la que ha enviado el mensaje.
        * Si es diferente, enviamos el mensaje a la conexión.
        */
        foreach ($this->clients as $client) {
            if ($from !== $client) {
                $client->send($msg);
            }
        }
    }

    /**
     * Se llama cuando se cierra una conexión.
     *
     * @param ConnectionInterface $conn La conexión que se ha cerrado.
     */
    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);
        echo "Conexión cerrada! ({$conn->resourceId})\n";
    }

    /**
     * Se llama cuando ocurre un error en una conexión.
     *
     * @param ConnectionInterface $conn La conexión en la que se ha producido el error.
     * @param \Exception $e La excepción que se ha lanzado.
     */
    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "Error: " . $e->getMessage() . "\n";
        $conn->close(); // Cerramos la conexión
    }

}