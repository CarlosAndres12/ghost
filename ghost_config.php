<?php

/**
 * Created by PhpStorm.
 * User: carlos
 * Date: 11/14/15
 * Time: 9:50 AM
 */
abstract class  ghost_config
{



    public  static function get_repository_path($name) {

        return "files/".$name."/";

    }


    public static  function get_package_path($repositorio,$name) {
        return ghost_config::get_repository_path($repositorio).$name;
    }
}