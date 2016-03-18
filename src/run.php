<?php

require '../vendor/autoload.php';
$config = require '../dev/config.php';

$client = new GitHubClient();

echo 'Created client, authenticating...' . PHP_EOL;

$client->setCredentials($config['username'], $config['password']);

foreach ($config['github'] as $fork => $projects) {
    foreach ($projects as $project => $branches) {
        foreach ($branches as $fromBranch => $toBranch) {
            echo sprintf(
                '[%s/%s] %s -> %s' . PHP_EOL,
                $fork,
                $project,
                $fromBranch,
                $toBranch
            );
            try {
                $client->pulls->createPullRequest(
                    $fork,
                    $project,
                    sprintf(
                        $config['prTitle'],
                        $fromBranch,
                        $toBranch
                    ),
                    $fromBranch,
                    $toBranch,
                    $config['prBody']
                );
            } catch (\Exception $e) {
                // Ignore status 422 messages, this means there is no need to create a PR, which is fine.
                if (strpos($e->getMessage(), 'Expected status [201], actual status [422]') === 0) {
                    continue;
                }
                echo sprintf(
                    '[%s] %s' . PHP_EOL,
                    get_class($e),
                    $e->getMessage()
                );
            }
        }
    }
}

echo 'Done!' . PHP_EOL;
