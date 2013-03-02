<?php

namespace Higgs\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'role' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    propel.generator.Higgs.Model.map
 */
class RoleTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'Higgs.Model.map.RoleTableMap';

    /**
     * Initialize the table attributes, columns and validators
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('role');
        $this->setPhpName('Role');
        $this->setClassname('Higgs\\Model\\Role');
        $this->setPackage('Higgs.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('name', 'Name', 'VARCHAR', true, 50, null);
        // validators
        $this->addValidator('name', 'minLength', 'propel.validator.MinLengthValidator', '1', 'name must be at least 1 character(s) !');
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('UserRole', 'Higgs\\Model\\UserRole', RelationMap::ONE_TO_MANY, array('id' => 'role_id', ), null, null, 'UserRoles');
        $this->addRelation('User', 'Higgs\\Model\\User', RelationMap::MANY_TO_MANY, array(), null, null, 'Users');
    } // buildRelations()

} // RoleTableMap
