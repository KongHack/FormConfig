<?php

namespace GCWorld\FormConfig\FormControlElements;

use GCWorld\FormConfig\Core\Twig;

/**
 * FormConfigComplexElement Class.
 */
class FormConfigComplexElement
{
    protected string $key     = '';
    protected string $url     = '';
    protected string $title   = '';
    protected ?string $hover   = null;
    protected ?string $heading = null;
    protected ?string $right   = null;

    /**
     * @param string $key
     * @param string $title
     */
    public function __construct(string $key, string $url, string $title)
    {
        $this->key   = $key;
        $this->url   = $url;
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string|null
     */
    public function getHover(): ?string
    {
        return $this->hover;
    }

    /**
     * @param string|null $hover
     * @return $this
     */
    public function setHover(?string $hover): static
    {
        $this->hover = $hover;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getHeading(): ?string
    {
        return $this->heading;
    }

    /**
     * @param string|null $heading
     * @return $this
     */
    public function setHeading(?string $heading): static
    {
        $this->heading = $heading;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getRight(): ?string
    {
        return $this->right;
    }

    /**
     * @param string|null $right
     * @return $this
     */
    public function setRight(?string $right): static
    {
        $this->right = $right;

        return $this;
    }

    /**
     * @param bool $active
     * @return string
     */
    public function render(bool $active): string
    {
        $ns = str_replace('_REPLACE', '_BS3', Twig::TWIG_NAMESPACE_REPLACE);

        return Twig::render('@' . $ns . '/form_control_elements/complex.twig', [
            'object' => $this,
            'active' => $active,
        ]);
    }
}
