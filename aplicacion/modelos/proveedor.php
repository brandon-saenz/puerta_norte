<?php
final class Modelos_Proveedor extends Modelo {
	protected $_db = null;

	public function iniciarDb($db) {
    	if (!$this->_db) {
			$this->_db = $db;
        }
    }

	public function registro() {
		try {
			$nombre = mb_strtoupper($_POST['nombre']);
			$rfc = mb_strtoupper($_POST['rfc']);
			$tipo = $_POST['tipo'];
			$contacto = mb_strtoupper($_POST['contacto']);
			$telefono = $_POST['telefono'];
			$correo = strtolower($_POST['correo']);
			$contrasena1 = $_POST['contrasena1'];
			$contrasena2 = $_POST['contrasena2'];

			if ($contrasena1 == $contrasena2) {
				$salt = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'), 0, 64);
				$contrasenaEncriptada = hash("sha256", $contrasena1.$salt);

				$bytes = random_bytes(10);
				$uniqueId = bin2hex($bytes);
				
				$arregloDatos = array($nombre, $rfc, $tipo, $contacto, $telefono, $correo, $salt, $contrasenaEncriptada, $uniqueId);
				$sth = $this->_db->prepare("INSERT INTO proveedores (nombre, rfc, tipo, contacto, telefono, email, salt, contrasena, fecha_registro, uniqueid) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?)");

				if($sth->execute($arregloDatos)) {
					$this->mensaje = Modelos_Sistema::status(2, '¡Registro de proveedor existoso! Ya puedes iniciar sesión.');
				} else {
					throw New Exception();
				}
			} else {
				$this->mensaje = Modelos_Sistema::status(1, 'Las contraseñas no coinciden.');
			}
		} catch (Exception $e) {
			$this->mensaje = Modelos_Sistema::status(1, 'El correo especificado del proveedor ya existe en nuestros registros.');
		}
	}

	public function cumplimiento() {
		try {
			$datosArray = array();

			if ($_SESSION['login_tipo'] == 1) {
				$tareas = 10;
			} elseif ($_SESSION['login_tipo'] == 2) {
				$tareas = 12;
			} else {
				$tareas = 15;
			}
			$cumplidas = 0;

			// Fecha de vencimiento
			$fechaVencimiento = new DateTime();
			$fechaVencimiento->add(new DateInterval('P7D'));
			$fechaVencimiento = $fechaVencimiento->getTimestamp();
			$datosArray['fechaVencimiento'] = utf8_encode(ucfirst(strftime("%A %d de %B del %Y", $fechaVencimiento)));

			// Datos principales
			$sth = $this->_db->prepare("SELECT * FROM proveedores WHERE id = ?");
			$sth->bindParam(1, $_SESSION['login_id']);
			if(!$sth->execute()) throw New Exception();
			$datos = $sth->fetch();

			$datosArray['status'] = $datos['status'];

			if ($datos['nombre'] && $datos['razon_social'] && $datos['rfc'] && $datos['contacto'] && $datos['telefono'] && $datos['email'] && $datos['domicilio'] && $datos['ciudad'] && $datos['estado'] && $datos['ofrece']) {
				$datosArray['principales'] = 1;
				$cumplidas++;
			} else {
				$datosArray['principales'] = 0;
			}

			if ($datos['logo']) {
				$datosArray['logo'] = 1;
				$cumplidas++;
			} else {
				$datosArray['logo'] = 0;
			}

			// Referencias
			$sth = $this->_db->prepare("SELECT COUNT(id) FROM proveedores_referencias WHERE id_proveedor = ?");
			$sth->bindParam(1, $_SESSION['login_id']);
			if(!$sth->execute()) throw New Exception();
			$cReferencias = $sth->fetchColumn();

			if ($cReferencias == 3) {
				$datosArray['referencias'] = 1;
				$cumplidas++;
			} else {
				$datosArray['referencias'] = 0;
			}

			// Referencias
			$sth = $this->_db->prepare("SELECT * FROM proveedores WHERE id = ?");
			$sth->bindParam(1, $_SESSION['login_id']);
			if(!$sth->execute()) throw New Exception();
			$datos = $sth->fetch();

			if ($datos['garantia_certificaciones']) {
				$datosArray['certificaciones'] = 1;
				$cumplidas++;
			} else {
				$datosArray['certificaciones'] = 0;
			}

			// Archivos
			if ($datos['csf']) {
				$datosArray['csf'] = 1;
				$cumplidas++;
			} else {
				$datosArray['csf'] = 0;
			}
			if ($datos['cdd']) {
				$datosArray['cdd'] = 1;
				$cumplidas++;
			} else {
				$datosArray['cdd'] = 0;
			}
			if ($datos['edocta'] || $datos['cta_clabe']) {
				$datosArray['edocta'] = 1;
				$cumplidas++;
			} else {
				$datosArray['edocta'] = 0;
			}
			if ($datos['opcs']) {
				$datosArray['opcs'] = 1;
				$cumplidas++;
			} else {
				$datosArray['opcs'] = 0;
			}
			if ($datos['ce']) {
				$datosArray['ce'] = 1;
				$cumplidas++;
			} else {
				$datosArray['ce'] = 0;
			}
			if ($datos['ine_anverso'] && $datos['ine_reverso']) {
				$datosArray['ine'] = 1;
				$cumplidas++;
			} else {
				$datosArray['ine'] = 0;
			}

			// Contratista
			if ($_SESSION['login_tipo'] == 2) {
				if ($datos['ac']) {
					$datosArray['ac'] = 1;
					$cumplidas++;
				} else {
					$datosArray['ac'] = 0;
				}
				if ($datos['pnrl']) {
					$datosArray['pnrl'] = 1;
					$cumplidas++;
				} else {
					$datosArray['pnrl'] = 0;
				}
			}

			// Contratista
			if ($_SESSION['login_tipo'] == 3) {
				if ($datos['ac']) {
					$datosArray['ac'] = 1;
					$cumplidas++;
				} else {
					$datosArray['ac'] = 0;
				}
				if ($datos['pnrl']) {
					$datosArray['pnrl'] = 1;
					$cumplidas++;
				} else {
					$datosArray['pnrl'] = 0;
				}
				if ($datos['iorl']) {
					$datosArray['iorl'] = 1;
					$cumplidas++;
				} else {
					$datosArray['iorl'] = 0;
				}
				if ($datos['upp']) {
					$datosArray['upp'] = 1;
					$cumplidas++;
				} else {
					$datosArray['upp'] = 0;
				}
				if ($datos['eoss']) {
					$datosArray['eoss'] = 1;
					$cumplidas++;
				} else {
					$datosArray['eoss'] = 0;
				}
				if ($datos['pep']) {
					$datosArray['pep'] = 1;
					$cumplidas++;
				} else {
					$datosArray['pep'] = 0;
				}
			}

			$datosArray['porcentaje'] = round(($cumplidas/$tareas)*100);

			if ($datosArray['porcentaje'] == 100) {
				$datosArray['color'] = '#3699FF';
			} else {
				$datosArray['color'] = '#1BC5BD';
			}

			return $datosArray;
		} catch (Exception $e) {
			echo Modelos_Sistema::status(0, $e->getMessage());
		}
	}

