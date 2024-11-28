<?php

namespace WonderWp\Component\Panel\Metabox;

interface MetaboxInterface
{
    const CONTEXT_NORMAL = 'normal';
    const CONTEXT_ADVANCED = 'advanced';
    const CONTEXT_SIDE = 'side';

    const PRIORITY_HIGH = 'high';
    const PRIORITY_CORE = 'core';
    const PRIORITY_DEFAULT = 'default';
    const PRIORITY_LOW = 'low';

    /**
     * Get Meta box ID
     * @return string
     */
    public function getId(): string;

    /**
     * Set Meta box ID (used in the 'id' attribute of the add_meta_box function).
     * @see https://developer.wordpress.org/reference/functions/add_meta_box/
     * @param string $id
     * @return mixed
     */
    public function setId(string $id): static;

    /**
     * Get Meta box title
     * @return string
     */
    public function getTitle(): string;

    /**
     * Set Meta box title (used in the 'title' attribute of the add_meta_box function).
     * @see https://developer.wordpress.org/reference/functions/add_meta_box/
     * @param string $title
     *
     * @return static
     */
    public function setTitle(string $title): static;

    /**
     * Get the callback function to display the meta box content
     * @return callable
     */
    public function getCallback(): callable;

    /**
     * Set the callback function to display the meta box content
     * The function should echo its output.
     * @see https://developer.wordpress.org/reference/functions/add_meta_box/
     * @param callable $callback
     * @return static
     */
    public function setCallback(callable $callback): static;

    /**
     * Get the screen(s) to which the meta box will be added
     * @return array
     */
    public function getScreens(): ?array;

    /**
     * Set the screen(s) to which the meta box will be added
     * @see https://developer.wordpress.org/reference/functions/add_meta_box/
     * @param array $screens
     * @return mixed
     */
    public function setScreens(?array $screens): static;

    /**
     * Get the context within the screen where the boxes should display.
     * @return string
     */
    public function getContext(): string;

    /**
     * Set the context within the screen where the boxes should display.
     * @see https://developer.wordpress.org/reference/functions/add_meta_box/
     * @param string $context
     * @return mixed
     */
    public function setContext(string $context): static;

    /**
     * Get the priority within the context where the boxes should show.
     * @return string
     */
    public function getPriority(): string;

    /**
     * Set the priority within the context where the boxes should show.
     * @see https://developer.wordpress.org/reference/functions/add_meta_box/
     * @param string $priority
     * @return mixed
     */
    public function setPriority(string $priority): static;

    /**
     * Get the callback arguments
     * @return array
     */
    public function getCallbackArgs(): ?array;

    /**
     * Set the callback arguments
     * @see https://developer.wordpress.org/reference/functions/add_meta_box/
     * @param array $callbackArgs
     * @return mixed
     */
    public function setCallbackArgs(?array $callbackArgs): static;
}
