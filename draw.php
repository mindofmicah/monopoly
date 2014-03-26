<?php
if (array_key_exists('WINDIR', $_SERVER)) {
    $pipes = createWindowsPipes();
} else {
    $pipes = createSpecialPipes();
} 

//header('content-type:text/html; charset=UTF-8');
$spaces = json_decode(file_get_contents('spaces.json'));
$spaces = $spaces->spaces;
$row_count = count($spaces);

echo $pipes['topleft'] . str_repeat($pipes['line'].$pipes['line']. $pipes['line'] . $pipes['line'] . $pipes['down'], $row_count) . $pipes['line'] .$pipes['line'] . $pipes['line'] . $pipes['line'] . $pipes['topright'] . "\n";
echo "|" . str_repeat("    |", $row_count) . "    |". "\n";
echo "|" . str_repeat("    |", $row_count) . "    |"."\n" ;
echo "|" . str_repeat("    |", $row_count) . "    |"."\n";
echo $pipes['right'] . '----+' . str_repeat("----" . $pipes['up'], $row_count-2) . '----+----' .$pipes['left'] . "\n";

foreach(range(1, $row_count - 2) as $index) {
if($index != 1) {
echo $pipes['right'] .'----'.$pipes['left'] . str_repeat(" ", ($row_count-2)*5) . "    ".$pipes['right']."----" . $pipes['left']. "\n";
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
echo $pipes['bottomleft'] . '----+' . str_repeat("----┴", $row_count-2) . '----+----'. $pipes['bottomright'] . "\n";

echo "\u2122";

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


function createSpecialPipes()
{
    $pipes = array(
        'pipe'=>'2502',
        'line'=>'2500',
        'left'=>'2524',
        'right'=>'251C',
        'up'=>'2534',
        'down'=>'252C',
        'topleft'=>'250C',
        'topright'=>'2510',
        'bottomleft'=>'2514',
        'bottomright'=>'2518'
    );
    foreach ($pipes as $key =>$code) {
       $pipes[$key] = json_decode('"\u'.$code.'"'); 
    }

    return $pipes;
}

function createWindowsPipes()
{
    return array(
        'pipe'=>'|',
        'line'=>'-',
        'left'=>'+',
        'right'=>'+',
        'up'=>'+',
        'down'=>'+',
        'topleft'=>'+',
        'topright'=>'+',
        'bottomleft'=>'+',
        'bottomright'=>'+'
    );    
}