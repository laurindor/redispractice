<?php
//phpinfo();


try {
    // Crear instancia de Redis
    $redis = new \Redis();
    
    // Conectarte a un servidor redis
    // En este caso dentro de la misma maquina (localhost) y usando el puerto predeterminado de redis
    $redis->connect('127.0.0.1', 6379);
    $redis->select(4);
    // Define y almacena alguna llave
    $redis->set('user', 'ciber');

    // Luego obten el valor
    $user = $redis->get('user');

    // Deberia imprimir: sdkcarlos
    print($user);
} catch (Exception $ex) {
    echo $ex->getMessage();
}
?>