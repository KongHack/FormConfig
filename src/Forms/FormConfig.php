<?php
namespace GCWorld\FormConfig\Forms;

use GCWorld\FormConfig\Abstracts\Base;
use GCWorld\FormConfig\Core\Config;
use GCWorld\FormConfig\Core\CSRFController;
use GCWorld\FormConfig\Core\FCHook;
use GCWorld\FormConfig\Core\Twig;
use GCWorld\FormConfig\FieldContainerInterface;
use GCWorld\FormConfig\Fields\Hidden;
use GCWorld\FormConfig\Generated\FieldCreate;
use GCWorld\FormConfig\Interfaces\ModelFieldText;
use GCWorld\Interfaces\ORMDescriptionInterface;

/**
 * Class FormConfig.
 */
class FormConfig implements FieldContainerInterface
{
    const OVERRIDE_SUBMIT      = 'submitButton';
    const OVERRIDE_PANEL_CLASS = 'panelClass';

    const DEFAULT_NAVIGATION_TAG = 'div';

    const REQUIRED_INDICATOR_OFF      = 0;
    const REQUIRED_INDICATOR_ASTERISK = 1;
    const REQUIRED_INDICATOR_VERBOSE  = 2;

    const FORM_MODE_BOOTSTRAP_3       = 'BS3';
    const FORM_MODE_BOOTSTRAP_5       = 'BS5';

    protected static ?int    $requiredIndicator = null;
    protected static ?string $formMode          = null;

    protected ?FieldCreate $builder         = null;
    protected ?string      $navigationTag   = null;
    protected ?string      $navigationRight = null;
    protected string       $method          = 'POST';
    protected bool         $isReadOnly      = false;
    protected bool         $isWrapped       = true;
    protected bool         $useHoldOn       = false;
    protected string       $name            = '';
    protected array        $hooks           = [];
    protected string       $formId          = '';
    protected string       $twigTemplate    = '';
    protected array        $twigOverrides   = [];
    protected array        $fields          = [];
    protected array        $rawData         = [];
    protected string       $navigationTitle = 'Navigation';
    protected array        $renderArgs      = [
        'formArray'   => [],
        'formCurrent' => '',
        'urlBase'     => '',
        'urlCurrent'  => '',
    ];

    /**
     * @var array
     */
    protected array $csrf = [
        'enabled'          => false,
        'name'             => '',
        'tokenNameMethod'  => '',
        'tokenValueMethod' => '',
    ];

    /**
     * @var array
     */
    protected array $unattributedErrors = [];

    /**
     * Only used in the event of a simple form.  Great for rows!
     *
     * @var string
     */
    protected string $simpleFormWrappingClass = '';

    /**
     * @var object|null
     */
    protected ?object $callingObject = null;

    /**
     * FormConfig constructor.
     */
    public function __construct(object $callingObject = null)
    {
        $this->callingObject = $callingObject;

        $config = Config::getInstance()->getConfig();
        if(isset($config['general']['holdOn'])) {
            $this->useHoldOn = (bool) $config['general']['holdOn'];
        }
        if(self::$requiredIndicator === null) {
            self::$requiredIndicator = 2;

            if (isset($config['general']['requiredIndicator'])) {
                self::$requiredIndicator = (int) $config['general']['requiredIndicator'];
            }
        }
        if(self::$formMode === null) {
            self::$formMode = 'BS3';

            if (isset($config['general']['formMode'])) {
                self::$formMode = (string) $config['general']['formMode'];
            }
        }

        $this->csrf = CSRFController::get()->getConfig();

        if($this->csrf['enabled']) {
            $this->setCSRFField();
        }
    }

    /**
     * @return $this
     */
    protected function enableCSRF(): static
    {
        CSRFController::get()->forceEnable();

        return $this;
    }

    /**
     * @return void
     */
    protected function setCSRFField(): void
    {
        if($this->csrf['enabled']
            && $this->csrf['tokenNameMethod'] != ''
            && $this->csrf['tokenValueMethod'] != ''
        ) {
            $name   = call_user_func($this->csrf['tokenNameMethod']);
            $value  = call_user_func($this->csrf['tokenValueMethod']);
            $cField = new FormField($name);
            $cField->setValue($value);
            $cField->setType(Hidden::getKey());
            $cField->setDataAttribute('csrf','1');
            $this->addFieldObject($cField);

            $this->csrf['name']  = $name;
            $this->csrf['value'] = $value;
        }
    }

    /**
     * @return int|null
     */
    public static function getRequiredIndicator(): ?int
    {
        return self::$requiredIndicator;
    }

