<?php
 
class paquetexusuario extends object_standard
{
	//attributes
	protected $paquete;
	protected $repositorio;	
	protected $usuario;	

	//components
	var $components = array();
	
	//auxiliars for primary key and for files
	var $auxiliars = array();
	
	//data about the attributes
	public function metadata()
	{
		return array("paquete" => array(), "repositorio" => array(), "usuario" => array(),
			"repositorio" => array( "foreign_name" => "u_p", "foreign" => "paquete", "foreign_attribute" => "repositorio" ),
			"paquete" => array( "foreign_name" => "u_p", "foreign" => "paquete", "foreign_attribute" => "paquete" ),
			"usuario" => array( "foreign_name" => "u_u", "foreign" => "usuario", "foreign_attribute" => "usuario" )); 
	}

	public function primary_key()
	{
		return array("paquete","repositorio","usuario");
	}
	
	public function relational_keys($class, $rel_name)
	{
		switch($class)
		{		
			case "paquete":
				switch ($rel_name) {
					case "u_p":
						return array("paquete","repositorio");
						break;
				}
				break;

				case "usuario":
				switch ($rel_name) {
					case "u_u":
						return array("usuario");
						break;
				}
				break;

	    default:
				break;
		}
	}

}

?>