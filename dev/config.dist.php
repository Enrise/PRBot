<?php

return [
    'username' => 'myMergeBot',
    'password' => 'somepass123',
    'prTitle' => 'Make sure that %s is in %s!',
    'prBody' => '![](https://heavyeditorial.files.wordpress.com/2012/08/thumbsup.gif)',
    'github' => [
        'UserOrOrganisation' => [
            'ProjectA' => [
                'release/1.1' => 'develop',
                'release/1.1' => 'release/1.2',
                'release/1.2' => 'develop',
            ],
        ],
        'AnotherUser' => [
            'ProjectB' => [
                'release/2.0' => 'develop',
                'master' => 'develop',
            ],
        ],
    ],
];

