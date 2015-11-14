<?php
/**
 * Created by PhpStorm.
 * User: carlos
 * Date: 11/13/15
 * Time: 9:00 PM
 */

include_once('query.php');
include_once("object_interpeter.php");

class ghost_object extends object_standard {


    public static function get_all() {
        $class = get_called_class();

        $objs = array();

        foreach(object_interpeter::get_data(query::all($class)) as $obj) {
            $objs[] = new $class($obj);
        }

        return $objs;



    }

    /**
     * @param condition[] $condtions
     */
    public static function get_valid($condtions) {

        $class = get_called_class();

        $objs = array();

        foreach(object_interpeter::get_data(query::by_condition($condtions,$class)) as $obj) {
            $objs[] = new $class($obj);
        }

        return $objs;
    }

    public static function insert_object($object) {

        object_interpeter::insert_data(query::insert_object($object));

    }








}
