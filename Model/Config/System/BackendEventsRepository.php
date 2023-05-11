<?php
/**
 * Copyright © Squeezely B.V. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Squeezely\Plugin\Model\Config\System;

use Squeezely\Plugin\Api\Config\RepositoryInterface;
use Squeezely\Plugin\Api\Config\System\BackendEventsInterface;

/**
 * Backend Events provider class
 */
class BackendEventsRepository extends AdvancedOptionsRepository implements BackendEventsInterface
{

    /**
     * @inheritDoc
     */
    public function isBackendEventEnabled(string $eventName): bool
    {
        return $this->isBackendEventsEnabled() && in_array($eventName, $this->getEnabledBackendEvents());
    }

    /**
     * @inheritDoc
     */
    public function isBackendEventsEnabled(int $storeId = null): bool
    {
        return $this->getFlag(RepositoryInterface::XML_PATH_ENABLED, $storeId)
            && $this->getFlag(self::XML_PATH_BACKEND_EVENTS_ENABLED, $storeId);
    }

    /**
     * @inheritDoc
     */
    public function getEnabledBackendEvents(int $storeId = null): array
    {
        return explode(
            ',',
            $this->getStoreValue(self::XML_PATH_BACKEND_EVENTS_EVENTS, $storeId)
        );
    }

    /**
     * @inheritDoc
     */
    public function getPoolSize(): int
    {
        return (int)$this->getStoreValue(
            self::XML_PATH_BACKEND_EVENTS_POOL_SIZE
        );
    }
}
