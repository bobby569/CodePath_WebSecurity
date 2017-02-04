<?php
    require_once('../private/initialize.php');
?>

<?php $page_title = 'Registration Success'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<?php
    if (is_post_request()) {
        redirect_to("register.php");
    }
 ?>

<div id="main-content">
    <h1>Registration Success</h1>
    <p>Your registration was submitted successfully.</p>
    <input type="submit" name="submit" value="Register another one">
</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
