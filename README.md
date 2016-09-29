# PRBot

## What

The PRBot was created to automatically create a new pull request, when a merge-back was forgotten.
For example; if a hotfix was made for version 1.1, it should also be merged back to your development branch.
The PRBot should run every morning, to remind you what's still in need of a merge-back.

## Requirements

In order to run the PRBot, you need to have the following available:

* A server with a CRON-job.
* PHP 7.0 or higher with the CURL module enabled.
* A GitHub account with READ access to the repositories you want to monitor. WRITE access is required to assign the PRs.

## Installation

1. Clone this repository on your server
1. Run `composer install` with [composer](https://getcomposer.org/).
1. Copy `etc/config.yml.dist` to `etc/config.yml`, and edit the file to configure your setup.
1. Set up a cron job as explained below.

### Explanation of the configuration file

```yaml
username: MyMergeBot  // Your GitHub username
password: somepass123 // Your GitHub password

// These projects will be checked, extend the list as long as you want.
projects:
  ProjectA:
    fork: SomeUserOrOrganisation
    // The title that will be used for your PRs, the first %s being the
    // branch to merge from, the second %s being the to branch to merge to.
    prTitle: "Make sure that %s is in %s!"
    prBody: "![](https://heavyeditorial.files.wordpress.com/2012/08/thumbsup.gif)"
    merges:
      release/1.0: release/1.1 // Create a PR to merge back release/1.1 into release/1.2
      release/1.1: release/1.2
      release/1.2: develop
    // These GitHub usernames will be assigned to PR's on SomeUserOrOrganisation/ProjectA.
    // Make sure these users exist on GitHub or GitHub will silently fail assigning these any user at all.
    assignees:
      - UserA
      - UserB
      - UserC
  ProjectB:
    fork: AnotherUserOrOrganisation
    prTitle: "[Automated] Merging %s back into %s"
    prBody: "![](http://i.imgur.com/HRQ0Bwl.png)"
    merges:
      master: develop // Create a PR to merge back master into develop
    // These GitHub usernames will be assigned to PR's on AnotherUserOrOrganisation/ProjectB.
    assignees:
      - UserA
      - UserD
      - UserE
```

## Cronjob

We recommend that you configure your cronjob to run every morning before you get to work. For example at 5am from monday to friday:

![0 5 * * 1-5](https://cloud.githubusercontent.com/assets/6495166/13875109/2efe13a8-ecfc-11e5-87ce-5c3214903073.png)

## Example

![image](https://cloud.githubusercontent.com/assets/6495166/13874703/d7a38018-ecf9-11e5-9b8b-966a92e73434.png)
