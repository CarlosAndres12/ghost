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


    public function obtener_paquetes_mantenidos(){
        $cod['paquetexusuario']['usuario'] = $_SESSION["nombre_usuario"];

        $options["paquetexusuario"]["lvl2"] = "por_usuario";

        $this->orm->connect();
        $this->orm->read_data(array("paquetexusuario"),$options,$cod);
        $paquetesxusuario = $this->orm->get_objects("paquetexusuario");
        $this->orm->close();

        return $paquetesxusuario;
    }


    public function buscar_paquete(){

        $paquetesxusuario = $this->obtener_paquetes_mantenidos();
        $this->engine->assign('paquetesxusuario',$paquetesxusuario);

        if($this->get->nombre == null){
            $this->engine->assign('error_msg',"Para buscar un repositorio primero debe ingresar su nombre.");
            return;
        }

        $repositorio = $this->get->repositorio;
        $nombre = $this->get->nombre;

// ------------------------
        $cod['paquete']['nombre'] = $nombre;
        $cod['paquete']['nombre_repositorio'] = $repositorio;

        $options["paquete"]["lvl2"] = "buscar_huerfanos";


        $this->orm->connect();
        $this->orm->read_data(array("paquete"),$options,$cod);
        $paquetes_huerfanos = $this->orm->get_objects("paquete");
        $this->engine->assign('paquetes_huerfanos',$paquetes_huerfanos);
        $this->orm->close();
// ------------------------

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