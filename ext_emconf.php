<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Plain FAQ',
    'description' => 'Plain FAQ extension with list and detail view. Migration commands to migrate data and plugin settings from ext:irfaq',
    'category' => 'plugin',
    'author' => 'Torben Hansen',
    'author_email' => 'torben@derhansen.com',
    'state' => 'stable',
    'uploadfolder' => 0,
    'createDirs' => '',
    'clearCacheOnLoad' => 0,
    'version' => '1.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '8.7.0-9.5.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
