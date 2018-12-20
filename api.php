<?php
require_once('config.php');
require_once('alphaID.inc.php');

$longURL = trim($_REQUEST['url']); // http://google.de
$returnFormat = trim($_REQUEST['format']); // json, plain
$callback = isset($_REQUEST['callback']) ? $_REQUEST['callback'] : null; // calback for json


$result = new stdClass();
$result->status = true;
$result->longurl = $longURL;

// Error Checking
if(empty($longURL)) {
  $result->status = false;
  $result->text = "No URL given";
  returnError($result, $returnFormat);
  exit;
}

if(!validURL($longURL)) {
  $result->status = false;
  $result->text = "Wrong URL Format: ".$longURL;
  returnError($result, $returnFormat);
  exit;
}


$shortID = createShortURL($longURL);
$result->shortid = $shortID;
$result->shorturl = BASE_HREF.$shortID;


returnData($result, $returnFormat);


/* = Functions
 * ==========================================================*/

/**
* Get ShortURL ID
* @param {String} A Long URL to shorten
* @return {String}   Returns a string value containing the row id converted with alphaID function
*/
function createShortURL($longURL) {
  $id = checkURL($longURL);
  if(!$id){
    global $pdo;
    try {
      $stmt = $pdo->prepare('INSERT INTO urlshort (longurl) VALUES (?)');
      $stmt->execute([$longURL]);
      $id = $pdo->lastInsertId();
    } catch (\PDOException $e) {
      throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }
  }
  $newShortID = alphaID($id);
  return $newShortID;
}

/**
* Output handling
* @param {Object} A Object containing data
* @param {String} Output Format plain or json
*/
function returnData($result, $returnFormat) {
  global $callback;
  if($returnFormat == "json"){
    if(!empty($callback)){
      echo $callback."(".json_encode($result).")";
    }else{
      echo json_encode($result);
    }
  }else{
    echo $result->shorturl;
  }
}

/**
* Error Output handling
* @param {Object} A Object containing data
* @param {String} Output Format plain or json
*/
function returnError($error, $returnFormat) {
  global $callback;
  if($returnFormat == "json"){
    if(!empty($callback)){
      echo $callback."(".json_encode($error).")";
    }else{
      echo json_encode($error);
    }
  }else{
    echo $error->text;
  }
}

/**
* Check URL for existing ShortURL
* @param {String} A Long URL to shorten
* @return {String|Bool} Returns a ID > 0 if a ShortURL exists or false if no ShortURL exists
*/
function checkURL($longURL) {
  global $pdo;
  try {
    $stmt = $pdo->prepare('SELECT id FROM urlshort WHERE longurl = ? LIMIT 1 OFFSET 0');
    $stmt->execute([$longURL]);
    $result = $stmt->fetch();
  } catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
  }

  if($result['id']) {
    return $result['id'];
  } else {
    return false;
  }
}

/**
* Check for valid URL
* @param {String} A Long URL to shorten
* @return {Bool} Returns true if LongURL is valid
*/
function validURL($url) {
  return filter_var($url, FILTER_VALIDATE_URL);
}
