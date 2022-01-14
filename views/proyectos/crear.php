<br/>
<form action="" method="post" enctype="multipart/form-data">
    <div class="card">
        <div class="card-header">
            Proyectos
        </div>
        
        <div class="card-body">

          <div class="form-group">
            <label for="txtNombre">Nombre:</label>
            <input type="text" class="form-control" name="txtNombre" id="txtNombre"  placeholder="Nombre del producto">
          </div> 

          <div class="form-group">
            <label for="">Cantidad:</label>
            <input type="number" class="form-control" name="txtquantity" min="0" placeholder="Cantidad del producto">
          </div>  

          <div class="form-group">
            <label for="">Precio:</label>
            <input type="number" class="form-control" name="txtprice" min="0" placeholder="Precio del producto">
          </div>  
          
          <div class="form-group">
              <label for="">Imagen:</label>
              <input type="file" accept="image/*" class="form-control" name="txtImagen" id="txtImagen" placeholder="Selecciona la imagen"> 
          </div>

        </div>

        <div class="card-footer text-muted">
            <button type="submit" name="" id="" class="btn btn-primary" btn-lg btn-block">Agregar</button>
            <a  class="btn btn-danger" href="./" role="button">Cancelar</a>
        </div>
    </div>
</form>