<?php
require_once 'db.php';
global $PDO;
session_start();

$id = $_GET['id'];
if (intval($id)) {
	// we should get the person data first, make sure it is in db or not, before actually deleting them
	$query     = 'SELECT * FROM persons WHERE id = :id LIMIT 1';
	$statement = $PDO->prepare( $query );
	$statement->execute( array(
		"id" => $id
	) );

	if ($statement->rowCount() == 1) {
		$person = $statement->fetch(PDO::FETCH_ASSOC);

		$query     = 'DELETE FROM persons WHERE id = :id';
		$statement = $PDO->prepare( $query );
		$statement->execute( array(
			"id"   => $id
		) );
		$_SESSION['info'] = '"' . $person['name'] . '" data has been deleted.';
	} else {
		$_SESSION['error'] = 'Person data with given ID was not found!';
	}
}

header('Location: ../index.php');
die();