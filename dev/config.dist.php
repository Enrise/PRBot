<?php

return [
    'username' => 'myMergeBot',
    'password' => 'somepass123',
    'github' => [
        'myFork' => [
            'ProjectA' => [
                'release/1.1' => 'develop',
                'release/1.1' => 'release/1.2',
                'release/1.2' => 'develop',
            ]
        ]
    ]
];

