<?php 
	namespace config\connect;
	use config\componentes\configSistema as configSistema;
	use \PDO;

	class connectDB extends configSistema{

		protected $conex;
		private $puerto;
		private $usuario;
		private $password;
		private $local;
		private $nameDB;

		public function __construct(){

			$this->usuario = parent::_USER_();
			$this->password = parent::_PASS_();
			$this->local = parent::_LOCAL_();
			$this->nameDB = parent::_BD_();
			$this->conectarDB();
		}

		protected function conectarDB(){
			try{
				$this->conex = new \PDO("mysql:host={$this->local};dbname={$this->nameDB}", $this->usuario , $this->password);
			}catch (PDOException $e) {
				print "¡Error!: " . $e->getMessage() . "<br/>";
				die();
			}
		}

		public function registrar_bitacora($id_usuario,$accion)
		{
			try {
				// Verificar si ya existe un registro en la tabla `historial` para el usuario
				$result = $this->conex->query("SELECT accion FROM historial WHERE id_usuario = '$id_usuario'");
				if ($result->rowCount() > 0) {
					// Si existe, concatenar la nueva acción con un `/`
					$row = $result->fetch();
					$nueva_accion = $accion . " / " . $row['accion'] ;
					$this->conex->query("UPDATE historial SET accion = '$nueva_accion' WHERE id_usuario = '$id_usuario'");
				} else {
					// Si no existe, insertar un nuevo registro en la tabla `historial`
					$this->conex->query("INSERT INTO historial(id_usuario, accion) VALUES('$id_usuario', '$accion')");
				}   
			} catch (Exception $e) {
				return false;
			}
		}
	
 }
