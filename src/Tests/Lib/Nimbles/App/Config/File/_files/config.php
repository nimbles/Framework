<?php
use Nimbles\App\Config;
return new Config(array(
    'level1' => array(
    	'a' => 1,
    	'b' => array(
    		'c' => 2
        ),
    	'd' => array(
    		'e' => 4
        )
    ),
    'level2:level1' => array(
        'a' => 2,
        'd' => array(
            'e' => 5,
            'f' => 6
        )
    )
));