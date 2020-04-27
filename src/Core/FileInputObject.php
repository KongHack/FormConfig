<?php
namespace GCWorld\FormConfig\Core;

class FileInputObject
{
    protected $fileName = null;
    protected $fileId   = null;
    protected $fileUrl  = null;

    /**
     * @param string $fileUrl
     * @return $this
     */
    public function setFileName(string $fileName)
    {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * @param string $fileUrl
     * @return $this
     */
    public function setFileId(string $fileId)
    {
        $this->fileId = $fileId;

        return $this;
    }

    /**
     * @param string $fileUrl
     * @return $this
     */
    public function setFileUrl(string $fileUrl)
    {
        $this->fileUrl = $fileUrl;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * @return null|string
     */
    public function getFileId()
    {
        return $this->fileId;
    }

    /**
     * @return null|string
     */
    public function getFileUrl()
    {
        return $this->fileUrl;
    }

}
