<?php

namespace Higgs\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'user' table.
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
class UserTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'Higgs.Model.map.UserTableMap';

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
        $this->setName('user');
        $this->setPhpName('User');
        $this->setClassname('Higgs\\Model\\User');
        $this->setPackage('Higgs.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('username', 'Username', 'VARCHAR', true, 50, null);
        $this->addColumn('password', 'Password', 'VARCHAR', true, 40, null);
        $this->addColumn('salt', 'Salt', 'VARCHAR', true, 40, null);
        $this->addColumn('email', 'Email', 'VARCHAR', true, 255, null);
        $this->addColumn('created_at', 'CreatedAt', 'TIMESTAMP', false, null, null);
        // validators
        $this->addValidator('username', 'minLength', 'propel.validator.MinLengthValidator', '1', 'Username must be at least 1 character(s) !');
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('UserRole', 'Higgs\\Model\\UserRole', RelationMap::ONE_TO_MANY, array('id' => 'user_id', ), null, null, 'UserRoles');
        $this->addRelation('Post', 'Higgs\\Model\\Post', RelationMap::ONE_TO_MANY, array('id' => 'user_id', ), null, null, 'Posts');
        $this->addRelation('PostEdited', 'Higgs\\Model\\Post', RelationMap::ONE_TO_MANY, array('id' => 'editor_id', ), null, null, 'PostEditeds');
        $this->addRelation('Subject', 'Higgs\\Model\\Subject', RelationMap::ONE_TO_MANY, array('id' => 'user_id', ), null, null, 'Subjects');
        $this->addRelation('Role', 'Higgs\\Model\\Role', RelationMap::MANY_TO_MANY, array(), null, null, 'Roles');
    } // buildRelations()

    /**
     *
     * Gets the list of behaviors registered for this table
     *
     * @return array Associative array (name => parameters) of behaviors
     */
    public function getBehaviors()
    {
        return array(
            'timestampable' =>  array (
  'create_column' => 'created_at',
  'update_column' => 'updated_at',
  'disable_updated_at' => 'true',
),
        );
    } // getBehaviors()

} // UserTableMap
