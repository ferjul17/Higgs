<?php



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
 * @package    propel.generator.Higgs.map
 */
class UserTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'Higgs.map.UserTableMap';

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
        $this->setClassname('User');
        $this->setPackage('Higgs');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('USERNAME', 'Username', 'VARCHAR', true, 50, null);
        $this->addColumn('PASSWORD', 'Password', 'VARCHAR', true, 40, null);
        $this->addColumn('EMAIL', 'Email', 'VARCHAR', true, 255, null);
        $this->addColumn('AUTHOR_ID', 'AuthorId', 'INTEGER', true, null, null);
        $this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Post', 'Post', RelationMap::ONE_TO_MANY, array('id' => 'user_id', ), null, null, 'Posts');
        $this->addRelation('Post', 'Post', RelationMap::ONE_TO_MANY, array('id' => 'editor_id', ), null, null, 'Posts');
        $this->addRelation('Post', 'Subject', RelationMap::ONE_TO_MANY, array('id' => 'user_id', ), null, null, 'Posts');
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
            'timestampable' => array('create_column' => 'created_at', 'update_column' => 'updated_at', 'disable_updated_at' => 'true', ),
        );
    } // getBehaviors()

} // UserTableMap
