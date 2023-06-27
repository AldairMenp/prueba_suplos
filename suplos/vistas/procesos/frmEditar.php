<a href="?controlador=procesos&metodo=frmDocumentos&id=<?= $this->id; ?>" class="btn btn-primary">Añadir documentos<a>
  
<h1>Editar Procesos</h1>
<form action="?controlador=procesos&metodo=actualizar" method="POST" id="frmEditar">

<input type="hidden" name="id" value="<?= $this->id; ?> ">
  <div class="mb-3">
    <label for="exampleInputObjeto" class="form-label">Objeto</label>
    <input type="text" name="objetivo" value="<?= $this->objeto; ?>" class="form-control"
     id="exampleInputObjeto" required>
  </div>

  <div class="mb-3">
    <label for="exampleInputNombre" class="form-label">Digite nombre del comprador</label>
    <input type="text" value="<?= $this->nombre_responsable; ?>" name="nombreResponsable"
     class="form-control" id="exampleInputNombre" required>

  </div>

  <div class="mb-3">

    <div class="form-group">
      <label for="my-textarea">Descripcion</label>
      <textarea id="my-textarea" name="descripcion" class="form-control"
       rows="3" required><?= $this->descripcion; ?></textarea>
    </div>
  </div>

  <div class="mb-3">

    <select class="form-select" data-selector='<?= $this->moneda; ?>' name="moneda" id="moneda" aria-label="Seleccione moneda">
      <option>Selecione moneda</option>
      <option value="COP">COP</option>
      <option value="USD">USD</option>
      <option value="EUR">EUR</option>
    </select>

  </div>





  <div class="mb-3">
    <label for="exampleInputPresupuesto" class="form-label">Presupuesto</label>
    <input type="number" value="<?= $this->presupuesto; ?>" class="form-control" required name="presupuesto" id="exampleInputPresupuesto" aria-describedby="emailHelp">

  </div>


  <div class="mb-3">

    <select class="form-select" name="actividad" aria-label="Seleccione Actividad">
      <option value="none">Seleccione actividades</option>
      <?php
      foreach ($this->selectorActividades as  $value) {

        if ($value["id"] == $this->actividades_id) {

          echo '<option value="' . $value["id"] . '" selected>' . $value["nombre_segmento"] . '</option>';
        } else {

          echo '<option value="' . $value["id"] . '">' . $value["nombre_segmento"] . '</option>';
        }
      }
      ?>
    </select>

  </div>

  <h1>Cronograma</h1>

  <input type="date" name="fechaInicio" id="" value="<?= $this->fecha_inicio;  ?>" required>


  <input type="time" name="horaInicio" id="" value="<?= $this->hora_inicio;  ?>" required>
  <input type="date" name="fechaFin" id="" value="<?= $this->fecha_fin;  ?>" required>
  <input type="time" name="horaFin" id="" value="<?= $this->hora_fin;  ?>" required>


  <button type="submit" class="btn btn-primary">Enviar</button>
</form>