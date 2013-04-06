<?php

namespace Higgs\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'forum' table.
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
class ForumTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'Higgs.Model.map.ForumTableMap';

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
        $this->setName('forum');
        $this->setPhpName('Forum');
        $this->setClassname('Higgs\\Model\\Forum');
        $this->setPackage('Higgs.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('title', 'Title', 'VARCHAR', true, 255, null);
        $this->addForeignKey('category_id', 'CategoryId', 'INTEGER', 'category', 'id', true, null, null);
        $this->addForeignKey('last_post_id', 'LastPostId', 'INTEGER', 'post', 'id', false, null, null);
        $this->addColumn('nb_subjects', 'NbSubjects', 'INTEGER', true, null, 0);
        // validators
        $this->addValidator('title', 'minLength', 'propel.validator.MinLengthValidator', '1', 'Title must be at least 1 character(s) !');
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Category', 'Higgs\\Model\\Category', RelationMap::MANY_TO_ONE, array('category_id' => 'id', ), null, null);
        $this->addRelation('LastPost', 'Higgs\\Model\\Post', RelationMap::MANY_TO_ONE, array('last_post_id' => 'id', ), null, null);
        $this->addRelation('Subject', 'Higgs\\Model\\Subject', RelationMap::ONE_TO_MANY, array('id' => 'forum_id', ), null, null, 'Subjects');
    } // buildRelations()

} // ForumTableMap
