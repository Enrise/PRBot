# PRBot

### What

The PRBot was created to automatically create a new pull request, when a merge-back was forgotten.
For exmaple; if a hotfix was made for version 1.1, it should also be merged back to your development branch.
The PRBot should run every morning, to remind you what's still in need of a merge-back.

### Requirements

In order to run the PRBot, you need to have the following available:

* A server with a CRON-job
* PHP 5.4 or higher
* Have the PHP CURL module enabled

Once you downloaded all the files, make sure you run `composer install` with [composer](https://getcomposer.org/).

# Configuration

Copy the `dev/config.dist.php` to `dev/config.php`, and edit the file to configure your setup.

```php
<?php

return [
    'username' => 'myMergeBot', // Your github username
    'password' => 'somepass123', // Your github password
    // The title that will be used for your PR's, %s being the branch names:
    'prTitle' => 'Make sure that %s is in %s!',
    // Message the PRBot uses for the pull request:
    'prBody' => '![](https://heavyeditorial.files.wordpress.com/2012/08/thumbsup.gif)',
    'github' => [
        // http://github.com/UserOrOrganisation/ProjectA
        'UserOrOrganisation' => [
            'ProjectA' => [
                // Merges back release/1.1 into release/1.2
                'release/1.1' => 'release/1.2',
                // Merges back release/1.2 into develop
                'release/1.2' => 'develop',
            ],
        ],
        // http://github.com/UserOrOrganisation/ProjectB
        'UserOrOrganisation' => [
            'ProjectB' => [
                // Merges back release/2.0 into develop
                'release/2.0' => 'develop',
                // Merges back master into develop
                'master' => 'develop',
            ],
        ],
    ],
];
```

We recommend that you configure your cronjob to run every morning before you get to work. For example at 5am.

# Example

![image](https://cloud.githubusercontent.com/assets/6495166/13874703/d7a38018-ecf9-11e5-9b8b-966a92e73434.png)
