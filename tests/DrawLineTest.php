<?php
/**
 * 
 **/
 require 'LineDrawer.php';
class DrawLineTest extends PHPUnit_Framework_TestCase
{
    public function testANonSpecialCharacterGetsTreatedNormally()
    {
        $line_drawer = new LineDrawer();
        $this->assertEquals("F\n", $line_drawer->draw('F'));
    }    
    public function testACharacterCanBeRepeated()
    {
        $line_drawer = new LineDrawer();
        $this->assertEquals("FF\n", $line_drawer->draw('{F2}'));
        // code...
    }

    public function testAnythingNotInBracesIsRenderedNormally()
    {
        $line = new LineDrawer;
        $line->map('m', 'f');
        $this->assertEquals("m\n", $line->draw('m'));
        $this->assertEquals("m:2\n", $line->draw('m:2'));
    }
    public function testWeCanMapItems()
    {
        // code...
        $line_drawer = new LineMock;
        $line_drawer->map('m', 'f');
        $this->assertEquals($line_drawer->map, array('m'=>'f'));
    }

    public function testAMappedCharacterReturnsSubtitution()
    {
        $line_drawer = new LineDrawer();
        $line_drawer->map('m', 'F');
        $this->assertEquals("F\n", $line_drawer->draw('{m}'));
        $this->assertEquals("FFF\n", $line_drawer->draw('{m3}'));
    }
    public function testAComplicatedString()
    {
        $line_drawer = new LineDrawer();
        $line_drawer->map('m', 't');
        $this->assertEquals('I likelike turtles' ."\n", $line_drawer->draw('I {/like2} {murmles}'));
    }
    public function testARenderSectionCanHaveMultipleRepeaters()
    {
        $line_drawer = new LineDrawer();
        $this->assertEquals("AABB\n", $line_drawer->draw('{A2B2}'));
    }

    public function testOnlyRepeatAffectImmediateNeighbor()
    {
        $line = new LineDrawer;
        $input = '{onlyrepeatb4}';
        $expected = "onlyrepeatbbbb\n";
        $this->assertEquals($expected, $line->draw($input));

        $input = '{onlyrepeat/ab4}';
        $expected = "onlyrepeatabababab\n";
        $this->assertEquals($expected, $line->draw($input));


        $line->map('tr', '+');
        
        $input = '{tr}';
        $expected = "tr\n";
        $this->assertEquals($expected, $line->draw($input));

        $input = '{/tr}';
        $expected = "+\n";
        $this->assertEquals($expected, $line->draw($input));
    }
}

class LineMock extends LineDrawer
{
    public function __get($prop)
    {
        return $this->$prop;
    }
}
