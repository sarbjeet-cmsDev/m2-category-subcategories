<?php
namespace Mgenius\Subcategories\Block;

class ListCategories extends \Magento\Framework\View\Element\Template
{
	protected $_template = "list.phtml";

	protected $category = null;

	protected $storeManager;
	protected $coreRegistry;
	protected $scopeConfig;
	protected $categoryFactory;
	protected $helperImage;

	public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Catalog\Model\CategoryFactory $categoryFactory,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Catalog\Helper\Image $helperImage,
        array $data = []
    ) {    
        $this->storeManager        = $storeManager;
        $this->coreRegistry        = $coreRegistry;
        $this->scopeConfig         = $scopeConfig;
        $this->categoryFactory     = $categoryFactory;
        $this->helperImage         = $helperImage;
        parent::__construct($context, $data);
    }

    public function getChildCategories(){

    	$categories = [];
    	if($categoryId = $this->getParentCategoryId()){
    		$categories = $this->categoryFactory->create()->getCollection()
                            ->addAttributeToSelect(['name', 'url_key', 'url_path', 'image'])
                            ->addAttributeToFilter('parent_id', $categoryId)
                            ->addIsActiveFilter();
    	}
		return $categories;   	

    }

    public function getImageUrl($category){
    	if (!empty($image = $category->getImage())){
    		return $image;
    	}
    	else{
    		return $this->helperImage->getDefaultPlaceholderUrl('small_image');
    	}
    }

    public function getParentCategoryId(){
    	if ($this->getCurrentCategory() && $this->getCurrentCategory()->getSubcatsEnable()) {
    		return $this->getCurrentCategory()->getId();
    	}else if((int)$this->getCategoryId()){
    		return $this->getCategoryId();
    	}
    	return null;
    }

    public function getCurrentCategory()
    {
    	if(!$this->category){
    		return $this->category = $this->coreRegistry->registry('current_category');	
    	}
    	return $this->category;
    }

    public function toHtml()
    {
        if (!$this->getParentCategoryId()) {
            return '';
        }
        return parent::toHtml();
    }
}