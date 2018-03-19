<?php

namespace WonderWp\Component\Panel;

use WonderWp\Component\Form\Field\FieldInterface;

interface PanelInterface
{
    /**
     * @return mixed
     */
    public function getId();

    /**
     * @param mixed $id
     *
     * @return static
     */
    public function setId($id);

    /**
     * @return string
     */
    public function getTitle();

    /**
     * @param string $title
     *
     * @return static
     */
    public function setTitle($title);

    /**
     * @return FieldInterface[]
     */
    public function getFields();

    /**
     * @param mixed $fields
     *
     * @return static
     */
    public function setFields($fields);

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

}
