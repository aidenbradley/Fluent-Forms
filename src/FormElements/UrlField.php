<?php

namespace Drupal\fluent_forms\FormElements;

use Drupal\fluent_forms\Base\FormElementBuilder;
use Drupal\link\LinkItemInterface;

class UrlField extends FormElementBuilder
{
    /** @var string|int */
    protected $linkType = LinkItemInterface::LINK_GENERIC;

    public function elementType(): string
    {
        return 'url';
    }

    public function onlyExternalLinks(): self
    {
        $this->linkType = LinkItemInterface::LINK_EXTERNAL;

        return $this;
    }

    public function onlyInternalLinks(): self
    {
        $this->linkType = LinkItemInterface::LINK_INTERNAL;

        return $this;
    }

    public function internalAndExternalLinks(): self
    {
        $this->linkType = LinkItemInterface::LINK_GENERIC;

        return $this;
    }

    public function build(): array
    {
        $build = array_merge(parent::build(), [
            '#link_type' => $this->linkType,
        ]);

        $build['#attributes']['pattern'] = 'https?://.+';
        $build['#attributes']['oninvalid'] = 'this.setCustomValidity(
        \'Please ensure your website link begins with https:// or http://\'
        )';

        return $build;
    }
}
