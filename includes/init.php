<?php
// vvv DO NOT MODIFY/REMOVE vvv

// check current php version to ensure it meets 2300's requirements
function check_php_version()
{
  if (version_compare(phpversion(), '7.0', '<')) {
    define(VERSION_MESSAGE, "PHP version 7.0 or higher is required for 2300. Make sure you have installed PHP 7 on your computer and have set the correct PHP path in VS Code.");
    echo VERSION_MESSAGE;
    throw VERSION_MESSAGE;
  }
}
check_php_version();

function config_php_errors()
{
  ini_set('display_startup_errors', 1);
  ini_set('display_errors', 0);
  error_reporting(E_ALL);
}
config_php_errors();

// open connection to database
function open_or_init_sqlite_db($db_filename, $init_sql_filename)
{
  if (!file_exists($db_filename)) {
    $db = new PDO('sqlite:' . $db_filename);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (file_exists($init_sql_filename)) {
      $db_init_sql = file_get_contents($init_sql_filename);
      try {
        $result = $db->exec($db_init_sql);
        if ($result) {
          return $db;
        }
      } catch (PDOException $exception) {
        // If we had an error, then the DB did not initialize properly,
        // so let's delete it!
        unlink($db_filename);
        throw $exception;
      }
    } else {
      unlink($db_filename);
    }
  } else {
    $db = new PDO('sqlite:' . $db_filename);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $db;
  }
  return null;
}

function exec_sql_query($db, $sql, $params = array())
{
  $query = $db->prepare($sql);
  if ($query and $query->execute($params)) {
    return $query;
  }
  return null;
}
// ^^^ DO NOT MODIFY/REMOVE ^^^

// You may place any of your code here.

//Source: Kyle Harms, lab-08/includes/init.php

$db = open_or_init_sqlite_db('secure/gallery.sqlite', 'secure/init.sql');

define('SESSION_COOKIE_DURATION', 60*60*2); //2 hours per session

if (isset($_POST['login']) && isset($_POST['username']) && isset($_POST['password'])) { // Check if the visitor attempted to log in
  $username = trim($_POST['username']);
  $password = trim($_POST['password']);

log_in($username, $password);
}
else { // Check if the visitor already has a session
  session_login();
}

function log_in($username, $password) {
  global $db;
  global $currentuser;

  if (isset($username) && isset($password)) {

  $sql = "SELECT * FROM visitors WHERE user_name = :username;"; // Look for the submitted username in our list of user_names
    $parameterz = array(
      ':username' => $username
    );

    $record = exec_sql_query($db, $sql, $parameterz)->fetchAll();
    if ($record) {                                             // Store username if it is valid
      $account = $record[0];

      if (password_verify($password, $account['password'])) {  // Validate password
        $session = session_create_id();

        $sql = "INSERT INTO sessions (user_id, session) VALUES (:user_id, :session);"; // Add a new session for the visitor to database
        $parameterz = array(
          ':user_id' => $account['id'],
          ':session' => $session
        );

        $result = exec_sql_query($db, $sql, $parameterz);
        if ($result) {
          setcookie('session', $session, time() + SESSION_COOKIE_DURATION); // Give the visitor a cookie

          $currentuser = $account;
          return $currentuser;
        }
      }
    }
  }
    $currentuser = NULL; // Login failed, so there is no current user
    return NULL;
}

function find_user($userid) {
  global $db;

  $sql = "SELECT * FROM visitors WHERE id = :userid;";
  $parameterz = array(
    ':userid' => $userid
  );

  $record = exec_sql_query($db, $sql, $parameterz)->fetchAll();
  if ($record) {
    return $record[0];
  }
  return NULL;
}

function find_session($session) {
 global $db;

  if (isset($session)) {
    $sql = "SELECT * FROM sessions WHERE session = :session;";
    $parameterz = array(
      ':session' => $session
    );

    $record = exec_sql_query($db, $sql, $parameterz)->fetchAll();
    if ($record) {
      return $record[0];
    }
  }
  return NULL;
}

function session_login() {
  global $db;
  global $currentuser;

  if (isset($_COOKIE['session'])) {
    $session = $_COOKIE['session'];

    $sessionrecord = find_session($session);
    if (isset($sessionrecord)) {
      $currentuser = find_user($sessionrecord['user_id']);

      setcookie('session', $session, time() + SESSION_COOKIE_DURATION);
      return $currentuser;
    }
  }
  $currentuser = NULL;
  return NULL;
}

function is_user_logged_in() {  // Check currentuser to find out if a visitor is logged in or not
  global $currentuser;

  return $currentuser != NULL;
}

function log_out() {
  global $currentuser;

  setcookie('session', '', time() - 60*15); // Expire the cookie
  $currentuser = NULL;
}

if (isset($currentuser) && (isset($_GET['logout']) || isset($_POST['logout']))) {
  log_out();
}

?>
