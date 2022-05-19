<?php
opcache_reset();

ini_set('display_errors', 1);
error_reporting(E_ALL);

class myClass {
    public $var;
		
    function __construct() {
	    $this->var = 1;
    }

    function inc() { $this->var++; }

    function showValue() {  return $this->var;    }
}

$a = new myClass(); // $a "references" a Foo object
$b = $a; //b also references the same Foo object as a
$c = &$a; //b also references the same Foo object as a

echo "Title A: ".$a->showValue()."<br />";

$a->inc();
echo "Title B: ".$b->showValue()."<br />";
echo "Title C: ".$c->showValue()."<br />";
?>
