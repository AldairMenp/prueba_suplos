<?php
require_once "modelo/usuario_modelo.php";
require_once "modelo/mts-prestamo_modelo.php";
require_once "modelo/mt_biblio_modelo.php";
require_once "modelo/mt_tec_modelo.php";
require_once "modelo/mt_vr_modelo.php";
/**
 * clase que controla el usuario
 */
class usuario_controlador
{
    /**
     * metodo lleva la clase vista
     */
    public function __construct()
    {
        $this->vista = new vista();
    }
    /**
     * metodo muestra la vista de informacion de institucion 
     */
    public function frmInfonins()
    {
        session_start();// Comprobamos si ya tiene una sesion
        if (isset($_SESSION['rol'])) {
           
            $this->vista->unirContenido("usuario/informacion");
            die();
        }else{
            header('Location:  ?controlador=usuario&accion=frmLogin');
        }
    }
    public function contactenos()
    {
        session_start();// Comprobamos si ya tiene una sesion
        if (isset($_SESSION['rol'])) {
           
            $this->vista->unirContenido("usuario/contactenos");
        }else{
            
            header("location:index.php");
       }
    }
    /**
     * metodo muestra la vista de el index
     */
    public function frmLogin()
    {
        session_start();// Comprobamos si ya tiene una sesion
        if (isset($_SESSION['rol'])) {
            header('Location:  ?controlador=usuario&accion=frmLobby');
            die();
        }else{
            $this->vista->unirContenido("login/index");
        }
    }
    /**
     * metodo de el login toma los datos y los lleva a 3 metodos en el modelo usuario el primero verifica si existe el 2 su estado el 3 crea la variable de session con 
     * 4 datos nombre apellido id rol 
     */
    public function login(){
        session_start();// Comprobamos si ya tiene una sesion
        if (isset($_SESSION['rol'])) {
            header('Location:  ?controlador=usuario&accion=frmLobby');
            die();
        }else{
            extract($_POST);
            $log["id"]   = $id;
            $log["pass"] = $pass;
            $log["doc"]  = $doc;
            if ($id != "" && $pass != "") {
                //var_dump($rol);
                $exist = usuario_modelo::mdlBuscarById($id);
                $rta = usuario_modelo::mdlLogin($log);
                if($exist > 0){  
                    if($rta != "" && $rta["estado_usu"] == 0){
                        echo json_encode(array("mensaje" => "bloqueado"));
                       
                    }else{

                        if ($rta != "") {
                            $rol = usuario_modelo::mdlSesion($id);
                            $_SESSION["foto"] = usuario_modelo::imagen_perfil($id);
                            $_SESSION["rol"] = $rol;
                            /*foreach ($rol as $dato) {
                                $_SESSION["rol"] = $dato["rol_usu"];
                            }*/
                            echo json_encode(array("mensaje" => "index.php"));
                        
                        } else {
                            echo json_encode(array("mensaje" => "Datos incorrectos"));
                            //echo "datos incorrectos";
                        }
                    }
                }else {
                    echo json_encode(array("mensaje" => "c"));
                    //echo "datos incorrectos";
                }
            } else {
                echo json_encode(array("mensaje" => "Campos incompletos"));
                //echo "datos incompletos";
            }
        }
    }
    /** 
     * metodo cerrar session elimina todas las variables de session del sistena
     */
    public function Logout(){
        session_start();
        session_destroy();//destruimos la sesion
        $_SESSION = array();//limpiamos la sesion
        header('Location:  ?controlador=usuario&accion=frmLogin');
        die();
    }
    /**
     * metodo del formulario lobby carga el formario de lobby con informacion de su contenido como imagenes princiaples y informacion
     */
    public function frmLobby(){
        session_start();
        if (isset($_SESSION['rol'])) {
            $this->vista->rta = usuario_modelo::imgprincipal();
            $b = mt_biblio_modelo::mdlTotal();
            $t = mt_tec_modelo::mdlTotal();
            $v = mt_vr_modelo::mdlTotal();
            $this->vista->infomateriales = array($b,$t,$v);
            $this->vista->arrayroles = usuario_modelo::mdlcantidad();
            $this->vista->unirContenido("usuario/lobby");
        }else{
            header('Location: ?controlador=usuario&accion=frmLogin');
            die();
        }
        
    }
    /**
     * metodo del formulario de actualización de datos del usuario 
     */
    public function frmActualizacion(){
        session_start();
        if (isset($_SESSION['rol'])) {
            foreach($_SESSION['rol'] as $dato){
                $id = $dato['id_usu']; 
                $this->vista->datos = usuario_modelo::mdlBusquedauser($id);
            }
            $this->vista->unirContenido("usuario/actualizacion_datos");
        }else{
            header('Location: ?controlador=usuario&accion=frmLogin');
            die();
        }
    }
    /**
     * metodo que actualiza informacion toma los datos y los actualiza en el metodo estatico mdlactualizar
     */
    public function actualizar(){
        session_start();
        if (isset($_SESSION['rol'])) {
            extract($_REQUEST);
            $datos['tel'] = $tel;
            $datos['direc'] = strtoupper($direc);
            $datos['correo'] = strtoupper($correo);
            $datos['correo2'] = strtoupper($correo2);
            $datos['id'] = $id;
            $union = $datos["tel"].$datos["direc"].$datos["correo"];
            if($verificar[0] == $union){
                echo json_encode (array("mensaje"=>"Datos actualizados existen"));//correcta
            }else{
                if( $datos['tel'] != "" && $datos['direc'] != "" && $datos['correo'] !="" && $datos["correo2"] != "" ){

                    if($correo == $correo2){
                        $rta = usuario_modelo::mdlActualizar($datos);
                        if ($rta > 0) {
                            echo json_encode (array("mensaje"=>"Usuario actualizado correctamente"));//correcta
                        }else {
                            echo json_encode (array("mensaje"=>"Error al actualizar"));//error
                        }
                    }else{
                        echo json_encode (array("mensaje"=>"Confirmacion de correo eletronico no coinside")); //Informacion no coinside
                    }
                    
                }else{
                    echo json_encode (array("mensaje"=>"Campos vacios"));//campos vacios
                }
            }
        }else{
            header('Location: ?controlador=usuario&accion=frmLogin');
            die();
        }
    }
    /**
     * metodo del formulario informacion , formulario donde podras visualizar la informacion de los usuarios dependioendo a tu rol que incia podras visualizar
     */
    public function frmInfo(){
        session_start();// Comprobamos si ya tiene una sesion
        if (isset($_SESSION['rol'])) {

            foreach ($_SESSION["rol"] as $var){
                $rol = $var["rol_usu"];
            }
            if($rol == 6  || $rol == 7){
                $limite = 15;
                $total  = usuario_modelo::mdlTotal();
                
                if ($total > $limite) {
                    $secciones = ceil($total / $limite);
                } else {
                    $secciones = 1;
                }
                if (isset($_GET["pagina"]) && is_numeric($_GET["pagina"])) {
                    $pagina = $_GET["pagina"];
                } else {
                    $pagina = 0;
                }

                $pag_actual        = ($pagina / $limite) + 1;
                $this->vista->info = usuario_modelo::mdlListar($pagina, $limite);
                if ($secciones > 1) {

                    $this->vista->pag = "";
                    for ($i = 1; $i <= $secciones; $i++) {
                        if ($i != $pag_actual) {
                            $this->vista->pag .= "<a class='paginar' href='?controlador=usuario&accion=frmInfo&pagina=" . ($limite * ($i - 1)) . "'>" . $i . "</a> ";
                        } else {
                            $this->vista->pag .= "<a class='active'>".$i."</a>";
                        }
                    }
                } else {
                    $this->vista->pag = "";

                }
                $this->vista->unirContenido("usuario/usuarios_lista_info");
            }else{
                header("location:index.php");
            }
            die();
        }else{
            header('Location: ?controlador=usuario&accion=frmLogin');
        }
    }
    /**
     * metodo que maneja la busqueda de usuario metodo busca por la variable busqueda busca la informacion en la bd
     */
    public function listado(){
        session_start();

        foreach ($_SESSION["rol"] as $var){
            $rol = $var["rol_usu"];
        }
        if($rol == 6  || $rol == 7){
            extract($_REQUEST);
            $busqueda =str_replace(' ', '', $busqueda);
            $limite = 15;
            $total  = usuario_modelo::mdlTotalusu($busqueda);
            if($total > 0){
                if ($total > $limite) {
                    $secciones = ceil($total / $limite);
                } else {
                    $secciones = 1;
                }
                if (isset($_GET["pagina"]) && is_numeric($_GET["pagina"])) {
                    $pagina = $_GET["pagina"];
                } else {
                    $pagina = 0;
                }

                $pag_actual        = ($pagina / $limite) + 1;
                $this->vista->info = usuario_modelo::mdlListarusu($pagina, $limite, $busqueda);

                $tabla             = "";
                if ($secciones >= 1) {
                    $tabla = '<br><table class="table">
                        <thead class="thead" class="border">
                            <tr>
                                <th scope="col" colspan="10" class ="text-center border">LISTA DE INFORMACION</th>
                            </tr>
                            <tr>
                                <th scope="col" class="text-center border">ID</th>
                                <th scope="col" class="text-center border">USUARIO</th>
                                <th scope="col" class="text-center border">GRADO O LABOR</th>
                                <th scope="col" class="text-center border">PRESTAMOS</th>
                                <th scope="col" class="text-center border">ACCIONES</th>
                            </tr>
                        </thead>';
                    foreach ($this->vista->info as $valor) {
                        $id = $valor["id_usu"];
                        $tabla .= "<tr>
                        <td>" . $valor["id_usu"] . "</td>
                        <td>" . $valor["nombre_usu"] ." " . $valor["apellido_usu"] ."</td>"
                        ;
                        if ($valor['estado_usu'] == 0) {
                        
                            foreach($_SESSION["rol"] as $va){ 
                                $rol = $va["rol_usu"] ;
                            } 
                            if($rol == 6){ 
                                if($valor["rol_usu"] != 2  and $valor["rol_usu"] != 6 and $valor["rol_usu"] != 7 ){
                                    $tabla .="<td>ESTUDIANTE</td>
                                    <td>BLOQUEADO</td><td><a class='desblo' href='?controlador=usuario&accion=desbloquear&id=$id'>
                                    <i class='fa fa-check' aria-hidden='true'></i>Desbloquear</a>" . "&nbsp;" 
                                    . "<a class='eliusu'href='?controlador=usuario&accion=eliminar&id=$id'>
                                    <i class='fa fa-times' aria-hidden='true'></i> Eliminar</a>" . "&nbsp;" .
                                    "<a class='ok'  href='?controlador=usuario&accion=frmVisual&id=$id'><i class='fa fa-check' aria-hidden='true'></i>Visualizar</a>
                                </td>"
                                ;
                                }elseif($valor["rol_usu"] == 7){
                                    $tabla .="<td>BIBLIOTECARIO</td>
                                    <td>BLOQUEADO</td><td><a class='desblo' href='?controlador=usuario&accion=desbloquear&id=$id'>
                                    <i class='fa fa-check' aria-hidden='true'></i>Desbloquear</a>" . "&nbsp;" 
                                    . "<a class='eliusu'href='?controlador=usuario&accion=eliminar&id=$id'>
                                    <i class='fa fa-times' aria-hidden='true'></i> Eliminar</a>" . "&nbsp;" .
                                    "<a class='ok'  href='?controlador=usuario&accion=frmVisual&id=$id'><i class='fa fa-check' aria-hidden='true'></i>Visualizar</a>
                                </td>"
                                ;
                                }elseif($valor["rol_usu"] == 6){
                                    $tabla .="<td>DIRECTIVO</td>
                                    <td>BLOQUEADO</td><td><a class='desblo' href='?controlador=usuario&accion=desbloquear&id=$id'>
                                    <i class='fa fa-check' aria-hidden='true'></i>Desbloquear</a>" . "&nbsp;" 
                                    . "<a class='eliusu'href='?controlador=usuario&accion=eliminar&id=$id'>
                                    <i class='fa fa-times' aria-hidden='true'></i> Eliminar</a>" . "&nbsp;" .
                                    "<a class='ok'  href='?controlador=usuario&accion=frmVisual&id=$id'><i class='fa fa-check' aria-hidden='true'></i>Visualizar</a>
                                </td>"
                                ;
                                }elseif($valor["rol_usu"] == 2){
                                    $tabla .="<td>PROFESOR</td>
                                    <td>BLOQUEADO</td><td><a class='desblo' href='?controlador=usuario&accion=desbloquear&id=$id'>
                                    <i class='fa fa-check' aria-hidden='true'></i>Desbloquear</a>" . "&nbsp;" 
                                    . "<a class='eliusu'href='?controlador=usuario&accion=eliminar&id=$id'>
                                    <i class='fa fa-times' aria-hidden='true'></i> Eliminar</a>" . "&nbsp;" .
                                    "<a class='ok'  href='?controlador=usuario&accion=frmVisual&id=$id'><i class='fa fa-check' aria-hidden='true'></i>Visualizar</a>
                                </td>"
                                ;
                                }
                            }else{
                                if($valor["rol_usu"] != 2  and $valor["rol_usu"] != 6 and $valor["rol_usu"] != 7 ){
                                    $tabla .="<td>ESTUDIANTE</td>
                                    <td>BLOQUEADO</td><td><a class='desblo' href='?controlador=usuario&accion=desbloquear&id=$id'>
                                    <i class='fa fa-check' aria-hidden='true'></i>Desbloquear</a>" . "&nbsp;" 
                                    . "<a class='eliusu'href='?controlador=usuario&accion=eliminar&id=$id'>
                                    <i class='fa fa-times' aria-hidden='true'></i> Eliminar</a>" . "&nbsp;" .
                                    "<a class='ok'  href='?controlador=usuario&accion=frmVisual&id=$id'><i class='fa fa-check' aria-hidden='true'></i>Visualizar</a>
                                </td>"
                                ;
                                
                            }else if($valor["rol_usu"] == 7){
                                $tabla .= "<td>BIBLIOTECARIO</td>
                                <td>BLOQUEADO</td><td>USUARIO NO PUEDE SER VISUALIZADO
                                </td>"
                                ;
                            }elseif($valor["rol_usu"] == 6){
                                $tabla .= "<td>DIRECTIVO</td>
                                <td>BLOQUADO</td><td>USUARIO NO PUEDE SER VISUALIZADO
                                </td>"
                                ;
                            }elseif($valor["rol_usu"] == 2){
                                echo "<td>PROFESOR</td>
                            <td>BLOQUEADO</td><td>USUARIO NO PUEDE SER VISUALIZADO
                                </td>"
                                ;
                            }
                            }

                        }else{
                            foreach($_SESSION["rol"] as $va){ 
                                $rol = $va["rol_usu"] ;
                            } 
                            if($rol == 6){ 
                                if($valor["rol_usu"] != 2  and $valor["rol_usu"] != 6 and $valor["rol_usu"] != 7 ){
                                    $tabla .= "<td>ESTUDIANTE</td>
                                    <td>ACTIVO</td><td><a class='bloque' href='?controlador=usuario&accion=bloquear&id=$id'>
                                    <i class='fa fa-times' aria-hidden='true'></i>Bloquear</a>"."&nbsp;&nbsp;".
                                    "<a class='eliusu' href='?controlador=usuario&accion=eliminar&id=$id'><i class='fa fa-times' aria-hidden='true'></i> Eliminar</a>"."&nbsp;"."<a class='ok'  href='?controlador=usuario&accion=frmVisual&id=$id'><i class='fa fa-check' aria-hidden='true'></i>Visualizar</a>
                                    </td>"
                                    ;
                                    
                                }elseif($valor["rol_usu"] == 7){
                                    $tabla .= "<td>BIBLIOTECARIO</td>
                                    <td>ACTIVO</td><td><a class='bloque' href='?controlador=usuario&accion=bloquear&id=$id'>
                                    <i class='fa fa-times' aria-hidden='true'></i>Bloquear</a>"."&nbsp;&nbsp;".
                                    "<a class='eliusu' href='?controlador=usuario&accion=eliminar&id=$id'><i class='fa fa-times' aria-hidden='true'></i> Eliminar</a>"."&nbsp;"."<a class='ok'  href='?controlador=usuario&accion=frmVisual&id=$id'><i class='fa fa-check' aria-hidden='true'></i>Visualizar</a>
                                    </td>"
                                    ;
                                    
                                }elseif($valor["rol_usu"] == 6){
                                    $tabla .= "<td>DIRECTIVO</td>
                                    <td>ACTIVO</td><td><a class='bloque' href='?controlador=usuario&accion=bloquear&id=$id'>
                                    <i class='fa fa-times' aria-hidden='true'></i>Bloquear</a>"."&nbsp;&nbsp;".
                                    "<a class='eliusu' href='?controlador=usuario&accion=eliminar&id=$id'><i class='fa fa-times' aria-hidden='true'></i> Eliminar</a>"."&nbsp;"."<a class='ok'  href='?controlador=usuario&accion=frmVisual&id=$id'><i class='fa fa-check' aria-hidden='true'></i>Visualizar</a>
                                    </td>"
                                    ;
                                    
                                }elseif($valor["rol_usu"] == 2){
                                    $tabla .= "<td>PROFESOR</td>
                                    <td>ACTIVO</td><td><a class='bloque' href='?controlador=usuario&accion=bloquear&id=$id'>
                                    <i class='fa fa-times' aria-hidden='true'></i>Bloquear</a>"."&nbsp;&nbsp;".
                                    "<a class='eliusu' href='?controlador=usuario&accion=eliminar&id=$id'><i class='fa fa-times' aria-hidden='true'></i> Eliminar</a>"."&nbsp;"."<a class='ok'  href='?controlador=usuario&accion=frmVisual&id=$id'><i class='fa fa-check' aria-hidden='true'></i>Visualizar</a>
                                    </td>"
                                    ;
                                    
                                }
                            }else{
                                if($valor["rol_usu"] != 2  and $valor["rol_usu"] != 6 and $valor["rol_usu"] != 7 ){
                                    $tabla .= "<td>ESTUDIANTE</td>
                                    <td>ACTIVO</td><td><a class='bloque' href='?controlador=usuario&accion=bloquear&id=$id'>
                                    <i class='fa fa-times' aria-hidden='true'></i>Bloquear</a>"."&nbsp;&nbsp;".
                                    "<a class='eliusu' href='?controlador=usuario&accion=eliminar&id=$id'><i class='fa fa-times' aria-hidden='true'></i> Eliminar</a>"."&nbsp;"."<a class='ok'  href='?controlador=usuario&accion=frmVisual&id=$id'><i class='fa fa-check' aria-hidden='true'></i>Visualizar</a>
                                    </td>"
                                    ;
                                    
                                }elseif($valor["rol_usu"] == 7){
                                    $tabla .= "<td>BIBLIOTECARIO</td>
                                    <td>ACTIVO</td><td>USUARIO NO PUEDE SER VISUALIZADO
                                    </td>"
                                    ;
                                }elseif($valor["rol_usu"] == 6){
                                    $tabla .= "<td>DIRECTIVO</td>
                                    <td>ACTIVO</td><td>USUARIO NO PUEDE SER VISUALIZADO
                                    </td>"
                                    ;
                                }elseif($valor["rol_usu"] == 2){
                                    $tabla .= "<td>PROFESOR</td>
                                <td>ACTIVO</td><td>USUARIO NO PUEDE SER VISUALIZADO
                                    </td>"
                                    ;
                                }
                            }
                    }
                }
                    $tabla .= "</tr>  </table>";

                    $this->vista->pag = "";
                    for ($i = 1; $i <= $secciones; $i++) {
                        if ($i != $pag_actual) {
                            
                            $this->vista->pag .= "<a  href='?controlador=usuario&accion=listado&pagina=" . ($limite * ($i - 1)) . "' class='paginacion paginar' data-parametro='" . $busqueda . "''>" . $i . "</a> ";
                            
                        }else{
                            $this->vista->pag .= "<a class='active'>".$i."</a>";
                        }
                    }
                } else {
                    $this->vista->pag = "";

                }
            }else{
                $tabla = '
                    <br>
                    <br>
                    <center><h1>USUARIO NO ENCONTRADO</h1></center>
                    <br>
                ';
                $this->vista->pag = "";

            }
            echo json_encode(array("respuesta" => $this->vista->pag, "tabla" => $tabla));
        }else{
            header("location:index.php");
        }
    }
    /**
     * metodo de bloquear usuario bloquea el usuario escogido en la lista de info pero no te deja bloquearte si tienes session iniciada
     */
    public function bloquear()
    {
        session_start();
        extract($_REQUEST);
        foreach($_SESSION["rol"] as $date){
            $id2 = $date["id_usu"];
        }
        if($id2 == $id){
            echo json_encode(array("msje" => "i"));
        }else{
            $rta = usuario_modelo::mdlbloqueo($id);
            if ($rta > 0) {
                echo json_encode(array("msje" => "Usuario bloquado"));//usuario bloqueado
            } else {
                echo "<br>ERROR AL ELIMINAR";
            }
        }
    }
    /**
     * metodo de desbloquear usuario en el sistema bloquea cambia estado de usuaro
     */
    public function desbloquear()
    {
        extract($_REQUEST);
        $rta = usuario_modelo::mdldesbloqueo($id);
        if ($rta > 0) {
            echo json_encode(array("msje" => "Usuario desbloquado"));
            //usuario desbloqueado
        } else {
            echo "<br>ERROR AL ELIMINAR";
        }
    }
    /**
     * metodo de eliminar usuario en el sistema sin dejarte auto eliminar y si debe prestamos no deja eliminar
     */
    public function eliminar()
    {   
        session_start();
        extract($_REQUEST);
        $p = usuario_modelo::mdlcantp($id);
        if($p == 0){
            foreach($_SESSION["rol"] as $date){
                $id2 = $date["id_usu"];
            }
            if($id2 == $id){
                echo json_encode(array("delete" => "i"));
                //No puedes autoeliminarte
            }else if(1==1){
                $rta = usuario_modelo::mdlEliminar($id);
                if ($rta > 0) {
                    echo json_encode(array("delete" => "true"));
                    //eliminado correctamente
                } else {
                    echo "<br>ERROR AL ELIMINAR";
                }
            }
        }else{
            echo json_encode(array("delete" => "p"));// si el usuario debe prestamos muestra esta alerta 
        }
    }
    /**
     * metodo de vista de visualizar visualiza informacion de usuario de una forma mas amplia
     */
    public function frmVisual(){
        session_start();
        if (isset($_SESSION['rol'])) {
            foreach ($_SESSION["rol"] as $var){
                $rol = $var["rol_usu"];
            }
            if($rol == 6  || $rol == 7 || $rol == 2){
                extract($_REQUEST);
                $rta = $this->vista->visu = usuario_modelo::mdlvisual($id);
            
                if ($rta > 0) {
                $this->vista->unirContenido("usuario/usuario_visualizar");
                }
            }else{
                header("location:index.php");
            }
        }else{
            header('Location: ?controlador=usuario&accion=frmLogin');
        }
    }
    /**
     * metodo de vista de cambio de pass 
     */
    public function frmcambiopass(){
        session_start();
        if (isset($_SESSION['rol'])) {
            $this->vista->unirContenido("usuario/usuario_cambio_pass");
        }else{
            header('Location: ?controlador=usuario&accion=frmLogin');
        }
        
    }
    /**
     * metodo de cambio de pass toma los datos los valida y da respuesta a un cambio de contraseña
     */
    public function cambiopass()
    {
        session_start();
        if (isset($_SESSION['rol'])) {
            extract($_POST);
            $con["ante"] = $ante;
            $con["new"]  = $new;
            $con["new2"] = $new2;

            if($ante != "" && $new != "" && $new2 != ""){
                foreach ($_SESSION["rol"] as $dato){
                    $id =  $dato["id_usu"]."<br>";
                }
                if($new == $new2){
                    if($ante == $new){
                        echo json_encode(array("cambio" => "iguales"));
                    }else{
                        $rta = usuario_modelo::mdlcambiopassexiste($con,$id);
                        if($rta > 0){
                            $rta = usuario_modelo::mdlcambiopass($con,$id); 
                            
                            echo json_encode(array("cambio" => "true"));
                        // echo "cambiado";
                        }else{
                            echo json_encode(array("cambio" => "false"));
                        //  echo "claves anterior no icorrecta";

                        }
                    }
                }else{
                    echo json_encode(array("cambio" => "null"));
                   //echo "claves nuevas no coinsiden";

                }            
            }else{
                echo json_encode(array("cambio" => "vacio"));
                //echo "faltan campos";
            }
        }
    }
    /**
     * metodo que muestra la vista del formulario registrar
     */
    public function frmRegistrarusu(){
        session_start();
        if (isset($_SESSION['rol'])) {
            foreach ($_SESSION["rol"] as $var){
                $rol = $var["rol_usu"];
            }
            if($rol == 6 || $rol == 7 ){
                $this->vista->unirContenido("usuario/registro_usuario");
            }else{
                header("location:index.php");
            }
        }else{
            header('Location: ?controlador=usuario&accion=frmLogin');
        }
        
    }
    /**
     * metodo de registrar toma los datos de registro de usuario valida y da respuestas
     */
    public function registrar(){
        extract($_POST);
        $datos["doc"]     = $doc;
        $datos["id"]      = strtoupper($id);
        $datos["nom"]     = strtoupper($nom);
        $datos["ape"]     = strtoupper($ape);
        $datos["sexo"]    = $sexo;
        $datos["fecha"]   = $fecha;
        $datos["tel"]     = $tel;
        $datos["dir"]     = strtoupper($dir);
        $datos["sede"]    = $sede;
        $datos["rol"]     = $rol;
        $datos["muni"]    = $muni;
        $datos["correo"]  = strtoupper($correo);
        $datos["correo2"] = strtoupper($correo2);
        $datos["pass"]    = $pass;
        $datos["pass2"]   = $pass2;
        $datos["est"]     = $est;
        $datos["tipo"]     = $tipo;
        //acudiente
        if( $tipo == 1){
            $datos["dacu"] = $dacu ;
            $datos["nacu"] = $nacu ;
            $datos["aacu"] = $aacu;
            $datos["telacu"] = $telacu;
            $datos["diracu"] = $diracu;
            $datos["correoacu"] = $correoacu; 
            $datos["correoacu2"] = $correoacu2;
        }
        
        if($tipo == 1){
            if ($id != "" && $nom != ""  && $ape != ""  && $fecha != "" 
            && $tel != "" && $dir != ""  && $correo != ""  && $correo2 != "" 
            && $pass != "" && $pass2 != ""  && $dacu != ""  && $nacu != ""  && $aacu != "") {
                if ($correo == $correo2 && $pass == $pass2 && $correoacu == $correoacu2) {

                    $rta = usuario_modelo::mdlRegistrar($datos);
                    if ($rta > 0) {
                        echo json_encode(array("respuesta_usu" => "true"));   //registrado correctamente
                    
                    } else {
                        echo json_encode(array("respuesta_usu" => "false")); // no fue registrado correctamente
                    }
                } else {
                    echo json_encode(array("respuesta_usu" => "i")); //campos de confirmacion no coinsiden
                }
            } else {
                echo json_encode(array("respuesta_usu" => "vacio")); //campos importantes vacios
            }
        }else{
            if ($id != ""  && $nom != ""  && $ape != ""  && $fecha != "" 
             && $tel != ""  && $dir != ""  && $correo != ""  && $correo2 != "" 
            ) {
                if ($correo == $correo2 && $pass == $pass2) {

                    $rta = usuario_modelo::mdlRegistrar($datos);
                    if ($rta > 0) {
                        echo json_encode(array("respuesta_usu" => "true"));  //registrado correctamente

                    } else {
                        echo json_encode(array("respuesta_usu" => "false")); // no fue registrado correctamente
                    }
                } else {
                    echo json_encode(array("respuesta_usu" => "i")); //campos de confirmacion no coinsiden
                    }
            } else {
                echo json_encode(array("respuesta_usu" => "vacio")); //campos importantes vacios
            }
        }
      
    }
    /**
     * metodo de formulario de recuperar
     */
    public function frmRecuperarCorreo(){
        $this->vista->unirContenido("login/recuperar_pass");
    }
    /**
     * metodo para recuperar contraseña por correo toma los datos de correo y fecha y verifica si pertencen a alguien
     */
    public function mandarcorreo(){
       extract($_POST);

        if(isset($_POST["salir"])){

            $this->vista->unirContenido("login/index");
        }else{
           $dato["correo"] = $correo;
           $dato["fecha"] = $fecha;
            if($correo != "" || $fecha != ""){
                $rta = usuario_modelo::recuperarmail($dato);
               

                if($rta  >= 1){
                    $length = 10;
                    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    $charactersLength = strlen($characters);
                    $randomString = '';
                    for ($i = 0; $i < $length; $i++) {
                        $randomString .= $characters[rand(0, $charactersLength - 1)];
                    }
                    $this->clave = $randomString;
                    $pass = password_hash($randomString, PASSWORD_DEFAULT);
                    $rta2 = usuario_modelo::recuperarmaillist($dato,$pass);

                    require_once "vista/login/pass.php";
                    echo json_encode(array("msj" => "true")); //satisfactorio

                }else{
                    echo json_encode(array("msj" => "false")); //error
                
                }
            }else{
                echo json_encode(array("msj" => "vacio")); //campos vacios
            }
        }
     }    
     /**
      * metodo para visualizar mis prestamos muestra mis prestamos activos
      */
    public function frmmisprestamos(){
        session_start();
        if(isset($_SESSION["rol"])){
            foreach ($_SESSION["rol"] as $value){
                $id_usu =  $value["id_usu"];
            }
         
            $rta = usuario_modelo::mdlcanpres($id_usu);
            if($rta > 0){
                $this->vista->rtab = usuario_modelo::mdllistarcanpresB($id_usu);
                $this->vista->rtat = usuario_modelo::mdllistarcanpresT($id_usu);
                $this->vista->rtav = usuario_modelo::mdllistarcanpresV($id_usu);
            }else{
                $this->vista->menor = true;
            }
            $this->vista->unircontenido("prestamos/mis_prestamos");
        }else{
            header('location: index.php');
        }
    }
    /**
     * metodo frmregistraro de vista que registra otros roles es un reguistro de usuarios solo entra rol directivo
     */
    public function frmregistraro(){
        session_start();
       
        if(isset($_SESSION["rol"])){
            foreach ($_SESSION["rol"] as $value){
                $rol =  $value["rol_usu"];
            }
            if($rol == 6){
                $this->vista->unircontenido("usuario/registrar_otros_roles");

            }else{
               header("location:index.php");

            }
        }else{
            header('location: index.php');
        }
    }
}

?>