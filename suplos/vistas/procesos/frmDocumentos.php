<h1>Documentos de penticion y ofertas</h1>

<form action="?controlador=procesos&metodo=subirDocumento" method="POST" id= "SubirDocumento" enctype="multipart/form-data">

<input class="form-control" type="text" name="titulo" required>
<div class="form-group">
    <label for="descripcion">descripcion</label>
    <textarea id="descripcion" class="form-control" name="descipcion" rows="3" required></textarea>
</div>
<input class="form-control" type="hidden" name="idProceso" value="<?= $_GET["id"] ?>">
<input class="form-control" type="file" name="file" required>

<input  type="submit" name="Enviar" class="btn btn-primary">
</form>
  <table class="table">
    <thead class="thead" class="border">

      <tr>
        <th scope="col">Id</th>
        <th scope="col">Titulo</th>
        <th scope="col">Contenido</th>
        <th scope="col">Visualizar</th>

      </tr>
    </thead>

    <?php
    foreach ($this->dataConsulta as $valor) {

        echo "<tr>";
        echo "
                <td>" . $valor["id"] . "</td> 
                <td>" . $valor["titulo_documento"] . "</td> 
                <td>" . $valor["descriptcion_documento"] . "</td> 
                <td><a target='_blank' href='" . $valor["ubicacion_documento"] . "'>  Ver </td>";
        echo "</tr>";
    }
    ?>

    <thbody>

</thbody>
  </table>