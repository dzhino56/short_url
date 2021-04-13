<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Таблица</title>
    <link rel="stylesheet" href="css/table.css"
    <link href='https://fonts.googleapis.com/css?family=Rock+Salt' rel='stylesheet' type='text/css'>
</head>
<body>
<form action='catchers/tableCatcher.php' method='POST'>
    <table border=1>
        <thead>
            <tr>
                <?php
                require_once 'classes/DBUtils.php';
                $dbUtils = new DBUtils();
                $pdo = $dbUtils->getPdo();
                $pdo_result = $pdo->prepare("SELECT * FROM links");
                $pdo_result->execute();
                $name = 'name';
                for ($x = 0, $size = $pdo_result->columnCount(); $x < $size; $x++) {
                    $col = $pdo_result->getColumnMeta($x);
                    print "\t<th>$col[$name]</th>\n";
                }
                ?>
                <th>Исправить</th>
                <th>Удалить</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $rows = $pdo_result->fetchAll(PDO::FETCH_ASSOC);
            $id = 'id';
            foreach ($rows as $row) {
                print "<tr>\n";
                foreach ($row as $field) {
                    print "\t<td>$field</td>\n";
                }
                print "<td>\n";
                print "\t<p><label><input type='radio' name='change_id' value='$row[$id]'></label></p>\n";
                print "</td>\n";
                print "<td>\n";
                print "\t<p><label><input type='checkbox' name='delete_ids[]' value='$row[$id]'></label></p>\n";
                print "</td>\n";
                print "</tr>\n";
            } ?>
        </tbody>
    </table>
    <input type='submit' class="button" value='Выбрать'>
</form>
</body>
</html>