<?php  

namespace ebuai;

//building page admin | receiving all function from page
class PageAdmin extends Page{

	public function __construct($opts = array(), $tpl_dir = "/views/admin/"){

		parent::__construct($opts, $tpl_dir);

	}
}

?>