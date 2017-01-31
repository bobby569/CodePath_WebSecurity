<?php
  require_once('../private/initialize.php');

  // Set default values for all variables the page needs.
  $hidden = "hidden";
  $errors = array();
  // if this is a POST request, process the form
  // Hint: private/functions.php can help

  // Confirm that POST values are present before accessing them.
  if (isset($_POST['submit'])) {
    $firstname = isset($_POST['firstname']) ? $_POST['firstname'] : '';
    $lastname = isset($_POST['lastname']) ? $_POST['lastname'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    // Perform Validations
    // Hint: Write these in private/validation_functions.php
    $errors = [];
    if (is_blank($firstname)) {
      $errors["err1"] = "First name cannot be blank.";
    } elseif (!has_length($firstname, ['min' => 2, 'max' => 20])) {
      $errors["err1"] = "First name must be between 2 and 20 characters.";
    }
    if (is_blank($lastname)) {
      $errors["err2"] = "Last name cannot be blank.";
    } elseif (!has_length($lastname, ['min' => 2, 'max' => 20])) {
      $errors["err2"] = "Last name must be between 2 and 20 characters.";
    }
    if (is_blank($email)) {
      $errors["err3"] = "Email cannot be blank.";
    } elseif (!has_valid_email_format($email)) {
      $errors["err3"] = "The email format does not seem right."
    }
    if (is_blank($username)) {
      $errors["err4"] = "First name cannot be blank.";
    } elseif (!has_length($username, ['min' => 2, 'max' => 20])) {
      $errors["err4"] = "First name must be between 2 and 20 characters.";
    } elseif (start_with_alpha($username)) {
      $errors["err4"] = "The username needs to start with alphabet."
    }
    if (!empty($error)) {
      $hidden = "";
    } else {
      // if there were no errors, submit data to database
      $sql = "";
      $result = db_query($db, $sql);
      if ($result) {
        db_close($db);
        // TODO redirect user to success page
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
    <ul>
    <?php
      foreach ($errors as $key => $value) {
        if (isset($key)) {
          echo "<li>$value</li>";
        }
      }
     ?>
   </ul>
  </div>

  <form action="register.php" method="post">
    First name:<br>
    <input type="text" name="firstname"><br>
    Last name:<br>
    <input type="text" name="lastname"><br>
    Email: <br>
    <input type="text" name="email"><br>
    Username: <br>
    <input type="text" name="username"><br>
    <input type="password" name="password"><br>
    <input type="submit" name="submit" value="Submit">
  </form>

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