	public function datosPrincipales() {
		try {
			$datosArray = array();

			$sth = $this->_db->prepare("SELECT * FROM proveedores WHERE id = ?");
			$sth->bindParam(1, $_SESSION['login_id']);
			if(!$sth->execute()) throw New Exception();
			$datos = $sth->fetch();

			switch($datos['tipo']) {
				case 1: $tipo = 'PERSONA FÍSICA'; break;
				case 2: $tipo = 'PERSONA MORAL'; break;
				case 3: $tipo = 'CONTRATISTA DE PROYECTO Y OBRAS'; break;
			}

			$datosArray['nombre'] = $datos['nombre'];
			$datosArray['razon_social'] = $datos['razon_social'];
			$datosArray['rfc'] = $datos['rfc'];
			$datosArray['tipo'] = $tipo;
			$datosArray['contacto'] = $datos['contacto'];
			$datosArray['telefono'] = $datos['telefono'];
			$datosArray['email'] = $datos['email'];
			$datosArray['domicilio'] = $datos['domicilio'];
			$datosArray['ciudad'] = $datos['ciudad'];
			$datosArray['estado'] = $datos['estado'];
			$datosArray['fax'] = $datos['fax'];
			$datosArray['ofrece'] = $datos['ofrece'];
			$datosArray['garantia_certificaciones'] = $datos['garantia_certificaciones'];
			$datosArray['certificaciones'] = $datos['certificaciones'];
			$datosArray['garantias'] = $datos['garantias'];
			
			$datosArray['csf'] = $datos['csf'];
			$datosArray['cdd'] = $datos['cdd'];
			$datosArray['edocta'] = $datos['edocta'];
			$datosArray['opcs'] = $datos['opcs'];
			$datosArray['ce'] = $datos['ce'];

			$datosArray['ac'] = $datos['ac'];
			$datosArray['pnrl'] = $datos['pnrl'];
			$datosArray['iorl'] = $datos['iorl'];
			$datosArray['upp'] = $datos['upp'];
			$datosArray['eoss'] = $datos['eoss'];
			$datosArray['pep'] = $datos['pep'];

			$datosArray['cta_banco'] = $datos['cta_banco'];
			$datosArray['cta_sucursal'] = $datos['cta_sucursal'];
			$datosArray['cta_cuenta'] = $datos['cta_cuenta'];
			$datosArray['cta_clabe'] = $datos['cta_clabe'];
			$datosArray['cta_encargado'] = $datos['cta_encargado'];

			$datosArray['ine_anverso'] = $datos['ine_anverso'];
			$datosArray['ine_reverso'] = $datos['ine_reverso'];

			return $datosArray;
		} catch (Exception $e) {
			echo Modelos_Sistema::status(0, $e->getMessage());
		}
	}

