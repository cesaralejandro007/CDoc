<?php 

	namespace config\componentes;

	define("_URL_", "http://localhost/dashboard/www/Control_de_Documentos/CDoc/");
	define("_BD_", "cdoc");
	define("_PASS_", "");
	define("_USER_", "root");
	define("_LOCAL_", "localhost");
	define("DIRECTORY_CONTROL", "bin/controlador/");
	define("DIRECTORY_MODEL", "bin/modelo/");
	define("DIRECTORY_VISTA", "vista/");
	define("MODEL", "Modelo.php");
	define("CONTROLADOR", "Controlador.php");
	define("VISTA", "Vista.php");
	date_default_timezone_set('America/Caracas');

	class configSistema{
		public function _int(){
			if(!file_exists("bin/controlador/frontControlador.php")){
				return "Error configSistema";
			}
		}

		public function _URL_(){
			return _URL_;
		}
		public function _BD_(){
			return _BD_;
		}
		public function _PASS_(){
			return _PASS_;
		}
		public function _USER_(){
			return _USER_;
		}
		public function _LOCAL_(){
			return _LOCAL_;
		}
		public function _Dir_Control_(){
			return DIRECTORY_CONTROL; 
		}
		public function _Dir_Model_(){
			return DIRECTORY_MODEL; 
		}
		public function _Dir_Vista_(){
			return DIRECTORY_VISTA; 
		}
		public function _MODEL_(){
			return MODEL;
		}
		public function _Control_(){
			return CONTROLADOR;
		}
		public function _VISTA_(){
			return VISTA;
		}

		public static function Seguridad($string, $accion = null)
		{
			// Advanced Encryption Standard cipher-block chaining
			$metodo        = "AES-256-CBC"; //El método de cifrado //clave simétrica de 256 bits
			$llave = openssl_digest("key", 'whirlpool', true); //genera un hash usando el método dado y devuelve codificada (512 bits)
			$iv    = substr(hash("whirlpool", $llave), 0, 16); // ciframos el vector de inicialización y acortamos con substr a 16

			if ($accion == 'codificar') {
				$salida = openssl_encrypt($string, $metodo, $llave, 0, $iv); // ciframos la direccion obtenida con el metodo openssl_encrypt
				$salida = base64_encode($salida); // ciframos la salida en bs64
			} else if ($accion == 'decodificar') {
				$string = base64_decode($string);
				$salida = openssl_decrypt($string, $metodo, $llave, 0, $iv);
			}
			return $salida;
			unset($metodo,$llave,$iv,$accion,$sting,$salida);
		}

		public static function _INICIO_() {
			return self::Seguridad('Login', 'codificar');
		}

		public static function _MLOGIN_() {
			echo self::Seguridad('Login', 'codificar');
		}

		public static function _SALIR_() {
			echo self::Seguridad('Login', 'codificar');
		}

		public static function _PRINCIPAL_() {
			echo self::Seguridad('Principal', 'codificar');
		}

		public static function _BitacoraSistema_() {
			echo self::Seguridad('BitacoraSistema', 'codificar');
		}

		public static function _Historial_() {
			echo self::Seguridad('Historial', 'codificar');
		}

		public static function _ConsultarUsuario_() {
			echo self::Seguridad('ConsultarUsuario', 'codificar');
		}

		public static function _ConsultarSecciones_() {
			echo self::Seguridad('Secciones', 'codificar');
		}
		
		public static function _DocumentosEntrada_() {
			echo self::Seguridad('DocumentosEntrada', 'codificar');
		}

		public static function _DocumentosSalida_() {
			echo self::Seguridad('DocumentosSalida', 'codificar');
		}

		public static function _DocumentosSinEntrada_() {
			echo self::Seguridad('DocumentosSinEntrada', 'codificar');
		}
		
		public static function _docSinEntrada_() {
			return self::Seguridad('DocumentosSinEntrada', 'codificar');
		}
		
		public static function _docSilida_() {
			return self::Seguridad('DocumentosSalida', 'codificar');
		}

		public static function _docEntrada_() {
			return self::Seguridad('DocumentosEntrada', 'codificar');
		}
	}

 ?>