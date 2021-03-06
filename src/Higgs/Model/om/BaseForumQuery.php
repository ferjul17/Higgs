<?php

namespace Higgs\Model\om;

use \Criteria;
use \Exception;
use \ModelCriteria;
use \ModelJoin;
use \PDO;
use \Propel;
use \PropelCollection;
use \PropelException;
use \PropelObjectCollection;
use \PropelPDO;
use Higgs\Model\Category;
use Higgs\Model\Forum;
use Higgs\Model\ForumPeer;
use Higgs\Model\ForumQuery;
use Higgs\Model\Post;
use Higgs\Model\Subject;

/**
 * Base class that represents a query for the 'forum' table.
 *
 *
 *
 * @method ForumQuery orderById($order = Criteria::ASC) Order by the id column
 * @method ForumQuery orderByTitle($order = Criteria::ASC) Order by the title column
 * @method ForumQuery orderByCategoryId($order = Criteria::ASC) Order by the category_id column
 * @method ForumQuery orderByLastPostId($order = Criteria::ASC) Order by the last_post_id column
 * @method ForumQuery orderByNbSubjects($order = Criteria::ASC) Order by the nb_subjects column
 * @method ForumQuery orderByNbPosts($order = Criteria::ASC) Order by the nb_posts column
 *
 * @method ForumQuery groupById() Group by the id column
 * @method ForumQuery groupByTitle() Group by the title column
 * @method ForumQuery groupByCategoryId() Group by the category_id column
 * @method ForumQuery groupByLastPostId() Group by the last_post_id column
 * @method ForumQuery groupByNbSubjects() Group by the nb_subjects column
 * @method ForumQuery groupByNbPosts() Group by the nb_posts column
 *
 * @method ForumQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method ForumQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method ForumQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method ForumQuery leftJoinCategory($relationAlias = null) Adds a LEFT JOIN clause to the query using the Category relation
 * @method ForumQuery rightJoinCategory($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Category relation
 * @method ForumQuery innerJoinCategory($relationAlias = null) Adds a INNER JOIN clause to the query using the Category relation
 *
 * @method ForumQuery leftJoinLastPost($relationAlias = null) Adds a LEFT JOIN clause to the query using the LastPost relation
 * @method ForumQuery rightJoinLastPost($relationAlias = null) Adds a RIGHT JOIN clause to the query using the LastPost relation
 * @method ForumQuery innerJoinLastPost($relationAlias = null) Adds a INNER JOIN clause to the query using the LastPost relation
 *
 * @method ForumQuery leftJoinSubject($relationAlias = null) Adds a LEFT JOIN clause to the query using the Subject relation
 * @method ForumQuery rightJoinSubject($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Subject relation
 * @method ForumQuery innerJoinSubject($relationAlias = null) Adds a INNER JOIN clause to the query using the Subject relation
 *
 * @method Forum findOne(PropelPDO $con = null) Return the first Forum matching the query
 * @method Forum findOneOrCreate(PropelPDO $con = null) Return the first Forum matching the query, or a new Forum object populated from the query conditions when no match is found
 *
 * @method Forum findOneByTitle(string $title) Return the first Forum filtered by the title column
 * @method Forum findOneByCategoryId(int $category_id) Return the first Forum filtered by the category_id column
 * @method Forum findOneByLastPostId(int $last_post_id) Return the first Forum filtered by the last_post_id column
 * @method Forum findOneByNbSubjects(int $nb_subjects) Return the first Forum filtered by the nb_subjects column
 * @method Forum findOneByNbPosts(int $nb_posts) Return the first Forum filtered by the nb_posts column
 *
 * @method array findById(int $id) Return Forum objects filtered by the id column
 * @method array findByTitle(string $title) Return Forum objects filtered by the title column
 * @method array findByCategoryId(int $category_id) Return Forum objects filtered by the category_id column
 * @method array findByLastPostId(int $last_post_id) Return Forum objects filtered by the last_post_id column
 * @method array findByNbSubjects(int $nb_subjects) Return Forum objects filtered by the nb_subjects column
 * @method array findByNbPosts(int $nb_posts) Return Forum objects filtered by the nb_posts column
 *
 * @package    propel.generator.Higgs.Model.om
 */
