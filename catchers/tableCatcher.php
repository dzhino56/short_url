<html lang="ru">
<head>
    <meta charset="utf-8">
    <title> Таблица </title>
</head>
<body>
<?php

require_once '../classes/TableHandler.php';

$tableHandler = new TableHandler();
if (isset($_POST['change_id'])) {
    $tableHandler->print_edit_form();
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