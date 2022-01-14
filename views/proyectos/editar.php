<br/>
<form action="./editar" method="post" enctype="multipart/form-data">
    <div class="card">
        <div class="card-header">
            Proyectos
        </div>
        
        <div class="card-body">

        <div class="form-group">
            <label for="txtID">ID:</label>
            <input readonly type="text" class="form-control" value="<?php echo $proyecto['id'];?>" name="txtID" id="txtID"  placeholder="Nombre del proyecto">
          </div>  

          <div class="form-group">
            <label for="txtNombre">Nombre:</label>
            <input type="text" class="form-control" value="<?php echo $proyecto['nombre'];?>" name="txtNombre" id="txtNombre"  placeholder="Nombre del proyecto">
          </div>  

          <div class="form-group">
            <label for="">Cantidad:</label>
            <input type="number" class="form-control"  value="<?php echo $proyecto['quantity'];?>" min="0" name="txtquantity" placeholder="Cantidad del producto">
          </div>  

          <div class="form-group">
            <label for="">Precio:</label>
            <input type="number" class="form-control" value="<?php echo $proyecto['price'];?>" min="0" name="txtprice" placeholder="Precio del producto">
          </div> 
          
          <div class="form-group">
              <label for="">Imagen:</label>
              <br/>
              <img class="img-thumbnail" src="img/<?php echo $proyecto['imagen']; ?>" width="100" />
              <br/>
              <input type="file"
                class="form-control" name="txtImagen" id="txtImagen" placeholder="Selecciona la imagen">
              
          </div>
        </div>

        <div class="card-footer text-muted">
            
            <button type="submit" name="" id="" class="btn btn-success" btn-lg btn-block">Modificar</button>

            <a  class="btn btn-danger" href="./" role="button">Cancelar</a>

        </div>
    </div>
</form>