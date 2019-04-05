<?php
namespace GCWorld\FormConfig\Core;

class FCHook
{
    const TYPE_MAIN_PRE   = 1;
    const TYPE_MAIN_POST  = 2;
    const TYPE_BLOCK_PRE  = 3;
    const TYPE_BLOCK_POST = 4;

    const METHOD_HTML    = 1;
    const METHOD_INCLUDE = 2;

    protected $type   = null;
    protected $method = null;
    protected $data   = null;

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
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

}
