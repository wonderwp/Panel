<?php

namespace WonderWp\Component\Panel\Metabox;

class Metabox implements MetaboxInterface
{
    /** @var string */
    protected $id;

    /** @var string */
    protected $title;

    /** @var callable */
    protected $callback;

    /** @var array */
    protected $screens;

    /** @var string */
    protected $context = MetaboxInterface::CONTEXT_ADVANCED;

    /** @var string */
    protected $priority = MetaboxInterface::PRIORITY_DEFAULT;

    /** @var ?array */
    protected $callbackArgs;

    /**
     * @param string $id
     * @param string $title
     * @param callable $callback
     * @param array|null $screens
     * @param string $context
     * @param string $priority
     * @param array|null $callbackArgs
     */
    public function __construct(
        string   $id = '',
        string   $title = '',
        ?callable $callback = null,
        ?array   $screens = null,
        string   $context = MetaboxInterface::CONTEXT_ADVANCED,
        string   $priority = MetaboxInterface::PRIORITY_DEFAULT,
        ?array   $callbackArgs = null
    )
    {
        $this->id = $id;
        $this->title = $title;
        $this->callback = $callback;
        $this->screens = $screens;
        $this->context = $context;
        $this->priority = $priority;
        $this->callbackArgs = $callbackArgs;
    }

    /** @inheritDoc */
    public function getId(): string
    {
        return $this->id;
    }

    /** @inheritDoc */
    public function setId(string $id): static
    {
        $this->id = $id;
        return $this;
    }

    /** @inheritDoc */
    public function getTitle(): string
    {
        return $this->title;
    }

    /** @inheritDoc */
    public function setTitle(string $title): static
    {
        $this->title = $title;
        return $this;
    }

    /** @inheritDoc */
    public function getCallback(): callable
    {
        return $this->callback;
    }

    /** @inheritDoc */
    public function setCallback(callable $callback): static
    {
        $this->callback = $callback;
        return $this;
    }

    /** @inheritDoc */
    public function getScreens(): ?array
    {
        return $this->screens;
    }

    /** @inheritDoc */
    public function setScreens(?array $screens): static
    {
        $this->screens = $screens;
        return $this;
    }

    /** @inheritDoc */
    public function getContext(): string
    {
        return $this->context;
    }

    /** @inheritDoc */
    public function setContext(string $context): static
    {
        $this->context = $context;
        return $this;
    }

    /** @inheritDoc */
    public function getPriority(): string
    {
        return $this->priority;
    }

    /** @inheritDoc */
    public function setPriority(string $priority): static
    {
        $this->priority = $priority;
        return $this;
    }

    /** @inheritDoc */
    public function getCallbackArgs(): ?array
    {
        return $this->callbackArgs;
    }

    /** @inheritDoc */
    public function setCallbackArgs(?array $callbackArgs): static
    {
        $this->callbackArgs = $callbackArgs;
        return $this;
    }
}
