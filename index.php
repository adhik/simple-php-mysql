<?php
require_once 'includes/db.php';
require_once 'templates/header.php';
global $PDO;
session_start();

try {
	$query     = 'SELECT * FROM persons ORDER BY id DESC';
	$statement = $PDO->prepare( $query );
	$statement->execute();
} catch ( PDOException $e ) {
	echo 'Query error: ' . $e->getMessage();
	die();
}
if ( $_SESSION['info'] ): ?>
    <div class="alert alert-success" role="alert">
		<?= $_SESSION['info'] ?>
    </div>
<?php endif; ?>

    <h1>Persons Data</h1>
    <a href="/create-edit.php" class="btn btn-primary mb-3">Add person</a>

<?php if ( $statement->rowCount() <= 0 ): ?>
    <p>No data</p>
<?php
else: ?>
    <table class="table table-hover">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
		<?php while ( $row = $statement->fetch( PDO::FETCH_ASSOC ) ): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['name'] ?></td>
                <td>
                    <a href="/create-edit.php?id=<?= $row['id'] ?>" class="btn btn-outline-secondary">Edit</a>
                    <button type="button"
                            class="btn btn-outline-secondary"
                            data-bs-toggle="modal"
                            data-bs-target="#delete-modal-<?= $row['id'] ?>">
                        Delete
                    </button>

                    <!-- Delete modal -->
                    <div id="delete-modal-<?= $row['id'] ?>" class="modal fade" tabindex="-1"
                         aria-labelledby="delete-modal"
                         aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Delete person</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure to delete "<?= $row['name'] ?>"?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button"
                                            class="btn btn-secondary"
                                            data-bs-dismiss="modal"
                                    >
                                        No
                                    </button>
                                    <button type="button"
                                            class="btn btn-primary"
                                            onclick="location.href='/includes/delete-action.php?id='+<?= $row['id'] ?>">
                                        Yes
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
		<?php endwhile; ?>
        </tbody>
    </table>

<?php endif;
// cleanups
$_SESSION['error'] = null;
$_SESSION['info']  = null;
require_once 'templates/footer.php';