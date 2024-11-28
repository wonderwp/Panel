<?php

namespace WonderWp\Component\Panel\PostFieldPanel;

use WonderWp\Component\Form\Field\FieldInterface;
use WonderWp\Component\Panel\Metabox\MetaboxInterface;

interface PostFieldPanelInterface extends MetaboxInterface
{
    /**
     * @return FieldInterface[]
     */
    public function getFields();

    /**
     * @param FieldInterface[] $fields
     *
     * @return static
     */
    public function setFields(array $fields);

    /**
     * @return array
     */
    public function getPostTypes();

    /**
     * @param array $postTypes
     *
     * @return static
     */
    public function setPostTypes(array $postTypes);

    /**
     * @param mixed $value
     *
     * @return mixed
     */
    public function formatToDb($value);

    /**
     * @param mixed $value
     *
     * @return mixed
     */
    public function formatFromDb($value);
}
