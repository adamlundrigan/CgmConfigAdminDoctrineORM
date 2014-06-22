<?php
return array(
    'doctrine' => array(
        'driver' => array(
            'cgmconfigadmin_entity' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\XmlDriver',
                'paths' => __DIR__ . '/xml/cgmconfigadmin'
            ),
            'cgmconfigadmindoctrineorm_entity' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\XmlDriver',
                'paths' => __DIR__ . '/xml/cgmconfigadmindoctrineorm'
            ),

            'orm_default' => array(
                'drivers' => array(
                    'CgmConfigAdmin\Entity'  => 'cgmconfigadmin_entity',
                    'CgmConfigAdminDoctrineORM\Entity'  => 'cgmconfigadmindoctrineorm_entity',
                )
            )
        )
    ),
);
