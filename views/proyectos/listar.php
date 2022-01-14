
<br/>
<a class="btn btn-primary" href="./crear">Agregar nuevo proyecto</a>
<br/><br/>

<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Precio</th>
            <th>Imagen</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>

        <?php foreach ($proyectos as $proyecto) { ?>
            <tr>
                <td><?php echo $proyecto['id']; ?></td>
                <td><?php echo $proyecto['nombre']; ?></td>
                <td><?php echo $proyecto['quantity']; ?></td>
                <td><?php echo "$ ".number_format($proyecto['price'],2);?></td>
                <td><img class="img-thumbnail"  src="img/<?php echo $proyecto['imagen']; ?>" width="150" /></td>
                <td>
                    <form action="./editar" class="d-inline" method="get">
                        <input type="hidden" name="txtID" id="txtID" value="<?php echo $proyecto['id']; ?>" />
                        <button type="submit" class="btn btn-info">Editar</button>
                    </form>
                    |
                    <form action="./borrar" class="d-inline" method="post">
                        <input type="hidden" name="txtID" id="txtID" value="<?php echo $proyecto['id']; ?>" />
                        <button type="submit" class="btn btn-danger"><i class="bi bi-trash-fill"></i></button>
                    </form>
                </td>
            </tr>
        <?php } ?>
      
    </tbody>
</table>