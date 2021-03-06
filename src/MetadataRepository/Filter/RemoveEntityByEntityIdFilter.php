<?php

namespace OpenConext\Component\EngineBlockMetadata\MetadataRepository\Filter;

use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\QueryBuilder;
use OpenConext\Component\EngineBlockMetadata\Entity\AbstractRole;

/**
 * Class RemoveEntityByEntityIdFilter
 * @package OpenConext\Component\EngineBlockMetadata\MetadataRepository\Filter
 */
class RemoveEntityByEntityIdFilter extends AbstractFilter
{
    /**
     * @var string
     */
    private $entityId;

    /**
     * @param string $entityId
     */
    public function __construct($entityId)
    {
        $this->entityId = $entityId;
    }

    /**
     * {@inheritdoc}
     */
    public function filterRole(AbstractRole $role)
    {
        return $role->entityId === $this->entityId ? null : $role;
    }

    /**
     * {@inheritdoc}
     */
    public function toQueryBuilder(QueryBuilder $queryBuilder, $repositoryClassName)
    {
        return $queryBuilder
            ->andWhere('role.entityId <> :removeEntityId')
            ->setParameter('removeEntityId', $this->entityId);
    }

    /**
     * {@inheritdoc}
     */
    public function toExpression($repositoryClassName)
    {
        return Criteria::expr()->neq('entityId', $this->entityId);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return parent::__toString() . ' -> ' . $this->entityId;
    }
}
