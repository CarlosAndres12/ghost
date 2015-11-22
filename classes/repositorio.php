<?php
 
class repositorio extends object_standard
{
	//attributes
	protected $nombre;
	protected $descripcion;	

	//components
	var $components = array();
	
	//auxiliars for primary key and for files
	var $auxiliars = array();
	
	//data about the attributes
	public function metadata()
	{
		return array("nombre" => array(), "descripcion" => array()); 
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
}

?>