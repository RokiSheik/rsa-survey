<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header("Location: login.php");
    exit();
}
require_once '../config.php';
$id = $_GET['id'] ?? 0;
$conn = get_conn();
$stmt = $conn->prepare("DELETE FROM submissions WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();
$conn->close();
header("Location: submissions.php");
exit();
?>
