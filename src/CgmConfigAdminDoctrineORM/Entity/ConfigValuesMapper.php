<?php 
namespace CgmConfigAdminDoctrineORM\Entity;

use CgmConfigAdmin\Entity\ConfigValuesMapperInterface;
use Doctrine\ORM\EntityManager;
use CgmConfigAdminDoctrineORM\Options\ModuleOptions;

class ConfigValuesMapper implements ConfigValuesMapperInterface
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * @var \CgmConfigAdminDoctrineORM\Options\ModuleOptions
     */
    protected $options;

    /**
     * @var string
     */
    protected $tableName = 'configadminvalues';

    public function __construct(EntityManager $em, ModuleOptions $options)
    {
        $this->em = $em;
        $this->options = $options;
    }

    public function find($id)
    {
        $er = $this->em->getRepository('CgmConfigAdminDoctrineORM\Entity\ConfigValues');
        return $er->find($id);
    }

    public function save($configValues)
    {
        $this->em->persist($configValues);
        $this->em->flush();
    }

    public function setTableName($table)
    {
        $this->tableName = $table;
        return $this;
    }
}
