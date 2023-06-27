<h1>Consultar Procesos</h1>
<form action="?controlador=procesos&metodo=consultar" method="POST" id="consultarProceso">
<br>

    <input type="text" name="busquedaID"  placeholder="Numero ID procesos/ eventos">
    <br>

    <input type="text" name="busquedaDescripcion"  placeholder="Objeto / descripcion">
        <br>

        <input type="text" name="comprador"  
        placeholder="Digite comprador">


<br>
   
    <select id="estadoSelector" name="estadoSelector"  name="">
        <option value="none">Seleccione</option>
        <option value="Y">Activo</option>
        <option value="P">Publicado</option>
        <option value="E">Evaluado</option>
    </select>


    <input  type="submit" name="Buscar" class="btn btn-primary"/>
</form>

<!-- <a href="">Generar Excel</a> -->
<div id="respuesta">
    <table class="table">
        <thead class="thead" class="border">

            <h4>Numero de procesos / Eventos listado <strong>
                    <?= $this->total; ?>
                </strong></h4>
            <tr>
                <th>Id</th>
                <th>Ronda</th>
                <th>Objeto</th>
                <th>Descripcion</th>
                <th>Fecha inicio</th>
                <th>Fecha cierre</th>
                <th>Estado</th>
                <th>Responsable del evento</th>
                <th>Acciones</th>
            </tr>
        </thead>


        <thbody>


            <?php
            foreach ($this->datosPaginados as $valor) {

                echo "<tr>";
                echo "
                <td>" . $valor["id"] . "</td> 
                <td>" . $valor["id"] . "</td> 
                <td>" . $valor["objeto"] . "</td> 
                <td>" . $valor["descripcion"] . "</td> 
                <td>" . $valor["fecha_inicio"] . "</td> 
                <td>" . $valor["fecha_fin"] . "</td> 
                <td>" . $valor["estado"] . "</td> 
                <td>" . $valor["nombre_responsable"] . "</td> 
                <td> 
                <a href='?controlador=procesos&metodo=frmEditar&id=". $valor["id"]."'>EDITAR</a>
                <a class='eliminar-proceso' href='?controlador=procesos&metodo=borrar&id=". $valor["id"]."'  >BORRAR</a>
                 </td> 
                
                ";


                echo "</tr>";
            }

            ?>
        </thbody>

    </table>

    <?= $this->pagina; ?>
</div>
