<?php
  require_once('../private/initialize.php');

  // Set default values for all variables the page needs.
  $hidden = "hidden";
  $errors = array();
  // if this is a POST request, process the form
  //if (isset($_POST['submit'])) {
  if (is_post_request()) {
    // Retrieve data
    $firstname = isset($_POST['firstname']) ? $_POST['firstname'] : '';
    $lastname = isset($_POST['lastname']) ? $_POST['lastname'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    // Perform Validations
    if (is_blank($firstname)) {
      array_push($errors, "First name cannot be blank");
    } elseif (!has_length($firstname, ['min' => 2, 'max' => 255])) {
      array_push($errors, "First name must be between 2 and 255 characters");
    } elseif (!is_valid_name($firstname)) {
      array_push($errors, "First name should only contain: letters, spaces and symbols(- , . ')");
    }
    if (is_blank($lastname)) {
      array_push($errors, "Last name cannot be blank");
    } elseif (!has_length($lastname, ['min' => 2, 'max' => 255])) {
      array_push($errors, "Last name must be between 2 and 255 characters");
    } elseif (!is_valid_name($lastname)) {
      array_push($errors, "Last name should only contain: letters, spaces and symbols(- , . ')");
    }
    if (is_blank($email)) {
      array_push($errors, "Email cannot be blank");
    } elseif (!has_length($email, ['max' => 255])) {
        array_push($errors, "Email must be less than 255 characters");
    } elseif (!has_valid_email_format($email)) {
      array_push($errors, "The email format is invalid");
    } elseif (!is_valid_email($email)) {
      array_push($errors, "Email should only contain: letters, numbers, symbols(_ @ .)");
    }
    if (is_blank($username)) {
      array_push($errors, "Username cannot be blank");
    } elseif (!has_length($username, ['min' => 8, 'max' => 255])) {
      array_push($errors, "First name must be between 2 and 255 characters");
    } elseif (!starts_with_alpha($username)) {
      array_push($errors, "The username needs to start with alphabet");
    } elseif (!is_valid_username($username)) {
      array_push($errors, "Username should only contain: letters, numbers, symbols(_)");
    }
    // React to the validations
    if (!empty($errors)) {
      $hidden = "";
    } else {
//      $sql = "SELECT COUNT(*) FROM globitek.USERS WHERE USERNAME = '$username';";
//      if (db_query($db, $sql) != 0) {
//        echo "<script>alter('Username already exists.')</script>";
//        exit;
//      }
      // if there were no errors, submit data to database
      $date = date("Y-m-d H:i:s");
      $sql = "INSERT INTO globitek.USERS (FIRSTNAME, LASTNAME, EMAIL, USERNAME, CREATE_AT) ";
      $sql .= "VALUES ('$firstname', '$lastname', '$email', '$username', '$date');";
      $result = db_query($db, $sql);
      if ($result) {
        db_close($db);
        redirect_to("registration_success.php");
      } else {
        echo db_error($db);
        db_close($db);
        exit;
      }
    }
  }
?>

<?php $page_title = 'Register'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="main-content">
  <h1>Register</h1>
  <p>Register to become a Globitek Partner.</p>

  <div <?php echo $hidden; ?>>
    <p>Please fix the following error(s): </p>
    <ul>
    <?php
      foreach ($errors as $err) {
        echo "<li class='error'>$err</li>";
      }
     ?>
    </ul>
  </div>

    <form id="form" action="register.php" method="post">
        First name:<br>
        <input class="input_box" type="text" name="firstname" value="<?php echo $firstname; ?>"><br>
        Last name:<br>
        <input class="input_box" type="text" name="lastname" value="<?php echo $lastname; ?>"><br>
        Email: <br>
        <input class="input_box" type="text" name="email" value="<?php echo $email; ?>"><br>
        Username: <br>
        <input class="input_box" type="text" name="username" value="<?php echo $username; ?>"><br><br>
        <input type="submit" name="submit" value="Submit">
    </form>

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
