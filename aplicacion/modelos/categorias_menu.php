<?php
final class Modelos_Categoriasmenu extends Modelo {
	protected $_db = null;
	public $mensajes = array();

	public function iniciarDb($db) {
    	if (!$this->_db) {
			$this->_db = $db;
        }
    }

	public function obtenerDatos() {
		try {
			$sth = $this->_db->prepare("SELECT * FROM categorias_menu ORDER BY id_categoria ASC");
			// $sth->bindParam(1, $_SESSION['login_id']);
			$sth->setFetchMode(PDO::FETCH_INTO, $this);
			if(!$sth->execute()) throw New Exception();
			$sth->fetch();

	  		return $this;
		} catch (Exception $e) {
			$this->mensajes[] = Modelos_Sistema::status(0, $e->getMessage());
		}
	}

}