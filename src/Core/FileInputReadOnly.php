<?php
namespace GCWorld\FormConfig\Core;

use GCWorld\FormConfig\Fields\FileInput;
use GCWorld\FormConfig\Fields\HTML;
use GCWorld\FormConfig\Forms\FormField;

/**
 * Class FileInputReadOnly
 */
class FileInputReadOnly
{
    /**
     * @param FormField $field
     * @return void
     */
    public static function makeReadOnly(FormField $field)
    {
        if(empty($field->getValue())) {
            $field->setValue('No File Selected');
        } else {
            $val = $field->getValue();
            $field->setValue(self::getValue($val));
        }

        $field->setType(HTML::getKey());
    }

    /**
     * @param mixed $val
     */
    protected static function getValue($val)
    {

        if(is_array($val) && isset($val['url'])) {
            $url  = $val['url'];
            $name = $val['name'] ?? $val['url'];
            $id   = $val['id'] ?? null;

            $val = new FileInputObject();
            $val->setFileId($id);
            $val->setFileName($name);
            $val->setFileUrl($url);
            // Intentionally failover
        }

        if($val instanceof FileInputObject) {
            $html  = '<div>';
            $html .= '<a href="'.$val->getFileUrl().'"';
            if($val->getFileId() !== null) {
                $html .= ' data-file_id="'.str_replace('"',"'",$val->getFileId()).'"';
            }
            $html .= '>'.$val->getFileName().'</a>';
            $html .= '</div>';
            return $html;
        }

        return '';
    }
}