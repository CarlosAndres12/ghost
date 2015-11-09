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

        $paquete = new paquete($this->post);
        $this->orm->connect();
        $this->orm->delete_data('normal',$paquete);
        $this->orm->close();
//        rmdir("files/$nombre");
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
        parent::run();
        if(isset($this->post->option)){
            $this->{$this->post->option}();
        }

        $paquete = new paquete($this->get);

//        var_dump($paquete);

        $this->engine->assign('paquete',$paquete);


        $this->display();
    }
}

$call = new c_eliminar_paquete();
$call->run();
