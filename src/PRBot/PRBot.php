<?php
declare(strict_types=1);

namespace PRBot;

/**
 * The main PRBot class
 */
class PRBot
{
    /**
     * The fork (user / company) where the project lives.
     *
     * @var string
     */
    protected $fork;

    /**
     * The name of the project.
     *
     * @var string
     */
    protected $projectName;

    /**
     * The client that does the work for us.
     *
     * @var \GitHubClient
     */
    protected $gitHubClient;

    /**
     * PRBot constructor.
     *
     * @param \GitHubClient $gitHubClient
     */
    public function __construct(\GitHubClient $gitHubClient)
    {
        $this->gitHubClient = $gitHubClient;
    }

    /**
     * Set the fork of the project.
     *
     * @param string $fork The fork of the project.
     */
    public function setFork(string $fork)
    {
        $this->fork = $fork;
    }

    /**
     * Set the name of the project.
     *
     * @param string $projectName The name of the project.
     */
    public function setProjectName(string $projectName)
    {
        $this->projectName = $projectName;
    }

    /**
     * Create a PullRequest on GitHub.
     *
     * @param string $fromBranch The branch that holds the changes we want to merge.
     * @param string $toBranch   The branch we want to merge the changes into.
     * @param string $prTitle    The title of the PR.
     * @param string $prBody     The body of the PR, can contain markdown.
     *
     * @throws \GitHubClientException
     *
     * @return \GitHubFullPull
     */
    public function createPR(
        string $fromBranch,
        string $toBranch,
        string $prTitle,
        string $prBody
    ): \GitHubFullPull {
        $pullRequest = $this->gitHubClient->pulls->createPullRequest(
            $this->fork,
            $this->projectName,
            sprintf(
                $prTitle,
                $fromBranch,
                $toBranch
            ),
            $fromBranch,
            $toBranch,
            $prBody
        );

        return $pullRequest;
    }

    /**
     * Assign a create PR to one or more assignees.
     *
     * @param int   $prNumber  The ID of the PR that we want to assign.
     * @param array $assignees An array of GitHub usernames that this PR will be assigned to.
     *
     * @throws \GitHubClientException
     */
    public function assignPR(
        int $prNumber,
        array $assignees
    ) {
        $data = [
            'assignees' => $assignees,
        ];

        $url = sprintf(
            '/repos/%s/%s/issues/%d',
            $this->fork,
            $this->projectName,
            $prNumber
        );

        $this->gitHubClient->request($url, 'PATCH', json_encode($data), 200, 'GitHubIssue');
    }
}
