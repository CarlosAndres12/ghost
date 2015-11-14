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

        $paquete = new paquete($this->post);

        $paquete->set('fecha_ultima_actualizada',date('Y/m/d H:i:s'));
        $paquete->set('tamano_comprimido',1);
        $paquete->set('tamano_instalado',1);


        $paquete->auxiliars['nombre_viejo'] = $this->post->nombre_viejo;
//        var_dump($paquete);
        $this->orm->connect();
        $this->orm->update_data('normal',$paquete);
        $this->orm->close();
//        rename("files/$nombre_viejo","files/$nombre");
        $index = $gvar['l_global'];
        header("Location: $index buscar_paquetes.php?success_msg=paquete actualizado exitosamente.");


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
        parent::run();
        if(isset($this->post->option)){
            $this->{$this->post->option}();
        }

        $paquete = c_utils::get_paquete($this->get->nombre, $this->get->repositorio,$this->orm);
        $paquete->nombre_viejo = $this->get->nombre;



//        var_dump($paquete);



        $this->engine->assign('paquete',$paquete);
        $this->engine->assign('repositorios', c_utils::get_repositorios($this->orm));
        $this->engine->assign('archs', paquete::getArchitectures());


        $this->display();
    }
}

$call = new c_editar_paquete();
$call->run();