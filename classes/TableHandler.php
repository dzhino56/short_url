<?php
require_once 'DBUtils.php';

class TableHandler
{
    private $pdo;
    function __construct(){
        $dbUtils = new DBUtils();
        $this->pdo = $dbUtils->getPdo();
    }
    function print_edit_form()
    {
        $id = $_POST['change_id'];
        if (isset($id)) {
            $pdo_result = $this->pdo->prepare("SELECT * FROM links WHERE id = :id");
            $pdo_result->execute(['id' => $id]);

            if (!$pdo_result) {
                return ($this->pdo->errorInfo());
            }
            $PHP_SELF = $_SERVER['PHP_SELF'];

            print "<form action='$PHP_SELF' method='POST'>\n<label>\n<select  name='field_name' >\n";
            $name = 'name';
            for ($x = 0, $size = $pdo_result->columnCount(); $x < $size; $x++) {
                $col = $pdo_result->getColumnMeta($x);
                if ($col['name'] != 'id') {
                    print "\t<option value=$col[$name]>$col[$name]</option>\n";
                }
            }


            print "</label>\n</select>\n";
            print "\t<p>Введите новое значение <label><input type='text' name='field_value'></label></p>\n";
            print "<p><label><input type='submit' value='Заменить'></label></p>\n";
            print "<label><input type=hidden name='change_id' value='$id'></label>\n";
            print "</form>\n";
        }
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