<?php
  require_once('../private/initialize.php');

  // Set default values for all variables the page needs.
  $hidden = "hidden";
  $errors = array();
  // if this is a POST request, process the form
  // Hint: private/functions.php can help

  // Confirm that POST values are present before accessing them.
  //if (isset($_POST['submit'])) {
  if (is_post_request()) {
    $firstname = isset($_POST['firstname']) ? $_POST['firstname'] : '';
    $lastname = isset($_POST['lastname']) ? $_POST['lastname'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    // Perform Validations
    // Hint: Write these in private/validation_functions.php
    if (is_blank($firstname)) {
      array_push($errors, "First name cannot be blank");
    } elseif (!has_length($firstname, ['min' => 2, 'max' => 20])) {
      array_push($errors, "First name must be between 2 and 20 characters");
    }
    if (is_blank($lastname)) {
      array_push($errors, "Last name cannot be blank");
    } elseif (!has_length($lastname, ['min' => 2, 'max' => 20])) {
      array_push($errors, "Last name must be between 2 and 20 characters");
    }
    if (is_blank($email)) {
      array_push($errors, "Email cannot be blank");
    } elseif (!has_valid_email_format($email)) {
      array_push($errors, "The email format does not seem right");
    }
    if (is_blank($username)) {
      array_push($errors, "First name cannot be blank");
    } elseif (!has_length($username, ['min' => 2, 'max' => 20])) {
      array_push($errors, "First name must be between 2 and 20 characters");
    } elseif (!starts_with_alpha($username)) {
      array_push($errors, "The username needs to start with alphabet");
    }
    if (is_blank($password)) {
      array_push($errors, "The password cannot be empty");
    }
    if (!empty($errors)) {
      $hidden = "";
    } else {
      // if there were no errors, submit data to database
      $sql = "";
      $result = db_query($db, $sql);
      if ($result) {
        db_close($db);
        // TODO redirect user to success page
//        header("Location: ./registration_success.php");
//        exit;
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

  <form id="form" action="register.php" method="post" style="font-family: cursive">
    First name:<br>
    <input class="input_box" type="text" name="firstname" value="<?php echo $_POST['firstname']; ?>"><br>
    Last name:<br>
    <input class="input_box" type="text" name="lastname" value="<?php echo $_POST['lastname']; ?>"><br>
    Email: <br>
    <input class="input_box" type="text" name="email" value="<?php echo $_POST['email']; ?>"><br>
    Username: <br>
    <input class="input_box" type="text" name="username" value="<?php echo $_POST['username']; ?>"><br>
    Password: <br>
    <input class="input_box" type="password" name="password"><br><br>
    <input type="submit" name="submit" value="Submit">
  </form>

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
