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

echo $line->draw('{/tl}{' . str_repeat('h4d', $row_count) . '}{h4/tr}');
echo $line->draw('{v/    v' . $row_count . '    v}');
echo $line->draw('{v/    v' . $row_count . '    v}');
echo $line->draw('{v/    v' . $row_count . '    v}');
echo $line->draw('{rh4+}' . str_repeat("{h4u}", $row_count - 2) . '{h4+h4l}');

//echo $line->draw('{v}{v' .$row_count .'}');
//die();
//echo $pipes['topleft'] . str_repeat($pipes['line'].$pipes['line']. $pipes['line'] . $pipes['line'] . $pipes['down'], $row_count) . $pipes['line'] .$pipes['line'] . $pipes['line'] . $pipes['line'] . $pipes['topright'] . "\n";

foreach (range(1, $row_count - 2) as $index) {
    if ($index != 1) {
        echo $line->draw('{rh4l' . str_repeat(" ", ($row_count - 2) * 5) . ' 4rh4l}');
    }

    echo $line->draw("{v 4v" . str_repeat(" ", ($row_count - 2) * 5) . " 4v 4v}");
    if ($index == floor($row_count / 2)) {
        // TODO Update this to new syntax
        echo "|    |" . "                       MONOPOLY              " . "    |    |" . "\n";
    } else {
        echo $line->draw("{v 4v" . str_repeat(" ", ($row_count - 2) * 5) . " 4v 4v}");
    }
    echo $line->draw("{v 4v" . str_repeat(" ", ($row_count - 2) * 5) . " 4v 4v}");
}

echo $line->draw("{rh4+/hhhhd" . ($row_count - 2) . "/h4+/h4l}");
echo $line->draw("{v/    v" . $row_count . "/ 4v}");
echo $line->draw("{v/    v" . $row_count . "/ 4v}");
echo $line->draw("{v/    v" . $row_count . "/ 4v}");
echo $line->draw('{/bl/h4u/hhhhu' . ($row_count - 2) . '/h4u/h4/br' . '}');

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
