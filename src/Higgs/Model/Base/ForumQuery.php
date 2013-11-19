<?php

namespace Higgs\Model\Base;

use \Exception;
use \PDO;
use Higgs\Model\Forum as ChildForum;
use Higgs\Model\ForumQuery as ChildForumQuery;
use Higgs\Model\Map\ForumTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'forum' table.
 *
 *
 *
 * @method     ChildForumQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildForumQuery orderByTitle($order = Criteria::ASC) Order by the title column
 * @method     ChildForumQuery orderByCategoryId($order = Criteria::ASC) Order by the category_id column
 * @method     ChildForumQuery orderByLastPostId($order = Criteria::ASC) Order by the last_post_id column
 * @method     ChildForumQuery orderByNbSubjects($order = Criteria::ASC) Order by the nb_subjects column
 * @method     ChildForumQuery orderByNbPosts($order = Criteria::ASC) Order by the nb_posts column
 *
 * @method     ChildForumQuery groupById() Group by the id column
 * @method     ChildForumQuery groupByTitle() Group by the title column
 * @method     ChildForumQuery groupByCategoryId() Group by the category_id column
 * @method     ChildForumQuery groupByLastPostId() Group by the last_post_id column
 * @method     ChildForumQuery groupByNbSubjects() Group by the nb_subjects column
 * @method     ChildForumQuery groupByNbPosts() Group by the nb_posts column
 *
 * @method     ChildForumQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildForumQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildForumQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildForumQuery leftJoinCategory($relationAlias = null) Adds a LEFT JOIN clause to the query using the Category relation
 * @method     ChildForumQuery rightJoinCategory($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Category relation
 * @method     ChildForumQuery innerJoinCategory($relationAlias = null) Adds a INNER JOIN clause to the query using the Category relation
 *
 * @method     ChildForumQuery leftJoinLastPost($relationAlias = null) Adds a LEFT JOIN clause to the query using the LastPost relation
 * @method     ChildForumQuery rightJoinLastPost($relationAlias = null) Adds a RIGHT JOIN clause to the query using the LastPost relation
 * @method     ChildForumQuery innerJoinLastPost($relationAlias = null) Adds a INNER JOIN clause to the query using the LastPost relation
 *
 * @method     ChildForumQuery leftJoinSubject($relationAlias = null) Adds a LEFT JOIN clause to the query using the Subject relation
 * @method     ChildForumQuery rightJoinSubject($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Subject relation
 * @method     ChildForumQuery innerJoinSubject($relationAlias = null) Adds a INNER JOIN clause to the query using the Subject relation
 *
 * @method     ChildForum findOne(ConnectionInterface $con = null) Return the first ChildForum matching the query
 * @method     ChildForum findOneOrCreate(ConnectionInterface $con = null) Return the first ChildForum matching the query, or a new ChildForum object populated from the query conditions when no match is found
 *
 * @method     ChildForum findOneById(int $id) Return the first ChildForum filtered by the id column
 * @method     ChildForum findOneByTitle(string $title) Return the first ChildForum filtered by the title column
 * @method     ChildForum findOneByCategoryId(int $category_id) Return the first ChildForum filtered by the category_id column
 * @method     ChildForum findOneByLastPostId(int $last_post_id) Return the first ChildForum filtered by the last_post_id column
 * @method     ChildForum findOneByNbSubjects(int $nb_subjects) Return the first ChildForum filtered by the nb_subjects column
 * @method     ChildForum findOneByNbPosts(int $nb_posts) Return the first ChildForum filtered by the nb_posts column
 *
 * @method     array findById(int $id) Return ChildForum objects filtered by the id column
 * @method     array findByTitle(string $title) Return ChildForum objects filtered by the title column
 * @method     array findByCategoryId(int $category_id) Return ChildForum objects filtered by the category_id column
 * @method     array findByLastPostId(int $last_post_id) Return ChildForum objects filtered by the last_post_id column
 * @method     array findByNbSubjects(int $nb_subjects) Return ChildForum objects filtered by the nb_subjects column
 * @method     array findByNbPosts(int $nb_posts) Return ChildForum objects filtered by the nb_posts column
 *
 */
abstract class ForumQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \Higgs\Model\Base\ForumQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'Higgs', $modelName = '\\Higgs\\Model\\Forum', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildForumQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildForumQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \Higgs\Model\ForumQuery) {
            return $criteria;
        }
        $query = new \Higgs\Model\ForumQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildForum|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ForumTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ForumTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return   ChildForum A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, TITLE, CATEGORY_ID, LAST_POST_ID, NB_SUBJECTS, NB_POSTS FROM forum WHERE ID = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            $obj = new ChildForum();
            $obj->hydrate($row);
            ForumTableMap::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildForum|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return ChildForumQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ForumTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildForumQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ForumTableMap::ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildForumQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ForumTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ForumTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ForumTableMap::ID, $id, $comparison);
    }

    /**
     * Filter the query on the title column
     *
     * Example usage:
     * <code>
     * $query->filterByTitle('fooValue');   // WHERE title = 'fooValue'
     * $query->filterByTitle('%fooValue%'); // WHERE title LIKE '%fooValue%'
     * </code>
     *
     * @param     string $title The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildForumQuery The current query, for fluid interface
     */
    public function filterByTitle($title = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($title)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $title)) {
                $title = str_replace('*', '%', $title);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ForumTableMap::TITLE, $title, $comparison);
    }

    /**
     * Filter the query on the category_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCategoryId(1234); // WHERE category_id = 1234
     * $query->filterByCategoryId(array(12, 34)); // WHERE category_id IN (12, 34)
     * $query->filterByCategoryId(array('min' => 12)); // WHERE category_id > 12
     * </code>
     *
     * @see       filterByCategory()
     *
     * @param     mixed $categoryId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildForumQuery The current query, for fluid interface
     */
    public function filterByCategoryId($categoryId = null, $comparison = null)
    {
        if (is_array($categoryId)) {
            $useMinMax = false;
            if (isset($categoryId['min'])) {
                $this->addUsingAlias(ForumTableMap::CATEGORY_ID, $categoryId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($categoryId['max'])) {
                $this->addUsingAlias(ForumTableMap::CATEGORY_ID, $categoryId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ForumTableMap::CATEGORY_ID, $categoryId, $comparison);
    }

    /**
     * Filter the query on the last_post_id column
     *
     * Example usage:
     * <code>
     * $query->filterByLastPostId(1234); // WHERE last_post_id = 1234
     * $query->filterByLastPostId(array(12, 34)); // WHERE last_post_id IN (12, 34)
     * $query->filterByLastPostId(array('min' => 12)); // WHERE last_post_id > 12
     * </code>
     *
     * @see       filterByLastPost()
     *
     * @param     mixed $lastPostId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildForumQuery The current query, for fluid interface
     */
    public function filterByLastPostId($lastPostId = null, $comparison = null)
    {
        if (is_array($lastPostId)) {
            $useMinMax = false;
            if (isset($lastPostId['min'])) {
                $this->addUsingAlias(ForumTableMap::LAST_POST_ID, $lastPostId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($lastPostId['max'])) {
                $this->addUsingAlias(ForumTableMap::LAST_POST_ID, $lastPostId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ForumTableMap::LAST_POST_ID, $lastPostId, $comparison);
    }

    /**
     * Filter the query on the nb_subjects column
     *
     * Example usage:
     * <code>
     * $query->filterByNbSubjects(1234); // WHERE nb_subjects = 1234
     * $query->filterByNbSubjects(array(12, 34)); // WHERE nb_subjects IN (12, 34)
     * $query->filterByNbSubjects(array('min' => 12)); // WHERE nb_subjects > 12
     * </code>
     *
     * @param     mixed $nbSubjects The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildForumQuery The current query, for fluid interface
     */
    public function filterByNbSubjects($nbSubjects = null, $comparison = null)
    {
        if (is_array($nbSubjects)) {
            $useMinMax = false;
            if (isset($nbSubjects['min'])) {
                $this->addUsingAlias(ForumTableMap::NB_SUBJECTS, $nbSubjects['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($nbSubjects['max'])) {
                $this->addUsingAlias(ForumTableMap::NB_SUBJECTS, $nbSubjects['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ForumTableMap::NB_SUBJECTS, $nbSubjects, $comparison);
    }

    /**
     * Filter the query on the nb_posts column
     *
     * Example usage:
     * <code>
     * $query->filterByNbPosts(1234); // WHERE nb_posts = 1234
     * $query->filterByNbPosts(array(12, 34)); // WHERE nb_posts IN (12, 34)
     * $query->filterByNbPosts(array('min' => 12)); // WHERE nb_posts > 12
     * </code>
     *
     * @param     mixed $nbPosts The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildForumQuery The current query, for fluid interface
     */
    public function filterByNbPosts($nbPosts = null, $comparison = null)
    {
        if (is_array($nbPosts)) {
            $useMinMax = false;
            if (isset($nbPosts['min'])) {
                $this->addUsingAlias(ForumTableMap::NB_POSTS, $nbPosts['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($nbPosts['max'])) {
                $this->addUsingAlias(ForumTableMap::NB_POSTS, $nbPosts['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ForumTableMap::NB_POSTS, $nbPosts, $comparison);
    }

    /**
     * Filter the query by a related \Higgs\Model\Category object
     *
     * @param \Higgs\Model\Category|ObjectCollection $category The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildForumQuery The current query, for fluid interface
     */
    public function filterByCategory($category, $comparison = null)
    {
        if ($category instanceof \Higgs\Model\Category) {
            return $this
                ->addUsingAlias(ForumTableMap::CATEGORY_ID, $category->getId(), $comparison);
        } elseif ($category instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ForumTableMap::CATEGORY_ID, $category->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByCategory() only accepts arguments of type \Higgs\Model\Category or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Category relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildForumQuery The current query, for fluid interface
     */
    public function joinCategory($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Category');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Category');
        }

        return $this;
    }

    /**
     * Use the Category relation Category object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Higgs\Model\CategoryQuery A secondary query class using the current class as primary query
     */
    public function useCategoryQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCategory($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Category', '\Higgs\Model\CategoryQuery');
    }

    /**
     * Filter the query by a related \Higgs\Model\Post object
     *
     * @param \Higgs\Model\Post|ObjectCollection $post The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildForumQuery The current query, for fluid interface
     */
    public function filterByLastPost($post, $comparison = null)
    {
        if ($post instanceof \Higgs\Model\Post) {
            return $this
                ->addUsingAlias(ForumTableMap::LAST_POST_ID, $post->getId(), $comparison);
        } elseif ($post instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ForumTableMap::LAST_POST_ID, $post->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByLastPost() only accepts arguments of type \Higgs\Model\Post or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the LastPost relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildForumQuery The current query, for fluid interface
     */
    public function joinLastPost($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('LastPost');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'LastPost');
        }

        return $this;
    }

    /**
     * Use the LastPost relation Post object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Higgs\Model\PostQuery A secondary query class using the current class as primary query
     */
    public function useLastPostQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinLastPost($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'LastPost', '\Higgs\Model\PostQuery');
    }

    /**
     * Filter the query by a related \Higgs\Model\Subject object
     *
     * @param \Higgs\Model\Subject|ObjectCollection $subject  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildForumQuery The current query, for fluid interface
     */
    public function filterBySubject($subject, $comparison = null)
    {
        if ($subject instanceof \Higgs\Model\Subject) {
            return $this
                ->addUsingAlias(ForumTableMap::ID, $subject->getForumId(), $comparison);
        } elseif ($subject instanceof ObjectCollection) {
            return $this
                ->useSubjectQuery()
                ->filterByPrimaryKeys($subject->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterBySubject() only accepts arguments of type \Higgs\Model\Subject or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Subject relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildForumQuery The current query, for fluid interface
     */
    public function joinSubject($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Subject');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Subject');
        }

        return $this;
    }

    /**
     * Use the Subject relation Subject object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Higgs\Model\SubjectQuery A secondary query class using the current class as primary query
     */
    public function useSubjectQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSubject($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Subject', '\Higgs\Model\SubjectQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildForum $forum Object to remove from the list of results
     *
     * @return ChildForumQuery The current query, for fluid interface
     */
    public function prune($forum = null)
    {
        if ($forum) {
            $this->addUsingAlias(ForumTableMap::ID, $forum->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the forum table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ForumTableMap::DATABASE_NAME);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ForumTableMap::clearInstancePool();
            ForumTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildForum or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildForum object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
     public function delete(ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ForumTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ForumTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();


        ForumTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ForumTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // ForumQuery
