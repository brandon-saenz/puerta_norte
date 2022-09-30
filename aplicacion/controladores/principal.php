<?php
final class Principal extends Controlador {

	function index() {
		$pagina = $this->cargarVista('principal');
		$pagina->renderizar();
	}

}