<?php

namespace Higgs\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'post' table.
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
class PostTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'Higgs.Model.map.PostTableMap';

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
        $this->setName('post');
        $this->setPhpName('Post');
        $this->setClassname('Higgs\\Model\\Post');
        $this->setPackage('Higgs.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('message', 'Message', 'LONGVARCHAR', true, null, null);
        $this->addForeignKey('subject_id', 'SubjectId', 'INTEGER', 'subject', 'id', true, null, null);
        $this->addForeignKey('user_id', 'UserId', 'INTEGER', 'user', 'id', true, null, null);
        $this->addForeignKey('editor_id', 'EditorId', 'INTEGER', 'user', 'id', false, null, null);
        $this->addColumn('created_at', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('updated_at', 'UpdatedAt', 'TIMESTAMP', false, null, null);
        // validators
        $this->addValidator('message', 'minLength', 'propel.validator.MinLengthValidator', '1', 'Message must be at least 1 character(s) !');
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Subject', 'Higgs\\Model\\Subject', RelationMap::MANY_TO_ONE, array('subject_id' => 'id', ), null, null);
        $this->addRelation('User', 'Higgs\\Model\\User', RelationMap::MANY_TO_ONE, array('user_id' => 'id', ), null, null);
        $this->addRelation('Editor', 'Higgs\\Model\\User', RelationMap::MANY_TO_ONE, array('editor_id' => 'id', ), null, null);
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
  'disable_updated_at' => 'false',
),
        );
    } // getBehaviors()

} // PostTableMap
