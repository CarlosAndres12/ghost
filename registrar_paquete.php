<?php

/**
 * Created by PhpStorm.
 * User: carlos
 * Date: 11/5/15
 * Time: 3:09 PM
 */

require('configs/include.php');

class c_registrar_paquete extends ghost_controller
{


    public function registrar_paquete() {

        $data = $this->post;

        $arch = $data->arquitectura;

        // pruebas de las arquitectura en el backEnd
        if(!in_array($arch,paquete::getArchitectures())) {
            $this->engine->assign('error_msg',"la arquitectura selecionado '$arch' no es valida, por favor seleccione otra.");
            return;
        }

        $data->fecha_subida = date('Y/m/d H:i:s');
        $data->fecha_ultima_actualizada = date('Y/m/d H:i:s');

        // TODO calcular correctamente
        $data->tamano_comprimido = 1;
        $data->tamano_instalado = 1;

        $paquete = new paquete($data);

        $this->orm->connect();

        $this->orm->insert_data('normal',$paquete);

        $this->orm->close();

        // TODO capturar exepciones
        $index = $gvar['l_global'];
        header("Location: $index index.php?success_msg=paquete registrado exitosamente.");



    }

    private function get_repositorios() {

        $options["repositorio"]["lvl2"] = "all";

        $this->orm->connect();
        $this->orm->read_data(array('repositorio'),$options);

        $repositorios = $this->orm->get_objects("repositorio");

        $this->orm->close();

        return $repositorios;

    }

    public function display()
    {
        $this->engine->assign('title',$this->gvar['n_index']);
        $this->engine->assign('repositorios',$this->get_repositorios());
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