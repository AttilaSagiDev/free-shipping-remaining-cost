<?php
/**
 * Copyright (c) 2024 Attila Sagi
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 */

declare(strict_types=1);

namespace Space\FreeShippingRemainingCost\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Widget\Block\BlockInterface;
use Space\FreeShippingRemainingCost\ViewModel\ContentMessage;

class Widget extends Template implements BlockInterface
{
    /**
     * @var ContentMessage
     */
    private ContentMessage $contentMessage;

    /**
     * Constructor
     *
     * @param Context $context
     * @param ContentMessage $contentMessage
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        ContentMessage $contentMessage,
        array $data = []
    ) {
        $this->contentMessage = $contentMessage;
        parent::__construct($context, $data);
    }

    /**
     * Before to html handler
     *
     * @return $this
     */
    protected function _beforeToHtml(): static
    {
        $this->setData('view_model', $this->contentMessage);
        return parent::_beforeToHtml();
    }
}
