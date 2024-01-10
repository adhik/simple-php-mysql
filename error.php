<?php
session_start();
if (!$_SESSION['error']) {
    header('Location: index.php');
    die();
}

require_once 'templates/header.php';
?>
    <h1>Unknown Error</h1>
    <p>Sorry, something went wrong.</p>
    <code>
        <?= $_SESSION['error'] ?>
    </code>
<?php
$_SESSION['error'] = null;
require_once 'templates/footer.php';
