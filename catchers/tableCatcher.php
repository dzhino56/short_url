<html lang="ru">
<head>
    <meta charset="utf-8">
    <title> Таблица </title>
</head>
<body>
<?php

require_once '../classes/TableHandler.php';
require_once '../editForm.php';
require_once '../classes/DBUtils.php';


$dbUtils = new DBUtils();
$pdo = $dbUtils->getPdo();
$tableHandler = new TableHandler();

if (isset($_POST['change_id'])) {
    $id = $_POST['change_id'];
    if (isset($id)) {
        $pdo_result = $pdo->prepare("SELECT * FROM links WHERE id = :id");
        $pdo_result->execute(['id' => $id]);
        if (!$pdo_result) {
            return ($pdo->errorInfo());
        }
        print_edit_form($id, $pdo_result);
    }
    if (isset($_POST['field_name']) and isset($_POST['field_value'])) {
        $tableHandler->edit();
    }
}

if (isset($_POST['delete_ids'])) {
    $tableHandler->delete();
}

?>

</body>
</html>