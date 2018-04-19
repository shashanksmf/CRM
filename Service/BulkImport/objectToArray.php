<?php
    header("Access-Control-Allow-Origin: *");
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

class objectToArray {

  public function convert($data) 
	{
		if (is_object($data)) {
	        // Gets the properties of the given object
	        // with get_object_vars function
			$data = get_object_vars($data);
		}

		if (is_array($data)) {
	        /*
	        * Return array converted to object
	        * Using __FUNCTION__ (Magic constant)
	        * for recursive call
	        */
	        return array_map(array($this, __FUNCTION__), $data);
	    } else {
	        // Return array
	    	return $data;
	    }
	}
}

?>