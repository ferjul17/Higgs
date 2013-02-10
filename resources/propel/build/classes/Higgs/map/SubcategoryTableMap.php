<?php



/**
 * This class defines the structure of the 'subcategory' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    propel.generator.Higgs.map
 */
class SubcategoryTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'Higgs.map.SubcategoryTableMap';

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
        $this->setName('subcategory');
        $this->setPhpName('Subcategory');
        $this->setClassname('Subcategory');
        $this->setPackage('Higgs');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('TITLE', 'Title', 'VARCHAR', true, 255, null);
        $this->addForeignKey('CATEGORY_ID', 'CategoryId', 'INTEGER', 'category', 'ID', true, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Category', 'Category', RelationMap::MANY_TO_ONE, array('category_id' => 'id', ), null, null);
        $this->addRelation('Subject', 'Subject', RelationMap::ONE_TO_MANY, array('id' => 'subcategory_id', ), null, null, 'Subjects');
    } // buildRelations()

} // SubcategoryTableMap
