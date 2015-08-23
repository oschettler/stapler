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
     * Constructor method
     *
     * @param Attachment $attachedFile
     * @param GithubApi $githubApi
     */
    function __construct(Attachment $attachedFile)
    {
        $this->attachedFile = $attachedFile;
    }

    /**
     * Return the url for a file upload.
     *
     * @param  string $styleName
     * @return string
     */
    public function url($styleName)
    {
        $paths = explode(':', $styleName);
        if (count($paths) == 1) {
            $domain = $_SERVER['HTTP_HOST'];
        }
        else {
            $domain = $paths[0];
        }
        return 'http://' . $domain . $this->path($styleName);
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
    public function move($file, $filePath, $style)
    {


        if ($this->githubApi) {
            $this->githubApi->save($filePath, file_get_contents($file));
        }
        else {
            throw \Exception("Not logged into Github");
        }
    }
}
