<?php

namespace GCWorld\FormConfig\Traits;

/**
 * Trait MetaDataTrait
 */
trait MetaDataTrait
{
    /** @var array<string, mixed> */
    protected array $metaData = [];

    /**
     * @param string $key
     * @param mixed  $value
     *
     * @return $this
     */
    public function setMetaData(string $key, mixed $value): static
    {
        $this->metaData[$key] = $value;

        return $this;
    }

    /**
     * @param string $key
     * @return mixed|null
     */
    public function getMetaData(string $key): mixed
    {
        return $this->metaData[$key] ?? null;
    }

    /**
     * @return array<string, mixed>
     */
    public function getMetaDataAll(): array
    {
        return $this->metaData;
    }
}
