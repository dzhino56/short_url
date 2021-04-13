<?php
require_once 'DBUtils.php';

class TableHandler
{
    private $pdo;
    function __construct(){
        $dbUtils = new DBUtils();
        $this->pdo = $dbUtils->getPdo();
    }


    function edit()
    {
        $change_id = $_POST['change_id'];
        $field_name = $_POST['field_name'];
        $field_value = $_POST['field_value'];

        if (isset($change_id, $field_name, $field_value)) {
            echo $field_name;
            echo $field_value;
            echo $change_id;
            $result = $this->pdo->prepare("UPDATE links SET $field_name=:field_value WHERE id = :change_id");
            $result->execute(['field_value' => $field_value, 'change_id' => $change_id]);
        }
    header("Location: ../table.php");
    }

    function delete()
    {
        $ids_to_delete = array();
        foreach ($_POST['delete_ids'] as $selected) {
            $ids_to_delete[] = $selected;
        }

        $sql = "DELETE FROM links WHERE id IN (" . implode(',', array_map('intval', $ids_to_delete)) . ")";
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
    header("Location: ../table.php");
    }
}