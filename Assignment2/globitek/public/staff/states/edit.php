<?php
require_once('../../../private/initialize.php');

if(!isset($_GET['id'])) {
  redirect_to('index.php');
}
$id = validate_query($_GET['id']);
$states_result = find_state_by_id($id);
// No loop, only one result
$state = db_fetch_assoc($states_result);

// Set default values for all variables the page needs.
$errors = array();

if(is_post_request()) {
    // Confirm that values are present before accessing them.
    if(isset($_POST['name'])) {
        $state['name'] = strip_tags($_POST['name']);
    }
    if(isset($_POST['code'])) {
        $state['code'] = strip_tags($_POST['code']);
    }
    if(isset($_POST['country_id'])) {
        $state['country_id'] = strip_tags($_POST['country_id']);
    }

    $result = update_state($state);
    if($result === true) {
        redirect_to('show.php?id=' . $state['id']);
    } else {
        $errors = $result;
    }
}
?>
<?php $page_title = 'Staff: Edit State ' . $state['name']; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="main-content">
  <a href="show.php?id=<?php echo $state['id'] ?>">Back to States List</a><br />

  <h1>Edit State: <?php echo $state['name']; ?></h1>

    <?php echo display_errors($errors); ?>

    <form action="edit.php?id=<?php echo $state['id']; ?>" method="post">
        Name:<br />
        <input type="text" name="name" value="<?php echo $state['name']; ?>" /><br />
        Code:<br />
        <input type="text" name="code" value="<?php echo $state['code']; ?>" /><br />
        Country id:<br />
        <select name="country_id">
            <option value="0">Select</option>
            <option value="1" <?php echo ($state['country_id'] == "1")?'selected="selected"':''; ?>>1 - USA</option>
            <option value="2" <?php echo ($state['country_id'] == "2")?'selected="selected"':''; ?>>2 - UK</option>
            <option value="3" <?php echo ($state['country_id'] == "3")?'selected="selected"':''; ?>>3 - Others</option>
        </select>
        <br /><br />
        <input type="submit" name="submit" value="Update"  />
    </form>

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
