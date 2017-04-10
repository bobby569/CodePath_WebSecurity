<?php

  function h($string="") {
    return htmlspecialchars($string);
  }

  function u($string="") {
    return urlencode($string);
  }

  function raw_u($string="") {
    return rawurlencode($string);
  }

  function redirect_to($location) {
    header("Location: " . $location);
    exit;
  }

  function url_for($script_path) {
    return DOC_ROOT . $script_path;
  }

  function is_post_request() {
    return $_SERVER['REQUEST_METHOD'] == 'POST';
  }

  function is_get_request() {
    return $_SERVER['REQUEST_METHOD'] == 'GET';
  }

  function request_is_same_domain() {
    if(!isset($_SERVER['HTTP_REFERER'])) { return false; }
    $referer_host = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
    $actual_host = parse_url($_SERVER['HTTP_HOST'], PHP_URL_HOST);
    return ($referer_host === $actual_host);
  }

  function display_errors($errors=array()) {
    $output = '';
    if (!empty($errors)) {
      $output .= "<div class=\"errors\">";
      $output .= "Please fix the following errors:";
      $output .= "<ul>";
      foreach ($errors as $error) {
        $output .= "<li>{$error}</li>";
      }
      $output .= "</ul>";
      $output .= "</div>";
    }
    return $output;
  }

  function record_failed_login($username) {
    // The failure technically already happened, so
    // get the time ASAP.
    $sql_date = date("Y-m-d H:i:s");

    $fl_result = find_failed_login($username);
    $failed_login = db_fetch_assoc($fl_result);

    if(!$failed_login) {
      $failed_login = [
        'username' => $username,
        'count' => 1,
        'last_attempt' => $sql_date
      ];
      insert_failed_login($failed_login);
    } else {
      $failed_login['count'] = $failed_login['count'] + 1;
      $failed_login['last_attempt'] = $sql_date;
      update_failed_login($failed_login);
    }
    return true;
  }

  // Deal with login
  function update_login($username, $success, $errors=array()) {
    $sql_date = date("Y-m-d H:i:s");
    $fl_result = find_login($username);
    // No loop is needed
    $login = db_fetch_assoc($fl_result);

    if ($success) {
      if (isset($login)) {
        remove_failed_login($username);
      }
      return $errors;
    } else {
      if (!isset($login)) {
        $login = [
          'username' => $username,
          'count' => 1,
          'last_attempt' => $sql_date
        ];
        insert_failed_login($login);
      } else {
        $login['count'] = intval($login['count']) + 1;
        if ($login['count'] < 5) {
          $login['last_attempt'] = $sql_date;
          update_failed_login($login);
        } else {
          $time_remaining = get_time_remain($login['username']);
          if ($time_remaining < 0) {
            $login['count'] = 0;
            $login['last_attempt'] = $sql_date;
            update_failed_login($login);
          } else {
            $time_in_minute = ceil($time_remaining / 60);
            array_push($errors, "Too many failed logins. Try again after " . $time_in_minute . " minute(s)");
          }
        }
      }
    }
    return $errors;
  }

?>
