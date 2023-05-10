<?php
/**
 *
 * @author      Deviget Core Team <contact@deviget.com>
 * @copyright   2023 Deviget (https://deviget.com)
 * @license     https://deviget.com Copyright
 * @link        https://deviget.com
 *
 */

namespace Deviget\Configs\Setup\Patch\Data;

use Magento\Cms\Model\PageFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class UpdateHomePage implements DataPatchInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var PageFactory
     */
    private $pageFactory;
    /**
     * @var \Magento\Cms\Model\ResourceModel\Page
     */
    private $pageResource;

    /**
     * AddNewCmsPage constructor.
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param PageFactory $pageFactory
     * @param \Magento\Cms\Model\ResourceModel\Page $pageResource
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        PageFactory $pageFactory,
        \Magento\Cms\Model\ResourceModel\Page $pageResource
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->pageFactory = $pageFactory;
        $this->pageResource = $pageResource;
    }

    /**
     * {@inheritdoc}
     */
    public function apply()
    {
        $content = <<<HTML
<style>#html-body [data-pb-style=K5WXBLM]{justify-content:flex-start;display:flex;flex-direction:column;background-position:left top;background-size:cover;background-repeat:no-repeat;background-attachment:scroll}</style><div data-content-type="row" data-appearance="contained" data-element="main"><div data-enable-parallax="0" data-parallax-speed="0.5" data-background-images="{}" data-background-type="image" data-video-loop="true" data-video-play-only-visible="true" data-video-lazy-load="true" data-video-fallback-src="" data-element="inner" data-pb-style="K5WXBLM"><div class="product-slider" data-content-type="products" data-appearance="carousel" data-autoplay="false" data-autoplay-speed="4000" data-infinite-loop="false" data-show-arrows="false" data-show-dots="true" data-carousel-mode="default" data-center-padding="90px" data-element="main">{{widget type="Magento\CatalogWidget\Block\Product\ProductsList" template="Magento_PageBuilder::catalog/product/widget/content/carousel.phtml" anchor_text="" id_path="" show_pager="0" products_count="20" condition_option="category_ids" condition_option_value="3" type_name="Catalog Products Carousel" conditions_encoded="^[`1`:^[`aggregator`:`all`,`new_child`:``,`type`:`Magento||CatalogWidget||Model||Rule||Condition||Combine`,`value`:`1`^],`1--1`:^[`operator`:`==`,`type`:`Magento||CatalogWidget||Model||Rule||Condition||Product`,`attribute`:`category_ids`,`value`:`3`^]^]" sort_order="position"}}</div></div></div>
HTML;

        $pageIdentifier = 'Home page';
        $cmsPageModel = $this->pageFactory->create()->load($pageIdentifier, 'title');
        $cmsPageModel->setContent($content);
        $cmsPageModel->setTitle('Deviget Store');
        $cmsPageModel->setContentHeading('');
        $cmsPageModel->save();
    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies()
    {
        return [
            UploadHomeBannerImages::class
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }
}
