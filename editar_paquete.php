<?php
/**
 * Created by PhpStorm.
 * User: carlos
 * Date: 11/8/15
 * Time: 9:03 PM
 */

require('configs/include.php');
require_once('utils.php');

class c_editar_paquete extends ghost_admin_controller {



    public function editar_paquete(){

        $data = $this->post;

        $arch = $data->arquitectura;


        $options["paquetexusuario"]["lvl2"] = "by_usuario_repositorio";

        $cod['paquetexusuario']['nombre_repositorio'] = $this->get->repositorio;
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

        {
            $obj = new stdClass();
            $obj->paquete = $this->post->nombre_viejo;
            $obj->repositorio = $this->get->repositorio;

            $dep = new dependencia($obj);

            $this->orm->delete_data('by_paquete_repositorio', $dep);
        }





        $this->orm->close();




//        var_dump($data);
//        sleep(10);

        // pruebas de las arquitectura en el backEnd
        if(!in_array($arch,paquete::getArchitectures())) {
            $this->engine->assign('error_msg',"la arquitectura selecionado '$arch' no es valida, por favor seleccione otra.");
            return;
        }




        {
            $finfo = new finfo(FILEINFO_MIME);

            if(strpos($finfo->file($_FILES['file']['tmp_name']),"application/zip") === true) {

                $this->engine->assign('error_msg',"el archivo no es valido $type");
                return;
            }

        }
        $upload_dir = ghost_config::get_package_path($data->repositorio,$this->post->nombre_viejo);
        unlink($upload_dir);

        $upload_dir = ghost_config::get_package_path($data->repositorio,$data->nombre);

        if(!move_uploaded_file($_FILES['file']['tmp_name'], $upload_dir)) {

            $this->engine->assign('error_msg',"no fue posible subir el archivo");
            return;

        }



        $data->fecha_subida = date('Y/m/d H:i:s');
        $data->fecha_ultima_actualizada = $data->fecha_subida;

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
            $paquete = new paquete($data);

            $paquete->auxiliars['nombre_viejo'] = $this->post->nombre_viejo;
//        var_dump($paquete);
            $this->orm->connect();
            $this->orm->update_data('normal',$paquete);
            $this->orm->close();
//        rename("files/$nombre_viejo","files/$nombre");


        }

        $dependencias = $data->dependencia;


        foreach($dependencias as $dependencia) {
            $temp = new stdClass();

            $temp->paquete = $data->nombre;
            $temp->repositorio = $data->repositorio;
            $temp->dependencia = $dependencia;

            $dep = new dependencia($temp);

            dependencia::insert_object($dep);

        }

        $licencias = $data->licencia;

        foreach($licencias as $licencia) {
            $temp = new stdClass();
            $temp->paquete = $data->nombre;
            $temp->repositorio = $data->repositorio;
            $temp->valor = $licencia;

            $lic = new licencia($temp);

            licencia::insert_object($lic);
        }


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
            header("Location: $index index.php?success_msg=error al actualizar el paquete");


        }

        $paquete = c_utils::get_paquete($this->get->nombre, $this->get->repositorio,$this->orm);
        $paquete->nombre_viejo = $this->get->nombre;



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
