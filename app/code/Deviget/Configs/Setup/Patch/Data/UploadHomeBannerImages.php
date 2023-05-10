<?php

namespace Deviget\Configs\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Cms\Model\PageFactory;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Driver\File;

class UploadHomeBannerImages implements DataPatchInterface
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
        // Local Image Patch
        $localFilePath = __DIR__ . '/../../media/slider1.png';

        // Destination in Pub Media
        $bannerImagesPath = 'sparsh/banner/image/s/l';

        // Upload the file to the banner folder
        $mediaPath = $this->directoryList->getPath(DirectoryList::MEDIA);
        $destinationPath = $mediaPath . '/' . $bannerImagesPath;

        if (!$this->fileDriver->isExists($destinationPath)) {
            $this->fileDriver->createDirectory($destinationPath, 0777);
        }

        $destinationFilePath = $destinationPath . '/' . basename($localFilePath);
        $this->fileDriver->copy($localFilePath, $destinationFilePath);

        $this->fileDriver->deleteFile($localFilePath);

        // Local Image Patch
        $localFilePath = __DIR__ . '/../../media/slider2.png';

        // Upload the file to the WYSIWYG folder
        $mediaPath = $this->directoryList->getPath(DirectoryList::MEDIA);
        $destinationPath = $mediaPath . '/' . $bannerImagesPath;

        if (!$this->fileDriver->isExists($destinationPath)) {
            $this->fileDriver->createDirectory($destinationPath, 0777);
        }

        $destinationFilePath = $destinationPath . '/' . basename($localFilePath);
        $this->fileDriver->copy($localFilePath, $destinationFilePath);

        $this->fileDriver->deleteFile($localFilePath);
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
