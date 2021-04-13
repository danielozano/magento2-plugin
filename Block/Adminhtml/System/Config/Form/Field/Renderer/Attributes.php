<?php
/**
 * Copyright © Squeezely B.V. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Squeezely\Plugin\Block\Adminhtml\System\Config\Form\Field\Renderer;

use Magento\Framework\View\Element\Context;
use Magento\Framework\View\Element\Html\Select;
use Squeezely\Plugin\Model\Config\Source\Attributes as AttributesSource;

/**
 * HTML select for Product Attributes
 */
class Attributes extends Select
{

    /**
     * @var array
     */
    private $attribute = [];
    /**
     * @var AttributesSource
     */
    private $attributes;

    /**
     * Attributes constructor.
     *
     * @param Context $context
     * @param AttributesSource $attributes
     * @param array $data
     */
    public function __construct(
        Context $context,
        AttributesSource $attributes,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->attributes = $attributes;
    }

    /**
     * @inheritDoc
     */
    public function _toHtml()
    {
        if (!$this->getOptions()) {
            foreach ($this->getAttributeSource() as $attribute) {
                $this->addOption($attribute['value'], $attribute['label']);
            }
        }

        return parent::_toHtml();
    }

    /**
     * Get all attributes
     *
     * @return array
     */
    private function getAttributeSource(): array
    {
        if (!$this->attribute) {
            $this->attribute = $this->attributes->toOptionArray();
        }

        return $this->attribute;
    }

    /**
     * Sets name for input element
     *
     * @param string $value
     *
     * @return mixed
     */
    public function setInputName(string $value)
    {
        return $this->setData('name', $value);
    }
}
