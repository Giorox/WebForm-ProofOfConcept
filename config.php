<?php
ini_set( "display_errors", true );
date_default_timezone_set( "America/Sao_Paulo" );  // http://www.php.net/manual/en/timezones.php
define( "DB_DSN", "mysql:host=localhost;dbname=form_pofc" );
define( "DB_USERNAME", "root" );
define( "DB_PASSWORD", "" );
define( "CLASS_PATH", "classes" );
define( "TEMPLATE_PATH", "templates" );
define( "ADMIN_USERNAME", "giramundo" );
define( "ADMIN_PASSWORD", "paibenedito2017" );
require( CLASS_PATH . "/Answer.php" );

setlocale(LC_ALL, 'portuguese-brazilian', 'ptb');

function handleException( Throwable $t ) {
echo "Oops! Tivemos um problema. Tente Novamente mais tarde." . $t;
error_log( $t->getMessage() );
}

set_exception_handler( 'handleException' );
?>
