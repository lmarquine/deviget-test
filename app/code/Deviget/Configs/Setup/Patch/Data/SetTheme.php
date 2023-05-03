<?php

namespace Deviget\Configs\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Theme\Model\ResourceModel\Theme\CollectionFactory as ThemeCollectionFactory;
use Magento\Theme\Model\Config as ThemeConfig;
use Magento\Store\Model\Store;
use Magento\Framework\App\Config\ScopeConfigInterface;

class SetTheme implements DataPatchInterface
{
    const THEME_NAME = 'Deviget/theme-test';

    private $themeCollectionFactory;
    private $themeConfig;

    public function __construct(
        ThemeCollectionFactory $themeCollectionFactory,
        ThemeConfig $themeConfig
    ) {
        $this->themeCollectionFactory = $themeCollectionFactory;
        $this->themeConfig = $themeConfig;
    }

    public static function getDependencies()
    {
        return [];
    }

    public function getAliases()
    {
        return [];
    }

    public function apply()
    {
        $this->assignTheme();
    }

    protected function assignTheme()
    {
        $themes = $this->themeCollectionFactory->create()->loadRegisteredThemes();
        foreach ($themes as $theme) {

            if ($theme->getCode() == self::THEME_NAME) {
                $this->themeConfig->assignToStore(
                    $theme,
                    [Store::DEFAULT_STORE_ID],
                    ScopeConfigInterface::SCOPE_TYPE_DEFAULT
                );
            }
        }
    }
}
