<?php

if($_SERVER['REQUEST_METHOD']=='POST'){
 
    $imagen= $_POST['foto'];
    $nombre = $_POST['nombre'];

    // RUTA DONDE SE GUARDARAN LAS IMAGENES
    $path = "vistas/img/pagos/$nombre.png";

    $actualpath = "http://localhost/backend/$path";

    file_put_contents($path, base64_decode($imagen));
    
    echo "SE SUBIO EXITOSAMENTE";
}