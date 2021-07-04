<?php

namespace Genius\Subcategories\Setup;

use Magento\Catalog\Model\Category;
use Magento\Catalog\Setup\CategorySetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{
    private $catalogSetupFactory;

    public function __construct(
        CategorySetupFactory $categorySetupFactory

    ) {
        $this->catalogSetupFactory = $categorySetupFactory;
    }

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $catalogSetup = $this->catalogSetupFactory->create(['setup' => $setup]);

        $code = 'subcats_enable';
        $attribute  = [
            'type'          => 'int',
            'label'         => 'Display',
            'input'         => 'select',
            'source'        => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',
            'global'        =>  \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
            'required'      =>  false,
            'default'       =>  false,
            'group'         =>  "Child Categories",
            'sort_order'    =>  10,
        ];
        $catalogSetup->addAttribute(Category::ENTITY, $code, $attribute);
    }
}