abstract class BaseForumQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseForumQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'Higgs', $modelName = 'Higgs\\Model\\Forum', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ForumQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   ForumQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return ForumQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof ForumQuery) {
            return $criteria;
        }
        $query = new ForumQuery();
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
     * @param     PropelPDO $con an optional connection object
     *
     * @return   Forum|Forum[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ForumPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(ForumPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * Alias of findPk to use instance pooling
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 Forum A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneById($key, $con = null)
     {
        return $this->findPk($key, $con);
     }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 Forum A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `title`, `category_id`, `last_post_id`, `nb_subjects`, `nb_posts` FROM `forum` WHERE `id` = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $obj = new Forum();
            $obj->hydrate($row);
            ForumPeer::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return Forum|Forum[]|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($stmt);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return PropelObjectCollection|Forum[]|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection($this->getDbName(), Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($stmt);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return ForumQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ForumPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ForumQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ForumPeer::ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id >= 12
     * $query->filterById(array('max' => 12)); // WHERE id <= 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ForumQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ForumPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ForumPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ForumPeer::ID, $id, $comparison);
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
     * @return ForumQuery The current query, for fluid interface
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

        return $this->addUsingAlias(ForumPeer::TITLE, $title, $comparison);
    }

    /**
     * Filter the query on the category_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCategoryId(1234); // WHERE category_id = 1234
     * $query->filterByCategoryId(array(12, 34)); // WHERE category_id IN (12, 34)
     * $query->filterByCategoryId(array('min' => 12)); // WHERE category_id >= 12
     * $query->filterByCategoryId(array('max' => 12)); // WHERE category_id <= 12
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
     * @return ForumQuery The current query, for fluid interface
     */
    public function filterByCategoryId($categoryId = null, $comparison = null)
    {
        if (is_array($categoryId)) {
            $useMinMax = false;
            if (isset($categoryId['min'])) {
                $this->addUsingAlias(ForumPeer::CATEGORY_ID, $categoryId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($categoryId['max'])) {
                $this->addUsingAlias(ForumPeer::CATEGORY_ID, $categoryId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ForumPeer::CATEGORY_ID, $categoryId, $comparison);
    }

    /**
     * Filter the query on the last_post_id column
     *
     * Example usage:
     * <code>
     * $query->filterByLastPostId(1234); // WHERE last_post_id = 1234
     * $query->filterByLastPostId(array(12, 34)); // WHERE last_post_id IN (12, 34)
     * $query->filterByLastPostId(array('min' => 12)); // WHERE last_post_id >= 12
     * $query->filterByLastPostId(array('max' => 12)); // WHERE last_post_id <= 12
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
     * @return ForumQuery The current query, for fluid interface
     */
    public function filterByLastPostId($lastPostId = null, $comparison = null)
    {
        if (is_array($lastPostId)) {
            $useMinMax = false;
            if (isset($lastPostId['min'])) {
                $this->addUsingAlias(ForumPeer::LAST_POST_ID, $lastPostId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($lastPostId['max'])) {
                $this->addUsingAlias(ForumPeer::LAST_POST_ID, $lastPostId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ForumPeer::LAST_POST_ID, $lastPostId, $comparison);
    }

    /**
     * Filter the query on the nb_subjects column
     *
     * Example usage:
     * <code>
     * $query->filterByNbSubjects(1234); // WHERE nb_subjects = 1234
     * $query->filterByNbSubjects(array(12, 34)); // WHERE nb_subjects IN (12, 34)
     * $query->filterByNbSubjects(array('min' => 12)); // WHERE nb_subjects >= 12
     * $query->filterByNbSubjects(array('max' => 12)); // WHERE nb_subjects <= 12
     * </code>
     *
     * @param     mixed $nbSubjects The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ForumQuery The current query, for fluid interface
     */
    public function filterByNbSubjects($nbSubjects = null, $comparison = null)
    {
        if (is_array($nbSubjects)) {
            $useMinMax = false;
            if (isset($nbSubjects['min'])) {
                $this->addUsingAlias(ForumPeer::NB_SUBJECTS, $nbSubjects['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($nbSubjects['max'])) {
                $this->addUsingAlias(ForumPeer::NB_SUBJECTS, $nbSubjects['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ForumPeer::NB_SUBJECTS, $nbSubjects, $comparison);
    }

    /**
     * Filter the query on the nb_posts column
     *
     * Example usage:
     * <code>
     * $query->filterByNbPosts(1234); // WHERE nb_posts = 1234
     * $query->filterByNbPosts(array(12, 34)); // WHERE nb_posts IN (12, 34)
     * $query->filterByNbPosts(array('min' => 12)); // WHERE nb_posts >= 12
     * $query->filterByNbPosts(array('max' => 12)); // WHERE nb_posts <= 12
     * </code>
     *
     * @param     mixed $nbPosts The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ForumQuery The current query, for fluid interface
     */
    public function filterByNbPosts($nbPosts = null, $comparison = null)
    {
        if (is_array($nbPosts)) {
            $useMinMax = false;
            if (isset($nbPosts['min'])) {
                $this->addUsingAlias(ForumPeer::NB_POSTS, $nbPosts['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($nbPosts['max'])) {
                $this->addUsingAlias(ForumPeer::NB_POSTS, $nbPosts['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ForumPeer::NB_POSTS, $nbPosts, $comparison);
    }

    /**
     * Filter the query by a related Category object
     *
     * @param   Category|PropelObjectCollection $category The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ForumQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByCategory($category, $comparison = null)
    {
        if ($category instanceof Category) {
            return $this
                ->addUsingAlias(ForumPeer::CATEGORY_ID, $category->getId(), $comparison);
        } elseif ($category instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ForumPeer::CATEGORY_ID, $category->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByCategory() only accepts arguments of type Category or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Category relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ForumQuery The current query, for fluid interface
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
     * @see       useQuery()
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
     * Filter the query by a related Post object
     *
     * @param   Post|PropelObjectCollection $post The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ForumQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByLastPost($post, $comparison = null)
    {
        if ($post instanceof Post) {
            return $this
                ->addUsingAlias(ForumPeer::LAST_POST_ID, $post->getId(), $comparison);
        } elseif ($post instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ForumPeer::LAST_POST_ID, $post->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByLastPost() only accepts arguments of type Post or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the LastPost relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ForumQuery The current query, for fluid interface
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
     * @see       useQuery()
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
     * Filter the query by a related Subject object
     *
     * @param   Subject|PropelObjectCollection $subject  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ForumQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterBySubject($subject, $comparison = null)
    {
        if ($subject instanceof Subject) {
            return $this
                ->addUsingAlias(ForumPeer::ID, $subject->getForumId(), $comparison);
        } elseif ($subject instanceof PropelObjectCollection) {
            return $this
                ->useSubjectQuery()
                ->filterByPrimaryKeys($subject->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterBySubject() only accepts arguments of type Subject or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Subject relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ForumQuery The current query, for fluid interface
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
     * @see       useQuery()
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
     * @param   Forum $forum Object to remove from the list of results
     *
     * @return ForumQuery The current query, for fluid interface
     */
    public function prune($forum = null)
    {
        if ($forum) {
            $this->addUsingAlias(ForumPeer::ID, $forum->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
