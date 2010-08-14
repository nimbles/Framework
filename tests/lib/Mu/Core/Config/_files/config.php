<?php
return array(
    'level1' => array(
        'a' => 1,
        'b' => 2,
        'c' => 3,
        'd' => array(
            'e' => 4,
            'f' => 5,
            'g' => array(
                'h' => 6
            )
        )
    ),
    'level2 : level1' => array(
        'a' => 'one',
        'd' => array(
            'e' => 'four'
        ),
        'i' => 'seven'
    ),
    'level3 : level2' => array(
        'j' => 8
    )
);
