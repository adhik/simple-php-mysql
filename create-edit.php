<?php
require_once 'includes/db.php';
require_once 'templates/header.php';
global $PDO;
session_start();
$id         = $_GET['id'];
$isEditMode = false;
$title      = 'Add new person';
$person     = [];

if ( intval( $id ) ) {
	try {
		$query     = 'SELECT * FROM persons WHERE id = :id LIMIT 1';
		$statement = $PDO->prepare( $query );
		$statement->execute( array(
			"id" => $id
		) );

		$person     = $statement->fetch( PDO::FETCH_ASSOC );
		$isEditMode = true;
		$title      = 'Edit person';
	} catch ( PDOException $e ) {
		echo 'Query error: ' . $e->getMessage();
		die();
	}
}

?>
    <h1><?= $title ?></h1>

    <!-- error messages if any -->
<?php if ( $_SESSION['error'] ): ?>
    <div class="alert alert-danger" role="alert">
		<?= $_SESSION['error'] ?>
    </div>
<?php endif; ?>

    <form action="includes/create-edit-action.php" method="post">
        <!-- this is needed to determine ADD or EDIT mode -->
        <input type="hidden" name="id" value="<?= $id ?>"/>

        <div class="row">
            <div class="col-12">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input
                            type="text"
                            class="form-control"
                            id="name"
                            name="name"
                            maxlength="50"
                            required="required"
                            value="<?= $person['name'] ?? '' ?>"
                    />
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="/index.php" class="btn btn-secondary">Cancel</a>
            </div>
        </div>
    </form>

<?php
// cleanups
$_SESSION['error'] = null;
$_SESSION['info']  = null;

require_once 'templates/footer.php';