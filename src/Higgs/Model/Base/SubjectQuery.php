<?php

namespace Higgs\Model\Base;

use \Exception;
use \PDO;
use Higgs\Model\Subject as ChildSubject;
use Higgs\Model\SubjectQuery as ChildSubjectQuery;
use Higgs\Model\Map\SubjectTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'subject' table.
 *
 *
 *
 * @method     ChildSubjectQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildSubjectQuery orderByTitle($order = Criteria::ASC) Order by the title column
 * @method     ChildSubjectQuery orderByForumId($order = Criteria::ASC) Order by the forum_id column
 * @method     ChildSubjectQuery orderByUserId($order = Criteria::ASC) Order by the user_id column
 * @method     ChildSubjectQuery orderByNbPosts($order = Criteria::ASC) Order by the nb_posts column
 * @method     ChildSubjectQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildSubjectQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildSubjectQuery groupById() Group by the id column
 * @method     ChildSubjectQuery groupByTitle() Group by the title column
 * @method     ChildSubjectQuery groupByForumId() Group by the forum_id column
 * @method     ChildSubjectQuery groupByUserId() Group by the user_id column
 * @method     ChildSubjectQuery groupByNbPosts() Group by the nb_posts column
 * @method     ChildSubjectQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildSubjectQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildSubjectQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildSubjectQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildSubjectQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildSubjectQuery leftJoinUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the User relation
 * @method     ChildSubjectQuery rightJoinUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the User relation
 * @method     ChildSubjectQuery innerJoinUser($relationAlias = null) Adds a INNER JOIN clause to the query using the User relation
 *
 * @method     ChildSubjectQuery leftJoinForum($relationAlias = null) Adds a LEFT JOIN clause to the query using the Forum relation
 * @method     ChildSubjectQuery rightJoinForum($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Forum relation
 * @method     ChildSubjectQuery innerJoinForum($relationAlias = null) Adds a INNER JOIN clause to the query using the Forum relation
 *
 * @method     ChildSubjectQuery leftJoinPost($relationAlias = null) Adds a LEFT JOIN clause to the query using the Post relation
 * @method     ChildSubjectQuery rightJoinPost($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Post relation
 * @method     ChildSubjectQuery innerJoinPost($relationAlias = null) Adds a INNER JOIN clause to the query using the Post relation
 *
 * @method     ChildSubject findOne(ConnectionInterface $con = null) Return the first ChildSubject matching the query
 * @method     ChildSubject findOneOrCreate(ConnectionInterface $con = null) Return the first ChildSubject matching the query, or a new ChildSubject object populated from the query conditions when no match is found
 *
 * @method     ChildSubject findOneById(int $id) Return the first ChildSubject filtered by the id column
 * @method     ChildSubject findOneByTitle(string $title) Return the first ChildSubject filtered by the title column
 * @method     ChildSubject findOneByForumId(int $forum_id) Return the first ChildSubject filtered by the forum_id column
 * @method     ChildSubject findOneByUserId(int $user_id) Return the first ChildSubject filtered by the user_id column
 * @method     ChildSubject findOneByNbPosts(int $nb_posts) Return the first ChildSubject filtered by the nb_posts column
 * @method     ChildSubject findOneByCreatedAt(string $created_at) Return the first ChildSubject filtered by the created_at column
 * @method     ChildSubject findOneByUpdatedAt(string $updated_at) Return the first ChildSubject filtered by the updated_at column
 *
 * @method     array findById(int $id) Return ChildSubject objects filtered by the id column
 * @method     array findByTitle(string $title) Return ChildSubject objects filtered by the title column
 * @method     array findByForumId(int $forum_id) Return ChildSubject objects filtered by the forum_id column
 * @method     array findByUserId(int $user_id) Return ChildSubject objects filtered by the user_id column
 * @method     array findByNbPosts(int $nb_posts) Return ChildSubject objects filtered by the nb_posts column
 * @method     array findByCreatedAt(string $created_at) Return ChildSubject objects filtered by the created_at column
 * @method     array findByUpdatedAt(string $updated_at) Return ChildSubject objects filtered by the updated_at column
 *
 */
abstract class SubjectQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \Higgs\Model\Base\SubjectQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'Higgs', $modelName = '\\Higgs\\Model\\Subject', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildSubjectQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildSubjectQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \Higgs\Model\SubjectQuery) {
            return $criteria;
        }
        $query = new \Higgs\Model\SubjectQuery();
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
     * @return ChildSubject|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = SubjectTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SubjectTableMap::DATABASE_NAME);
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
     * @return   ChildSubject A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, TITLE, FORUM_ID, USER_ID, NB_POSTS, CREATED_AT, UPDATED_AT FROM subject WHERE ID = :p0';
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
            $obj = new ChildSubject();
            $obj->hydrate($row);
            SubjectTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildSubject|array|mixed the result, formatted by the current formatter
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
     * @return ChildSubjectQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(SubjectTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildSubjectQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(SubjectTableMap::ID, $keys, Criteria::IN);
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
     * @return ChildSubjectQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(SubjectTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(SubjectTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SubjectTableMap::ID, $id, $comparison);
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
     * @return ChildSubjectQuery The current query, for fluid interface
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

        return $this->addUsingAlias(SubjectTableMap::TITLE, $title, $comparison);
    }

    /**
     * Filter the query on the forum_id column
     *
     * Example usage:
     * <code>
     * $query->filterByForumId(1234); // WHERE forum_id = 1234
     * $query->filterByForumId(array(12, 34)); // WHERE forum_id IN (12, 34)
     * $query->filterByForumId(array('min' => 12)); // WHERE forum_id > 12
     * </code>
     *
     * @see       filterByForum()
     *
     * @param     mixed $forumId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSubjectQuery The current query, for fluid interface
     */
    public function filterByForumId($forumId = null, $comparison = null)
    {
        if (is_array($forumId)) {
            $useMinMax = false;
            if (isset($forumId['min'])) {
                $this->addUsingAlias(SubjectTableMap::FORUM_ID, $forumId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($forumId['max'])) {
                $this->addUsingAlias(SubjectTableMap::FORUM_ID, $forumId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SubjectTableMap::FORUM_ID, $forumId, $comparison);
    }

    /**
     * Filter the query on the user_id column
     *
     * Example usage:
     * <code>
     * $query->filterByUserId(1234); // WHERE user_id = 1234
     * $query->filterByUserId(array(12, 34)); // WHERE user_id IN (12, 34)
     * $query->filterByUserId(array('min' => 12)); // WHERE user_id > 12
     * </code>
     *
     * @see       filterByUser()
     *
     * @param     mixed $userId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSubjectQuery The current query, for fluid interface
     */
    public function filterByUserId($userId = null, $comparison = null)
    {
        if (is_array($userId)) {
            $useMinMax = false;
            if (isset($userId['min'])) {
                $this->addUsingAlias(SubjectTableMap::USER_ID, $userId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userId['max'])) {
                $this->addUsingAlias(SubjectTableMap::USER_ID, $userId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SubjectTableMap::USER_ID, $userId, $comparison);
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
     * @return ChildSubjectQuery The current query, for fluid interface
     */
    public function filterByNbPosts($nbPosts = null, $comparison = null)
    {
        if (is_array($nbPosts)) {
            $useMinMax = false;
            if (isset($nbPosts['min'])) {
                $this->addUsingAlias(SubjectTableMap::NB_POSTS, $nbPosts['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($nbPosts['max'])) {
                $this->addUsingAlias(SubjectTableMap::NB_POSTS, $nbPosts['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SubjectTableMap::NB_POSTS, $nbPosts, $comparison);
    }

    /**
     * Filter the query on the created_at column
     *
     * Example usage:
     * <code>
     * $query->filterByCreatedAt('2011-03-14'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt('now'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt(array('max' => 'yesterday')); // WHERE created_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $createdAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSubjectQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(SubjectTableMap::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(SubjectTableMap::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SubjectTableMap::CREATED_AT, $createdAt, $comparison);
    }

    /**
     * Filter the query on the updated_at column
     *
     * Example usage:
     * <code>
     * $query->filterByUpdatedAt('2011-03-14'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt('now'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt(array('max' => 'yesterday')); // WHERE updated_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $updatedAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSubjectQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(SubjectTableMap::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(SubjectTableMap::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SubjectTableMap::UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related \Higgs\Model\User object
     *
     * @param \Higgs\Model\User|ObjectCollection $user The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSubjectQuery The current query, for fluid interface
     */
    public function filterByUser($user, $comparison = null)
    {
        if ($user instanceof \Higgs\Model\User) {
            return $this
                ->addUsingAlias(SubjectTableMap::USER_ID, $user->getId(), $comparison);
        } elseif ($user instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SubjectTableMap::USER_ID, $user->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByUser() only accepts arguments of type \Higgs\Model\User or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the User relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildSubjectQuery The current query, for fluid interface
     */
    public function joinUser($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('User');

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
            $this->addJoinObject($join, 'User');
        }

        return $this;
    }

    /**
     * Use the User relation User object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Higgs\Model\UserQuery A secondary query class using the current class as primary query
     */
    public function useUserQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUser($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'User', '\Higgs\Model\UserQuery');
    }

    /**
     * Filter the query by a related \Higgs\Model\Forum object
     *
     * @param \Higgs\Model\Forum|ObjectCollection $forum The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSubjectQuery The current query, for fluid interface
     */
    public function filterByForum($forum, $comparison = null)
    {
        if ($forum instanceof \Higgs\Model\Forum) {
            return $this
                ->addUsingAlias(SubjectTableMap::FORUM_ID, $forum->getId(), $comparison);
        } elseif ($forum instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SubjectTableMap::FORUM_ID, $forum->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByForum() only accepts arguments of type \Higgs\Model\Forum or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Forum relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildSubjectQuery The current query, for fluid interface
     */
    public function joinForum($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Forum');

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
            $this->addJoinObject($join, 'Forum');
        }

        return $this;
    }

    /**
     * Use the Forum relation Forum object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Higgs\Model\ForumQuery A secondary query class using the current class as primary query
     */
    public function useForumQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinForum($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Forum', '\Higgs\Model\ForumQuery');
    }

    /**
     * Filter the query by a related \Higgs\Model\Post object
     *
     * @param \Higgs\Model\Post|ObjectCollection $post  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSubjectQuery The current query, for fluid interface
     */
    public function filterByPost($post, $comparison = null)
    {
        if ($post instanceof \Higgs\Model\Post) {
            return $this
                ->addUsingAlias(SubjectTableMap::ID, $post->getSubjectId(), $comparison);
        } elseif ($post instanceof ObjectCollection) {
            return $this
                ->usePostQuery()
                ->filterByPrimaryKeys($post->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPost() only accepts arguments of type \Higgs\Model\Post or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Post relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildSubjectQuery The current query, for fluid interface
     */
    public function joinPost($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Post');

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
            $this->addJoinObject($join, 'Post');
        }

        return $this;
    }

    /**
     * Use the Post relation Post object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Higgs\Model\PostQuery A secondary query class using the current class as primary query
     */
    public function usePostQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPost($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Post', '\Higgs\Model\PostQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildSubject $subject Object to remove from the list of results
     *
     * @return ChildSubjectQuery The current query, for fluid interface
     */
    public function prune($subject = null)
    {
        if ($subject) {
            $this->addUsingAlias(SubjectTableMap::ID, $subject->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the subject table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SubjectTableMap::DATABASE_NAME);
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
            SubjectTableMap::clearInstancePool();
            SubjectTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildSubject or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildSubject object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(SubjectTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(SubjectTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();


        SubjectTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            SubjectTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     ChildSubjectQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(SubjectTableMap::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     ChildSubjectQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(SubjectTableMap::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     ChildSubjectQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(SubjectTableMap::UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     ChildSubjectQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(SubjectTableMap::UPDATED_AT);
    }

    /**
     * Order by create date desc
     *
     * @return     ChildSubjectQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(SubjectTableMap::CREATED_AT);
    }

    /**
     * Order by create date asc
     *
     * @return     ChildSubjectQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(SubjectTableMap::CREATED_AT);
    }

} // SubjectQuery
