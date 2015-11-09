<?php
/**
 * Created by PhpStorm.
 * User: carlos
 * Date: 11/8/15
 * Time: 4:59 PM
 */

require('configs/include.php');
require_once('utils.php');

class c_buscar_paquete extends ghost_controller {





    public function buscar_paquete(){
        if($this->get->nombre == null){
            $this->engine->assign('error_msg',"Para buscar un repositorio primero debe ingresar su nombre.");
            return;
        }

        $repositorio = $this->get->repositorio;
        $nombre = $this->get->nombre;



//        $this->engine->assign('nombre',$nombre);


        $cod['paquete']['nombre'] = $nombre;
        $cod['paquete']['nombre_repositorio'] = $repositorio;

        $options["paquete"]["lvl2"] = "search";


        $this->orm->connect();
        $this->orm->read_data(array("paquete"),$options,$cod);
        $paquetes = $this->orm->get_objects("paquete");
        $this->orm->close();

        if($paquetes==null){
            $this->engine->assign('error_msg',"No se encontraron paquetes.");
        }else{
            $this->engine->assign('paquetes',$paquetes);
//            var_dump($paquetes);
        }
    }

    public function display()
    {

        $this->engine->assign('title',$this->gvar['n_index']);
        $this->engine->assign('repositorios',c_utils::get_repositorios($this->orm));

        $this->engine->display('header.tpl');
        $this->engine->display('buscar_paquetes.tpl');
        $this->engine->display('footer.tpl');
        $this->engine->display('message.tpl');
    }

    public function run()
    {
        parent::run();
        if(isset($this->get->option)){
            $this->{$this->get->option}();
        }
        $this->display();
    }
}

$call = new c_buscar_paquete();
$call->run();