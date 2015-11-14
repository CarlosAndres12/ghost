<?php

/**
 * Created by PhpStorm.
 * User: carlos
 * Date: 11/13/15
 * Time: 9:04 PM
 */


//require('../configs/include.php');
include_once('ghost_orm.php');

abstract class  object_interpeter
{

    public static function get_data($query) {
       $data = ghost_orm::get()->db->get_data($query);

//        var_dump($data);

        return $data;
    }

    public static function insert_data($query) {

//        echo "hola\n\n".$query."\n\nhola";

        ghost_orm::get()->db->do_operation($query);

    }


}


//object_interpeter::get_data("SELECT * FROM paquete");