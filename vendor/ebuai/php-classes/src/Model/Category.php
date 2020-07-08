<?php  

namespace ebuai\Model;

//calling sql class
use \ebuai\DB\Sql;
//calling model class
use \ebuai\Model;

//model user class
class Category extends Model {

	//function list all categories panel admin
	public static function listAll() {

		$sql = new Sql();

		return $sql->select('SELECT * FROM tb_categories ORDER BY descategory');

	}

	//function create an category
	public function save() {

		$sql = new Sql();

		$results = $sql->select('CALL sp_categories_save(:idcategory, :descategory)', array(
			':idcategory'=>$this->getidcategory(),
			':descategory'=>$this->getdescategory()
		));

		$this->setData($results[0]);

		Category::updateFile();

	}

	public function get($idcategory) {

		$sql = new Sql();

		$results = $sql->select('SELECT * FROM tb_categories WHERE idcategory = :idcategory', [
			':idcategory'=>$idcategory
		]);

		$this->setData($results[0]);

	}

	public function delete() {

		$sql = new Sql();

		$sql->query('DELETE FROM tb_categories WHERE idcategory = :idcategory', [
			':idcategory'=>$this->getidcategory()
		]);

		Category::updateFile();

	}

	public function updateFile() {

		$categories = Category::listAll();

		$html = [];

		foreach ($categories as $row) {
			array_push($html, '<li><a href="/categories/'.$row['idcategory'].'">'.$row['descategory'].'</a></li>');
		}

		file_put_contents($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'categories-menu.html', implode('', $html));

	}	

}

?>