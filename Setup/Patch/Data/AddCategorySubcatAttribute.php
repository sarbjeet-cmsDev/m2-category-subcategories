<?php

declare (strict_types = 1);

namespace Mgenius\Subcategories\Setup\Patch\Data;

use Magento\Catalog\Model\Category;
use Magento\Catalog\Setup\CategorySetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;

/**
 * Create Category Subcatgory Enabled/Disabled Attribute
 */
class AddCategorySubcatAttribute implements DataPatchInterface {

	/**
	 * Attribute name
	 */
	const ATTRIBUTE_CODE = 'subcats_enable';

	/**
	 * @var CategorySetupFactory
	 */
	private $categorySetupFactory;

	/**
	 * @var ModuleDataSetupInterface
	 */
	private $moduleDataSetup;

	/**
	 * @param CategorySetupFactory     $categorySetupFactory
	 * @param ModuleDataSetupInterface $moduleDataSetup
	 */
	public function __construct(
		CategorySetupFactory $categorySetupFactory,
		ModuleDataSetupInterface $moduleDataSetup
	) {
		$this->categorySetupFactory = $categorySetupFactory;
		$this->moduleDataSetup = $moduleDataSetup;
	}

	public function apply() {

		$catalogSetup = $this->categorySetupFactory->create(['setup' => $this->moduleDataSetup]);
		$catalogSetup->addAttribute(
			Category::ENTITY,
			self::ATTRIBUTE_CODE,
			[
	            'type'          => 'int',
	            'label'         => 'Display',
	            'input'         => 'select',
	            'source'        => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',
	            'global'        =>  ScopedAttributeInterface::SCOPE_STORE,
	            'required'      =>  false,
	            'default'       =>  false,
	            'group'         =>  "Child Categories",
	            'sort_order'    =>  10,
	        ]
		);

		return $this;
	}

	/**
	 * @return array
	 */
	public static function getDependencies(): array
	{
		return [];
	}

	/**
	 * @return string
	 */
	public static function getVersion(): string {
		return '1.0.3';
	}

	/**
	 * @return array
	 */
	public function getAliases(): array
	{
		return [];
	}
}
