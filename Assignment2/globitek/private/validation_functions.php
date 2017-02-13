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

  function has_valid_email_format($value) {
    return filter_var($value, FILTER_VALIDATE_EMAIL);
  }

  function starts_with_alpha($value) {
    return ctype_alpha(substr($value, 0, 1));
  }

  function is_valid_name($value) {
    return !preg_match('/[^a-z-,. \']/i', $value);
  }

  function is_valid_email($value) {
    return !preg_match('/[^a-z0-9@._-]/', $value);
  }

  function is_valid_username($value) {
    return !preg_match('/[^a-z0-9_]/', $value);
  }

  function is_valid_phone($value) {
    return !preg_match('/[^0-9()-]/', $value);
  }

  function validate_name($value, $name, $errors=array()) {
    if (is_blank($value)) {
      array_push($errors, "($name) name cannot be empty.");
    } else if (!has_length($value, ['max' => 255])) {
      array_push($errors, "($name) name must be less than 255 characters");
    } elseif (!is_valid_name($value)) {
      array_push($errors, "($name) name should only contain: letters, spaces and symbols(- , . ')");
    }
  }

  function validate_username($value, $errors=array()) {
    if (is_blank($value)) {
      array_push($errors, "Username cannot be blank");
    } elseif (!has_length($value, ['max' => 255])) {
      array_push($errors, "Username must be between 8 and 255 characters");
    } elseif (!starts_with_alpha($value)) {
      array_push($errors, "The username needs to start with alphabet");
    } elseif (!is_valid_username($value)) {
      array_push($errors, "Username should only contain: letters, numbers, symbols(_)");
    }
  }

  function validate_email($value, $errors=array()) {
    if (is_blank($value)) {
      array_push($errors, "Email cannot be blank");
    } elseif (!has_length($value, ['max' => 255])) {
      array_push($errors, "Email must be less than 255 characters");
    } elseif (!has_valid_email_format($value)) {
      array_push($errors, "The email format is invalid");
    } elseif (!is_valid_email($value)) {
      array_push($errors, "Email should only contain: letters, numbers, symbols(_ @ .)");
    }
  }

  function validate_phone($value, $errors=array()) {
    if (is_blank($value)) {
      array_push($errors, "Phone cannot be empty");
    } else if (!has_length($value, ['min' => 7, 'max' => 15])) {
      array_push($errors, "Phone number must be of length between 7 and 15");
    } else if (!is_valid_phone($value)) {
      array_push($error, "Phone number should only contain: numbers, symbols(- ( ))");
    }
  }


?>
