<?php

  // is_blank('abcd')
  function is_blank($value='') {
    return !isset($value) || trim($value) == '';
  }

  // has_length('abcd', ['min' => 3, 'max' => 5])
  function has_length($value, $options=array()) {
    $length = strlen($value);
    if(isset($options['max']) && ($length > $options['max'])) {
      return false;
    } elseif(isset($options['min']) && ($length < $options['min'])) {
      return false;
    } elseif(isset($options['exact']) && ($length != $options['exact'])) {
      return false;
    } else {
      return true;
    }
  }

  // has_valid_email_format('test@test.com')
  function has_valid_email_format($value) {
    $has_at_symbol = strpos($value, '@') !== false;
    $chars_match = preg_match('/\A[A-Za-z0-9_\-@\.]+\Z/', $value);
    return $has_at_symbol && $chars_match;
  }

  // has_valid_username_format('johnny_5')
  function has_valid_username_format($value) {
    return preg_match('/\A[A-Za-z0-9_]+\Z/', $value);
  }

  // has_valid_phone_format('(212) 555-6666')
  function has_valid_phone_format($value) {
    return preg_match('/\A[0-9\-\(\)]+\Z/', $value);
  }

  function is_valid_password($value){
    return preg_match('/[~!@#$%^&*+=]/', $value) && preg_match('/[A-Za-z0-9]/', $value);
  }

  // Works for both new records and existing records, just
  // add the current ID of an existing record as the second
  // argument.
  // New: is_unique_username('rockclimber67');
  // Existing: is_unique_username('rockclimber67', 31);
  function is_unique_username($username, $current_id=null) {
    $users_result = find_users_by_username($username);
    // Loop through all results, return false if username is in use
    while($user = db_fetch_assoc($users_result)) {
      // Make sure username isn't in use by our current user.
      // Use (int) to make sure we are comparing two integers.
      if((int) $user['id'] != (int) $current_id) {
        return false; // username is being used by someone else
      }
    }
    // Returns true at the end, but only if the loop had no records
    // to loop through or if the loop never returned false.
    return true;  // username is not used by anyone
  }

  function validate_password($password, $password_confirm, $errors=array()) {
    if (is_blank($password) || is_blank($password_confirm)) {
        array_push($errors, "Password field(s) cannot leave blank");
    } elseif (strcmp($password, $password_confirm) != 0) {
        array_push($errors, "Passwords do not match");
    } elseif (has_length($password, array('min' => 12))) {
        array_push($errors, "Password need to be at least 12 characters");
    } elseif (!is_valid_password($password)) {
        array_push($errors, "Password must contain at least one of each: uppercase letter, lowercase letter, number, symbol.");
    }
    return $errors;
  }

  function validate_input($values, $errors=array()) {
    $link = db_connect();
    foreach ($values as $value) {
      $value_clean = mysqli_real_escape_string($link, $value);
      if (strcmp($value, $value_clean) != 0) {
        array_push($errors, "SQL injection detected");
        break;
      }
    }
    mysqli_close($link);
    return $errors;
  }

  function validate_query($value) {
    $id = raw_u(strip_tags(rawurldecode($value)));
    return htmlEntities($id, ENT_QUOTES);
  }

?>
