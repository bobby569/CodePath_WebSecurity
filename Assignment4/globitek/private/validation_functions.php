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

  function is_valid_username($value) {
    return !preg_match('/[^A-Za-z0-9_]/', $value);
  }

  function starts_with_alpha($value) {
    return ctype_alpha(substr($value, 0, 1));
  }

  // has_valid_phone_format('(212) 555-6666')
  function has_valid_phone_format($value) {
    return preg_match('/\A[0-9\-\(\)]+\Z/', $value);
  }

  function validate_username($value, $errors=array()) {
    if (is_blank($value)) {
        array_push($errors, "Username cannot be blank");
    } elseif (!has_length($value, array('max' => 255))) {
        array_push($errors, "Username must be less than 255 characters");
    } elseif (!starts_with_alpha($value)) {
        array_push($errors, "The username needs to start with alphabet");
    } elseif (!is_valid_username($value)) {
        array_push($errors, "Username should only contain: letters, numbers, symbols(_)");
    }
    return $errors;
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
