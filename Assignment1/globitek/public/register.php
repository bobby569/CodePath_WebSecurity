<?php
  require_once('../private/initialize.php');

  // Set default values for all variables the page needs.
  $hidden = "hidden";
  $errors = array("err1" => "", "err2" => "", "err3" => "", "err4" => "");
  $options = array("max" => 16, "min" => "8");
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
    if (is_blank($_POST['first_name'])) {
      $errors[] = "First name cannot be blank.";
    } elseif (!has_length($_POST['first_name'], ['min' => 2, 'max' => 20])) {
      $errors[] = "First name must be between 2 and 20 characters.";
    }
    if (is_blank($_POST['last_name'])) {
      $errors[] = "Last name cannot be blank.";
    } elseif (!has_length($_POST['last_name'], ['min' => 2, 'max' => 30])) {
      $errors[] = "Last name must be between 2 and 30 characters.";
    }

  }








    // if there were no errors, submit data to database

      // Write SQL INSERT statement
      // $sql = "";

      // For INSERT statments, $result is just true/false
      // $result = db_query($db, $sql);
      // if($result) {
      //   db_close($db);

      //   TODO redirect user to success page

      // } else {
      //   // The SQL INSERT statement failed.
      //   // Just show the error, not the form
      //   echo db_error($db);
      //   db_close($db);
      //   exit;
      // }

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


  <?php
    // TODO: display any form errors here
    // Hint: private/functions.php can help
  ?>

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
