<?php

if (array_key_exists('WINDIR', $_SERVER)) {
    $pipes = createWindowsPipes();
} else {
    $pipes = createSpecialPipes();
}

//header('content-type:text/html; charset=UTF-8');
$spaces = json_decode(file_get_contents('spaces.json'));


$spaces = $spaces->spaces;
$row_count = count($spaces) / 4 + 1;



require 'LineDrawer.php';
$line = new LineDrawer;
$line->map('tl', $pipes['topleft']);
$line->map('tr', $pipes['topright']);
$line->map('bl', $pipes['bottomleft']);
$line->map('br', $pipes['bottomright']);
$line->map('u', $pipes['up']);
$line->map('l', $pipes['left']);
$line->map('r', $pipes['right']);
$line->map('d', $pipes['down']);
//$line->map('tl','asdf');
$line->map('h', $pipes['line']);
$line->map('v', $pipes['pipe']);
$line->map('+', $pipes['plus']);



// Draw the top row
$ret = '';
$start_index = $row_count * 2 - 2;
$end_index = $start_index + $row_count -1;

//echo $start_index . ':' . $end_index . "\n";
//print_r(range($start_index, $end_index));
$line1 = $line2 = $line3 = '';
foreach (range($start_index, $end_index) as $cur_index) {
    $lines = drawSpace($spaces[$cur_index]);

    $line1.= $lines[0];
    $line2.= $lines[1];
    $line3.= $lines[2];


/*    $line2.='{    v}';
    if (property_exists($spaces[$cur_index],'price')) {
        $line3.= '$'. $spaces[$cur_index]->price .'{v}';
    } else {
        $line3.= '{ 4v}';
    }*/
}
$ret.=$line->draw('{/tl}{' . str_repeat('h4d', $row_count-1) . '}{h4/tr}');
$ret.=$line->draw('{v}'.$line1);
$ret.=$line->draw('{v}'.$line2);
$ret.=$line->draw('{v}'.$line3);
$ret.=$line->draw('{rh4+}' . str_repeat("{h4u}", $row_count - 3) . '{h4+h4l}');
echo $ret;


function drawSpace($space)
{
    if (property_exists($space,'price')) {
        $line3= '$'. $space->price .'{v}';
    } else {
        $line3= '{ 4v}';
    }

    return [
        str_pad($space->abbr, 4, ' ', STR_PAD_LEFT).'{v}',
        '{    v}',
        $line3
    ];
}


//echo $line->draw('{v}{v' .$row_count .'}');
//die();
//echo $pipes['topleft'] . str_repeat($pipes['line'].$pipes['line']. $pipes['line'] . $pipes['line'] . $pipes['down'], $row_count) . $pipes['line'] .$pipes['line'] . $pipes['line'] . $pipes['line'] . $pipes['topright'] . "\n";

$ret = '';
$spaces_str = '{ ' .(($row_count - 2) *5 -1) . '}';
while ($end_index < count($spaces)) {
    if ($ret != '') {
       $ret.=$line->draw('{rh4l}' . $spaces_str . '{rh4l}');
    }
    $space1 = drawSpace($spaces[$start_index--]); 
    $space2 = drawSpace($spaces[$end_index++]); 
// 14
// 4
    $ret.= $line->draw('{v}'.$space1[0] .$spaces_str.'{v}' .$space2[0]);
    $ret.= $line->draw('{v}'.$space1[1] .$spaces_str.'{v}'. $space2[1]);
    $ret.= $line->draw('{v}'.$space1[2] .$spaces_str.'{v}' . $space2[2]);
      

}
/*foreach (range(1, $row_count - 2) as $index) {
    if ($index != 1) {
        echo $line->draw('{rh4l' . str_repeat(" ", ($row_count - 2) * 5) . ' 4rh4l}');
    }

    echo $line->draw("{v 4v" . str_repeat(" ", ($row_count - 2) * 5) . " 4v 4v}");
    if ($index == floor($row_count / 2)) {
        // TODO Update this to new syntax
        echo "|    |" . "   MONOPOLY   " . "|    |" . "\n";
    } else {
        echo $line->draw("{v 4v" . str_repeat(" ", ($row_count - 2) * 5) . " 4v 4v}");
    }
    echo $line->draw("{v 4v" . str_repeat(" ", ($row_count - 2) * 5) . " 4v 4v}");
}
*/
echo $ret;


$line1 = $line2 = $line3 = '';
while ($start_index>=0) {
    $lines =  drawSpace($spaces[$start_index--]);    
    $line1.= $lines[0];
    $line2.= $lines[1];
    $line3.= $lines[2];
}


$ret = $line->draw("{rh4+/hhhhd" . ($row_count - 3) . "/h4+/h4l}");
$ret.= $line->draw('{v}'.$line1);
$ret.= $line->draw('{v}'.$line2);
$ret.= $line->draw('{v}'.$line3);

$ret.= $line->draw('{/bl/h4u/hhhhu' . ($row_count - 3) . '/h4u/h4/br' . '}');

echo $ret;
/*
$line1 ='';
$line2 = '';
$line3 = '';
for ($i = 0; $i <= $row_count; $i++) {

    $line1 = '{ '.$spaces[$i]->abbr.' v}'.$line1;
    if (property_exists($spaces[$i],'price')) {
        $line3 = '$'. $spaces[$i]->price .'{v}'. $line3;
    } else {
        $line3 = '{ 4v}'.$line3;
    }

}
$ret.= $line->draw('{v}'.$line1);
$ret.= $line->draw("{v/    v" . $row_count . "/ 4v}");
$ret.= $line->draw('{v}'. $line3);
$ret.= $line->draw('{/bl/h4u/hhhhu' . ($row_count - 2) . '/h4u/h4/br' . '}');

echo $ret;
*/
function createSpecialPipes()
{
    $pipes = array(
        'pipe'        => '2502',
        'line'        => '2500',
        'left'        => '2524',
        'right'       => '251C',
        'up'          => '2534',
        'down'        => '252C',
        'topleft'     => '250C',
        'topright'    => '2510',
        'bottomleft'  => '2514',
        'bottomright' => '2518',
        'plus' => '253C'
    );
    foreach ($pipes as $key => $code) {
        $pipes[$key] = json_decode('"\u' . $code . '"');
    }

    return $pipes;
}

function createWindowsPipes()
{
    return array(
        'pipe'        => '|',
        'line'        => '-',
        'left'        => '+',
        'right'       => '+',
        'up'          => '+',
        'down'        => '+',
        'topleft'     => '+',
        'topright'    => '+',
        'bottomleft'  => '+',
        'bottomright' => '+',
        'plus'        => '+'
    );
}
