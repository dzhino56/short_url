<?php
require_once 'classes/DBUtils.php';
function print_edit_form($id, $pdo_result)
{
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