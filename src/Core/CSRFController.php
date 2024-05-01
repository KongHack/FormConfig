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
    protected static ?self $instance = null;

    /**
     * CSRF Config Array
     *
     * @var array
     */
    protected array $csrf = [
        'enabled'          => false,
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

    /**
     * CSRFController Constructor.
     */
    public function __construct()
    {
        $config = Config::getInstance()->getConfig();

        if(isset($config['csrf'])) {
            $this->csrf['enabled']          = $config['csrf']['enabled'] ?? false;
            $this->csrf['tokenNameMethod']  = $config['csrf']['tokenNameMethod'] ?? '';
            $this->csrf['tokenValueMethod'] = $config['csrf']['tokenValueMethod'] ?? '';
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
    public function isEnabled(): bool
    {
        return $this->csrf['enabled'];
    }

    /**
     * @throws CSRFNotEnabledException
     *
     * @return void
     */
    public function forceEnable(): void
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
    public function doCheck(): bool
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
     * @return string
     */
    public function getTokenName(): string
    {
        if($this->csrf['enabled']) {
            return call_user_func($this->csrf['tokenNameMethod']);
        }

        return '';
    }

    /**
     * @return string
     */
    public function getTokenValue(): string
    {
        if($this->csrf['enabled']) {
            return call_user_func($this->csrf['tokenValueMethod']);
        }

        return '';
    }

    /**
     * @return array
     */
    public function getConfig(): array
    {
        return $this->csrf;
    }

}