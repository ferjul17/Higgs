<?php

namespace Higgs\Model\Map;

use Higgs\Model\Forum;
use Higgs\Model\ForumQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


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
 */
class ForumTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;
    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'Higgs.Model.Map.ForumTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'Higgs';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'forum';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Higgs\\Model\\Forum';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Higgs.Model.Forum';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 6;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 6;

    /**
     * the column name for the ID field
     */
    const ID = 'forum.ID';

    /**
     * the column name for the TITLE field
     */
    const TITLE = 'forum.TITLE';

    /**
     * the column name for the CATEGORY_ID field
     */
    const CATEGORY_ID = 'forum.CATEGORY_ID';

    /**
     * the column name for the LAST_POST_ID field
     */
    const LAST_POST_ID = 'forum.LAST_POST_ID';

    /**
     * the column name for the NB_SUBJECTS field
     */
    const NB_SUBJECTS = 'forum.NB_SUBJECTS';

    /**
     * the column name for the NB_POSTS field
     */
    const NB_POSTS = 'forum.NB_POSTS';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Id', 'Title', 'CategoryId', 'LastPostId', 'NbSubjects', 'NbPosts', ),
        self::TYPE_STUDLYPHPNAME => array('id', 'title', 'categoryId', 'lastPostId', 'nbSubjects', 'nbPosts', ),
        self::TYPE_COLNAME       => array(ForumTableMap::ID, ForumTableMap::TITLE, ForumTableMap::CATEGORY_ID, ForumTableMap::LAST_POST_ID, ForumTableMap::NB_SUBJECTS, ForumTableMap::NB_POSTS, ),
        self::TYPE_RAW_COLNAME   => array('ID', 'TITLE', 'CATEGORY_ID', 'LAST_POST_ID', 'NB_SUBJECTS', 'NB_POSTS', ),
        self::TYPE_FIELDNAME     => array('id', 'title', 'category_id', 'last_post_id', 'nb_subjects', 'nb_posts', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Title' => 1, 'CategoryId' => 2, 'LastPostId' => 3, 'NbSubjects' => 4, 'NbPosts' => 5, ),
        self::TYPE_STUDLYPHPNAME => array('id' => 0, 'title' => 1, 'categoryId' => 2, 'lastPostId' => 3, 'nbSubjects' => 4, 'nbPosts' => 5, ),
        self::TYPE_COLNAME       => array(ForumTableMap::ID => 0, ForumTableMap::TITLE => 1, ForumTableMap::CATEGORY_ID => 2, ForumTableMap::LAST_POST_ID => 3, ForumTableMap::NB_SUBJECTS => 4, ForumTableMap::NB_POSTS => 5, ),
        self::TYPE_RAW_COLNAME   => array('ID' => 0, 'TITLE' => 1, 'CATEGORY_ID' => 2, 'LAST_POST_ID' => 3, 'NB_SUBJECTS' => 4, 'NB_POSTS' => 5, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'title' => 1, 'category_id' => 2, 'last_post_id' => 3, 'nb_subjects' => 4, 'nb_posts' => 5, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
    );

    /**
     * Initialize the table attributes and columns
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
        $this->setClassName('\\Higgs\\Model\\Forum');
        $this->setPackage('Higgs.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('TITLE', 'Title', 'VARCHAR', true, 255, null);
        $this->addForeignKey('CATEGORY_ID', 'CategoryId', 'INTEGER', 'category', 'ID', true, null, null);
        $this->addForeignKey('LAST_POST_ID', 'LastPostId', 'INTEGER', 'post', 'ID', false, null, null);
        $this->addColumn('NB_SUBJECTS', 'NbSubjects', 'INTEGER', true, null, 0);
        $this->addColumn('NB_POSTS', 'NbPosts', 'INTEGER', true, null, 0);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Category', '\\Higgs\\Model\\Category', RelationMap::MANY_TO_ONE, array('category_id' => 'id', ), null, null);
        $this->addRelation('LastPost', '\\Higgs\\Model\\Post', RelationMap::MANY_TO_ONE, array('last_post_id' => 'id', ), null, null);
        $this->addRelation('Subject', '\\Higgs\\Model\\Subject', RelationMap::ONE_TO_MANY, array('id' => 'forum_id', ), null, null, 'Subjects');
    } // buildRelations()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {

            return (int) $row[
                            $indexType == TableMap::TYPE_NUM
                            ? 0 + $offset
                            : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
                        ];
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? ForumTableMap::CLASS_DEFAULT : ForumTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     * @return array (Forum object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = ForumTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = ForumTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + ForumTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = ForumTableMap::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            ForumTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = ForumTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = ForumTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                ForumTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(ForumTableMap::ID);
            $criteria->addSelectColumn(ForumTableMap::TITLE);
            $criteria->addSelectColumn(ForumTableMap::CATEGORY_ID);
            $criteria->addSelectColumn(ForumTableMap::LAST_POST_ID);
            $criteria->addSelectColumn(ForumTableMap::NB_SUBJECTS);
            $criteria->addSelectColumn(ForumTableMap::NB_POSTS);
        } else {
            $criteria->addSelectColumn($alias . '.ID');
            $criteria->addSelectColumn($alias . '.TITLE');
            $criteria->addSelectColumn($alias . '.CATEGORY_ID');
            $criteria->addSelectColumn($alias . '.LAST_POST_ID');
            $criteria->addSelectColumn($alias . '.NB_SUBJECTS');
            $criteria->addSelectColumn($alias . '.NB_POSTS');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(ForumTableMap::DATABASE_NAME)->getTable(ForumTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getServiceContainer()->getDatabaseMap(ForumTableMap::DATABASE_NAME);
      if (!$dbMap->hasTable(ForumTableMap::TABLE_NAME)) {
        $dbMap->addTableObject(new ForumTableMap());
      }
    }

    /**
     * Performs a DELETE on the database, given a Forum or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Forum object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ForumTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Higgs\Model\Forum) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(ForumTableMap::DATABASE_NAME);
            $criteria->add(ForumTableMap::ID, (array) $values, Criteria::IN);
        }

        $query = ForumQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) { ForumTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) { ForumTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the forum table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return ForumQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Forum or Criteria object.
     *
     * @param mixed               $criteria Criteria or Forum object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ForumTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Forum object
        }

        if ($criteria->containsKey(ForumTableMap::ID) && $criteria->keyContainsValue(ForumTableMap::ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.ForumTableMap::ID.')');
        }


        // Set the correct dbName
        $query = ForumQuery::create()->mergeWith($criteria);

        try {
            // use transaction because $criteria could contain info
            // for more than one table (I guess, conceivably)
            $con->beginTransaction();
            $pk = $query->doInsert($con);
            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $pk;
    }

} // ForumTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
ForumTableMap::buildTableMap();
