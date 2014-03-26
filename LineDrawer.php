<?php
class LineDrawer
{
    protected $map = array();
    public function draw($orig)
    {
        $ret = '';
        for ($i = 0; $i < strlen($orig); $i++) {
            if ($orig[$i] == '{') {
                $closing_brace = strpos($orig, '}', $i);

                $ret.= $this->render(substr($orig, $i+1, $closing_brace-$i-1));
                $i = $closing_brace;

            } else {


           $ret.=$orig[$i] ;
           }

        }
        return $ret . "\n";
    }
    protected function render($str)
    {
        if (preg_match('%(.+?):(\d+)%', $str, $matches)) {
            return str_repeat(str_replace(array_keys($this->map), array_values($this->map), $matches[1]), $matches[2]);
        }
        return str_replace(array_keys($this->map), array_values($this->map), $str);
        echo "\nrender this...\n";
        echo $str . "\n";
    }
    public function map($k, $v)
    {
        $this->map[$k] = $v;
    }
}
