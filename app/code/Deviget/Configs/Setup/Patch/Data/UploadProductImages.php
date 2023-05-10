<?php

namespace Deviget\Configs\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Cms\Model\PageFactory;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Driver\File;

class UploadProductImages implements DataPatchInterface
{
    const PRODUCT_IMAGES = array('t-shirt-1.png','t-shirt-1_1.png','t-shirt-4_1.png','t-shirt-6_1.png');

    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;
    /**
     * @var PageFactory
     */
    private $pageFactory;
    /**
     * @var DirectoryList
     */
    private $directoryList;
    /**
     * @var Filesystem
     */
    private $filesystem;
    /**
     * @var File
     */
    private $fileDriver;

    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        PageFactory $pageFactory,
        DirectoryList $directoryList,
        Filesystem $filesystem,
        File $fileDriver
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->pageFactory = $pageFactory;
        $this->directoryList = $directoryList;
        $this->filesystem = $filesystem;
        $this->fileDriver = $fileDriver;
    }

    public function apply()
    {
        foreach (self::PRODUCT_IMAGES as $image) {
            // Local Image Patch
            $localFilePath = __DIR__ . '/../../media/' . $image;

            // Destination in Pub Media
            $imageLocal = 'catalog/product/t/-';

            // Upload the file to the catalog folder
            $mediaPath = $this->directoryList->getPath(DirectoryList::MEDIA);
            $destinationPath = $mediaPath . '/' . $imageLocal;

            if (!$this->fileDriver->isExists($destinationPath)) {
                $this->fileDriver->createDirectory($destinationPath, 0777);
            }

            $destinationFilePath = $destinationPath . '/' . basename($localFilePath);
            $this->fileDriver->copy($localFilePath, $destinationFilePath);
        }
    }

    public function getAliases()
    {
        return [];
    }

    public static function getDependencies()
    {
        return [];
    }
}
