<?php
namespace CgmConfigAdminDoctrineORM\Options;

use CgmConfigAdmin\Options\ModuleOptions as BaseOptions;

class ModuleOptions extends BaseOptions
{
    protected $enableDefaultEntities = true;

    public function getEnableDefaultEntities()
    {
        return $this->enableDefaultEntities;
    }

    public function setEnableDefaultEntities($tf)
    {
        $this->enableDefaultEntities = ($tf == true);
        return $this;
    }
}
