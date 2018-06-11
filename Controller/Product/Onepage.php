<?php
/**
 * GiaPhuGroup Co., Ltd.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the GiaPhuGroup.com license that is
 * available through the world-wide-web at this URL:
 * https://www.giaphugroup.com/LICENSE.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    PHPCuong
 * @package     PHPCuong_OnePageProducts
 * @copyright   Copyright (c) 2018-2019 GiaPhuGroup Co., Ltd. All rights reserved. (http://www.giaphugroup.com/)
 * @license     https://www.giaphugroup.com/LICENSE.txt
 */

namespace PHPCuong\OnePageProducts\Controller\Product;

class Onepage extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Catalog\Api\CategoryRepositoryInterface
     */
    protected $categoryRepository;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Catalog\Api\CategoryRepositoryInterface $categoryRepository
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Catalog\Api\CategoryRepositoryInterface $categoryRepository,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->_coreRegistry = $coreRegistry;
        $this->categoryRepository = $categoryRepository;
        $this->_storeManager = $storeManager;
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $store = $this->_storeManager->getStore();
        $category = $this->categoryRepository->get(
            $store->getRootCategoryId()
        );

        $this->_coreRegistry->register('current_category', $category);

        $page = $this->resultPageFactory->create();
        $page->getLayout()->getBlock('page.main.title')->setPageTitle(__('One Page Products'));
        $page->getLayout()->getBlock('breadcrumbs')->addCrumb(
            'home',
            [
                'label' => __('Home'),
                'title' => __('Go to Home Page'),
                'link' => $store->getBaseUrl()
            ]
        )->addCrumb(
            'product-tag',
            [
                'label' => __('One Page Products'),
                'title' => __('One Page Products')
            ]
        );
        $page->getConfig()->addBodyClass('page-products');
        $page->getConfig()->getTitle()->set(__('One Page Products'));
        $page->getConfig()->setDescription(__('One Page Products'));
        $page->getConfig()->setKeywords(__('One Page Products'));
        $page->getConfig()->addRemotePageAsset($this->_url->getUrl('phpcuong/product/onepage'), 'canonical', ['attributes' => ['rel' => 'canonical']]);

        return $page;
    }
}
