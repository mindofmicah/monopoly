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
        while (preg_match('%^(.+?)(\d+)(.*)$%', $str, $match)) {

            $last_slash = strrpos($match[1], '/');
            if ($last_slash === false) {
                // Only repeat the last character
                $str = substr($match[1], 0, -1);
                $str.= str_repeat(substr($match[1], -1) , $match[2]);
                $str.=$match[3];
                    //$str = substr($match[1], 0, -2) . str_repeat(substr($match[1],-1), $match[2]) . $match[3] ."\n";
            } else {
//                echo $last_slash;
                $str = substr($match[1], 0, $last_slash);
                $str.= str_repeat(substr($match[1], $last_slash) , $match[2]);
                $str.=$match[3];
               
            } 
            //print_r($match);
//            echo 'orig:' . $str;
//            echo "\n";
          //  $str = str_repeat($match[1], $match[2]) .$match[3];
//    echo $str;
    //break;
            //    echo $str;
          //  die();
        }
        $str = str_replace(array_keys($this->map), array_values($this->map), $str);
        return str_replace('/', '', $str);
        return $str;
        die();
        
    }
    public function map($k, $v)
    {
        if (isset($k[1]) && $k[0] != '/') {
            $k = '/' . $k;
        }
        $this->map[$k] = $v;
    }
}
