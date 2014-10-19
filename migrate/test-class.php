<?php
require(dirname(__FILE__) . '/dbconfig.php');

class SimpleClass
{
    // member declaration
    public $var = 'a default value';

    // method declaration
    public function displayVar() {
        echo $this->var;
    }
}


class Category1 {
	public  $categoryId;
	public  $categoryName;		
}

?>