<?php
namespace GCWorld\FormConfig;

use GCWorld\ORM\FieldName;

/**
 * Class FormConfig
 * @package GCWorld\FormConfig\Forms
 */
class FormConfig
{
    protected $name          = '';
    protected $formId        = '';
    protected $twigTemplate  = '';
    protected $twigOverrides = [];
    protected $fields        = [];
    protected $formArrays    = [];

    /**
     * @param $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
    /**
     * @param $name
     * @return $this
     */
    public function setFormId($id)
    {
        $this->formId = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getFormId()
    {
        if($this->formId != '') {
            return $this->formId;
        }
        return 'form_'.$this->name;
    }

    /**
     * @param $key
     * @param $value
     * @return $this
     */
    public function setOverride($key, $value)
    {
        $this->twigOverrides[$key] = $value;

        return $this;
    }

    /**
     * @param $fileName
     * @return $this
     */
    public function setTwigTemplate($fileName)
    {
        $this->twigTemplate = $fileName;

        return $this;
    }

    /**
     * @param \GCWorld\FormConfig\FormField $field
     * @return $this
     */
    public function addFieldObject(FormField $field)
    {
        $this->fields[$field->getName()] = $field;

        return $this;
    }

    /**
     * @param $name
     * @return \GCWorld\FormConfig\FormField
     */
    public function createField($name)
    {
        $field               = new FormField($name);
        $this->fields[$name] = $field;

        return $field;
    }

    /**
     * @param $name
     * @return \GCWorld\FormConfig\FormArrayElement
     */
    public function createFieldArray($name)
    {
        $field               = new FormArrayElement();
        $this->fields[$name] = $field;

        return $field;
    }

    /**
     * @param array $requirements
     * @return $this
     */
    public function setRequirements(array $requirements)
    {
        if (count($requirements) > 0) {
            //Iterate fields.
            foreach ($requirements as $name => $level) {
                if (array_key_exists($name, $this->fields)) {
                    /** @var \GCWorld\FormConfig\FormField $field */
                    $field = $this->fields[$name];
                    $field->setReqLevel($level);
                }
            }
        }

        return $this;
    }

    /**
     * @param array $errors
     * @return $this
     */
    public function setErrors(array $errors)
    {
        if (count($errors) > 0) {
            //Iterate fields.
            foreach ($errors as $name => $err) {
                if (array_key_exists($name, $this->fields)) {
                    /** @var \GCWorld\FormConfig\FormField $field */
                    $field = $this->fields[$name];
                    $field->addError($err);
                }
            }
        }

        return $this;
    }

    /**
     * @param $object
     * @return $this
     */
    public function setValuesFromObject($object)
    {
        foreach ($this->fields as $name => $field) {
            /** @var \GCWorld\FormConfig\FormField $field */
            if (property_exists($object, $name) && method_exists($field, 'setValue')) {
                $function = FieldName::getterName($name);
                $field->setValue($object->$function());
            }
            if (property_exists($object, 'dbInfo') && array_key_exists($name, $object::$dbInfo)) {
                $dbType = $object::$dbInfo[$name];
                if(strstr($dbType,'(')) {
                    $start  = strpos($dbType, '(');
                    $end    = strpos($dbType, ')', $start + 1);
                    $length = $end - $start;
                    $result = substr($dbType, $start + 1, $length - 1);
                    $result = intval($result);
                    if($result > 0) {
                        $field->setMaxLength($result);
                    }
                }
            }
        }

        return $this;
    }

    /**
     * @param array $formsArray
     * @param       $currentForm
     * @param       $baseRoute
     * @param       $formUrl
     * @return array
     */
    public function getRenderArray(array $formsArray, $currentForm, $baseRoute, $formUrl)
    {
        return array(
            'form'          => $this->twigTemplate,
            'activeForm'    => $currentForm,
            'forms'         => $formsArray,
            'route'         => $baseRoute,
            'formUrl'       => $formUrl,
            'twigOverrides' => $this->twigOverrides,
            'formId'        => $this->getFormId(),
            $this->name     => $this->fields
        );
    }

    /**
     * @return array
     */
    public function getRenderFields()
    {
        if(empty($this->name)) {
            throw new \Exception('Name must be set first');
        }
        return [$this->name => $this->fields];
    }


    /**
     * Useful for building override defaults.
     * @param $mode
     */
    public function setDefaults($mode)
    {
        switch ($mode) {
            case 'delete':
                $this->setOverride('panelClass', 'danger')
                    ->setOverride('submitButton', '<input type="submit" class="btn btn-danger" value="Delete">');
                break;

            case 'add_more':
                $this->setOverride('submitButton', '
                    <button name="submitMode" type="submit" class="btn btn-default" value="C">Save &amp; Continue</button>
                    <button name="submitMode" type="submit" class="btn btn-default" value="A">Save &amp; Add More</button>
                ');
        }
    }
}
