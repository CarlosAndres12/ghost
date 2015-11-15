<?php

require('configs/include.php');
require_once('utils.php');

class c_adoptar_paquete extends ghost_controller {


    public function adoptar_paquete(){
        $repositorio = $this->get->repositorio;
        $nombre = $this->get->nombre;
        if($this->paquete_es_huerfano($repositorio,$nombre)){
            $paquetexusuario = new paquetexusuario($this->get);
            $paquetexusuario->set('usuario',$_SESSION["nombre_usuario"]);
            $paquetexusuario->set('paquete',$nombre);
            $this->orm->connect();
            $this->orm->insert_data('normal',$paquetexusuario);
            $this->orm->close();

            $index = $gvar['l_global'];
            header("Location: $index buscar_paquete.php?success_msg=El paquete ha sido adoptado.");
        }else{
            $index = $gvar['l_global'];
            header("Location: $index buscar_paquete.php?error_msg=Solo se pueden adoptar paquetes huerfanos.");
        }
    }

    public function paquete_es_huerfano($repositorio, $nombre){
        $cod['paquete']['nombre'] = $nombre;
        $cod['paquete']['nombre_repositorio'] = $repositorio;
        $options["paquete"]["lvl2"] = "buscar_huerfano";

        $this->orm->connect();
        $this->orm->read_data(array("paquete"),$options,$cod);
        $paquete = $this->orm->get_objects("paquete");
        $this->orm->close();
        if($paquete == null){
            return false;
        }else{
            return true;
        }
    }

    public function display()
    {

    }

    public function run()
    {
        parent::run();
        $this->adoptar_paquete();

    }
}

$call = new c_adoptar_paquete();
$call->run();