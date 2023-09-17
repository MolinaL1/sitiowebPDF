
<?php include("../template/cabecera.php") ?>
<?php
   print_r($_POST);
   print_r($_FILES);
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
                    <input type="text" class="form-control" name="txtID" id="txtID" placeholder="ID">
                </div>
                <div class="form-group">
                    <label for="txtNombre">Nombre</label>
                    <input type="text" class="form-control" name="txtNombre" id="txtNombre" placeholder="Nombre">
                </div>
                <div class="form-group">
                    <label for="txtImagen">Imagen</label>
                    <input type="file" class="form-control" name="txtImagen" id="txtImagen" placeholder="Escribe tu password">
                </div>
                <div class="btn-group" role="group" aria-label="">
                    <button type="submit" name="accion" value="Agregar" class="btn btn-success">Agregar</button>
                    <button type="submit" name="accion" value="Modificar" class="btn btn-warning">Modificar</button>
                    <button type="submit" name="accion" value="Cancelar" class="btn btn-info">Cancelar</button>
                </div>
            </form>
        </div>

    </div>

</div>
<div class="col-md-7">
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
        <tr>
            <td>Seccionar | Borrar</td>
            <td>2</td>
            <td>Aprende PHP</td>
            <td>imagen.jpg</td>
        </tr>
        
    </tbody>
   </table>
</div>


<?php include("../template/pie.php") ?>