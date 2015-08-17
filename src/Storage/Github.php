<?php namespace Codesleeve\Stapler\Storage;

use Codesleeve\Stapler\Attachment;
use Img\Publishers\GithubApi;

class Github implements StorageableInterface
{
    /**
     * The current attachedFile object being processed.
     *
     * @var \Codesleeve\Stapler\Attachment
     */
    public $attachedFile;

    /**
     * The Github API client.
     *
     * @var GithubApi
     */
    protected $githubApi;

    /**
     * Constructor method
     *
     * @param Attachment $attachedFile
     * @param GithubApi $githubApi
     */
    function __construct(Attachment $attachedFile, GithubApi $githubApi)
    {
        $this->attachedFile = $attachedFile;
        $this->githubApi = $githubApi;
    }

    /**
     * Return the url for a file upload.
     *
     * @param  string $styleName
     * @return string
     */
    public function url($styleName)
    {
        return 'http://DOMAIN' . $this->path($styleName);
    }

    /**
     * Return the key the uploaded file object is stored under within a bucket.
     *
     * @param  string $styleName
     * @return string
     */
    public function path($styleName)
    {
        return $this->attachedFile->getInterpolator()->interpolate($this->attachedFile->path, $this->attachedFile, $styleName);
    }

    /**
     * Remove an attached file.
     *
     * @param  array $filePaths
     */
    public function remove(array $filePaths)
    {
        if ($filePaths) {
            // N.Y.I.
        }
    }

    /**
     * Move an uploaded file to it's intended destination.
     *
     * @param  string $file
     * @param  string $filePath
     */
    public function move($file, $filePath)
    {
        $this->githubApi->save($filePath, file_get_contents($file));
    }
}