	public function actualizarDatosPrincipales() {
		try {
			$nombre = mb_strtoupper($_POST['nombre']);
			$razon_social = mb_strtoupper($_POST['razon_social']);
			$domicilio = mb_strtoupper($_POST['domicilio']);
			$ciudad = mb_strtoupper($_POST['ciudad']);
			$estado = mb_strtoupper($_POST['estado']);
			$rfc = mb_strtoupper($_POST['rfc']);
			$contacto = mb_strtoupper($_POST['contacto']);
			$telefono = mb_strtoupper($_POST['telefono']);
			$fax = mb_strtoupper($_POST['fax']);
			$ofrece = mb_strtoupper($_POST['ofrece']);

			$sth = $this->_db->prepare("
				UPDATE proveedores SET
				nombre = ?,
				razon_social = ?,
				domicilio = ?,
				ciudad = ?,
				estado = ?,
				rfc = ?,
				contacto = ?,
				telefono = ?,
				fax = ?,
				ofrece = ?
				WHERE id = ?
			");

			$datosArray = [$nombre, $razon_social, $domicilio, $ciudad, $estado, $rfc, $contacto, $telefono, $fax, $ofrece, $_SESSION['login_id']];
			if(!$sth->execute($datosArray)) throw New Exception();

			header('Location:' . STASIS . '/perfil/datos/principales/1');
		} catch (Exception $e) {
			echo Modelos_Sistema::status(0, $e->getMessage());
		}
	}

	public function referencias() {
		try {
			$datosArray = array();

			$sth = $this->_db->prepare("SELECT * FROM proveedores_referencias WHERE id_proveedor = ?");
			$sth->bindParam(1, $_SESSION['login_id']);
			if(!$sth->execute()) throw New Exception();
			
			$x = 1;
			while ($datos = $sth->fetch()) {
				$datosArray[$x]['empresa'] = $datos['empresa'];
				$datosArray[$x]['contacto'] = $datos['contacto'];
				$datosArray[$x]['telefono'] = $datos['telefono'];

				$x++;
			}

			return $datosArray;
		} catch (Exception $e) {
			echo Modelos_Sistema::status(0, $e->getMessage());
		}
	}

	public function actualizarReferencias() {
		try {
			$datosArray = array();

			$sth = $this->_db->prepare("DELETE FROM proveedores_referencias WHERE id_proveedor = ?");
			$sth->bindParam(1, $_SESSION['login_id']);
			if(!$sth->execute()) throw New Exception();

			for ($x=1; $x<=3; $x++) {
				if (!empty($_POST["empresa$x"])) {
					$sth = $this->_db->prepare("INSERT INTO proveedores_referencias (id_proveedor, empresa, contacto, telefono) VALUES (?, ?, ?, ?)");
					$sth->bindParam(1, $_SESSION['login_id']);
					$sth->bindParam(2, mb_strtoupper($_POST["empresa$x"]));
					$sth->bindParam(3, mb_strtoupper($_POST["contacto$x"]));
					$sth->bindParam(4, $_POST["telefono$x"]);
					if(!$sth->execute()) throw New Exception();
				}
			}

			header('Location:' . STASIS . '/perfil/datos/referencias/1');
		} catch (Exception $e) {
			echo Modelos_Sistema::status(0, $e->getMessage());
		}
	}

	public function actualizarCertificaciones() {
		try {
			$garantia_certificaciones = mb_strtoupper($_POST['garantia_certificaciones']);
			$garantias = mb_strtoupper($_POST['garantias']);

			if ($garantia_certificaciones == 1) {
				$certificaciones = $_POST['certificaciones'];
			} else {
				$certificaciones = 'N/A';
			}

			$sth = $this->_db->prepare("
				UPDATE proveedores SET
				garantia_certificaciones = ?,
				certificaciones = ?,
				garantias = ?
				WHERE id = ?
			");

			$datosArray = [$garantia_certificaciones, $certificaciones, $garantias, $_SESSION['login_id']];
			if(!$sth->execute($datosArray)) throw New Exception();

			header('Location:' . STASIS . '/perfil/datos/certificaciones/1');
		} catch (Exception $e) {
			echo Modelos_Sistema::status(0, $e->getMessage());
		}
	}

	public function actualizarCsf() {
		try {
			if (!$_FILES['archivo']['size'] == 0) {
				require APP . 'inc/class.upload.php';

				$handle = new upload($_FILES['archivo']);
				if ($handle->uploaded) {
					$archivo = Modelos_Caracteres::caracteres_latinos($handle->file_src_name_body) . '-' . time();
					$handle->file_new_name_body   = $archivo;
					$archivoDb = $archivo . '.' . $handle->file_src_name_ext;
					$handle->process(ROOT_DIR . 'data/privada/archivos/');
					if ($handle->processed) {
						$handle->clean();
					}
				}

				$arregloDatos = array($archivoDb, $_SESSION['login_id']);
				$sth = $this->_db->prepare("UPDATE proveedores SET csf = ? WHERE id = ?");
				if(!$sth->execute($arregloDatos)) throw New Exception();
			}

			header('Location:' . STASIS . '/perfil/datos/csf/1');
		} catch (Exception $e) {
			echo Modelos_Sistema::status(0, $e->getMessage());
		}
	}

	public function actualizarCdd() {
		try {
			if (!$_FILES['archivo']['size'] == 0) {
				require APP . 'inc/class.upload.php';

				$handle = new upload($_FILES['archivo']);
				if ($handle->uploaded) {
					$archivo = Modelos_Caracteres::caracteres_latinos($handle->file_src_name_body) . '-' . time();
					$handle->file_new_name_body   = $archivo;
					$archivoDb = $archivo . '.' . $handle->file_src_name_ext;
					$handle->process(ROOT_DIR . 'data/privada/archivos/');
					if ($handle->processed) {
						$handle->clean();
					}
				}

				$arregloDatos = array($archivoDb, $_SESSION['login_id']);
				$sth = $this->_db->prepare("UPDATE proveedores SET cdd = ? WHERE id = ?");
				if(!$sth->execute($arregloDatos)) throw New Exception();
			}

			header('Location:' . STASIS . '/perfil/datos/cdd/1');
		} catch (Exception $e) {
			echo Modelos_Sistema::status(0, $e->getMessage());
		}
	}

	public function actualizarEdocta() {
		try {
			if (!$_FILES['archivo']['size'] == 0) {
				require APP . 'inc/class.upload.php';

				$handle = new upload($_FILES['archivo']);
				if ($handle->uploaded) {
					$archivo = Modelos_Caracteres::caracteres_latinos($handle->file_src_name_body) . '-' . time();
					$handle->file_new_name_body   = $archivo;
					$archivoDb = $archivo . '.' . $handle->file_src_name_ext;
					$handle->process(ROOT_DIR . 'data/privada/archivos/');
					if ($handle->processed) {
						$handle->clean();
					}
				}

				$arregloDatos = array($archivoDb, $_SESSION['login_id']);
				$sth = $this->_db->prepare("UPDATE proveedores SET edocta = ? WHERE id = ?");
				if(!$sth->execute($arregloDatos)) throw New Exception();
			}

			$cta_banco = $_POST['cta_banco'];
			$cta_sucursal = $_POST['cta_sucursal'];
			$cta_cuenta = $_POST['cta_cuenta'];
			$cta_clabe = $_POST['cta_clabe'];
			$cta_encargado = $_POST['cta_encargado'];

			$arregloDatos = array($cta_banco, $cta_sucursal, $cta_cuenta, $cta_clabe, $cta_encargado, $_SESSION['login_id']);
			$sth = $this->_db->prepare("
				UPDATE proveedores SET
				cta_banco = ?,
				cta_sucursal = ?,
				cta_cuenta = ?,
				cta_clabe = ?,
				cta_encargado = ?
				WHERE id = ?
			");
			if(!$sth->execute($arregloDatos)) throw New Exception();

			header('Location:' . STASIS . '/perfil/datos/edocta/1');
		} catch (Exception $e) {
			echo Modelos_Sistema::status(0, $e->getMessage());
		}
	}

	public function actualizarOpcs() {
		try {
			if (!$_FILES['archivo']['size'] == 0) {
				require APP . 'inc/class.upload.php';

				$handle = new upload($_FILES['archivo']);
				if ($handle->uploaded) {
					$archivo = Modelos_Caracteres::caracteres_latinos($handle->file_src_name_body) . '-' . time();
					$handle->file_new_name_body   = $archivo;
					$archivoDb = $archivo . '.' . $handle->file_src_name_ext;
					$handle->process(ROOT_DIR . 'data/privada/archivos/');
					if ($handle->processed) {
						$handle->clean();
					}
				}

				$arregloDatos = array($archivoDb, $_SESSION['login_id']);
				$sth = $this->_db->prepare("UPDATE proveedores SET opcs = ? WHERE id = ?");
				if(!$sth->execute($arregloDatos)) throw New Exception();
			}

			header('Location:' . STASIS . '/perfil/datos/opcs/1');
		} catch (Exception $e) {
			echo Modelos_Sistema::status(0, $e->getMessage());
		}
	}

	public function actualizarCe() {
		try {
			$checkboxCe = $_POST['checkboxCe'];
			if ($checkboxCe == 1) {
				$checkboxCe = date('d/m/Y H:i');
			} else {
				$checkboxCe = '';
			}

			$arregloDatos = array($checkboxCe, $_SESSION['login_id']);
			$sth = $this->_db->prepare("UPDATE proveedores SET ce = ? WHERE id = ?");
			if(!$sth->execute($arregloDatos)) throw New Exception();

			header('Location:' . STASIS . '/perfil/datos/ce/1');
		} catch (Exception $e) {
			echo Modelos_Sistema::status(0, $e->getMessage());
		}
	}

	public function actualizarLogo() {
		try {
			if (!$_FILES['archivo']['size'] == 0) {
				require APP . 'inc/class.upload.php';

				$handle = new upload($_FILES['archivo']);
				if ($handle->uploaded) {
					$archivo = Modelos_Caracteres::caracteres_latinos($handle->file_src_name_body) . '-' . time();
					$handle->file_new_name_body   = $archivo;
					$archivoDb = $archivo . '.' . $handle->file_src_name_ext;
					$handle->process(ROOT_DIR . 'data/privada/archivos/');
					if ($handle->processed) {
						$handle->clean();
					}
				}

				$arregloDatos = array($archivoDb, $_SESSION['login_id']);
				$sth = $this->_db->prepare("UPDATE proveedores SET logo = ? WHERE id = ?");
				if(!$sth->execute($arregloDatos)) throw New Exception();
			}

			header('Location:' . STASIS . '/perfil/datos/logo/1');
		} catch (Exception $e) {
			echo Modelos_Sistema::status(0, $e->getMessage());
		}
	}

	public function descargarPdf($uniqueId) {
		// PDF
		require_once(APP . 'plugins/tcpdf/tcpdf.php');
		$pdf = new RTPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetTitle('Expediente Proveedor');
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		$pdf->SetFont('helvetica', '', 10);
		$pdf->SetPrintHeader(false);
		$pdf->SetMargins(10, 10, 10, 0);
		$pdf->AddPage();

		$sth = $this->_db->prepare("
			SELECT p.uniqueid, CONCAT(ap.nombre, ' ', ap.apellidos) AS aprueba, CONCAT(au.nombre, ' ', au.apellidos) AS autoriza, p.*
			FROM proveedores p
			LEFT JOIN empleados ap
			ON ap.id = p.id_aprueba
			LEFT JOIN empleados au
			ON au.id = p.id_autoriza
			WHERE p.uniqueid = ?
		");
		$sth->bindParam(1, $uniqueId);
		if(!$sth->execute()) throw New Exception();
		$datos = $sth->fetch();

		if (!$datos) die;

		switch($datos['tipo']) {
			case 1: $tipo = 'PERSONA FÍSICA'; break;
			case 2: $tipo = 'PERSONA MORAL'; break;
			case 3: $tipo = 'CONTRATISTA DE PROYECTO Y OBRAS'; break;
		}

		if ($datos['logo']) {
			$logo = '<img src="' . STASIS . '/data/privada/archivos/' . $datos['logo'] . '" height="40" />';
		} else {
			$logo = '';
		}

		$uniqueId = $datos['uniqueid'];
		$status = $datos['status'];
		$nombre = $datos['nombre'];
		$razon_social = $datos['razon_social'];
		$rfc = $datos['rfc'];
		$tipoNum = $datos['tipo'];
		$contacto = $datos['contacto'];
		$telefono = $datos['telefono'];
		$email = $datos['email'];
		$domicilio = $datos['domicilio'];
		$ciudad = $datos['ciudad'];
		$estado = $datos['estado'];
		$fax = $datos['fax'];
		$ofrece = $datos['ofrece'];
		$garantia_certificaciones = $datos['garantia_certificaciones'];
		if ($datos['certificaciones'] == '') $certificaciones = '' ; else $certificaciones = $datos['certificaciones'];
		if ($datos['garantias'] == '') $garantias = '' ; else $garantias = $datos['garantias'];
		$fechaRegistro = Modelos_Fecha::formatearFechaHora($datos['fecha_registro']);
		
		$csf = $datos['csf'];
		$cdd = $datos['cdd'];
		$edocta = $datos['edocta'];
		$opcs = $datos['opcs'];
		$ce = $datos['ce'];

		$ac = $datos['ac'];
		$pnrl = $datos['pnrl'];
		$iorl = $datos['iorl'];
		$upp = $datos['upp'];
		$eoss = $datos['eoss'];
		$pep = $datos['pep'];

		$cta_banco = mb_strtoupper($datos['cta_banco']);
		$cta_sucursal = mb_strtoupper($datos['cta_sucursal']);
		$cta_cuenta = mb_strtoupper($datos['cta_cuenta']);
		$cta_clabe = mb_strtoupper($datos['cta_clabe']);
		$cta_encargado = mb_strtoupper($datos['cta_encargado']);
		
		$ine_anverso = $datos['ine_anverso'];
		$ine_reverso = $datos['ine_reverso'];

		$usos_cfdi = [];
		$usos_cfdi_formatted = [];
		if (!empty($datos['uso_cfdi1'])) $usos_cfdi[] = $datos['uso_cfdi1'];
		if (!empty($datos['uso_cfdi2'])) $usos_cfdi[] = $datos['uso_cfdi2'];
		if (!empty($datos['uso_cfdi3'])) $usos_cfdi[] = $datos['uso_cfdi3'];

		foreach ($usos_cfdi as $uso_cfdi) {
			switch ($uso_cfdi) {
				case 'P01': $usos_cfdi_formatted[] = 'P01 - POR DEFINIR'; break;
				case 'G01': $usos_cfdi_formatted[] = 'G01 - ADQUISICIÓN DE MERCANCÍAS'; break;
				case 'G02': $usos_cfdi_formatted[] = 'G02 - DEVOLUCIONES, DESCUENTOS O BONIFICACIONES'; break;
				case 'G03': $usos_cfdi_formatted[] = 'G03 - GASTOS EN GENERAL'; break;
				case 'I01': $usos_cfdi_formatted[] = 'I01 - CONSTRUCCIONES'; break;
				case 'I02': $usos_cfdi_formatted[] = 'I02 - MOBILIARIO Y EQUIPO DE OFICINA POR INVERSIONES'; break;
				case 'I03': $usos_cfdi_formatted[] = 'I03 - EQUIPO DE TRANSPORTE'; break;
				case 'I04': $usos_cfdi_formatted[] = 'I04 - EQUIPO DE COMPUTO Y ACCESORIOS'; break;
				case 'I05': $usos_cfdi_formatted[] = 'I05 - DADOS, TROQUELES, MOLDES, MATRICES Y HERRAMENTAL'; break;
				case 'I06': $usos_cfdi_formatted[] = 'I06 - COMUNICACIONES TELEFÓNICAS'; break;
				case 'I07': $usos_cfdi_formatted[] = 'I07 - COMUNICACIONES SATELITALES'; break;
				case 'I08': $usos_cfdi_formatted[] = 'I08 - OTRA MAQUINARIA Y EQUIPO'; break;
				case 'D01': $usos_cfdi_formatted[] = 'D01 - HONORARIOS MÉDICOS, DENTALES Y GASTOS HOSPITALARIOS'; break;
				case 'D02': $usos_cfdi_formatted[] = 'D02 - GASTOS MÉDICOS POR INCAPACIDAD O DISCAPACIDAD'; break;
				case 'D03': $usos_cfdi_formatted[] = 'D03 - GASTOS FUNERALES'; break;
				case 'D04': $usos_cfdi_formatted[] = 'D04 - DONATIVOS'; break;
				case 'D05': $usos_cfdi_formatted[] = 'D05 - INTERESES REALES EFECTIVAMENTE PAGADOS POR CRÉDITOS HIPOTECARIOS (CASA HABITACIÓN'; break;
				case 'D06': $usos_cfdi_formatted[] = 'D06 - APORTACIONES VOLUNTARIAS AL SAR'; break;
				case 'D07': $usos_cfdi_formatted[] = 'D07 - PRIMAS POR SEGUROS DE GASTOS MÉDICOS'; break;
				case 'D08': $usos_cfdi_formatted[] = 'D08 - GASTOS DE TRANSPORTACIÓN ESCOLAR OBLIGATORIA'; break;
				case 'D09': $usos_cfdi_formatted[] = 'D09 - DEPÓSITOS EN CUENTAS PARA EL AHORRO, PRIMAS QUE TENGAN COMO BASE PLANES DE PENSIONES'; break;
				case 'D10': $usos_cfdi_formatted[] = 'D10 - PAGOS POR SERVICIOS EDUCATIVOS (COLEGIATURAS'; break;
				case 'S01': $usos_cfdi_formatted[] = 'S01 - SIN EFECTOS FISCALES'; break;
				case 'CP01': $usos_cfdi_formatted[] = 'CP01 - PAGOS'; break;
				case 'CN01': $usos_cfdi_formatted[] = 'CN01 - NÓMINA'; break;
			}
		}

		if (!empty($csf)) $csfHtml = '<img src="' . STASIS . '/img/link.png" width="7" /> <a target="_blank" href="' . STASIS . '/data/privada/archivos/' . $csf . '">Descargar</a>'; else $csfHtml = '';
		if (!empty($cdd)) $cddHtml = '<img src="' . STASIS . '/img/link.png" width="7" /> <a target="_blank" href="' . STASIS . '/data/privada/archivos/' . $cdd . '">Descargar</a>'; else $cddHtml = '';
		if (!empty($edocta)) $edoctaHtml = '<img src="' . STASIS . '/img/link.png" width="7" /> <a target="_blank" href="' . STASIS . '/data/privada/archivos/' . $edocta . '">Descargar</a>'; else $edoctaHtml = '';
		if (!empty($opcs)) $opcsHtml = '<img src="' . STASIS . '/img/link.png" width="7" /> <a target="_blank" href="' . STASIS . '/data/privada/archivos/' . $opcs . '">Descargar</a>'; else $opcsHtml = '';
		if (!empty($ce)) $ceHtml = '<img src="' . STASIS . '/img/link.png" width="7" /> <a target="_blank" href="' . STASIS . '/data/privada/Anexo_2_Codigo_de_Etica_de_Proveedores.pdf">' . $ce . ' hrs</a>'; else $ceHtml = '';

		if (!empty($ac)) $acHtml = '<img src="' . STASIS . '/img/link.png" width="7" /> <a target="_blank" href="' . STASIS . '/data/privada/archivos/' . $ac . '">Descargar</a>'; else $acHtml = '';
		if (!empty($pnrl)) $pnrlHtml = '<img src="' . STASIS . '/img/link.png" width="7" /> <a target="_blank" href="' . STASIS . '/data/privada/archivos/' . $pnrl . '">Descargar</a>'; else $pnrlHtml = '';
		if (!empty($iorl)) $iorlHtml = '<img src="' . STASIS . '/img/link.png" width="7" /> <a target="_blank" href="' . STASIS . '/data/privada/archivos/' . $iorl . '">Descargar</a>'; else $iorlHtml = '';
		if (!empty($upp)) $uppHtml = '<img src="' . STASIS . '/img/link.png" width="7" /> <a target="_blank" href="' . STASIS . '/data/privada/archivos/' . $upp . '">Descargar</a>'; else $uppHtml = '';
		if (!empty($eoss)) $eossHtml = '<img src="' . STASIS . '/img/link.png" width="7" /> <a target="_blank" href="' . STASIS . '/data/privada/archivos/' . $eoss . '">Descargar</a>'; else $eossHtml = '';
		if (!empty($pep)) $pepHtml = '<img src="' . STASIS . '/img/link.png" width="7" /> <a target="_blank" href="' . STASIS . '/data/privada/archivos/' . $pep . '">Descargar</a>'; else $pepHtml = '';
		
		if (!empty($ine_anverso)) $ineAnversoHtml = '<img src="' . STASIS . '/img/link.png" width="7" /> <a target="_blank" href="' . STASIS . '/data/privada/archivos/' . $ine_anverso . '">Descargar</a>'; else $ineAnversoHtml = '';
		if (!empty($ine_reverso)) $ineReversoHtml = '<img src="' . STASIS . '/img/link.png" width="7" /> <a target="_blank" href="' . STASIS . '/data/privada/archivos/' . $ine_reverso . '">Descargar</a>'; else $ineReversoHtml = '';

		if (!empty($datos['aprueba'])) {
			$aprueba = $datos['aprueba'];
			$fechaAprobacion = Modelos_Fecha::formatearFechaHora($datos['fecha_aprobacion']);
		} else {
			$aprueba = '';
			$fechaAprobacion = '';
		}

		if (!empty($datos['autoriza'])) {
			$autoriza = $datos['autoriza'];
			$fechaAutorizacion = Modelos_Fecha::formatearFechaHora($datos['fecha_autorizacion']);
		} else {
			$autoriza = '';
			$fechaAutorizacion = '';
		}

		$sth2 = $this->_db->prepare("
			SELECT pr.empresa, pr.contacto, pr.telefono
			FROM proveedores_referencias pr
			JOIN proveedores p
			ON p.id = pr.id_proveedor
			WHERE p.uniqueid = ?
		");
		$sth2->bindParam(1, $uniqueId);
		if(!$sth2->execute()) throw New Exception();
		
		$x = 1;
		$referencias = [];
		while ($datos2 = $sth2->fetch()) {
			$referencias[$x]['empresa'] = $datos2['empresa'];
			$referencias[$x]['contacto'] = $datos2['contacto'];
			$referencias[$x]['telefono'] = $datos2['telefono'];

			$x++;
		}

		// Cumplimiento
		if ($tipoNum == 1) {
			$tareas = 10;
		} elseif ($tipoNum == 2) {
			$tareas = 12;
		} elseif ($tipoNum == 3) {
			$tareas = 15;
		}
		$cumplidas = 0;

		// Fecha de vencimiento
		$fechaVencimiento = new DateTime();
		$fechaVencimiento->add(new DateInterval('P7D'));
		$fechaVencimiento = $fechaVencimiento->getTimestamp();
		$datosArray['fechaVencimiento'] = utf8_encode(ucfirst(strftime("%A %d de %B del %Y", $fechaVencimiento)));

		// Datos principales
		$sth = $this->_db->prepare("SELECT * FROM proveedores WHERE uniqueid = ?");
		$sth->bindParam(1, $uniqueId);
		if(!$sth->execute()) throw New Exception();
		$datos = $sth->fetch();

		$idProveedor = $datos['id'];
		$datosArray['status'] = $datos['status'];

		if ($datos['nombre'] && $datos['razon_social'] && $datos['rfc'] && $datos['contacto'] && $datos['telefono'] && $datos['email'] && $datos['domicilio'] && $datos['ciudad'] && $datos['estado'] && $datos['ofrece']) {
			$datosArray['principales'] = 1;
			$cumplidas++;
		} else {
			$datosArray['principales'] = 0;
		}

		if ($datos['logo']) {
			$datosArray['logo'] = 1;
			$cumplidas++;
		} else {
			$datosArray['logo'] = 0;
		}

		// Referencias
		$sth = $this->_db->prepare("SELECT COUNT(id) FROM proveedores_referencias WHERE id_proveedor = ?");
		$sth->bindParam(1, $idProveedor);
		if(!$sth->execute()) throw New Exception();
		$cReferencias = $sth->fetchColumn();

		if ($cReferencias == 3) {
			$datosArray['referencias'] = 1;
			$cumplidas++;
		} else {
			$datosArray['referencias'] = 0;
		}

		// Referencias
		$sth = $this->_db->prepare("SELECT * FROM proveedores WHERE id = ?");
		$sth->bindParam(1, $idProveedor);
		if(!$sth->execute()) throw New Exception();
		$datos = $sth->fetch();

		if ($datos['garantia_certificaciones']) {
			$datosArray['certificaciones'] = 1;
			$cumplidas++;
		} else {
			$datosArray['certificaciones'] = 0;
		}

		// Archivos
		if ($datos['csf']) {
			$datosArray['csf'] = 1;
			$cumplidas++;
		} else {
			$datosArray['csf'] = 0;
		}
		if ($datos['cdd']) {
			$datosArray['cdd'] = 1;
			$cumplidas++;
		} else {
			$datosArray['cdd'] = 0;
		}
		if ($datos['edocta'] || $datos['cta_clabe']) {
			$datosArray['edocta'] = 1;
			$cumplidas++;
		} else {
			$datosArray['edocta'] = 0;
		}
		if ($datos['opcs']) {
			$datosArray['opcs'] = 1;
			$cumplidas++;
		} else {
			$datosArray['opcs'] = 0;
		}
		if ($datos['ce']) {
			$datosArray['ce'] = 1;
			$cumplidas++;
		} else {
			$datosArray['ce'] = 0;
		}
		if ($datos['ine_anverso'] && $datos['ine_reverso']) {
			$datosArray['ine'] = 1;
			$cumplidas++;
		} else {
			$datosArray['ine'] = 0;
		}

		// Persona Moral
		if ($tipoNum == 2) {
			if ($datos['ac']) {
				$datosArray['ac'] = 1;
				$cumplidas++;
			} else {
				$datosArray['ac'] = 0;
			}
			if ($datos['pnrl']) {
				$datosArray['pnrl'] = 1;
				$cumplidas++;
			} else {
				$datosArray['pnrl'] = 0;
			}

			$archivosMoral = '
				<tr>
	                <td style="width: 66.5%;">Acta Constitutiva.</td>
	                <td style="width: 33.5%; text-align: center;">' . $acHtml . '</td>
	            </tr>
	            <tr>
	                <td style="width: 66.5%;">Poder Notarial del Representante Legal.</td>
	                <td style="width: 33.5%; text-align: center;">' . $pnrlHtml . '</td>
	            </tr>
			';
		} else {
			$archivosMoral = '';
		}

		// Contratista
		if ($tipoNum == 3) {
			if ($datos['ac']) {
				$datosArray['ac'] = 1;
				$cumplidas++;
			} else {
				$datosArray['ac'] = 0;
			}
			if ($datos['pnrl']) {
				$datosArray['pnrl'] = 1;
				$cumplidas++;
			} else {
				$datosArray['pnrl'] = 0;
			}
			if ($datos['iorl']) {
				$datosArray['iorl'] = 1;
				$cumplidas++;
			} else {
				$datosArray['iorl'] = 0;
			}
			if ($datos['upp']) {
				$datosArray['upp'] = 1;
				$cumplidas++;
			} else {
				$datosArray['upp'] = 0;
			}
			if ($datos['eoss']) {
				$datosArray['eoss'] = 1;
				$cumplidas++;
			} else {
				$datosArray['eoss'] = 0;
			}
			if ($datos['pep']) {
				$datosArray['pep'] = 1;
				$cumplidas++;
			} else {
				$datosArray['pep'] = 0;
			}

			$archivosContratistas = '
				<tr>
	                <td style="width: 66.5%;">Acta Constitutiva.</td>
	                <td style="width: 33.5%; text-align: center;">' . $acHtml . '</td>
	            </tr>
	            <tr>
	                <td style="width: 66.5%;">Poder Notarial del Representante Legal.</td>
	                <td style="width: 33.5%; text-align: center;">' . $pnrlHtml . '</td>
	            </tr>
	            <tr>
	                <td style="width: 66.5%;">Identificación Oficial del Representante Legal.</td>
	                <td style="width: 33.5%; text-align: center;">' . $iorlHtml . '</td>
	            </tr>
	            <tr>
	                <td style="width: 66.5%;">Último pago provisional ISR, ultimo pago provisional IVA, retencion de sueldos y salarios.</td>
	                <td style="width: 33.5%; text-align: center;">' . $uppHtml . '</td>
	            </tr>
	            <tr>
	                <td style="width: 66.5%;">Comprobante de pago al seguro social en caso de empresas outsourcing y lista de personal registrado en el Seguro Social.</td>
	                <td style="width: 33.5%; text-align: center;">' . $eossHtml . '</td>
	            </tr>
	            <tr>
	                <td style="width: 66.5%;">Notificación a proveedores y evaluación de proveedores.</td>
	                <td style="width: 33.5%; text-align: center;">' . $pepHtml . '</td>
	            </tr>
			';
		} else {
			$archivosContratistas = '';
		}

		$datosArray['porcentaje'] = round(($cumplidas/$tareas)*100);

		if ($datos['status'] != 0) {
			if ($datosArray['porcentaje'] != 100) {
				$statusHtml = '<img src="' . STASIS . '/img/s-success.png" height="7" /> Pendiente';
			} else {
				if ($datos['id_autoriza']) {
					$statusHtml = '<img src="' . STASIS . '/img/s-primary.png" height="7" /> Autorizado';
				} elseif ($datos['id_aprueba']) {
					$statusHtml = '<img src="' . STASIS . '/img/s-info.png" height="7" /> Aprobado';
				} else {
					$statusHtml = '<img src="' . STASIS . '/img/s-warning.png" height="7" /> En Revisión';
				}
			}
		} else {
			$inactivos[] = $arreglo;
			$nInactivos++;
		}

		$stasis = STASIS;
		TCPDF_FONTS::addTTFfont(APP . '/plugins/tcpdf/fonts/Roboto-Bold.ttf', 'TrueTypeUnicode', '', 96);
		TCPDF_FONTS::addTTFfont(APP . '/plugins/tcpdf/fonts/Roboto-Regular.ttf', 'TrueTypeUnicode', '', 96);
		TCPDF_FONTS::addTTFfont(APP . '/plugins/tcpdf/fonts/SanFransico.ttf', 'TrueTypeUnicode', '', 96);
		TCPDF_FONTS::addTTFfont(APP . '/plugins/tcpdf/fonts/SanFranciscoBold.ttf', 'TrueTypeUnicode', '', 96);

		$html = <<<EOF
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td style="width: 250px; color: #444;">
						<br /><img src="$stasis/img/gvalcas.png" height="50" />
					</td>
					<td style="width: 223px; text-align: right; color: #444;">
						<span style="font-size: 14px; font-family: 'Roboto Bold';">EXPEDIENTE DE PROVEEDOR</span><br /><br />
						<span style="font-size: 9px;">Fecha de Registro: $fechaRegistro</span><br />
						<span style="font-size: 9px;">Status de Proveedor: $statusHtml</span>
					</td>
					<td style="width: 65px; text-align: right;">
						<img src="http://chart.apis.google.com/chart?cht=qr&chs=100x100&chl=https://saevalcas.mx/proveedores/perfil/pdf/$uniqueId&chld=L|0" height="54">
					</td>
				</tr>
			</table>
			<br /><br />

			<table style="border: 2px solid #DDDCDD;">
			</table>
			<br /><br />

			<table style="text-align: center; font-size: 7px;" cellpadding="2" cellspacing="0" border="1">
				<tr>
					<td style="background-color: #3372B4; color: #FFF; width: 100%">
						<span style="text-align: center; font-size: 9px; font-family: 'SanFranciscoBold';">Logo de la Empresa</strong>
					</td>
				</tr>
				<tr><td>$logo</td></tr>
			</table>
			<br /><br />

			<table style="text-align: center; font-size: 7px;" cellpadding="2" cellspacing="0" border="1">
				<tr>
					<td colspan="4" style="background-color: #3372B4; color: #FFF; width: 100%">
						<span style="text-align: center; font-size: 9px; font-family: 'SanFranciscoBold';">Datos Generales</strong>
					</td>
				</tr>
				<tr>
				    <td><b><i>Nombre Comercial:</b></i><br />$nombre</td>
				    <td><b><i>Razón Social:</b></i><br />$razon_social</td>
				    <td><b><i>RFC:</b></i><br />$rfc</td>
                    <td><b><i>Tipo de Proveedor:</b></i><br />$tipo</td>
                </tr>
				<tr>
				    <td><b><i>Nombre del Contacto:</b></i><br />$contacto</td>
				    <td><b><i>Teléfono:</b></i><br />$telefono</td>
				    <td><b><i>Email:</b></i><br />$email</td>
                    <td><b><i>Fax:</b></i><br />$fax</td>
				</tr>
				<tr>
				    <td><b><i>Domicilio:</b></i><br />$domicilio</td>
				    <td><b><i>Ciudad:</b></i><br />$ciudad</td>
				    <td><b><i>Estado:</b></i><br />$estado</td>
                    <td><b><i>País:</b></i><br />MÉXICO</td>
				</tr>
				<tr>
				    <td colspan="4"><b><i>Producto y/o servicio que ofrece:</b></i><br />$ofrece</td>
				</tr>
			</table>
			<br /><br />

			<table style="text-align: center; font-size: 7px;" cellpadding="2" cellspacing="0" border="1">
				<tr>
					<td colspan="5" style="background-color: #3372B4; color: #FFF; width: 100%">
						<span style="text-align: center; font-size: 9px; font-family: 'SanFranciscoBold';">Datos Bancarios</strong>
					</td>
				</tr>
				<tr>
				    <td><b><i>Banco:</b></i><br />$cta_banco</td>
				    <td><b><i>Sucursal:</b></i><br />$cta_sucursal</td>
				    <td><b><i>Cuenta:</b></i><br />$cta_cuenta</td>
                    <td><b><i>CLABE:</b></i><br />$cta_clabe</td>
                    <td><b><i>Encargado:</b></i><br />$cta_encargado</td>
                </tr>
            </table><br /><br />

            <table style="text-align: center; font-size: 7px;" cellpadding="2" cellspacing="0" border="1">
				<tr>
					<td colspan="3" style="background-color: #3372B4; color: #FFF; width: 100%">
						<span style="text-align: center; font-size: 9px; font-family: 'SanFranciscoBold';">Usos de CFDI Autorizados</strong>
					</td>
				</tr>
				<tr>
				    <td><b><i>Uso CFDI #1:</b></i><br />$usos_cfdi_formatted[0]</td>
				    <td><b><i>Uso CFDI #2:</b></i><br />$usos_cfdi_formatted[1]</td>
				    <td><b><i>Uso CFDI #3:</b></i><br />$usos_cfdi_formatted[2]</td>
                </tr>
            </table><br /><br />

			<table style="text-align: center; font-size: 7px;" cellpadding="2" cellspacing="0" border="1">
				<tr>
					<td colspan="3" style="background-color: #3372B4; color: #FFF; width: 100%">
						<span style="text-align: center; font-size: 9px; font-family: 'SanFranciscoBold';">Referencias Comerciales</strong>
					</td>
				</tr>
				<tr>
					<td style="background-color: #6FA7E5; color: #FFF;">
						<span style="text-align: center; font-size: 7px; font-family: 'SanFranciscoBold';">Empresa</strong>
					</td>
					<td style="background-color: #6FA7E5; color: #FFF;">
						<span style="text-align: center; font-size: 7px; font-family: 'SanFranciscoBold';">Contacto</strong>
					</td>
					<td style="background-color: #6FA7E5; color: #FFF;">
						<span style="text-align: center; font-size: 7px; font-family: 'SanFranciscoBold';">Teléfono</strong>
					</td>
				</tr>
				<tr>
					<td>{$referencias[1]['empresa']}</td>
					<td>{$referencias[1]['contacto']}</td>
					<td>{$referencias[1]['telefono']}</td>
				</tr>
				<tr>
					<td>{$referencias[2]['empresa']}</td>
					<td>{$referencias[2]['contacto']}</td>
					<td>{$referencias[2]['telefono']}</td>
				</tr>
				<tr>
					<td>{$referencias[3]['empresa']}</td>
					<td>{$referencias[3]['contacto']}</td>
					<td>{$referencias[3]['telefono']}</td>
				</tr>
			</table>
			<br /><br />

			<table style="text-align: left; font-size: 7px;" cellpadding="2" cellspacing="0" border="1">
				<tr>
					<td colspan="2" style="background-color: #3372B4; color: #FFF; width: 100%">
						<span style="text-align: center; font-size: 9px; font-family: 'SanFranciscoBold';">Documentación Requerida</strong>
					</td>
				</tr>
				
                <tr>
                    <td style="width: 66.5%;">Identificación Oficial (Anverso).</td>
                    <td style="width: 33.5%; text-align: center;">$ineAnversoHtml</td>
                </tr>
                <tr>
                    <td style="width: 66.5%;">Identificación Oficial (Reverso).</td>
                    <td style="width: 33.5%; text-align: center;">$ineReversoHtml</td>
                </tr>
                <tr>
                    <td style="width: 66.5%;">Constancia de situación fiscal.</td>
                    <td style="width: 33.5%; text-align: center;">$csfHtml</td>
                </tr>
                <tr>
                    <td style="width: 66.5%;">Comprobante de domicilio (Recibo de servicios).</td>
                    <td style="width: 33.5%; text-align: center;">$cddHtml</td>
                </tr>
                <tr>
                    <td style="width: 66.5%;">Estado de cuenta bancario (Para comprobación de cuentas y CLABE).</td>
                    <td style="width: 33.5%; text-align: center;">$edoctaHtml</td>
                </tr>
                <tr>
                    <td style="width: 66.5%;">Opinión positiva del cumplimiento por parte del SAT.</td>
                    <td style="width: 33.5%; text-align: center;">$opcsHtml</td>
                </tr>
                $archivosMoral
                $archivosContratistas
                <tr>
                    <td style="width: 66.5%;">Aceptación de Código de Ética.</td>
                    <td style="width: 33.5%; text-align: center;">$ceHtml</td>
                </tr>
			</table>
			<br /><br />

			<table style="text-align: center; font-size: 7px;" cellpadding="2" cellspacing="0" border="1">
				<tr>
					<td colspan="2" style="background-color: #3372B4; color: #FFF; width: 100%">
						<span style="text-align: center; font-size: 9px; font-family: 'SanFranciscoBold';">Certificaciones o Garantías</strong>
					</td>
				</tr>
				
                <tr>
				    <td><b><i>Certificaciones con las que cuenta:</b></i><br />$certificaciones</td>
				    <td><b><i>Garantias que ofrece:</b></i><br />$garantias</td>
				</tr>
			</table>
			<br /><br />

			<table style="font-size: 7px; width: 100%;">
				<tr>
					<td style="width:50%; text-align: center;"><span style="font-family: \'SanFranciscoBold\';">Compras:</span><br />$aprueba<br />$fechaAprobacion</td>
					<td style="width:50%; text-align: center;"><span style="font-family: \'SanFranciscoBold\';">Administración:</span><br />$autoriza<br />$fechaAutorizacion</td>
				</tr>
				<tr>
					<td colspan="3" style="height: 0px;"></td>
				</tr>
				<tr>
					<td style="width:50%; text-align: center; font-family: \'Roboto\';">___________________________</td>
					<td style="width:50%; text-align: center; font-family: \'Roboto\';">___________________________</td>
				</tr>
				<tr>
					<td style="width:50%; font-family: \'SanFranciscoBold\'; text-align: center;">Firma</td>
					<td style="width:50%; font-family: \'SanFranciscoBold\'; text-align: center;">Firma</td>
				</tr>
			</table>
EOF;

		$fechaPdf = date('d-m-Y');
		$pdf->writeHTML($html, true, false, true, false, '');
		$pdf->lastPage();
		$pdf->Output("ProveedorGValcas_{$rfc}_{$fechaPdf}.pdf", 'I');
	}

	public function requisiciones() {
		$datosVista = [];

		$sth = $this->_db->prepare("
			SELECT rp.id, rp.id_requisicion, CONCAT(e.nombre, ' ', e.apellidos) AS solicita, d.nombre AS departamento, rp.producto, rp.tipo, rp.cantidad, rp.um, DATE(rp.fecha_creacion) AS fecha_creacion, DATE(rp.fecha_procesa) AS fecha_procesa, CONCAT(es.nombre, ' ', es.apellidos) AS autoriza, rp.fecha_autorizacion, rp.dias_entrega, rp.oc, rp.archivo_pdf, rp.archivo_xml, rp.subtotal, rp.iva, rp.total, rp.tipo_cambio, rp.moneda, rp.fecha_carga
			FROM requisiciones_partes rp
			JOIN departamentos d
			ON d.id = rp.id_departamento
			JOIN empleados e
			ON e.id = rp.id_solicita
			JOIN empleados es
			ON es.id = rp.id_autoriza
			JOIN requisiciones r
			ON r.id = rp.id_requisicion
			JOIN empleados ej
			ON ej.id = e.id_jefe
			WHERE rp.status IN(2, 3) AND rp.id_proveedor = ?
			ORDER BY rp.id_requisicion DESC
		");
		$sth->bindParam(1, $_SESSION['login_id']);
		if(!$sth->execute()) throw New Exception();

		$datosVista['nPendientes'] = 0;
		$datosVista['nCargados'] = 0;

		while ($datos = $sth->fetch()) {
			$fechaActual = new DateTime(date('Y-m-d 00:00:00'));
			$diasEntrega = $datos['dias_entrega'];

			$fechaVencimiento = new DateTime($datos['fecha_procesa']);
			$fechaVencimiento->modify("+$diasEntrega days");

			$diasVencidos = $fechaActual->diff($fechaVencimiento);
			$diasVencidos = $diasVencidos->format("%r%a");

			if ($diasVencidos >= 1) {
				$status = $diasVencidos;
			} elseif ($diasVencidos == 0) {
				$status = 'HOY';
			} else {
				$status = 'ATRASADA';
			}

			if ($diasVencidos >= 3) {
				$icono = 'icono-activar.png';
				$color = '#AFE5AF';
			} elseif ($diasVencidos >= 1 && $diasVencidos <= 2) {
				$icono = 'icono-alerta_amarillo.png';
				$color = '#FFFAC1';
			} elseif ($diasVencidos == 0 || $status == 'ATRASADA') {
				$icono = 'icono-advertencia.png';
				$color = '#FFB4AA';
			}

			if ($datos['moneda'] == 1) {
				$moneda = 'MXN';
			} elseif ($datos['moneda'] == 2) {
				$moneda = 'USD';
			}
			
			$arreglo = array(
				'id' => $datos['id'],
				'id_requisicion' => $datos['id_requisicion'],
				'solicita' => $datos['solicita'],
				'autoriza' => $datos['autoriza'],
				'departamento' => $datos['departamento'],
				'producto' => $datos['producto'],
				'tipo' => $datos['tipo'],
				'cantidad' => $datos['cantidad'],
				'um' => $datos['um'],
				'oc' => $datos['oc'],
				'dias_entrega' => $datos['dias_entrega'],
				'archivo_pdf' => $datos['archivo_pdf'],
				'archivo_xml' => $datos['archivo_xml'],
				'dias_vencidos' => $status,
				'icono' => $icono,
				'color' => $color,
				'fecha' => Modelos_Fecha::formatearFecha($datos['fecha_creacion']),
				'fecha_procesa' => Modelos_Fecha::formatearFecha($datos['fecha_procesa']),
				'fecha_vencimiento' => Modelos_Fecha::formatearFecha($fechaVencimiento->format('Y-m-d')),
				'fecha_autorizacion' => Modelos_Fecha::formatearFecha($datos['fecha_autorizacion']),
				'fecha_carga' => Modelos_Fecha::formatearFecha($datos['fecha_carga']),
				'subtotal' => '$ ' . number_format($datos['subtotal'], 2, '.', ',') . ' ' . $moneda,
				'iva' => '$ ' . number_format($datos['iva'], 2, '.', ',') . ' ' . $moneda,
				'total' => '$ ' . number_format($datos['total'], 2, '.', ',') . ' ' . $moneda,
				'tipo_cambio' => $datos['tipo_cambio'],
			);

			if ($datos['archivo_pdf'] && $datos['archivo_xml']) {
				$datosVista['cargados'][] = $arreglo;
				$datosVista['nCargados']++;
			} else {
				$datosVista['pendientes'][] = $arreglo;
				$datosVista['nPendientes']++;
			}
		}

		return $datosVista;
	}

	public function ordenesCompra($ids) {
		$sth = $this->_db->prepare("
			SELECT rp.oc
			FROM requisiciones_partes rp
			JOIN departamentos d
			ON d.id = rp.id_departamento
			JOIN empleados e
			ON e.id = rp.id_solicita
			JOIN empleados es
			ON es.id = rp.id_autoriza
			JOIN requisiciones r
			ON r.id = rp.id_requisicion
			JOIN empleados ej
			ON ej.id = e.id_jefe
			WHERE rp.status IN(2, 3) AND rp.id_proveedor = ? AND rp.id IN ($ids)
			ORDER BY rp.id_requisicion DESC
		");
		$sth->bindParam(1, $_SESSION['login_id']);
		if(!$sth->execute()) throw New Exception();

		$ordenesCompra = '';
		while ($datos = $sth->fetch()) {
			$ordenesCompra .= $datos['oc'] . ',';
		}
		$ordenesCompra = substr($ordenesCompra, 0, -1);

		return $ordenesCompra;
	}

	public function subirPdfXml() {
		try {
			require APP . 'inc/class.upload.php';

			$ids = $_POST['ids'];
			$ids = explode(',', $ids);

			if (!$_FILES['pdf']['size'] == 0) {
				$handle = new upload($_FILES['pdf']);
				if ($handle->uploaded) {
					$archivo = Modelos_Caracteres::caracteres_latinos($handle->file_src_name_body) . '-' . time();
					$handle->file_new_name_body   = $archivo;
					$archivoDb = $archivo . '.' . $handle->file_src_name_ext;
					$handle->process(ROOT_DIR . 'data/privada/facturas/');
					if ($handle->processed) {
						$handle->clean();
					}
				}

				foreach ($ids as $id) {
					$arregloDatos = array($archivoDb, $id);
					$sth = $this->_db->prepare("UPDATE requisiciones_partes SET archivo_pdf = ? WHERE id = ?");
					if(!$sth->execute($arregloDatos)) throw New Exception();
				}
			}

			if (!$_FILES['xml']['size'] == 0) {
				$handle = new upload($_FILES['xml']);
				if ($handle->uploaded) {
					$archivo = Modelos_Caracteres::caracteres_latinos($handle->file_src_name_body) . '-' . time();
					$handle->file_new_name_body   = $archivo;
					$archivoDb = $archivo . '.' . $handle->file_src_name_ext;
					$handle->process(ROOT_DIR . 'data/privada/facturas/');
					if ($handle->processed) {
						$handle->clean();
					}
				}











				// Procesar XML
				$document = new DOMDocument();
				$document->load(ROOT_DIR . 'data/privada/facturas/' . $archivo . '.txt');
				$xml = simplexml_load_file(ROOT_DIR . 'data/privada/facturas/' . $archivo . '.txt');
				$ns = $xml->getNamespaces(true);
				$xml->registerXPathNamespace('c', $ns['cfdi']);
				$xml->registerXPathNamespace('t', $ns['tfd']);
				$data = array();

				foreach ($xml->xpath('//c:Comprobante') as $cfdiComprobante){ 
					$data['moneda'] = (string)$cfdiComprobante['Moneda'];

					if ($data['moneda'] == 'USD') {
						$data['tipo_cambio'] = number_format((float)$cfdiComprobante['TipoCambio'], 2, '.', '');
					} else {
						$data['tipo_cambio'] = '';
					}

					$data['subtotal'] = number_format((float)$cfdiComprobante['SubTotal'], 2, '.', '');
					$data['total'] = number_format((float)$cfdiComprobante['Total'], 2, '.', '');
				}

				foreach ($xml->xpath('//c:Comprobante//c:Impuestos//c:Traslados//c:Traslado') as $Traslado){ 
					$tipoImpuesto = (string)$Traslado['Impuesto'];
					$data['impuesto'] = (string)$Traslado['Importe'];
				}

				foreach ($ids as $id) {
					if ($data['moneda'] == 'USD') {
						$moneda = 2;
					} elseif ($data['moneda'] == 'MXN') {
						$moneda = 1;
					}

					$arregloDatos = array($archivoDb, $data['subtotal'], $data['impuesto'], $data['total'], $moneda, $data['tipo_cambio'], $id);
					$sth = $this->_db->prepare("UPDATE requisiciones_partes SET archivo_xml = ?, subtotal = ?, iva = ?, total = ?, moneda = ?, tipo_cambio = ?, fecha_carga = NOW() WHERE id = ?");
					if(!$sth->execute($arregloDatos)) throw New Exception();
				}
			}

			header('Location:' . STASIS . '/');
		} catch (Exception $e) {
			echo Modelos_Sistema::status(0, $e->getMessage());
		}
	}

	public function actualizarAc() {
		try {
			if (!$_FILES['archivo']['size'] == 0) {
				require APP . 'inc/class.upload.php';

				$handle = new upload($_FILES['archivo']);
				if ($handle->uploaded) {
					$archivo = Modelos_Caracteres::caracteres_latinos($handle->file_src_name_body) . '-' . time();
					$handle->file_new_name_body   = $archivo;
					$archivoDb = $archivo . '.' . $handle->file_src_name_ext;
					$handle->process(ROOT_DIR . 'data/privada/archivos/');
					if ($handle->processed) {
						$handle->clean();
					}
				}

				$arregloDatos = array($archivoDb, $_SESSION['login_id']);
				$sth = $this->_db->prepare("UPDATE proveedores SET ac = ? WHERE id = ?");
				if(!$sth->execute($arregloDatos)) throw New Exception();
			}

			header('Location:' . STASIS . '/perfil/datos/ac/1');
		} catch (Exception $e) {
			echo Modelos_Sistema::status(0, $e->getMessage());
		}
	}

	public function actualizarPnrl() {
		try {
			if (!$_FILES['archivo']['size'] == 0) {
				require APP . 'inc/class.upload.php';

				$handle = new upload($_FILES['archivo']);
				if ($handle->uploaded) {
					$archivo = Modelos_Caracteres::caracteres_latinos($handle->file_src_name_body) . '-' . time();
					$handle->file_new_name_body   = $archivo;
					$archivoDb = $archivo . '.' . $handle->file_src_name_ext;
					$handle->process(ROOT_DIR . 'data/privada/archivos/');
					if ($handle->processed) {
						$handle->clean();
					}
				}

				$arregloDatos = array($archivoDb, $_SESSION['login_id']);
				$sth = $this->_db->prepare("UPDATE proveedores SET pnrl = ? WHERE id = ?");
				if(!$sth->execute($arregloDatos)) throw New Exception();
			}

			header('Location:' . STASIS . '/perfil/datos/pnrl/1');
		} catch (Exception $e) {
			echo Modelos_Sistema::status(0, $e->getMessage());
		}
	}

	public function actualizarIorl() {
		try {
			if (!$_FILES['archivo']['size'] == 0) {
				require APP . 'inc/class.upload.php';

				$handle = new upload($_FILES['archivo']);
				if ($handle->uploaded) {
					$archivo = Modelos_Caracteres::caracteres_latinos($handle->file_src_name_body) . '-' . time();
					$handle->file_new_name_body   = $archivo;
					$archivoDb = $archivo . '.' . $handle->file_src_name_ext;
					$handle->process(ROOT_DIR . 'data/privada/archivos/');
					if ($handle->processed) {
						$handle->clean();
					}
				}

				$arregloDatos = array($archivoDb, $_SESSION['login_id']);
				$sth = $this->_db->prepare("UPDATE proveedores SET iorl = ? WHERE id = ?");
				if(!$sth->execute($arregloDatos)) throw New Exception();
			}

			header('Location:' . STASIS . '/perfil/datos/iorl/1');
		} catch (Exception $e) {
			echo Modelos_Sistema::status(0, $e->getMessage());
		}
	}

	public function actualizarUpp() {
		try {
			if (!$_FILES['archivo']['size'] == 0) {
				require APP . 'inc/class.upload.php';

				$handle = new upload($_FILES['archivo']);
				if ($handle->uploaded) {
					$archivo = Modelos_Caracteres::caracteres_latinos($handle->file_src_name_body) . '-' . time();
					$handle->file_new_name_body   = $archivo;
					$archivoDb = $archivo . '.' . $handle->file_src_name_ext;
					$handle->process(ROOT_DIR . 'data/privada/archivos/');
					if ($handle->processed) {
						$handle->clean();
					}
				}

				$arregloDatos = array($archivoDb, $_SESSION['login_id']);
				$sth = $this->_db->prepare("UPDATE proveedores SET upp = ? WHERE id = ?");
				if(!$sth->execute($arregloDatos)) throw New Exception();
			}

			header('Location:' . STASIS . '/perfil/datos/upp/1');
		} catch (Exception $e) {
			echo Modelos_Sistema::status(0, $e->getMessage());
		}
	}

	public function actualizarEoss() {
		try {
			if (!$_FILES['archivo']['size'] == 0) {
				require APP . 'inc/class.upload.php';

				$handle = new upload($_FILES['archivo']);
				if ($handle->uploaded) {
					$archivo = Modelos_Caracteres::caracteres_latinos($handle->file_src_name_body) . '-' . time();
					$handle->file_new_name_body   = $archivo;
					$archivoDb = $archivo . '.' . $handle->file_src_name_ext;
					$handle->process(ROOT_DIR . 'data/privada/archivos/');
					if ($handle->processed) {
						$handle->clean();
					}
				}

				$arregloDatos = array($archivoDb, $_SESSION['login_id']);
				$sth = $this->_db->prepare("UPDATE proveedores SET eoss = ? WHERE id = ?");
				if(!$sth->execute($arregloDatos)) throw New Exception();
			}

			header('Location:' . STASIS . '/perfil/datos/eoss/1');
		} catch (Exception $e) {
			echo Modelos_Sistema::status(0, $e->getMessage());
		}
	}

	public function actualizarPep() {
		try {
			if (!$_FILES['archivo']['size'] == 0) {
				require APP . 'inc/class.upload.php';

				$handle = new upload($_FILES['archivo']);
				if ($handle->uploaded) {
					$archivo = Modelos_Caracteres::caracteres_latinos($handle->file_src_name_body) . '-' . time();
					$handle->file_new_name_body   = $archivo;
					$archivoDb = $archivo . '.' . $handle->file_src_name_ext;
					$handle->process(ROOT_DIR . 'data/privada/archivos/');
					if ($handle->processed) {
						$handle->clean();
					}
				}

				$arregloDatos = array($archivoDb, $_SESSION['login_id']);
				$sth = $this->_db->prepare("UPDATE proveedores SET pep = ? WHERE id = ?");
				if(!$sth->execute($arregloDatos)) throw New Exception();
			}

			header('Location:' . STASIS . '/perfil/datos/pep/1');
		} catch (Exception $e) {
			echo Modelos_Sistema::status(0, $e->getMessage());
		}
	}

	public function actualizarIne() {
		try {
			require APP . 'inc/class.upload.php';

			if (!$_FILES['archivo_anverso']['size'] == 0) {
				$handle = new upload($_FILES['archivo_anverso']);
				if ($handle->uploaded) {
					$archivo = Modelos_Caracteres::caracteres_latinos($handle->file_src_name_body) . '-' . time();
					$handle->file_new_name_body   = $archivo;
					$archivoDb = $archivo . '.' . $handle->file_src_name_ext;
					$handle->process(ROOT_DIR . 'data/privada/archivos/');
					if ($handle->processed) {
						$handle->clean();
					}
				}

				$arregloDatos = array($archivoDb, $_SESSION['login_id']);
				$sth = $this->_db->prepare("UPDATE proveedores SET ine_anverso = ? WHERE id = ?");
				if(!$sth->execute($arregloDatos)) throw New Exception();
			}

			if (!$_FILES['archivo_reverso']['size'] == 0) {
				$handle = new upload($_FILES['archivo_reverso']);
				if ($handle->uploaded) {
					$archivo = Modelos_Caracteres::caracteres_latinos($handle->file_src_name_body) . '-' . time();
					$handle->file_new_name_body   = $archivo;
					$archivoDb = $archivo . '.' . $handle->file_src_name_ext;
					$handle->process(ROOT_DIR . 'data/privada/archivos/');
					if ($handle->processed) {
						$handle->clean();
					}
				}

				$arregloDatos = array($archivoDb, $_SESSION['login_id']);
				$sth = $this->_db->prepare("UPDATE proveedores SET ine_reverso = ? WHERE id = ?");
				if(!$sth->execute($arregloDatos)) throw New Exception();
			}

			header('Location:' . STASIS . '/perfil/datos/ine/1');
		} catch (Exception $e) {
			echo Modelos_Sistema::status(0, $e->getMessage());
		}
	}

}