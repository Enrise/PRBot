<?php

use PRBot\PRBot;
use Symfony\Component\Yaml\Yaml;

require __DIR__ . '/../vendor/autoload.php';

$config = file_get_contents(__DIR__ . '/../etc/config.yml');
$config = Yaml::parse($config);

$client = new \GitHubClient();
$client->setCredentials($config['username'], $config['password']);

$prBot = new PRBot($client);

foreach ($config['projects'] as $projectName => $projectConfig) {
    $prBot->setFork($projectConfig['fork']);
    $prBot->setProjectName($projectName);

    foreach ($projectConfig['merges'] as $fromBranch => $toBranch) {
        echo sprintf(
            '[%s/%s] %s -> %s' . PHP_EOL,
            $projectConfig['fork'],
            $projectName,
            $fromBranch,
            $toBranch
        );
        try {
            $pullRequest = $prBot->createPR(
                $fromBranch,
                $toBranch,
                $projectConfig['prTitle'],
                $projectConfig['prBody']
            );
            $prBot->assignPR(
                $pullRequest->getNumber(),
                $projectConfig['assignees']
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

echo 'Done!' . PHP_EOL;
