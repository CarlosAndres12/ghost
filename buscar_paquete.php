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
        $cod['paquetexusuario']['nombre_repositorio'] = $repositorio;
        $cod['paquetexusuario']['paquete'] = $nombre;
        $cod['paquetexusuario']['usuario'] = $_SESSION["nombre_usuario"];

        $options["paquete"]["lvl2"] = "search";
        $options["paquetexusuario"]["lvl2"] = "by_usuario_repositorio";




        $this->orm->connect();
        $this->orm->read_data(array("paquete"),$options,$cod);
        $paquetes = $this->orm->get_objects("paquete");

        $this->orm->read_data(array('paquetexusuario'), $options, $cod);
        $paquetexusuario = $this->orm->get_objects("paquetexusuario");

        $this->orm->close();

//        var_dump($paquetes);
//        echo "\n\n hola    ".$_SESSION["nombre_usuario"]."\n\n";
//        var_dump($paquetexusuario);

        if($paquetes==null){
            $this->engine->assign('error_msg',"No se encontraron paquetes.");


        }else{

            $this->engine->assign('paquetes',$paquetes);


            foreach($paquetexusuario as $elem) {

                foreach($paquetes as &$paquete) {
                    if($elem->get('paquete') == $paquete->get('nombre')) {

                        $paquete->soy_matenedor = false;

                        if($_SESSION["nombre_usuario"] == $elem->get('usuario')) {
                            $paquete->soy_matenedor = true;
                        }
                    }
                }
            }

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