<?php

class dependencia extends object_standard
{
    //attributes
    protected $paquete;
    protected $repositorio;
    protected $dependencia;

    //components
    var $components = array();

    //auxiliars for primary key and for files
    var $auxiliars = array();

    //data about the attributes
    public function metadata()
    {
        return array(
            "repositorio" => array( "foreign_name" => "r_d", "foreign" => "repositorio", "foreign_attribute" => "nombre" ),
            "paquete" => array( "foreign_name" => "p_d", "foreign" => "paquete", "foreign_attribute" => "nombre" ),
            "dependencia" => array( "foreign_name" => "d_p", "foreign" => "paquete", "foreign_attribute" => "nombre" )
        );
    }

    public function primary_key()
    {
        return array("paquete", "repositorio", "depencia");
    }

    public function relational_keys($class, $rel_name)
    {
        switch($class)
        {
            case "repositorio":
                switch ($rel_name) {
                    case "r_d":
                        return array("repositorio");
                        break;
                }
                break;

            case "paquete":
                switch($rel_name) {
                    case "p_d":
                        return array("paquete");
                        break;
                    case "d_p":
                        return array("dependencia");
                        break;
                }
                break;

            default:
                break;
        }
    }
}

?>