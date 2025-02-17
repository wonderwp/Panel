<?php

namespace WonderWp\Component\Panel\PostFieldPanel;

use WonderWp\Component\Form\Field\FieldInterface;
use WonderWp\Component\Panel\Metabox\Metabox;

class PostFieldPanel extends Metabox
{
    /** @var FieldInterface[] */
    protected $fields = [];

    /** @var array */
    protected $postTypes = [];

    /** @inheritdoc */
    public function getFields()
    {
        return $this->fields;
    }

    /** @inheritdoc */
    public function setFields(array $fields)
    {
        $this->fields = $fields;

        return $this;
    }

    /** @deprecated Use getScreens instead */
    public function getPostTypes()
    {
        return $this->getScreens();
    }

    /** @deprecated Use setScreens instead */
    public function setPostTypes(array $postTypes)
    {
        return $this->setScreens($postTypes);
    }

    public static function formatToDb($value)
    {
        if (is_array($value) || is_object($value)) {
            $value = json_encode($value);
        }
        if (is_string($value)) {
            $value = stripslashes($value);
        }//Because request adds a /

        return $value;
    }

    public static function formatFromDb($value)
    {
        if ($value == 'on') {
            $value = 1;
        } elseif (is_serialized($value)) {
            $value = unserialize($value);
        } elseif (is_string($value) && self::isJson($value)) {
            //Fix unicode escaping
            $value = preg_replace('/u([0-9a-fA-F]{4})/', '\\u\1', $value);
            //Then json decode
            $value = json_decode($value, true);
        }

        return $value;
    }

    public static function isJson( $argument, $ignore_scalars = true ) {
        if ( ! is_string( $argument ) || '' === $argument ) {
            return false;
        }

        if ( $ignore_scalars && ! in_array( $argument[0], [ '{', '[' ], true ) ) {
            return false;
        }

        json_decode( $argument, $assoc = true );

        return json_last_error() === JSON_ERROR_NONE;
    }
}
