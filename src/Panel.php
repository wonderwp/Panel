<?php

namespace WonderWp\Component\Panel;

use WonderWp\Component\Form\Field\FieldInterface;

class Panel implements PanelInterface
{
    /** @var string */
    protected $id;
    /** @var string */
    protected $title;
    /** @var FieldInterface[] */
    protected $fields = [];
    /** @var array */
    protected $postTypes = [];

    /** @inheritdoc */
    public function getId()
    {
        return $this->id;
    }

    /** @inheritdoc */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /** @inheritdoc */
    public function getTitle()
    {
        return $this->title;
    }

    /** @inheritdoc */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

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

    /** @inheritdoc */
    public function getPostTypes()
    {
        return $this->postTypes;
    }

    /** @inheritdoc */
    public function setPostTypes(array $postTypes)
    {
        $this->postTypes = $postTypes;

        return $this;
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
