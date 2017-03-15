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

  // Deal with login
  function update_login($username, $success, $errors=array()) {
    $sql_date = date("Y-m-d H:i:s");
    $fl_result = find_login($username);
    $login = db_fetch_assoc($fl_result);

    if ($success) {
      if ($login) {
        remove_failed_login($username);
      }
      return $errors;
    } else {
      if (!$login) {
        $login = [
          'username' => $username,
          'count' => 1,
          'last_attempt' => $sql_date
        ];
        insert_failed_login($login);
        array_push($errors, "Login fails");
      } else {
        $login['count'] = $login['count'] + 1;
        $login['last_attempt'] = $sql_date;
        update_failed_login($login);
        $time_remain = check_time_remain($login);
        if ($login['count'] < 5) {
          array_push($errors, "Login fails");
        } else {
          if ($time_remain == 0) {
            $login['count'] = 0;
            array_push($errors, "Login fails");
          } else {
            array_push($errors, "Too many failed logins for this username. Please try again after " . $time_remain . "minutes");
          }
        }
      }
    }
    return $errors;
  }

  // Start of my hashing function


  // End of my hashing function
?>
