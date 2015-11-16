<?php

/**
 * Created by PhpStorm.
 * User: carlos
 * Date: 11/5/15
 * Time: 3:09 PM
 */

require('configs/include.php');
require_once('utils.php');
require_once('ghost_config.php');
//include_once('active_record/ghost_object.php');

class c_registrar_paquete extends ghost_controller
{


    public function registrar_paquete() {

        $data = $this->post;

        $arch = $data->arquitectura;

//        var_dump($data);
//        sleep(10);

        // pruebas de las arquitectura en el backEnd
        if(!in_array($arch,paquete::getArchitectures())) {
            $this->engine->assign('error_msg',"la arquitectura selecionado '$arch' no es valida, por favor seleccione otra.");
            return;
        }

        $upload_dir = ghost_config::get_package_path($data->repositorio,$data->nombre);

//        echo "el directorio es : ". $upload_dir;

//        echo "error : ".$_FILES['file']['error'];
//        sleep(10);

        if(!move_uploaded_file($_FILES['file']['tmp_name'], $upload_dir)) {

            $this->engine->assign('error_msg',"no fue posible subir el archivo");
            return;

        }



        $data->fecha_subida = date('Y/m/d H:i:s');
        $data->fecha_ultima_actualizada = $data->fecha_subida;

        // TODO calcular correctamente
        $data->tamano_comprimido = $_FILES["file"]["size"];
        $data->tamano_instalado = 1;

        $paquete = new paquete($data);

        paquete::insert_object($paquete);

        $dependencias = $data->dependencia;


        foreach($dependencias as $dependencia) {
            $temp = new stdClass();

            $temp->paquete = $data->nombre;
            $temp->repositorio = $data->repositorio;
            $temp->dependencia = $dependencia;

            $dep = new dependencia($temp);

            dependencia::insert_object($dep);

        }



        // TODO capturar exepciones
        $index = $gvar['l_global'];
        header("Location: $index index.php?success_msg=paquete registrado exitosamente.");



    }


    public function display()
    {
        $this->engine->assign('title',$this->gvar['n_index']);
        $this->engine->assign('repositorios', repositorio::get_all());
        $this->engine->assign('archs',paquete::getArchitectures());

        $this->engine->display('header.tpl');
        $this->engine->display('registrar_paquete.tpl');
        $this->engine->display('footer.tpl');
        $this->engine->display('message.tpl');
    }


    public function run()
    {
        parent::run();
        if(isset($this->post->option)){
            $this->{$this->post->option}();
        }
        $this->display();
    }

}

$call = new c_registrar_paquete();
$call->run();

header ("Connection: close");