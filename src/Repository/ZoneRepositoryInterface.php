<?php

namespace CommerceGuys\Zone\Repository;

/**
 * Zone repository interface.
 */
interface ZoneRepositoryInterface
{
    /**
     * Returns a zone instance matching the provided zone id.
     *
     * @param string $id The zone id.
     *
     * @return ZoneInterface
     */
    public function get($id);

    /**
     * Returns all available zone instances.
     *
     * @param string $scope An optional scope to filter zones by.
     *
     * @return array An array of zones implementing the ZoneInterface,
     *               keyed by zone id.
     */
    public function getAll($scope = null);
}
