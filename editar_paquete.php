<?php
/**
 * Created by PhpStorm.
 * User: carlos
 * Date: 11/8/15
 * Time: 9:03 PM
 */

require('configs/include.php');
require_once('utils.php');
require_once('ghost_config.php');

class c_editar_paquete extends ghost_admin_controller {

    public function paquete_es_mantenido_por_usuario_actual($repositorio, $nombre){
        $cod['paquetexusuario']['paquete'] = $nombre;
        $cod['paquetexusuario']['repositorio'] = $repositorio;
        $cod['paquetexusuario']['usuario'] = $_SESSION["nombre_usuario"];

        $options["paquetexusuario"]["lvl2"] = "one";

        $this->orm->connect();
        $this->orm->read_data(array("paquetexusuario"),$options,$cod);
        $paquetexusuario = $this->orm->get_objects("paquetexusuario");

        if($paquetexusuario == null){
            return false;
        }else{
            return true;
        }
    }


    public function editar_paquete(){
        $data = $this->post;
        $arch = $data->arquitectura;
        $options["paquetexusuario"]["lvl2"] = "by_usuario_repositorio";
        $cod['paquetexusuario']['nombre_repositorio'] = $this->post->repositorio_viejo;
        $cod['paquetexusuario']['paquete'] = $this->post->nombre_viejo;
        $cod['paquetexusuario']['usuario'] = $_SESSION["nombre_usuario"];
        // si no se hace esto el usuario podria hacer que el sistema
        // modifique paquetes de otro usuario

        $this->orm->connect();

        $this->orm->read_data(array('paquetexusuario'), $options, $cod);
        $paquetexusuario = $this->orm->get_objects("paquetexusuario");
        if($paquetexusuario == null) {
            $this->engine->assign('error_msg',"Hay un error en la verificacion de roles.");
            return;
        }

        // pruebas de las arquitectura en el backEnd
        if(!in_array($arch,paquete::getArchitectures())) {
            $this->engine->assign('error_msg',"la arquitectura selecionado '$arch' no es valida, por favor seleccione otra.");
            return;
        }
        {
            $finfo = new finfo(FILEINFO_MIME);
            if(strpos($finfo->file($_FILES['file']['tmp_name']),"application/zip") === true) {
                $this->engine->assign('error_msg',"el archivo no es valido ");
                return;
            }
        }


        $upload_dir = ghost_config::get_package_path($this->post->repositorio_viejo,$this->post->nombre_viejo);
        unlink($upload_dir);
        $upload_dir = ghost_config::get_package_path($this->post->repositorio,$this->post->nombre);
        echo $upload_dir;
        if(!move_uploaded_file($_FILES['file']['tmp_name'], $upload_dir)) {
            $this->engine->assign('error_msg',"no fue posible subir el archivo");
            var_dump($_FILES);
            return;
        }



        $data->fecha_ultima_actualizada = date('Y/m/d H:i:s');
        $data->tamano_comprimido = $_FILES["file"]["size"];
        {
            $zip = zip_open($upload_dir);
            $data->tamano_instalado = 0;
            if($zip) {
                while($zip_entry = zip_read($zip)) {
                    $data->tamano_instalado += zip_entry_filesize($zip_entry);
                }
            }
            zip_close($zip);
        }
        //paquete::insert_object($paquete);

        {

            $lic = new licencia();
            $lic->set("paquete", $this->post->nombre_viejo);
            $lic->set("repositorio", $this->post->repositorio_viejo);


            $dep = new dependencia();
            $dep->set("paquete", $this->post->nombre_viejo);
            $dep->set("repositorio", $this->post->repositorio_viejo);



            $this->orm->delete_data('by_paquete_repositorio', $dep);
            $this->orm->delete_data('by_paquete_repositorio', $lic);

        }



        {
            $paquete = new paquete($data);
            $paquete->auxiliars['nombre_viejo'] = $this->post->nombre_viejo;


            $this->orm->update_data('normal',$paquete);



            $pxu = new paquetexusuario();
            $pxu->set('paquete',$this->post->nombre);
            $pxu->set('repositorio',$this->post->repositorio);
            $pxu->set('usuario',$_SESSION["nombre_usuario"]);


            $pxu->auxiliars['paquete_viejo'] = $this->post->nombre_viejo;
            $pxu->auxiliars['repositorio_viejo'] = $this->post->repositorio_viejo;
            $pxu->auxiliars['usuario_viejo'] = $_SESSION["nombre_usuario"];


            $this->orm->update_data("normal",$pxu);

        }
        $dependencias = $data->dependencia;
        $unique_deps = array();
        foreach($dependencias as $dependencia) {

            $dep = new dependencia();

            $dep->set("paquete", $this->post->nombre);
            $dep->set("repositorio", $this->post->repositorio);
            $dep->set("dependencia", $dependencia);


            $not_in = true;

            foreach($unique_deps as $elem)  {
                if($elem->get('dependencia') == $dependencia) {
                    $not_in = false;
                    break;
                }

            }

            if($not_in)
                $unique_deps[] = $dep;

        }
        foreach($unique_deps as $dependencia) {
//            var_dump($dependencia);
            $this->orm->insert_data("normal",$dependencia);
        }
        $licencias = $data->licencia;
        $unique_lics = array();
        foreach($licencias as $licencia) {
            $lic = new licencia();
            $lic->set("paquete", $this->post->nombre);
            $lic->set("repositorio", $this->post->repositorio);
            $lic->set("valor", $licencia);




            $not_in = true;

            foreach($unique_lics as $elem)  {
                if($elem->get('paquete') == $licencia) {
                    $not_in = false;
                    break;
                }

            }

            if($not_in)
                $unique_lics[] = $lic;
        }
        foreach($unique_lics as $licencia) {
            $this->orm->insert_data("normal",$licencia);
        }


        $this->orm->close();

        $index = $gvar['l_global'];
        header("Location: $index index.php?success_msg=paquete actualizado exitosamente.");
    }
    public function display()
    {
        $this->engine->assign('title',$this->gvar['n_index']);
        $this->engine->display('header.tpl');
        $this->engine->display('editar_paquete.tpl');
        $this->engine->display('footer.tpl');
        $this->engine->display('message.tpl');
    }
    public function run()
    {
        try {
            parent::run();
            if(isset($this->post->option)){
                $this->{$this->post->option}();
            }
        } catch (Exception $e) {
            $this->error =  1;
            $index = $gvar['l_global'];
//            header("Location: $index index.php?success_msg=error al actualizar el paquete");
            $this->engine->assign('error_msg',"error desconocido al editar paquete" . $e->getMessage());
        }
        $paquete = c_utils::get_paquete($this->get->nombre, $this->get->repositorio,$this->orm);
        $paquete->nombre_viejo = $this->get->nombre;
        $paquete->repositorio_viejo = $this->get->repositorio;
//        var_dump($paquete);
        $this->engine->assign('paquete',$paquete);
        $this->engine->assign('repositorios', c_utils::get_repositorios($this->orm));
        $this->engine->assign('licencias', licencia::getLicencias());
        $this->engine->assign('archs', paquete::getArchitectures());
        $this->display();
    }
}
$call = new c_editar_paquete();
$call->run();

header ("Connection: close");