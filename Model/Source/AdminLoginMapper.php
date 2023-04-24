<?php

namespace MageEasy\DevTools\Model\Source;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;

class AdminLoginMapper extends AbstractFieldArray
{
    protected $_directoryList;

    public function __construct(
        \Magento\Framework\App\Filesystem\DirectoryList $directoryList,
        \Magento\Backend\Block\Template\Context $context,
        $data = []
    ) {
        $this->_directoryList = $directoryList;
        parent::__construct($context, $data);
    }

    /**
     * {@inheritdoc}
     */
    protected function _prepareToRender()
    {
        $this->addColumn('role', ['label' => __('Name/Role'), 'class' => 'required-entry']);
        $this->addColumn('username', ['label' => __('Username'), 'class' => 'required-entry']);
        $this->addColumn('password', ['label' => __('Password'), 'class' => 'required-entry']);

        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add');
    }

    public function renderCellTemplate($columnName)
    {
        if (empty($this->_columns[$columnName])) {
            throw new \Exception('Wrong column name specified.');
        }
        $column = $this->_columns[$columnName];
        $inputName = $this->_getCellInputElementName($columnName);

        if ($column['renderer']) {
            return $column['renderer']->setInputName(
                $inputName
            )->setInputId(
                $this->_getCellInputElementId('<%- _id %>', $columnName)
            )->setColumnName(
                $columnName
            )->setColumn(
                $column
            )->toHtml();
        }

            return '<input type="text" id="' . $this->_getCellInputElementId(
                '<%- _id %>',
                $columnName
            ) .
                '"' .
                ' name="' .
                $inputName .
                '" value="<%- ' .
                $columnName .
                ' %>" ' .
                ($column['size'] ? 'size="' .
                    $column['size'] .
                    '"' : '') .
                ' class="' .
                (isset($column['class'])
                    ? $column['class']
                    : 'input-text') . '"' . (isset($column['style']) ? ' style="' . $column['style'] . '"' : '') . '/>';
    }
}
