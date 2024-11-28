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

    public function formatToDb($value)
    {
        if (is_array($value) || is_object($value)) {
            $value = serialize($value);
        }
        if (is_string($value)) {
            $value = stripslashes($value);
        }//Because request adds a /

        return $value;
    }

    public function formatFromDb($value)
    {
        if ($value == 'on') {
            $value = 1;
        } elseif (is_serialized($value)) {
            $value = unserialize($value);
        }

        return $value;
    }
}
