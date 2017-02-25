<?php

class User extends \HXPHP\System\Model {
	static $belongs_to = array(
		array('role')
	);

	static $validates_presence_of = array(
		array(
			'name',
			'message' => 'O nome é um campo obrigatório.',
		),
		array(
			'email',
			'message' => 'O e-mail é um campo obrigatório.',
		),
		array(
			'username',
			'message' => 'O nome de usuário é um campo obrigatório.',
		),
		array(
			'password',
			'message' => 'A senha é um campo obrigatório.',
		)
	);

	static $validates_uniqueness_of = array(
		array(
			array('username'),
			'message' => 'Já existe um usuário nome de usuário cadastrado.',
		),
		array(
			array('email'),
			'message' => 'Já existe um usuário com esse email cadastrado.'
		),
		array(
			array('cpf'),
			'message' => 'Já existe um usuário com esse cpf cadastrado,	 por favor contate o administrador.'
		)
	);

	public static function cadastrar(array $post) {

		$callbackObj         = new \stdClass;
		$callbackObj->user   = null;
		$callbackObj->status = false;
		$callbackObj->errors = array();

		$role = Role::find_by_role('user');

		if (is_null($role)) {
			array_push($callbackObj->errors, 'A role user não existe. Contate o administrador');
			return $callbackObj;
		}
		//$cpf       = $_POST['cpf'];
		$user_data = array(
			'roles_id' => $role->id,
			'status'   => 0,
			//'cpf'      => $cpf,
		);

		$password = \HXPHP\System\Tools::hashHx($post['password']);

		$post = array_merge($post, $user_data, $password);

		$cadastrar = self::create($post);

		if ($cadastrar->is_valid()) {
			$callbackObj->user   = $cadastrar;
			$callbackObj->status = true;
			return $callbackObj;
		}

		$errors = $cadastrar->errors->get_raw_errors();

		foreach ($errors as $field => $message) {
			array_push($callbackObj->errors, $message[0]);
		}

		return $callbackObj;

	}

	public static function atualizar($user_id, array $post) {

		$callbackObj         = new \stdClass;
		$callbackObj->user   = null;
		$callbackObj->status = false;
		$callbackObj->errors = array();

		if (isset($post['password']) && !empty($post['password'])) {

			$password = \HXPHP\System\Tools::hashHx($post['password']);

			$post = array_merge($post, $password);
		}

		$user = self::find($user_id);

		$user->name      = $post['name'];
		$user->username  = $post['username'];
		$user->email     = $post['email'];
		$user->faixa     = $post['faixa'];
		$user->descricao = $post['descricao'];

		if (isset($post['salt'])) {
			$user->password = $post['password'];
			$user->salt     = $post['salt'];
		}

		$exists_mail = self::find_by_email($post['email']);

		if (!is_null($exists_mail) && intval($user_id) !== intval($exists_mail->id)) {
			array_push($callbackObj->errors, 'Já existe um usuário com esse email cadastrado.');

			return $callbackObj;

		}
		$exists_username = self::find_by_username($post['username']);

		if (!is_null($exists_username) && intval($user_id) !== intval($exists_username->id)) {
			array_push($callbackObj->errors, 'Já existe um usuário com o login cadastrado.');

			return $callbackObj;
		}

		$atualizar = $user->save(false);

		if ($atualizar) {
			$callbackObj->user   = $user;
			$callbackObj->status = true;
			return $callbackObj;
		}

		$errors = $cadastrar->errors->get_raw_errors();

		foreach ($errors as $field => $message) {
			array_push($callbackObj->errors, $message[0]);
		}

		return $callbackObj;

	}

	public static function login(array $post) {

		$callbackObj                       = new \stdClass;
		$callbackObj->user                 = null;
		$callbackObj->status               = false;
		$callbackObj->code                 = null;
		$callbackObj->tentativas_restantes = null;

		$user = self::find_by_username($post['username']);

		if (!is_null($user)) {

			$password = \HXPHP\System\Tools::hashHx($post['password'], $user->salt);

			if ($user->status === 1) {

				if (LoginAttempt::TentativasExistente($user->id)) {
					var_dump($password);

					if ($password['password'] === $user->password) {

						$callbackObj->user   = $user;
						$callbackObj->status = true;
						LoginAttempt::LimpaTentativas($user->id);

					} else {

						if (LoginAttempt::TentativasRestantes($user->id) <= 4) {
							$callbackObj->code                 = 'tentativas-esgotando';
							$callbackObj->tentativas_restantes = LoginAttempt::TentativasRestantes($user->id);

						} else {
							$callbackObj->code = 'dados-incorretos';
						}
						LoginAttempt::RegistrarTentativas($user->id);
					}
				} else {
					$callbackObj->code = 'usuario-bloqueado';
					$user->status      = 0;
					$user->save(false);
				}
			} else {
				$callbackObj->code = 'usuario-bloqueado';
			}

		} else {
			$callbackObj->code = 'usuario-inexistente';
		}

		return $callbackObj;
	}

	public static function atualizarSenha($user, $newPassword) {

		$user = User::find($user->id);
		var_dump($user);
		$password = \HXPHP\System\Tools::hashHX($newPassword);

		//return $user->update_attributes($password);

		$user->password = $password['password'];
		$user->salt     = $password['salt'];

		$user->save(false);
		return $user;//o atributa false no save ele da um skip no presence off

	}
}