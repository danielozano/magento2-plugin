<?php
/**
 * Copyright © Squeezely B.V. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Squeezely\Plugin\Console\Command\Product;

use Magento\Framework\Console\Cli;
use Squeezely\Plugin\Service\ItemUpdate\SyncAll;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Sync invalidated products via command line
 */
class SyncInvalidated extends Command
{

    /**
     * Command call name
     */
    public const COMMAND_NAME = 'squeezely:product:sync-invalidated';
    /**
     * @var SyncAll
     */
    private $syncAll;

    /**
     * SyncInvalidated constructor.
     *
     * @param SyncAll $syncAll
     */
    public function __construct(
        SyncAll $syncAll
    ) {
        $this->syncAll = $syncAll;
        parent::__construct();
    }

    /**
     * @inheritdoc
     */
    public function configure()
    {
        $this->setName(self::COMMAND_NAME);
        $this->setDescription('Squeezely: Sync product');
        parent::configure();
    }

    /**
     * @inheritdoc
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $results = $this->syncAll->execute();
        foreach ($results as $result) {
            if ($result['success']) {
                $output->writeln('<info>' . $result['message'] . '</info>');
            } else {
                $output->writeln('<error>' . $result['message'] . '</error>');
            }
        }

        return Cli::RETURN_SUCCESS;
    }
}
