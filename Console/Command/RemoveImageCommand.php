<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\RemoveImage\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RemoveImageCommand extends Command
{
    private $catalogProduct;
    private $appState;

    public function __construct(
        \Magento\Framework\App\State $appState,
        \Magento\RemoveImage\Model\CatalogProduct $catalogProduct
    ) {
        $this->appState = $appState;
        $this->catalogProduct = $catalogProduct;
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $options = [];
        $this->setName('removeimage:catalogproduct')
            ->setDescription('Remove all images from all products')
            ->setDefinition($options);
        parent::configure();
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->appState->setAreaCode(\Magento\Framework\App\Area::AREA_GLOBAL);
        $this->catalogProduct->RemoveImage($output);
        $output->writeln('<info>' . 'Images removed.' . '</info>');
    }
}
