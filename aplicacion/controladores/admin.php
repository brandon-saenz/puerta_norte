<?php
final class Admin extends Controlador {

	function index() {
		$pagina = $this->cargarVista('admin');
		$pagina->renderizar();
	}

}