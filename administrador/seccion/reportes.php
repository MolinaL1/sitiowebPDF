<?php
    include("../config/bd.php");

    $sentenciaSQL= $conexion->prepare("SELECT * FROM libros");
    $sentenciaSQL->execute();
    $listaLibros=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
?>