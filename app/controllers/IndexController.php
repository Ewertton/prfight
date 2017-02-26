<?php

class IndexController extends \HXPHP\System\Controller {

	public function __construct($configs) {

		parent::__construct($configs);
		$this->view->setVar('users', User::all());

	}

	public function aprendendoMaisAction() {
		$this->view->setFile('aprendendoMais');
	}

	public function professoresAction() {
		$this->view->setFile('professores');
	}

	public function escolaAction() {
		$this->view->setFile('escola');
	}

	public function fotosAction() {
		$this->view->setFile('fotos');
	}
	public function eventosAction() {
		$this->view->setFile('eventos');
	}
	public function alunosAction() {
		$this->view->setFile('alunos');
	}
	
}