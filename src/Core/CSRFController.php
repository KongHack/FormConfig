<?php
namespace GCWorld\FormConfig\Core;

use GCWorld\FormConfig\Exceptions\CSRFNotEnabledException;
use GCWorld\FormConfig\Exceptions\CSRFRequestFailedException;
use GCWorld\Globals\Globals;

/**
 * Class CSRFController
 */
class CSRFController
{
    protected static $instance = null;

    /**
     * CSRF Config Array
     *
     * @var array
     */
    protected $csrf = [
        'enabled'          => false,
        'name'             => '',
        'tokenNameMethod'  => '',
        'tokenValueMethod' => '',
    ];

    /**
     * @return CSRFController
     */
    public static function get()
    {
        if(self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function __construct()
    {
        $config = Config::getInstance()->getConfig();

        if(isset($config['csrf'])) {
            $this->csrf['enabled']          = $config['csrf']['enabled'] ?? false;
            $this->csrf['tokenNameMethod']  = $config['tokenNameMethod'] ?? '';
            $this->csrf['tokenValueMethod'] = $config['tokenValueMethod'] ?? '';
        }

        if($this->csrf['enabled'] && empty($this->csrf['tokenNameMethod'])) {
            $this->csrf['enabled'] = false;
        }
        if($this->csrf['enabled'] && empty($this->csrf['tokenValueMethod'])) {
            $this->csrf['enabled'] = false;
        }
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return $this->csrf['enabled'];
    }

    /**
     * @throws CSRFNotEnabledException
     */
    public function forceEnable()
    {
        if(empty($this->csrf['tokenNameMethod']) || empty($this->csrf['tokenValueMethod'])) {
            throw new CSRFNotEnabledException('Improperly Configured Tokens');
        }

        $this->csrf['enabled'] = true;
    }

    /**
     * @return bool
     * @throws CSRFNotEnabledException
     * @throws CSRFRequestFailedException
     */
    public function doCheck()
    {
        if($this->csrf['enabled']
            && $this->csrf['tokenNameMethod'] != ''
            && $this->csrf['tokenValueMethod'] != ''
        ) {
            $name   = call_user_func($this->csrf['tokenNameMethod']);
            $value  = call_user_func($this->csrf['tokenValueMethod']);
            $cGlobals = new Globals();
            if($cGlobals->string()->REQUEST($name) !== $value) {
                throw new CSRFRequestFailedException();
            }
            return true;
        }

        throw new CSRFNotEnabledException();
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return $this->csrf;
    }

}