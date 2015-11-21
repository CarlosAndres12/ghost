<?php
/**
 * Created by PhpStorm.
 * User: carlos
 * Date: 11/8/15
 * Time: 8:20 PM
 */

require('configs/include.php');

class c_eliminar_paquete extends ghost_admin_controller {

    public function eliminar_paquete(){


        $nombre = $this->post->nombre;


        $options["paquetexusuario"]["lvl2"] = "by_usuario_repositorio";

        $cod['paquetexusuario']['nombre_repositorio'] = $this->get->repositorio;
        $cod['paquetexusuario']['paquete'] = $nombre;
        $cod['paquetexusuario']['usuario'] = $_SESSION["nombre_usuario"];

        $paquete = new paquete($this->post);


        // si no se hace esto el usuario podria hacer que el sistema
        // elimine paquetes de otro usuario
        $this->orm->connect();
        $this->orm->read_data(array('paquetexusuario'), $options, $cod);
        $paquetexusuario = $this->orm->get_objects("paquetexusuario");

        if($paquetexusuario == null) {
            $this->engine->assign('error_msg',"Hay un error en la verificacion de roles.");
            return;
        } else {
            $this->orm->delete_data('by_paquete_repositorio_usuario', $paquetexusuario);
        }

        {
            $obj = new stdClass();
            $obj->paquete = $nombre;
            $obj->repositorio = $this->get->repositorio;

            $dep = new dependencia($obj);

            $this->orm->delete_data('by_paquete_repositorio', $dep);
        }


        $this->orm->delete_data('normal',$paquete);
        $this->orm->close();
        unlink("files/$nombre");
        $index = $gvar['l_global'];
        header("Location: $index buscar_paquete.php?success_msg=paquete eliminado exitosamente.");
    }

    public function display()
    {
        $this->engine->assign('title',$this->gvar['n_index']);

        $this->engine->display('header.tpl');
        $this->engine->display('eliminar_paquete.tpl');
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
            header("Location: $index index.php?success_msg=error al eliminar el paquete");


        }

        $paquete = new paquete($this->get);

//        var_dump($paquete);

        $this->engine->assign('paquete',$paquete);


        $this->display();
    }
}

$call = new c_eliminar_paquete();
$call->run();
