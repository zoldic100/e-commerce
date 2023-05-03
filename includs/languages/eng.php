<?php

function lang ($phrase) {
    static $lang = array(
        //navbar links
        'message' => 'hello',
        'HOME' => 'Home',
        'CATEGORIES' => 'categories',
        'ITEMS' => 'Items',
        'MEMBERS' => 'Members',
        'STATISTICS' => 'Statistics',
        'COMMENTS' => 'Comments',
        'LOGS' => 'Logs',

    );
    return $lang[$phrase];

} 