    /**
     * @param int $indicator
     *
     * @return void
     */
    public static function setRequiredIndicator(int $indicator): void
    {
        self::$requiredIndicator = $indicator;
    }

    /**
     * @return string|null
     */
    public static function getFormMode(): ?string
    {
        return self::$formMode;
    }

    /**
     * @param string $mode
     *
     * @return void
     */
    public static function setFormMode(string $mode): void
    {
        self::$formMode = $mode;
    }

    /**
     * @param bool $use
     *
     * @return $this
     */
    public function setHoldOn(bool $use): static
    {
        $this->useHoldOn = $use;

        return $this;
    }

    /**
     * @return bool
     */
    public function canHoldOn(): bool
    {
        return $this->useHoldOn;
    }

    /**
     * @return bool
     */
    public function hasRequired(): bool
    {
        foreach($this->getFormFields() as $field) {
            if($field->getReqLevel() > 1) {

                return true;
            }
        }

        return false;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $id
     *
     * @return $this
     */
    public function setFormId(string $id): static
    {
        $this->formId = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getFormId(): string
    {
        if ('' != $this->formId) {
            return $this->formId;
        }

        return 'form_'.$this->name;
    }

    /**
     * You can add anything here, even objects and resources!  It's just for referential storage

     * @param string $key
     * @param mixed  $value
     *
     * @return $this
     */
    public function addRawData(string $key, mixed $value): static
    {
        $this->rawData[$key] = $value;

        return $this;
    }

    /**
     * @param string $key
     * @return mixed|null
     */
    public function getRawData(string $key): mixed
    {
        return $this->rawData[$key] ?? null;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setNavigationTag($value): static
    {
        if(strlen($value) == 1 && is_numeric($value)){
            $value = 'h'.$value;
        }
        $this->navigationTag = strtolower($value);

        return $this;
    }

    /**
     * @return null|string
     */
    public function getNavigationTag(): ?string
    {
        if(null != $this->navigationTag){
            return $this->navigationTag;
        }

        return self::DEFAULT_NAVIGATION_TAG;
    }

    /**
     * @param string $key
     * @param string $value
     *
     * @return $this
     */
    public function setOverride(string $key, string $value): static
    {
        $this->twigOverrides[$key] = $value;

        return $this;
    }

    /**
     * @param string $fileName
     *
     * @return $this
     */
    public function setTwigTemplate(string $fileName): static
    {
        $this->twigTemplate = $fileName;

        return $this;
    }

    /**
     * @return string
     */
    public function getTwigTemplate(): string
    {
        return $this->twigTemplate;
    }

    /**
     * @param FormField $field
     *
     * @return $this
     */
    public function addFieldObject(FormField $field): static
    {
        $this->fields[$field->getNameRaw()] = $field;
        $field->setFormConfig($this);

        return $this;
    }

    /**
     * @param Base $field
     *
     * @return $this
     */
    public function addBuiltField(Base $field): static
    {
        $this->fields[$field->getNameRaw()] = $field;
        $field->setFormConfig($this);

        return $this;
    }

    /**
     * @param string $name
     *
     * @return FormField
     */
    public function createField(string $name): FormField
    {
        $field               = new FormField($name);
        $this->fields[$name] = $field;
        $field->setFormConfig($this);

        return $field;
    }

    /**
     * @param string $name
     *
     * @return FormField
     *
     * @throws \Exception
     */
    public function getField(string $name): FormField
    {
        if (!array_key_exists($name, $this->fields)) {
            throw new \Exception('Field Not Defined: '.$name);
        }

        return $this->fields[$name];
    }

    /**
     * @param string $name
     * @return $this
     */
    public function removeField(string $name): static
    {
        if(isset($this->fields[$name])) {
            unset($this->fields[$name]);
            return $this;
        }

        // If we are not in the main bank of fields, maybe we are in an array
        foreach($this->fields as $field) {
            if($field instanceof FormArrayElement) {
                if($field->removeFieldByName($name)) {
                    return $this;
                }
            }
        }

        return $this;
    }

    /**
     * @param string $name
     *
     * @return FormArrayElement
     */
    public function createFieldArray(string $name): FormArrayElement
    {
        $field               = new FormArrayElement($name);
        $this->fields[$name] = $field;
        $field->setFormConfig($this);

        return $field;
    }

    /**
     * @param array $requirements
     *
     * @return $this
     */
    public function setRequirements(array $requirements): static
    {
        if (count($requirements) > 0) {
            //Iterate fields.
            foreach ($requirements as $name => $level) {
                if (array_key_exists($name, $this->fields)) {
                    /** @var FormField $field */
                    $field = $this->fields[$name];
                    $field->setReqLevel($level);
                }
            }
        }

        return $this;
    }

    /**
     * @param array $errors
     *
     * @return $this
     */
    public function setErrors(array $errors): static
    {
        if (count($errors) > 0) {
            //Iterate fields.
            foreach ($errors as $name => $err) {
                if (array_key_exists($name, $this->fields)) {
                    /** @var FormField $field */
                    $field = $this->fields[$name];
                    $field->addError($err);
                    continue;
                }

                $this->unattributedErrors[$name] = $err;
            }
        }

        return $this;
    }

    /**
     * @param mixed $object
     *
     * @return $this
     */
    public function setValuesFromObject(mixed $object): static
    {
        $mft = ($object instanceof ModelFieldText);
        $orm = ($object instanceof ORMDescriptionInterface);

        foreach ($this->fields as $name => $field) {
            /** @var FormField $field */
            if (property_exists($object, $name) && method_exists($field, 'setValue')) {
                // In the event we're running into encoded UUIDs
                $function = 'get'.str_replace('_', '', ucwords($name, '_')).'AsString';
                if(method_exists($object,$function)) {
                    $field->setValue($object->$function());
                } else {
                    $function = 'get' . str_replace('_', '', ucwords($name, '_'));
                    if (method_exists($object, $function)) {
                        try {
                            $field->setValue($object->$function());
                        } catch (\Exception) {
                            // @TODO: Implement a logger
                        }
                    }
                }
            }
            if($orm && $field instanceof FormField) {
                $this->setFieldPropertiesFromORM($object, $name, $field);
                continue;
            }

            if (property_exists($object, 'dbInfo') && array_key_exists($name, $object::$dbInfo)) {
                $dbType = $object::$dbInfo[$name];
                if (str_contains($dbType, '(')) {
                    $start  = strpos($dbType, '(');
                    $end    = strpos($dbType, ')', $start + 1);
                    $length = $end - $start;
                    $result = substr($dbType, $start + 1, $length - 1);
                    $result = intval($result);
                    if ($result > 0) {
                        $field->setMaxLength($result);
                    }
                }
            }

            // Stock makes things much quicker, so instead of adding these in as an or
            // I'm splitting it out for speed purposes.
            // Eventually, I'd like to remove the second half and only care about instances of model field text;
            if($mft) {
                if(empty($field->getLabel())) {
                    $name = $object->getFieldName(str_replace('[]', '', $field->getNameRaw()));
                    if($name !== null) {
                        $field->setLabel($name);
                    }
                }
                if(empty($field->getHelpText())) {
                    $name = $object->getFieldHelpText(str_replace('[]', '', $field->getNameRaw()));
                    if($name !== null) {
                        $field->setHelpText($name);
                    }
                }
            } else {
                if ($field->getNameRaw() != $this->csrf['name']
                    && method_exists($field, 'getLabel')
                    && empty($field->getLabel())
                    && method_exists($object, 'getFieldName')
                ) {
                    $name = $object->getFieldName(str_replace('[]', '', $field->getNameRaw()));
                    if ($name !== null) {
                        $field->setLabel($name);
                    }
                }
                if (method_exists($field, 'getHelpText')
                    && empty($field->getHelpText())
                    && method_exists($object, 'getFieldHelpText')
                ) {
                    $name = $object->getFieldHelpText(str_replace('[]', '', $field->getNameRaw()));
                    if ($name !== null) {
                        $field->setHelpText($name);
                    }
                }
            }
        }

        return $this;
    }

    /**
     * @param ORMDescriptionInterface $object
     *
     * @return $this
     */
    public function setPropertiesFromObject(ORMDescriptionInterface $object): static
    {

        foreach ($this->fields as $name => $field) {
            if($field instanceof FormField) {
                $this->setFieldPropertiesFromORM($object, $name, $field);
                continue;
            }

            if (property_exists($object, 'dbInfo')
                && array_key_exists($name, $object::$dbInfo)
            ) {
                $dbType = $object::$dbInfo[$name];
                if (str_contains($dbType, '(')) {
                    $start  = strpos($dbType, '(');
                    $end    = strpos($dbType, ')', $start + 1);
                    $length = $end - $start;
                    $result = substr($dbType, $start + 1, $length - 1);
                    $result = intval($result);
                    if ($result > 0) {
                        $field->setMaxLength($result);
                    }
                }
            }
        }

        return $this;
    }

    /**
     * @param ORMDescriptionInterface $cObject
     * @param string                  $fieldName
     *
     * @return void
     */
    protected function setFieldPropertiesFromORM(
        ORMDescriptionInterface $cObject,
        string $fieldName,
        FormField $cField
    ): void
    {
        $label     = $cObject::getORMFieldTitle($fieldName);
        $helpText  = $cObject::getORMFieldHelp($fieldName);
        $descText  = $cObject::getORMFieldDesc($fieldName);
        $maxLength = $cObject::getORMFieldMaxLength($fieldName);

        if(!empty($label) && empty($cField->getLabel())) {
            $cField->setLabel($label);
        }
        if(!empty($helpText) && empty($cField->getHelpText())) {
            $cField->setHelpText($helpText);
        }
        if(!empty($descText) && empty($cField->getUnderLabelHtml())) {
            $cField->setUnderLabelHtml($descText);
        }
        if($maxLength > 0 && $cField->getMaxLength() < 1) {
            $cField->setMaxLength($maxLength);
        }
    }

    /**
     * @param array $values
     *
     * @throws \Exception
     *
     * @return $this
     */
    public function setValues(array $values): static
    {
        foreach ($values as $k => $v) {
            if (!array_key_exists($k, $this->fields)) {
                throw new \Exception('Invalid Field Name:: '.$k);
            }
            $field = $this->fields[$k];
            if (method_exists($field, 'setValue')) {
                $field->setValue($v);
            }
        }

        return $this;
    }

    /**
     * @param string $form
     * @return $this
     */
    public function setRenderForm(string $form): static
    {
        $this->renderArgs['formCurrent'] = $form;

        return $this;
    }

    /**
     * @param array $forms
     * @return $this
     */
    public function setRenderForms(array $forms): static
    {
        $this->renderArgs['formArray'] = $forms;

        return $this;
    }

    /**
     * @param string $url
     * @return $this
     */
    public function setRenderUrlBase(string $url): static
    {
        $this->renderArgs['urlBase'] = $url;

        return $this;
    }

    /**
     * @param string $url
     * @return $this
     */
    public function setRenderUrlForm(string $url): static
    {
        $this->renderArgs['urlCurrent'] = $url;

        return $this;
    }

    /**
     * @return array
     */
    public function getTwigArray(): array
    {
        return [
            'FC_Config'     => $this,
            'form'          => $this->twigTemplate,
            'activeForm'    => $this->renderArgs['formCurrent'],
            'forms'         => $this->renderArgs['formArray'],
            'route'         => $this->renderArgs['urlBase'],
            'formUrl'       => $this->renderArgs['urlCurrent'],
            'twigOverrides' => $this->twigOverrides,
            'formId'        => $this->getFormId(),
            'holdOn'        => $this->useHoldOn,
            $this->name     => $this->fields,
        ];
    }

    /**
     * @return array
     */
    public function getTwigOverrides(): array
    {
        return $this->twigOverrides;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function getRenderArg(string $key): mixed
    {
        return $this->renderArgs[$key] ?? null;
    }


    /**
     * @throws \Exception
     *
     * @return array
     */
    public function getRenderFields(): array
    {
        if (empty($this->name)) {
            throw new \Exception('Name must be set first');
        }

        return [$this->name => $this->fields];
    }

    /**
     * Useful for building override defaults.
     *
     * @param string $mode
     *
     * @return $this
     */
    public function setDefaults(string $mode): static
    {
        switch ($mode) {
            case 'delete':
                $html = Twig::get()->render(self::$formMode.'/overrides/delete_button.twig');
                $this->setOverride('panelClass', 'danger')
                    ->setOverride('submitButton', $html);
                break;
            case 'activate':
                $this->setOverride('panelClass', 'success')
                    ->setOverride('submitButton', '<input type="submit" class="btn btn-success" value="Activate">');
                break;
            case 'add_more':
                $id = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyz'), 0, 10);
                $id = 'submitBtn_'.$id;

                $this->setOverride('submitButton', '
                    <input type="hidden" name="submitMode" class="submitMode" value="C">
                    <button class="btn btn-default '.$id.'" value="C">Save &amp; Continue</button>
                    <button class="btn btn-default '.$id.'" value="A">Save &amp; Add More</button>
                    <script type="text/javascript">
                        $(function(){
                            $(".'.$id.'").click(function(e){
                                e.preventDefault();
                                $(this).siblings(".submitMode").val($(this).val());
                                $(this).closest("form").submit();
                            });
                        });
                    </script>
                ');
                break;
            case 'continue_or_stay':
                $id = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyz'), 0, 10);
                $id = 'submitBtn_'.$id;

                $this->setOverride('submitButton', '
                    <input type="hidden" name="submitMode" class="submitMode" value="C">
                    <button class="btn btn-default '.$id.'" value="C">Save &amp; Continue</button>
                    <button class="btn btn-default '.$id.'" value="A">Save &amp; Stay on This Page</button>
                    <script type="text/javascript">
                        $(function(){
                            $(".'.$id.'").click(function(e){
                                e.preventDefault();
                                $(this).siblings(".submitMode").val($(this).val());
                                $(this).closest("form").submit();
                            });
                        });
                    </script>
                ');
                break;
        }

        return $this;
    }

    /**
     * @return FormField[]
     */
    public function getFormFields(): array
    {
        return $this->fields;
    }

    /**
     * @param array $fields
     * @return void
     * @throws \Exception
     */
    public function setFormFields(array $fields): void
    {
        foreach($fields as $id => $field) {
            if(!($field instanceof FormField)) {
                throw new \Exception('Not a valid form field :: '.$id);
            }
        }

        $this->fields = $fields;
    }


    /**
     * @param callable|null $postProcess
     *
     * @return void
     */
    public function makeReadOnly(callable $postProcess = null): void
    {
        $this->isReadOnly = true;
        $this->makeFieldsReadOnly($this->fields);

        if($postProcess !== null) {
            call_user_func($postProcess, $this);
        }
    }

    /**
     * @param FormField $field
     *
     * @return void
     */
    public static function makeFieldReadOnly(FormField &$field): void
    {
        $field->makeReadOnly();
    }

    /**
     * @param array $fields
     *
     * @return void
     */
    protected function makeFieldsReadOnly(array &$fields): void
    {
        foreach ($fields as &$field) {
            if ($field instanceof FormField) {
                self::makeFieldReadOnly($field);
            } elseif ($field instanceof FormArrayElement) {
                $field->makeFieldsReadOnly();
            }
        }
    }

    /**
     * @return FieldCreate
     */
    public function getBuilder(): FieldCreate
    {
        if($this->builder == null) {
            $this->builder = new FieldCreate($this);
        }
        return $this->builder;
    }

    /**
     * @param FCHook $hook
     * @return $this
     */
    public function addHook(FCHook $hook): static
    {
        $this->hooks[] = $hook;

        return $this;
    }

    /**
     * @param int $index
     * @return $this
     */
    public function removeHook(int $index): static
    {
        unset($this->hooks[$index]);

        return $this;
    }

    /**
     * @return array
     */
    public function getHooks(): array
    {
        return $this->hooks;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setSimpleFormWrappingClass(string $value): static
    {
        $this->simpleFormWrappingClass = $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getSimpleFormWrappingClass(): string
    {
        return $this->simpleFormWrappingClass;
    }

    /**
     * @return bool
     */
    public function isReadOnly(): bool
    {
        return $this->isReadOnly;
    }

    /**
     * @return bool
     */
    public function doDebug(): bool
    {
        $config = Config::getInstance()->getConfig();
        if(isset($config['debugging'])
            && $config['debugging']['enabled']
            && isset($config['debugging']['userCheckMethod'])
            && $config['debugging']['userCheckMethod'] != ''
        ) {
            return call_user_func($config['debugging']['userCheckMethod']);
        }

        return false;
    }

    /**
     * @return string|null
     */
    public function getCSRFTokenName(): ?string
    {
        return $this->csrf['name'];
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setNavigationTitle(string $title): static
    {
        $this->navigationTitle = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getNavigationTitle(): string
    {
        return $this->navigationTitle;
    }

    /**
     * @param string $html
     * @return $this
     */
    public function setNavigationRight(string $html): static
    {
        $this->navigationRight = $html;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getNavigationRight(): ?string
    {
        return $this->navigationRight;
    }

    /**
     * @param bool $wrap
     * @return $this
     */
    public function setWrapped(bool $wrap): static
    {
        $this->isWrapped = $wrap;

        return $this;
    }

    /**
     * @return bool
     */
    public function isWrapped(): bool
    {
        return $this->isWrapped;
    }

    /**
     * @param string $method
     * @return $this
     */
    public function setMethod(string $method): static
    {
        $this->method = strtoupper($method);

        return $this;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }


    /**
     * @return string
     */
    public function getRenderForm(): string
    {
        return $this->renderArgs['formCurrent'] ?? '';
    }

    /**
     * @return array
     */
    public function getRenderForms(): array
    {
        return $this->renderArgs['formArray'] ?? [];
    }

    /**
     * @return array
     */
    public function getUnattributedErrors(): array
    {
        return $this->unattributedErrors;
    }
}
