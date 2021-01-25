<?php
namespace GCWorld\FormConfig\Traits;

/**
 * Trait MetaDataTrait
 */
trait MetaDataTrait
{
    protected $metaData = [];

    /**
     * @param string $key
     * @param mixed  $value
     *
     * @return $this
     */
    public function setMetaData(string $key, $value)
    {
        $this->metaData[$key] = $value;

        return $this;
    }

    /**
     * @param string $key
     * @return mixed|null
     */
    public function getMetaData(string $key)
    {
        return $this->metaData[$key] ?? null;
    }

    /**
     * @return array
     */
    public function getMetaDataAll()
    {
        return $this->metaData;
    }
}