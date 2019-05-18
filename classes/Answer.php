<?php

/**
 * Class to handle Answers
 */

class Answer
{
  // Properties

  /**
  * @var int The Answer ID from the database
  */
  public $id = null;

  /**
  * @var int When the Answer was first published
  */
  public $answerDate = null;

  /**
  * @var string Full name of the Answer
  */
  public $name = null;

  /**
  * @var string A short summary of the Answer
  */
  public $summary = null;

  /**
  * @var string The HTML content of the Answer
  */
  public $content = null;


  /**
  * Sets the object's properties using the values in the supplied array
  *
  * @param assoc The property values
  */

  public function __construct( $data=array() ) {
    if ( isset( $data['id'] ) ) $this->id = (int) $data['id'];
    if ( isset( $data['answerDate'] ) ) $this->answerDate = (int) $data['answerDate'];
    if ( isset( $data['name'] ) ) $this->name = preg_replace ( "/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()áéíóúãõçàâêîôûÁÉÍÓÚÂÊÎÔÛÃÕÇËÄÏÖÜ]/", "", $data['name'] );
    if ( isset( $data['summary'] ) ) $this->summary = $data['summary'];
    if ( isset( $data['content'] ) ) $this->content = $data['content'];
  }


  /**
  * Sets the object's properties using the edit form post values in the supplied array
  *
  * @param assoc The form post values
  */

  public function storeFormValues ( $params ) {

    // Store all the parameters
    $this->__construct( $params );

    // Parse and store the publication date
    if ( isset($params['answerDate']) ) {
      $answerDate = explode ( '-', $params['answerDate'] );

      if ( count($answerDate) == 3 ) {
        list ( $y, $m, $d ) = $answerDate;
        $this->answerDate = mktime ( 0, 0, 0, $m, $d+1, $y );
      }
    }
  }

  /**
  * Returns an Answer object matching the given Answer ID
  *
  * @param int The Answer ID
  * @return Answer|false The Answer object, or false if the record was not found or there was a problem
  */

  public static function getById( $id ) {
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $sql = "SELECT *, UNIX_TIMESTAMP(answerDate) AS answerDate FROM responses WHERE id = :id";
    $st = $conn->prepare( $sql );
    $st->bindValue( ":id", $id, PDO::PARAM_INT );
    $st->execute();
    $row = $st->fetch();
    $conn = null;
    if ( $row ) return new Article( $row );
  }


  /**
  * Returns all (or a range of) Answer objects in the DB
  *
  * @param int Optional The number of rows to return (default=all)
  * @param string Optional column by which to order the answers (default="answerDate DESC")
  * @return Array|false A two-element array : results => array, a list of Answer objects; totalRows => Total number of answers
  */

public static function getList( $numRows=1000000, $order="answerDate DESC" ) {

 $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);

 //Your whitlelist of order bys.
 $order_whitelist = array("answerDate DESC", "id DESC");

 // see if we have such a name, if it is not in the array then $order will be false.
        $order_check = array_search($order, $order_whitelist); 
    if ($order_check !== FALSE)
     {

     $sql = "SELECT SQL_CALC_FOUND_ROWS *, UNIX_TIMESTAMP(answerDate) AS answerDate FROM responses
        ORDER BY " . $order . " LIMIT :numRows";
     $st = $conn->prepare($sql);
     $st->bindValue(":numRows", $numRows, PDO::PARAM_INT);
     $st->execute();
     $list = array();

     while ($row = $st->fetch())
         {
         $answer = new Answer($row);
         $list[] = $answer;
         }
     }

    // Now get the total number of answers that matched the criteria
    $sql = "SELECT FOUND_ROWS() AS totalRows";
    $totalRows = $conn->query( $sql )->fetch();
    $conn = null;
    return ( array ( "results" => $list, "totalRows" => $totalRows[0] ) );
  }


  /**
  * Inserts the current Answer object into the database, and sets its ID property.
  */

  public function insert() {

    // Does the Answer object already have an ID?
    if ( !is_null( $this->id ) ) trigger_error ( "Answer::insert(): Attempt to insert an Answer object that already has its ID property set (to $this->id).", E_USER_ERROR );

    // Insert the Answer
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $sql = "INSERT INTO responses ( answerDate, name, summary, content, imageExtension, tagString ) VALUES ( FROM_UNIXTIME(:answerDate), :name, :summary, :content )";
    $st = $conn->prepare ( $sql );
    $st->bindValue( ":answerDate", $this->answerDate, PDO::PARAM_INT );
    $st->bindValue( ":name", $this->name, PDO::PARAM_STR );
    $st->bindValue( ":summary", $this->summary, PDO::PARAM_STR );
    $st->bindValue( ":content", $this->content, PDO::PARAM_STR );
    $st->execute();
    $this->id = $conn->lastInsertId();
    $conn = null;
  }


  /**
  * Updates the current Answer object in the database.
  */

  public function update() {

    // Does the Answer object have an ID?
    if ( is_null( $this->id ) ) trigger_error ( "Answer::update(): Attempt to update an Answer object that does not have its ID property set.", E_USER_ERROR );
   
    // Update the Answer
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $sql = "UPDATE responses SET answerDate=FROM_UNIXTIME(:answerDate), name=:name, summary=:summary, content=:content WHERE id = :id";
    $st = $conn->prepare ( $sql );
    $st->bindValue( ":answerDate", $this->answerDate, PDO::PARAM_INT );
    $st->bindValue( ":name", $this->name, PDO::PARAM_STR );
    $st->bindValue( ":summary", $this->summary, PDO::PARAM_STR );
    $st->bindValue( ":content", $this->content, PDO::PARAM_STR );
    $st->bindValue( ":id", $this->id, PDO::PARAM_INT );
    $st->execute();
    $conn = null;
  }


  /**
  * Deletes the current Answer object from the database.
  */

  public function delete() {

    // Does the Answer object have an ID?
    if ( is_null( $this->id ) ) trigger_error ( "Answer::delete(): Attempt to delete an Answer object that does not have its ID property set.", E_USER_ERROR );

    // Delete the Answer
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $st = $conn->prepare ( "DELETE FROM responses WHERE id = :id LIMIT 1" );
    $st->bindValue( ":id", $this->id, PDO::PARAM_INT );
    $st->execute();
    $conn = null;
  }

}

?>
