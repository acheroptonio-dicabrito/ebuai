<?php  

namespace ebuai\Model;

//calling sql class
use \ebuai\DB\Sql;
//calling sql class
use \ebuai\Model;

//model user class
class User extends Model{

	const SESSION = 'User';

	//verifying login
	public static function login($login, $password) {

		$sql = new Sql();

		$results = $sql->select('SELECT * FROM tb_users WHERE deslogin = :LOGIN', array(
			':LOGIN'=>$login
		));

		if (count($results) === 0){
			throw new \Exception('Usuário inexistente ou senha inválida');
		}

		$data = $results[0];

		if (password_verify($password, $data['despassword']) === true){

			$user = new User();

			$user->setData($data);

			$_SESSION[User::SESSION] = $user->getValues();

		} else {
			throw new \Exception('Usuário inexistente ou senha inválida');
		}

	}

	//verifying user session
	public static function verifyLogin($inadmin = true) {

		if (

			!isset($_SESSION[User::SESSION])
			||
			!$_SESSION[User::SESSION]
			||
			!(int)$_SESSION[User::SESSION]['iduser'] > 0
			||
			(bool)$_SESSION[User::SESSION]['inadmin'] !== $inadmin

		) {

			header('Location: /admin/login');
			exit;
		}

	}

	//function logout
	public static function logout() {

		$_SESSION[User::SESSION] = NULL;

	}
}

?>