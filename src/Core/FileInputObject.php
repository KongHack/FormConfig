<?php
namespace GCWorld\FormConfig\Core;

class FileInputObject
{
    protected ?string $fileName = null;
    protected ?string $fileId   = null;
    protected ?string $fileUrl  = null;

    /**
     * @param string $fileName
     * @return $this
     */
    public function setFileName(string $fileName): static
    {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * @param string $fileId
     * @return $this
     */
    public function setFileId(string $fileId): static
    {
        $this->fileId = $fileId;

        return $this;
    }

    /**
     * @param string $fileUrl
     * @return $this
     */
    public function setFileUrl(string $fileUrl): static
    {
        $this->fileUrl = $fileUrl;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    /**
     * @return null|string
     */
    public function getFileId(): ?string
    {
        return $this->fileId;
    }

    /**
     * @return null|string
     */
    public function getFileUrl(): ?string
    {
        return $this->fileUrl;
    }
}
