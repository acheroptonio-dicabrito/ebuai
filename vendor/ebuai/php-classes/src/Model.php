<?php  

namespace ebuai;

class Model {

	private $values = [];

	//function identify method
	public function __call($name, $args) {

		$method = substr($name, 0, 3);
		$fieldName = substr($name, 3, strlen($name));

		switch ($method) {

			case 'get':
					return $this->values[$fieldName];
				break;

			case 'set':
					$this->values[$fieldName] = $args[0];
				break;
		}

	}

	//creating method dynamically from database values
	public function setData($data = array()) {

		foreach ($data as $key => $value) {
			$this->{'set'.$key}($value);
		}

	}

	//getting values 
	public function getValues() {

		return $this->values;

	}

}

?>