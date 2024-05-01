<?php
namespace GCWorld\FormConfig\Core;

/**
 * Class FCHook
 */
class FCHook
{
    const TYPE_MAIN_PRE    = 1;
    const TYPE_MAIN_POST   = 2;
    const TYPE_BLOCK_PRE   = 3;
    const TYPE_BLOCK_POST  = 4;
    const TYPE_FIELDS_PRE  = 5;
    const TYPE_FIELDS_POST = 6;

    const METHOD_HTML    = 1;
    const METHOD_INCLUDE = 2;

    protected int    $type;
    protected string $method;
    protected string $data;

    /**
     * FCHook constructor.
     *
     * @param int    $type
     * @param int    $method
     * @param string $data
     */
    public function __construct(int $type, int $method, string $data)
    {
        $this->type   = $type;
        $this->method = $method;
        $this->data   = $data;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getMethod(): int
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getData(): string
    {
        return $this->data;
    }

}
