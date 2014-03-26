<?php
$spaces = json_decode(file_get_contents('spaces.json'));
$spaces = $spaces->spaces;
$row_count = count($spaces);

echo "┌" . str_repeat("----┬", $row_count) . "----┐" . "\n";
echo "|" . str_repeat("    |", $row_count) . "    |". "\n";
echo "|" . str_repeat("    |", $row_count) . "    |"."\n" ;
echo "|" . str_repeat("    |", $row_count) . "    |"."\n";
echo "├" . '----+' . str_repeat("----┴", $row_count-2) . '----+----┤' . "\n";

foreach(range(1, $row_count - 2) as $index) {
if($index != 1) {
echo "├----┤" . str_repeat(" ", ($row_count-2)*5) . "    ├----┤". "\n";
}

echo "|    |" . str_repeat(" ", ($row_count-2)*5) . "    |    |". "\n";
//echo $index .':'. $row_count / 2;
if ($index == floor($row_count/2)) {

echo "|    |" .   "                       MONOPOLY              "         ."    |    |". "\n";
} else {
echo "|    |" . str_repeat(" ", ($row_count-2)*5) . "    |    |". "\n";
}
echo "|    |" . str_repeat(" ", ($row_count-2)*5) . "    |    |". "\n";
}

echo "├----+" . str_repeat("----┬", $row_count - 2) . "----+----┤" . "\n";
echo "|" . str_repeat("    |", $row_count) . "    |". "\n";
echo "|" . str_repeat("    |", $row_count) . "    |"."\n" ;
echo "|" . str_repeat("    |", $row_count) . "    |"."\n";
echo "└" . '----+' . str_repeat("----┴", $row_count-2) . '----+----┘' . "\n";


/*foreach ($spaces as $index => $space) {

    if ($index == 0) {
        echo 'first';
        print_r($space);
    } else if ($index == ($row_count - 1)) {
        echo 'last';
        print_r($space);
    } else {
        print_r($space);
    }
} 
*/
//print_r($spaces);//
/*
+---------------------------------------------------------------+
| FP | IL |    |    |     |   |   |   |    |     |   |    | J |
|    |$200|    |    |     |   |   |   |    |     |   |    |   |
+----+----┴----┴----┴--┴--┴--┴--┴--┴--┴--┴--┴--┴--┴--┴--┴
*/
