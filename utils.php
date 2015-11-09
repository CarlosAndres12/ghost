<?php


abstract class  c_utils
{
    static function get_repositorios(&$orm) {

        $options["repositorio"]["lvl2"] = "all";

        $orm->connect();
        $orm->read_data(array('repositorio'),$options);

        $repositorios = $orm->get_objects("repositorio");

        $orm->close();

        return $repositorios;

    }


    static function get_paquete($nombre, $repositorio, &$orm) {

        $cod['paquete']['nombre'] = $nombre;
        $cod['paquete']['nombre_repositorio'] = $repositorio;

        $options["paquete"]["lvl2"] = "search";

        $orm->connect();
        $orm->read_data(array("paquete"),$options,$cod);
        $paquetes = $orm->get_objects("paquete");
        $orm->close();

        if($paquetes==null){
//            $this->engine->assign('error_msg',"No se encontraron paquetes.");
            return null;
        }else{
            return $paquetes[0];
        }


    }

}



