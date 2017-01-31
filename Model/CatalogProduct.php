<?php
namespace Magento\RemoveImage\Model;

use Magento\Catalog\Api\ProductAttributeMediaGalleryManagementInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;

class CatalogProduct
{
    private $productRepository;
    private $searchCriteriaBuilder;
    private $mediaGalleryManagement;

    public function __construct(
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        ProductAttributeMediaGalleryManagementInterface $mediaGalleryManagement
    ) {
        $this->productRepository = $productRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->mediaGalleryManagement = $mediaGalleryManagement;
    }

    public function RemoveImage($output)
    {
        $searchCriteria = $this->searchCriteriaBuilder->create();
        $searchResults = $this->productRepository->getList($searchCriteria);
        if ($searchResults->getTotalCount() > 0) {
            foreach ($searchResults->getItems() as $item) {
                $media = $this->mediaGalleryManagement->getList($item->getSku());
                if (count($media) > 0) {
                    foreach ($media as $mediaItem) {
                        $this->mediaGalleryManagement->remove($item->getSku(), $mediaItem->getId());
                    }
                }
                $output->write(".");
            }
            $output->write(PHP_EOL);
        }
    }
}
