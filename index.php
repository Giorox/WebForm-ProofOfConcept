<?php

require( "config.php" );
$action = isset( $_GET['action'] ) ? $_GET['action'] : "";

switch ( $action ) {
  case 'postAnswer':
    postAnswer();
    break;
  default:
    homepage();
}

function homepage() {  
  $results = array();
  $results['pageTitle'] = "Lessons Learned Form";

  require( TEMPLATE_PATH . "/form.php" );
}

function postAnswer() {

  $results = array();
  $results['formAction'] = "postAnswer";
  $results['pageTitle'] = "Lessons Learned Form";

  if ( isset( $_POST['saveChanges'] ) ) {

    // User has posted the form: save the new answer
    $answer = new Answer;
    $answer->storeFormValues( $_POST );
    $answer->insert();
    require( TEMPLATE_PATH . "/afterform.php" );

  } else {

    // User has not posted the form yet: display the form
    $results['answer'] = new Answer;
    require( TEMPLATE_PATH . "/form.php" );
  }

}

?>
