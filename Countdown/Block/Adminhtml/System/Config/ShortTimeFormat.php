<?php

namespace Ctidigital\Countdown\Block\Adminhtml\System\Config;

use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;

class ShortTimeFormat extends Field
{
    /**
     * There is no way to extend element, another than override it
     *
     * @param AbstractElement $abstractElement
     * @return string
     */
    protected function _getElementHtml(AbstractElement $abstractElement)
    {
        $abstractElement->addClass('select admin__control-select');

        $valueHrs = 0;
        $valueMin = 0;

        if ($value = $abstractElement->getValue()) {
            $values = explode(',', $value);
            if (is_array($values) && count($values) == 2) {
                $valueHrs = $values[0];
                $valueMin = $values[1];
            }
        }

        $html = '<input type="hidden" id="' . $abstractElement->getHtmlId() . '" />';
        $html .= '<select name="' . $abstractElement->getName() . '" style="width:80px" '
            . $abstractElement->serialize($abstractElement->getHtmlAttributes()) . '>';
        //Add empty option if time was not specified
        $html .= '<option value="">--</option>';

        for ($i = 0; $i < 24; $i++) {
            $hour = str_pad($i, 2, '0', STR_PAD_LEFT);
            $html .= '<option value="' . $hour . '" ' . ($valueHrs && $valueHrs ==
                $i ? 'selected="selected"' : '') . '>' . $hour . '</option>';
        }
        $html .= '</select>' . "\n";

        $html .= '<span class="time-separator">:&nbsp;</span><select name="'
            . $abstractElement->getName() . '" style="width:80px" '
            . $abstractElement->serialize($abstractElement->getHtmlAttributes()) . '>';
        //Add empty option if time was not specified
        $html .= '<option value="">--</option>';
        for ($i = 0; $i < 60; $i++) {
            $hour = str_pad($i, 2, '0', STR_PAD_LEFT);
            $html .= '<option value="' . $hour . '" ' . ($valueMin && $valueMin ==
                $i ? 'selected="selected"' : '') . '>' . $hour . '</option>';
        }
        $html .= '</select>' . "\n";

        $html .= $abstractElement->getAfterElementHtml();
        return $html;
    }
}
