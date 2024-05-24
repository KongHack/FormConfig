<?php
namespace GCWorld\FormConfig\Core;

use GCWorld\FormConfig\Enums\FCHookMethod;
use GCWorld\FormConfig\Enums\FCHookType;

/**
 * Class FCHook
 */
class FCHook
{
    protected FCHookType   $cType;
    protected FCHookMethod $cMethod;
    protected string       $data;

    /**
     * @param FCHookType   $type
     * @param FCHookMethod $method
     * @param string       $data
     */
    public function __construct(FCHookType $type, FCHookMethod $method, string $data)
    {
        $this->cType   = $type;
        $this->cMethod = $method;
        $this->data    = $data;
    }

    /**
     * @return FCHookType
     */
    public function getType(): FCHookType
    {
        return $this->cType;
    }

    /**
     * @return FCHookMethod
     */
    public function getMethod(): FCHookMethod
    {
        return $this->cMethod;
    }

    /**
     * @return string
     */
    public function getData(): string
    {
        return $this->data;
    }

}
