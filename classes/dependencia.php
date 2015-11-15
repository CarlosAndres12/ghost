<?php
 
class dependencia extends object_standard
{
	//attributes
	protected $paquete;	
	protected $dependencia;	
	protected $repositorio;

	//components
	var $components = array();
	
	//auxiliars for primary key and for files
	var $auxiliars = array();
	
	//data about the attributes
	public function metadata()
	{
		return array("paquete" => array(), "dependencia" => array(), "repositorio" => array()); 
	}

	public function primary_key()
	{
		return array("nombre");
	}
	
	public function relational_keys($class, $rel_name)
	{
		switch($class)
		{		
	    default:
				break;
		}
	}

	/**
	 * @return array
	 */
	public static function getArchitectures()
	{
		return self::$architectures;
	}


}

?>