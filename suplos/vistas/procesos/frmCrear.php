<H1>Crear Procesos</h1>
<form action="?controlador=procesos&metodo=crear" id="frmCrear" method="POST">
  <div class="mb-3">
    <label for="exampleInputObjeto" class="form-label">Objeto</label>
    <input type="text" name="objetivo" class="form-control" id="exampleInputObjeto" required>

  </div>

  <div class="mb-3">
    <label for="exampleInputNombre" class="form-label">Digite nombre del comprador</label>
    <input type="text" name="nombreResponsable" class="form-control" id="exampleInputNombre" required>

  </div>

  <div class="mb-3">

    <div class="form-group">
      <label for="my-textarea">Descripcion</label>
      <textarea id="my-textarea" name="descripcion" class="form-control" rows="3" required></textarea>
    </div>
  </div>

  <div class="mb-3">

    <select class="form-select" name="moneda" aria-label="Seleccione moneda" required>
      <option selected>Selecione moneda</option>
      <option value="COP">COP</option>
      <option value="USD">USD</option>
      <option value="EUR">EUR</option>
    </select>

  </div>





  <div class="mb-3">
    <label for="exampleInputPresupuesto" class="form-label">Presupuesto</label>
    <input type="number" class="form-control" name="presupuesto" id="exampleInputPresupuesto"
      aria-describedby="emailHelp" required>

  </div>


  <div class="mb-3">

    <select class="form-select" name="actividad" aria-label="Seleccione Actividad" required>
      <option value="none">Seleccione actividades</option>
      <?php

      foreach ($this->selectorActividades as $value) {

        echo '<option value="' . $value["id"] . '">' . $value["nombre_segmento"] . '</option>';
      }

      ?>

    </select>

  </div>

  <h1>Cronograma</h1>

  <div class="mb-3">

    <div class="form-group">
      <input type="date" name="fechaInicio" id="" required><br>
    </div>
  </div>

  <div class="mb-3">

    <div class="form-group">
      <input type="time" name="horaInicio" id="" required><br>
    </div>
  </div>

  <div class="mb-3">

    <div class="form-group">
      <input type="date" name="fechaFin" id="" required><br>
    </div>
  </div>
  <div class="mb-3">

  <div class="form-group">
    <input type="time" name="horaFin" id="" required><br>
  </div>
  </div>


  <button type="submit" class="btn btn-primary">Enviar</button>
</form>