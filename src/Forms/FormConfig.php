<?php
namespace GCWorld\FormConfig\Forms;

use GCWorld\ORM\FieldName;

/**
 * Class FormConfig.
 */
class FormConfig
{
    const OVERRIDE_SUBMIT      = 'submitButton';
    const OVERRIDE_PANEL_CLASS = 'panelClass';

    protected $name          = '';
    protected $formId        = '';
    protected $twigTemplate  = '';
    protected $twigOverrides = [];
    protected $fields        = [];
    protected $formArrays    = [];

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $id
     *
     * @return $this
     */
    public function setFormId(string $id)
    {
        $this->formId = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getFormId()
    {
        if ('' != $this->formId) {
            return $this->formId;
        }

        return 'form_'.$this->name;
    }

    /**
     * @param string $key
     * @param string $value
     *
     * @return $this
     */
    public function setOverride(string $key, string $value)
    {
        $this->twigOverrides[$key] = $value;

        return $this;
    }

    /**
     * @param string $fileName
     *
     * @return $this
     */
    public function setTwigTemplate(string $fileName)
    {
        $this->twigTemplate = $fileName;

        return $this;
    }

    /**
     * @return string
     */
    public function getTwigTemplate()
    {
        return $this->twigTemplate;
    }

    /**
     * @param FormField $field
     *
     * @return $this
     */
    public function addFieldObject(FormField $field)
    {
        $this->fields[$field->getNameRaw()] = $field;

        return $this;
    }

    /**
     * @param string $name
     *
     * @return FormField
     */
    public function createField(string $name)
    {
        $field               = new FormField($name);
        $this->fields[$name] = $field;

        return $field;
    }

    /**
     * @param string $name
     *
     * @return FormArrayElement
     */
    public function createFieldArray(string $name)
    {
        $field               = new FormArrayElement();
        $this->fields[$name] = $field;

        return $field;
    }

    /**
     * @param array $requirements
     *
     * @return $this
     */
    public function setRequirements(array $requirements)
    {
        if (count($requirements) > 0) {
            //Iterate fields.
            foreach ($requirements as $name => $level) {
                if (array_key_exists($name, $this->fields)) {
                    /** @var \GCWorld\FormConfig\Forms\FormField $field */
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
    public function setErrors(array $errors)
    {
        if (count($errors) > 0) {
            //Iterate fields.
            foreach ($errors as $name => $err) {
                if (array_key_exists($name, $this->fields)) {
                    /** @var \GCWorld\FormConfig\Forms\FormField $field */
                    $field = $this->fields[$name];
                    $field->addError($err);
                }
            }
        }

        return $this;
    }

    /**
     * @param mixed $object
     *
     * @return $this
     */
    public function setValuesFromObject($object)
    {
        foreach ($this->fields as $name => $field) {
            /** @var \GCWorld\FormConfig\Forms\FormField $field */
            if (property_exists($object, $name) && method_exists($field, 'setValue')) {
                $function = FieldName::getterName($name);
                $field->setValue($object->$function());
            }
            if (property_exists($object, 'dbInfo') && array_key_exists($name, $object::$dbInfo)) {
                $dbType = $object::$dbInfo[$name];
                if (strstr($dbType, '(')) {
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
            if (method_exists($field, 'getLabel') && empty($field->getLabel()) && method_exists(
                $object,
                'getFieldName'
            )
            ) {
                $field->setLabel($object->getFieldName(str_replace('[]', '', $field->getName())));
            }
        }

        return $this;
    }

    /**
     * @param array $values
     *
     * @throws \Exception
     *
     * @return $this
     */
    public function setValues(array $values)
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
     * @param array  $formsArray
     * @param string $currentForm
     * @param string $baseRoute
     * @param string $formUrl
     *
     * @return array
     */
    public function getRenderArray(array $formsArray, string $currentForm, string $baseRoute, string $formUrl)
    {
        return [
            'form'          => $this->twigTemplate,
            'activeForm'    => $currentForm,
            'forms'         => $formsArray,
            'route'         => $baseRoute,
            'formUrl'       => $formUrl,
            'twigOverrides' => $this->twigOverrides,
            'formId'        => $this->getFormId(),
            $this->name     => $this->fields,
        ];
    }

    /**
     * @throws \Exception
     *
     * @return array
     */
    public function getRenderFields()
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
    public function setDefaults(string $mode)
    {
        switch ($mode) {
            case 'delete':
                $this->setOverride('panelClass', 'danger')
                    ->setOverride('submitButton', '<input type="submit" class="btn btn-danger" value="Delete">');
                break;
            case 'activate':
                $this->setOverride('panelClass', 'success')
                    ->setOverride('submitButton', '<input type="submit" class="btn btn-success" value="Activate">');
                break;
            case 'add_more':
                $this->setOverride('submitButton', '
                    <button name="submitMode" type="submit" class="btn btn-default" value="C">Save &amp; Continue</button>
                    <button name="submitMode" type="submit" class="btn btn-default" value="A">Save &amp; Add More</button>
                ');
                break;
            case 'continue_or_stay':
                $this->setOverride('submitButton', '
                    <button name="submitMode" type="submit" class="btn btn-default" value="C">Save &amp; Continue</button>
                    <button name="submitMode" type="submit" class="btn btn-default" value="A">Save &amp; Stay on This Page</button>
                ');
                break;
        }

        return $this;
    }

    /**
     * @return FormField[]
     */
    public function getFormFields()
    {
        return $this->fields;
    }

    /**
     * @return void
     */
    public function makeReadOnly()
    {
        $this->makeFieldsReadOnly($this->fields);
    }

    /**
     * @param \GCWorld\FormConfig\Forms\FormField $field
     *
     * @return void
     */
    public static function makeFieldReadOnly(FormField &$field)
    {
        switch ($field->getType()) {
            case FormField::TYPE_SELECT_SINGLE:
            case FormField::TYPE_SELECT2_HTML_SINGLE:
            case FormField::TYPE_SELECT_AJAX_SINGLE:
                if (array_key_exists($field->getValue(), $field->getOptions())) {
                    $opts = $field->getOptions();
                    $field->setType(FormField::TYPE_STATIC)
                        ->setValue($opts[$field->getValue()])
                        ->setOptions([]);
                } else {
                    $field->setType(FormField::TYPE_STATIC)->setOptions([])->setValue('- Not Set -');
                }
                break;
            case FormField::TYPE_SELECT_MULTI:
            case FormField::TYPE_SELECT2_HTML_MULTI:
            case FormField::TYPE_SELECT_AJAX_MULTI:
                $opts = $field->getOptions();
                $vals = is_array($field->getValue()) ? $field->getValue() : [$field->getValue()];
                $text = [];
                foreach ($vals as $val) {
                    if (array_key_exists($val, $opts)) {
                        $text[] = $opts[$val];
                    }
                }
                $field->setType(FormField::TYPE_STATIC)->setOptions([]);
                if (count($text) > 0) {
                    $field->setValue(implode(', ', $text));
                } else {
                    $field->setValue(' - Not Set - ');
                }
                break;
            case FormField::TYPE_CHECKBOX:
            case FormField::TYPE_CHECKBOX_CENTERED:
            case FormField::TYPE_TOGGLE_TRUE_FALSE:
                $val = $field->getValue();
                $field->setValue($val ? 'Yes' : 'No')->setType(FormField::TYPE_STATIC);
                break;
            case FormField::TYPE_COLORPICKER:
                $field->setValue('Color Picker Here')->setType(FormField::TYPE_HTML);
                break;
            case FormField::TYPE_TOGGLE_YES_NO:
                $val = $field->getValue();
                $field->setValue('Y' == $val ? 'Yes' : 'No')->setType(FormField::TYPE_STATIC);
                break;
            case FormField::TYPE_FILE_INPUT:
            case FormField::TYPE_FILE_INPUT_MULTI:
            case FormField::TYPE_FILEMANAGER:
                $field->setValue('File Input Here')->setType(FormField::TYPE_STATIC);
                break;
            case FormField::TYPE_HIDDEN:
                $field->setValue('');
                break;
            default:
                $field->setType(FormField::TYPE_STATIC);
                break;
        }
    }

    /**
     * @param array $fields
     *
     * @return void
     */
    private function makeFieldsReadOnly(array &$fields)
    {
        foreach ($fields as &$field) {
            if ($field instanceof FormField) {
                self::makeFieldReadOnly($field);
            } elseif ($field instanceof FormArrayElement) {
                $field->makeFieldsReadOnly();
            }
        }
    }
}
