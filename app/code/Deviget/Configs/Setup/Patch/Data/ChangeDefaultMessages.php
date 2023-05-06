<?php
/**
 *
 * @author      Deviget Core Team <contact@deviget.com>
 * @copyright   2023 Deviget (https://deviget.com)
 * @license     https://deviget.com Copyright
 * @link        https://deviget.com
 *
 */

declare(strict_types=1);

namespace Deviget\Configs\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchInterface;
use Magento\Store\Model\ResourceModel\Website;
use Magento\Store\Model\WebsiteFactory;
use Magento\Framework\App\Config\Storage\WriterInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;

class ChangeDefaultMessages implements DataPatchInterface
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
     * const CODE_WEBSITE
     */
    const CODE_WEBSITE = ["base"];

    /**
     * Change Default Messages constructor.
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param Website $website
     * @param WriterInterface $writerInterface
     * @param WebsiteFactory $websiteFactory
     * @param StoreManager $storeManager
     */
    public function __construct(

        ModuleDataSetupInterface $moduleDataSetup,
        Website $website,
        WriterInterface $writerInterface,
        WebsiteFactory $websiteFactory,
        StoreManagerInterface $storeManager

    ) {

        $this->moduleDataSetup = $moduleDataSetup;
        $this->website = $website;
        $this->writerInterface = $writerInterface;
        $this->websiteFactory = $websiteFactory;
        $this->storeManager = $storeManager;

    }


    /**
     * @return array
     */
    public static function getDependencies()
    {
        return [];
    }


    /**
     * @return array
     */
    public function getAliases()
    {
        return [];
    }

    /**
     * @param \Magento\Store\Model\Website $website
     */
    private function changeMessages(\Magento\Store\Model\Website $website): void
    {

        $this->moduleDataSetup->getConnection()->startSetup();
        $this->writerInterface->save(
            'design/footer/copyright',
            "All rights reserved © 2023 Deviget Store",
            ScopeInterface::SCOPE_WEBSITES,
            $website->getId()
        );

        $this->moduleDataSetup->getConnection()->startSetup();
        $this->writerInterface->save(
            'design/header/welcome',
            "Welcome to Deviget Store",
            ScopeInterface::SCOPE_WEBSITES,
            $website->getId()
        );

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     * @return void
     */
    public function apply(): void
    {
        $websites = $this->storeManager->getWebsites();
        foreach ($websites as $web) {
            if (in_array($web->getCode(), self::CODE_WEBSITE)) {
                $website = $this->websiteFactory->create();
                $website->load($web->getCode());
                $this->changeMessages($website);
                break;
            }
        }
    }

    /**
     * Rollback all changes, done by this patch
     *
     * @return void
     */
    public function revert()
    {
        $websites = $this->storeManager->getWebsites();

        foreach ($websites as $web) {
            if (in_array($web->getCode(), self::CODE_WEBSITE)) {
                $website = $this->websiteFactory->create();
                $website->load($web->getCode());
                $this->writerInterface->delete(
                    'design/footer/copyright',
                    ScopeInterface::SCOPE_WEBSITES,
                    $website->getId()
                );
                $this->writerInterface->delete(
                    'design/header/welcome',
                    ScopeInterface::SCOPE_WEBSITES,
                    $website->getId()
                );
                break;
            }
        }
    }
}
