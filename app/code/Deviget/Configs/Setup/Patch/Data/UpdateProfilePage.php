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
use Magento\Framework\Setup\Patch\PatchInterface;
use Magento\Store\Model\ResourceModel\Website;
use Magento\Store\Model\WebsiteFactory;
use Magento\Framework\App\Config\Storage\WriterInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;

class UpdateProfilePage implements DataPatchInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var Website
     */
    private $website;

    /**
     * @var WriterInterface
     */
    private $writerInterface;

    /**
     * @var WebsiteFactory
     */
    private $websiteFactory;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var PageFactory
     */
    private $pageFactory;
    /**
     * @var \Magento\Cms\Model\ResourceModel\Page
     */
    private $pageResource;

    /**
     * const CODE_WEBSITE
     */
    const CODE_WEBSITE = ["base"];

    /**
     * AddNewCmsPage constructor.
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param PageFactory $pageFactory
     * @param \Magento\Cms\Model\ResourceModel\Page $pageResource
     * @param Website $website
     * @param WriterInterface $writerInterface
     * @param WebsiteFactory $websiteFactory
     * @param StoreManager $storeManager
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        PageFactory $pageFactory,
        \Magento\Cms\Model\ResourceModel\Page $pageResource,
        Website $website,
        WriterInterface $writerInterface,
        WebsiteFactory $websiteFactory,
        StoreManagerInterface $storeManager
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->pageFactory = $pageFactory;
        $this->pageResource = $pageResource;
        $this->website = $website;
        $this->writerInterface = $writerInterface;
        $this->websiteFactory = $websiteFactory;
        $this->storeManager = $storeManager;
    }

    /**
     * @param \Magento\Store\Model\Website $website
     */
    private function CreateProfilePage(\Magento\Store\Model\Website $website): void
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $content = <<<HTML
<style>#html-body [data-pb-style=XCPN7V4]{justify-content:flex-start;display:flex;flex-direction:column;background-position:left top;background-size:cover;background-repeat:no-repeat;background-attachment:scroll}#html-body [data-pb-style=Y0B9PJJ]{text-align:center;border-style:none}#html-body [data-pb-style=IE10VK3],#html-body [data-pb-style=Q8JT38C]{max-width:100%;height:auto}@media only screen and (max-width: 768px) { #html-body [data-pb-style=Y0B9PJJ]{border-style:none} }</style><div class="profile-page top-row" data-content-type="row" data-appearance="full-width" data-enable-parallax="0" data-parallax-speed="0.5" data-background-images="{}" data-background-type="image" data-video-loop="true" data-video-play-only-visible="true" data-video-lazy-load="true" data-video-fallback-src="" data-element="main" data-pb-style="XCPN7V4"><div class="row-full-width-inner" data-element="inner"><figure class="hire-img" data-content-type="image" data-appearance="full-width" data-element="main" data-pb-style="Y0B9PJJ"><img class="pagebuilder-mobile-hidden" src="{{media url=/wysiwyg/banner-me.jpg}}" alt="" title="" data-element="desktop_image" data-pb-style="Q8JT38C"><img class="pagebuilder-mobile-only" src="{{media url=/wysiwyg/banner-me.jpg}}" alt="" title="" data-element="mobile_image" data-pb-style="IE10VK3"></figure><h2 class="profile-page heading" data-content-type="heading" data-appearance="default" data-element="main">About Me</h2><div class="profile-page about-me" data-content-type="text" data-appearance="default" data-element="main"><p><span id="U9EHLYN" style="font-size: 28px;">Hey there! I'm <strong>Leonardo</strong>, a passionate and dedicated Magento Developer since <strong>2014</strong>.</span></p>
<p>&nbsp;</p>
<p><span id="WVXO6W0" style="font-size: 28px;">My journey began with Magento 1, and I've been immersed in the world of <strong>Magento 2</strong> since <strong>2018</strong>.</span></p>
<p>&nbsp;</p>
<p><span style="font-size: 28px;">My passion for creating seamless and engaging digital experiences has kept me going all these years.</span></p></div><h2 class="profile-page heading" data-content-type="heading" data-appearance="default" data-element="main">Experiences</h2><div data-content-type="text" data-appearance="default" data-element="main"><p><span id="L0PFIG4" style="font-size: 28px;">As a versatile <strong>developer</strong>, my expertise lies in <strong>frontend development</strong>, but I also have a <strong>little</strong> share of experience in <strong>backend development</strong>. I pride myself on my ability to create visually appealing and user-friendly web solutions, while keeping a keen eye on the technical aspects.</span></p>
<p>&nbsp;</p>
<p><span style="font-size: 28px;">Throughout my career, I've had the honor of working with some of the <strong>most prestigious clients</strong>, including <strong>Nestlé</strong>, <strong>Ambev</strong>, <strong>Laureate</strong> <strong>Group</strong>, <strong>Editora do Brasil</strong>, <strong>Todo Livro</strong>, <strong>Elgin</strong>, <strong>Arco</strong>, and <strong>Galderma</strong>, among others.</span></p>
<p>&nbsp;</p>
<p><span style="font-size: 28px;">These experiences have not only <strong>expanded</strong> my <strong>skillset</strong> but also taught me the importance of <strong>delivering</strong> top-notch work tailored to the specific needs of each client.</span></p>
<p>&nbsp;</p>
<p><span style="font-size: 28px;">Currently, I'm pursuing a degree in <strong>Internet Systems</strong>, with my graduation set for <strong>2023</strong>. This program is sharpening my knowledge of cutting-edge web technologies and <strong>best practices</strong>, allowing me to stay ahead of the game in this rapidly evolving industry.</span></p>
<p>&nbsp;</p>
<p><span style="font-size: 28px;">As your go-to <strong>Magento Developer</strong>, I am excited to bring my creativity, technical know-how, and commitment to excellence to your next project.</span></p>
<p>&nbsp;</p>
<p><span style="font-size: 28px;">Together, let's create a digital experience that leaves a lasting impression!</span></p></div></div></div>
HTML;

        $pageIdentifier = 'Profile Page';
        $cmsPageModel = $this->pageFactory->create()->load($pageIdentifier, 'title');
        $cmsPageModel->setIdentifier('profile-page');
        $cmsPageModel->setStores([$website->getStoreId()]);
        $cmsPageModel->setTitle('Profile Page');
        $cmsPageModel->setContentHeading('');
        $cmsPageModel->setPageLayout('1column');
        $cmsPageModel->setIsActive(1);
        $cmsPageModel->setContent($content)->save();

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     * {@inheritdoc}
     */
    public function apply()
    {

        $websites = $this->storeManager->getWebsites();
        foreach ($websites as $web) {
            if (in_array($web->getCode(), self::CODE_WEBSITE)) {
                $website = $this->websiteFactory->create();
                $website->load($web->getCode());
                $this->createProfilePage($website);
            }
        }

    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies()
    {
        return [
            UploadProfilePageImage::class
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
