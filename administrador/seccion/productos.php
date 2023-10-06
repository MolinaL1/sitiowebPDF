
<?php include("../template/cabecera.php") ?>
<?php
    $txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
    $txtNombre=(isset($_POST['txtNombre']))?$_POST['txtNombre']:"";

    $txtImagen=(isset($_FILES['txtImagen']['name']))?$_FILES['txtImagen']['name']:"";
    $accion=(isset($_POST['accion']))?$_POST['accion']:"";

    include("../config/bd.php");
print_r($_POST);
    switch ($accion) {
        case 'Agregar':
            // INSERT INTO `libros` (`id`, `nombre`, `imagen`) VALUES (NULL, 'libro de php', 'imagen jpg');
            $sentenciaSQL= $conexion->prepare("INSERT INTO `libros` (nombre,imagen) VALUES (:nombre,:imagen);");
            $sentenciaSQL->bindParam(':nombre',$txtNombre);
            $sentenciaSQL->bindParam(':imagen',$txtImagen);

            $fecha=new DateTime();
            $nombreArchivo=($txtImagen!="")?$fecha->getTimestamp()."_".$_FILES["txtImagen"]["name"]:"imagen.jpg";

            $tmpImagen=$_FILES["txtImagen"]["tmp_name"];
            if($tmpImagen!=""){
                move_uploaded_file($tmpImagen,"../../img/".$nombreArchivo);
            }

            $sentenciaSQL->bindParam(':imagen',$nombreArchivo);
            $sentenciaSQL->execute();
            // echo "Presionado boton agregar";
            header("Location:productos.php");
            break;
        case 'Modificar':
            $sentenciaSQL= $conexion->prepare("UPDATE libros SET nombre=:nombre WHERE id=:id");
            $sentenciaSQL->bindParam(':nombre',$txtNombre);
            $sentenciaSQL->bindParam(':id',$txtID);
            $sentenciaSQL->execute();

            if($txtImagen!=""){
                $fecha=new DateTime();
                $nombreArchivo=($txtImagen!="")?$fecha->getTimestamp()."_".$_FILES["txtImagen"]["name"]:"imagen.jpg";
                $tmpImagen=$_FILES["txtImagen"]["tmp_name"];
                
                move_uploaded_file($tmpImagen,"../../img/".$nombreArchivo);

                $sentenciaSQL= $conexion->prepare("SELECT imagen FROM libros WHERE id=:id");
                $sentenciaSQL->bindParam(':id',$txtID);
                $sentenciaSQL->execute();
                $Libros=$sentenciaSQL->fetch(PDO::FETCH_LAZY);
    
                if (isset($libros["imagen"]) && ($libros["imagen.jpg"])) {
    
                    if (file_exists("../../img/".$libros["imagen"])) {
                        unlink("../../img/".$libros["imagen"]);
                    }
                }

                $sentenciaSQL= $conexion->prepare("UPDATE libros SET imagen=:imagen WHERE id=:id");
                $sentenciaSQL->bindParam(':imagen',$nombreArchivo);
                $sentenciaSQL->bindParam(':id',$txtID);
                $sentenciaSQL->execute();
                
            }
            header("Location:productos.php");
            // echo "Presionado boton Modificar";
            break;
        case 'Cancelar':
            // echo "Presionado boton Cancelar";
            header("Location:productos.php");
            break;
        case 'Seleccionar':
            // echo "Presionado boton Selecionar";
            $sentenciaSQL= $conexion->prepare("SELECT * FROM libros WHERE id=:id");
            $sentenciaSQL->bindParam(':id',$txtID);
            $sentenciaSQL->execute();
            $Libros=$sentenciaSQL->fetch(PDO::FETCH_LAZY);
            $txtNombre=$Libros['nombre'];
            $txtImagen=$Libros['imagen'];
            break;
        case 'Borrar':

            $sentenciaSQL= $conexion->prepare("SELECT imagen FROM libros WHERE id=:id");
            $sentenciaSQL->bindParam(':id',$txtID);
            $sentenciaSQL->execute();
            $Libros=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

            if (isset($libros["imagen"]) && ($libros["imagen.jpg"])) {

                if (file_exists("../../img/".$libros["imagen"])) {
                    unlink("../../img/".$libros["imagen"]);
                }
            }
            // echo "Presionado boton Borrar";
            $sentenciaSQL= $conexion->prepare("DELETE FROM libros WHERE id=:id");
            $sentenciaSQL->bindParam(':id',$txtID);
            $sentenciaSQL->execute();
            header("Location:productos.php");
            break;
        
        default:
            # code...
            break;
    }

    $sentenciaSQL= $conexion->prepare("SELECT * FROM libros");
    $sentenciaSQL->execute();
    $listaLibros=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="col-md-5">
    <div class="card">
        <div class="card-header">
            Datos de Libro
        </div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="txtID">ID</label>
                    <input type="text" required readonly value="<?php echo $txtID?>" class="form-control" name="txtID" id="txtID" placeholder="ID">
                </div>
                <div class="form-group">
                    <label for="txtNombre">Nombre</label>
                    <input type="text" required value="<?php echo $txtNombre?>" class="form-control" name="txtNombre" id="txtNombre" placeholder="Nombre">
                </div>
                <div class="form-group">
                    <label for="txtImagen">Imagen</label>
                    <br>
                    <?php if ($txtImagen!="") { ?>
                        <img class="img-thumbnail rounded" src="../../img/<?php echo $txtImagen;?>" width="50" alt="">
                       <?php } ?>
                    <input type="file" class="form-control" name="txtImagen" id="txtImagen" placeholder="Escribe tu password" require>
                </div>
                <div class="btn-group" role="group" aria-label="">
                    <button type="submit" name="accion" <?php echo ($accion=="Seleccionar")?"disabled":""?> value="Agregar" class="btn btn-success">Agregar</button>
                    <button type="submit" name="accion" <?php echo ($accion!=="Seleccionar")?"disabled":""?> value="Modificar" class="btn btn-warning">Modificar</button>
                    <button type="submit" name="accion" <?php echo ($accion!=="Seleccionar")?"disabled":""?> value="Cancelar" class="btn btn-info">Cancelar</button>
                </div>
            </form>
        </div>

    </div>

</div>
<div class="col-md-7">
   <a href="reportes.php">Reportes pdf</a>
   <table class="table table-bordered">
    <thead>
        <tr>
            <th>Acciones</th>
            <th>ID</th>
            <th>Nombre</th>
            <th>Imagen</th>
            
        </tr>
    </thead>
    <tbody>
        <?php foreach($listaLibros as $libros){?>
        <tr>
            <td>
                
                <form method="post">
                    <input type="hidden" name="txtID" id="txtID" value="<?php echo $libros['id']?>">
                    <input type="submit" name="accion"  value="Seleccionar" class="btn btn-primary"/>
                    <input type="submit" name="accion" value="Borrar" class="btn btn-danger" />
                </form>
            </td>
            <td><?php echo $libros['id']?></td>
            <td><?php echo $libros['nombre']?></td>
            <td>
                <img class="img-thumbnail rounded" src="../../img/<?php echo $libros['imagen']?>" width="50" alt="">
            </td>
        </tr>
        <?php } ?>
    </tbody>
   </table>
</div>


<?php include("../template/pie.php") ?>