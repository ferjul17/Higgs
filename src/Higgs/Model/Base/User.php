<?php

namespace Higgs\Model\Base;

use \DateTime;
use \Exception;
use \PDO;
use Higgs\Model\Post as ChildPost;
use Higgs\Model\PostQuery as ChildPostQuery;
use Higgs\Model\Role as ChildRole;
use Higgs\Model\RoleQuery as ChildRoleQuery;
use Higgs\Model\Subject as ChildSubject;
use Higgs\Model\SubjectQuery as ChildSubjectQuery;
use Higgs\Model\User as ChildUser;
use Higgs\Model\UserQuery as ChildUserQuery;
use Higgs\Model\UserRole as ChildUserRole;
use Higgs\Model\UserRoleQuery as ChildUserRoleQuery;
use Higgs\Model\Map\UserTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use Propel\Runtime\Util\PropelDateTime;

abstract class User implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Higgs\\Model\\Map\\UserTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the id field.
     * @var        int
     */
    protected $id;

    /**
     * The value for the username field.
     * @var        string
     */
    protected $username;

    /**
     * The value for the password field.
     * @var        string
     */
    protected $password;

    /**
     * The value for the salt field.
     * @var        string
     */
    protected $salt;

    /**
     * The value for the email field.
     * @var        string
     */
    protected $email;

    /**
     * The value for the created_at field.
     * @var        string
     */
    protected $created_at;

    /**
     * The value for the updated_at field.
     * @var        string
     */
    protected $updated_at;

    /**
     * @var        ObjectCollection|ChildUserRole[] Collection to store aggregation of ChildUserRole objects.
     */
    protected $collUserRoles;
    protected $collUserRolesPartial;

    /**
     * @var        ObjectCollection|ChildPost[] Collection to store aggregation of ChildPost objects.
     */
    protected $collPosts;
    protected $collPostsPartial;

    /**
     * @var        ObjectCollection|ChildPost[] Collection to store aggregation of ChildPost objects.
     */
    protected $collPostEditeds;
    protected $collPostEditedsPartial;

    /**
     * @var        ObjectCollection|ChildSubject[] Collection to store aggregation of ChildSubject objects.
     */
    protected $collSubjects;
    protected $collSubjectsPartial;

    /**
     * @var        ChildRole[] Collection to store aggregation of ChildRole objects.
     */
    protected $collRoles;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection
     */
    protected $rolesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection
     */
    protected $userRolesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection
     */
    protected $postsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection
     */
    protected $postEditedsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection
     */
    protected $subjectsScheduledForDeletion = null;

    /**
     * Initializes internal state of Higgs\Model\Base\User object.
     */
    public function __construct()
    {
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (Boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (Boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>User</code> instance.  If
     * <code>obj</code> is an instance of <code>User</code>, delegates to
     * <code>equals(User)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        $thisclazz = get_class($this);
        if (!is_object($obj) || !($obj instanceof $thisclazz)) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey()
            || null === $obj->getPrimaryKey())  {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        if (null !== $this->getPrimaryKey()) {
            return crc32(serialize($this->getPrimaryKey()));
        }

        return crc32(serialize(clone $this));
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return User The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     *
     * @return User The current object, for fluid interface
     */
    public function importFrom($parser, $data)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), TableMap::TYPE_PHPNAME);

        return $this;
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        return array_keys(get_object_vars($this));
    }

    /**
     * Get the [id] column value.
     *
     * @return   int
     */
    public function getId()
    {

        return $this->id;
    }

    /**
     * Get the [username] column value.
     *
     * @return   string
     */
    public function getUsername()
    {

        return $this->username;
    }

    /**
     * Get the [password] column value.
     *
     * @return   string
     */
    public function getPassword()
    {

        return $this->password;
    }

    /**
     * Get the [salt] column value.
     *
     * @return   string
     */
    public function getSalt()
    {

        return $this->salt;
    }

    /**
     * Get the [email] column value.
     *
     * @return   string
     */
    public function getEmail()
    {

        return $this->email;
    }

    /**
     * Get the [optionally formatted] temporal [created_at] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw \DateTime object will be returned.
     *
     * @return mixed Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getCreatedAt($format = NULL)
    {
        if ($format === null) {
            return $this->created_at;
        } else {
            return $this->created_at instanceof \DateTime ? $this->created_at->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [updated_at] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw \DateTime object will be returned.
     *
     * @return mixed Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getUpdatedAt($format = NULL)
    {
        if ($format === null) {
            return $this->updated_at;
        } else {
            return $this->updated_at instanceof \DateTime ? $this->updated_at->format($format) : null;
        }
    }

    /**
     * Set the value of [id] column.
     *
     * @param      int $v new value
     * @return   \Higgs\Model\User The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[UserTableMap::ID] = true;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [username] column.
     *
     * @param      string $v new value
     * @return   \Higgs\Model\User The current object (for fluent API support)
     */
    public function setUsername($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->username !== $v) {
            $this->username = $v;
            $this->modifiedColumns[UserTableMap::USERNAME] = true;
        }


        return $this;
    } // setUsername()

    /**
     * Set the value of [password] column.
     *
     * @param      string $v new value
     * @return   \Higgs\Model\User The current object (for fluent API support)
     */
    public function setPassword($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->password !== $v) {
            $this->password = $v;
            $this->modifiedColumns[UserTableMap::PASSWORD] = true;
        }


        return $this;
    } // setPassword()

    /**
     * Set the value of [salt] column.
     *
     * @param      string $v new value
     * @return   \Higgs\Model\User The current object (for fluent API support)
     */
    public function setSalt($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->salt !== $v) {
            $this->salt = $v;
            $this->modifiedColumns[UserTableMap::SALT] = true;
        }


        return $this;
    } // setSalt()

    /**
     * Set the value of [email] column.
     *
     * @param      string $v new value
     * @return   \Higgs\Model\User The current object (for fluent API support)
     */
    public function setEmail($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->email !== $v) {
            $this->email = $v;
            $this->modifiedColumns[UserTableMap::EMAIL] = true;
        }


        return $this;
    } // setEmail()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return   \Higgs\Model\User The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ($dt !== $this->created_at) {
                $this->created_at = $dt;
                $this->modifiedColumns[UserTableMap::CREATED_AT] = true;
            }
        } // if either are not null


        return $this;
    } // setCreatedAt()

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     *
     * @param      mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return   \Higgs\Model\User The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            if ($dt !== $this->updated_at) {
                $this->updated_at = $dt;
                $this->modifiedColumns[UserTableMap::UPDATED_AT] = true;
            }
        } // if either are not null


        return $this;
    } // setUpdatedAt()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {


            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : UserTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : UserTableMap::translateFieldName('Username', TableMap::TYPE_PHPNAME, $indexType)];
            $this->username = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : UserTableMap::translateFieldName('Password', TableMap::TYPE_PHPNAME, $indexType)];
            $this->password = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : UserTableMap::translateFieldName('Salt', TableMap::TYPE_PHPNAME, $indexType)];
            $this->salt = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : UserTableMap::translateFieldName('Email', TableMap::TYPE_PHPNAME, $indexType)];
            $this->email = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : UserTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : UserTableMap::translateFieldName('UpdatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->updated_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 7; // 7 = UserTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating \Higgs\Model\User object", 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(UserTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildUserQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collUserRoles = null;

            $this->collPosts = null;

            $this->collPostEditeds = null;

            $this->collSubjects = null;

            $this->collRoles = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see User::setDeleted()
     * @see User::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(UserTableMap::DATABASE_NAME);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = ChildUserQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $con->commit();
                $this->setDeleted(true);
            } else {
                $con->commit();
            }
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(UserTableMap::DATABASE_NAME);
        }

        $con->beginTransaction();
        $isInsert = $this->isNew();
        try {
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // timestampable behavior
                if (!$this->isColumnModified(UserTableMap::CREATED_AT)) {
                    $this->setCreatedAt(time());
                }
                if (!$this->isColumnModified(UserTableMap::UPDATED_AT)) {
                    $this->setUpdatedAt(time());
                }
            } else {
                $ret = $ret && $this->preUpdate($con);
                // timestampable behavior
                if ($this->isModified() && !$this->isColumnModified(UserTableMap::UPDATED_AT)) {
                    $this->setUpdatedAt(time());
                }
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                UserTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                } else {
                    $this->doUpdate($con);
                }
                $affectedRows += 1;
                $this->resetModified();
            }

            if ($this->rolesScheduledForDeletion !== null) {
                if (!$this->rolesScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    $pk  = $this->getPrimaryKey();
                    foreach ($this->rolesScheduledForDeletion->getPrimaryKeys(false) as $remotePk) {
                        $pks[] = array($pk, $remotePk);
                    }

                    UserRoleQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);
                    $this->rolesScheduledForDeletion = null;
                }

                foreach ($this->getRoles() as $role) {
                    if ($role->isModified()) {
                        $role->save($con);
                    }
                }
            } elseif ($this->collRoles) {
                foreach ($this->collRoles as $role) {
                    if ($role->isModified()) {
                        $role->save($con);
                    }
                }
            }

            if ($this->userRolesScheduledForDeletion !== null) {
                if (!$this->userRolesScheduledForDeletion->isEmpty()) {
                    \Higgs\Model\UserRoleQuery::create()
                        ->filterByPrimaryKeys($this->userRolesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->userRolesScheduledForDeletion = null;
                }
            }

                if ($this->collUserRoles !== null) {
            foreach ($this->collUserRoles as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->postsScheduledForDeletion !== null) {
                if (!$this->postsScheduledForDeletion->isEmpty()) {
                    \Higgs\Model\PostQuery::create()
                        ->filterByPrimaryKeys($this->postsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->postsScheduledForDeletion = null;
                }
            }

                if ($this->collPosts !== null) {
            foreach ($this->collPosts as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->postEditedsScheduledForDeletion !== null) {
                if (!$this->postEditedsScheduledForDeletion->isEmpty()) {
                    foreach ($this->postEditedsScheduledForDeletion as $postEdited) {
                        // need to save related object because we set the relation to null
                        $postEdited->save($con);
                    }
                    $this->postEditedsScheduledForDeletion = null;
                }
            }

                if ($this->collPostEditeds !== null) {
            foreach ($this->collPostEditeds as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->subjectsScheduledForDeletion !== null) {
                if (!$this->subjectsScheduledForDeletion->isEmpty()) {
                    \Higgs\Model\SubjectQuery::create()
                        ->filterByPrimaryKeys($this->subjectsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->subjectsScheduledForDeletion = null;
                }
            }

                if ($this->collSubjects !== null) {
            foreach ($this->collSubjects as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[UserTableMap::ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . UserTableMap::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(UserTableMap::ID)) {
            $modifiedColumns[':p' . $index++]  = 'ID';
        }
        if ($this->isColumnModified(UserTableMap::USERNAME)) {
            $modifiedColumns[':p' . $index++]  = 'USERNAME';
        }
        if ($this->isColumnModified(UserTableMap::PASSWORD)) {
            $modifiedColumns[':p' . $index++]  = 'PASSWORD';
        }
        if ($this->isColumnModified(UserTableMap::SALT)) {
            $modifiedColumns[':p' . $index++]  = 'SALT';
        }
        if ($this->isColumnModified(UserTableMap::EMAIL)) {
            $modifiedColumns[':p' . $index++]  = 'EMAIL';
        }
        if ($this->isColumnModified(UserTableMap::CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'CREATED_AT';
        }
        if ($this->isColumnModified(UserTableMap::UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'UPDATED_AT';
        }

        $sql = sprintf(
            'INSERT INTO user (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'ID':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case 'USERNAME':
                        $stmt->bindValue($identifier, $this->username, PDO::PARAM_STR);
                        break;
                    case 'PASSWORD':
                        $stmt->bindValue($identifier, $this->password, PDO::PARAM_STR);
                        break;
                    case 'SALT':
                        $stmt->bindValue($identifier, $this->salt, PDO::PARAM_STR);
                        break;
                    case 'EMAIL':
                        $stmt->bindValue($identifier, $this->email, PDO::PARAM_STR);
                        break;
                    case 'CREATED_AT':
                        $stmt->bindValue($identifier, $this->created_at ? $this->created_at->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'UPDATED_AT':
                        $stmt->bindValue($identifier, $this->updated_at ? $this->updated_at->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = UserTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getUsername();
                break;
            case 2:
                return $this->getPassword();
                break;
            case 3:
                return $this->getSalt();
                break;
            case 4:
                return $this->getEmail();
                break;
            case 5:
                return $this->getCreatedAt();
                break;
            case 6:
                return $this->getUpdatedAt();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {
        if (isset($alreadyDumpedObjects['User'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['User'][$this->getPrimaryKey()] = true;
        $keys = UserTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getUsername(),
            $keys[2] => $this->getPassword(),
            $keys[3] => $this->getSalt(),
            $keys[4] => $this->getEmail(),
            $keys[5] => $this->getCreatedAt(),
            $keys[6] => $this->getUpdatedAt(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collUserRoles) {
                $result['UserRoles'] = $this->collUserRoles->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collPosts) {
                $result['Posts'] = $this->collPosts->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collPostEditeds) {
                $result['PostEditeds'] = $this->collPostEditeds->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collSubjects) {
                $result['Subjects'] = $this->collSubjects->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param      string $name
     * @param      mixed  $value field value
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return void
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = UserTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @param      mixed $value field value
     * @return void
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setUsername($value);
                break;
            case 2:
                $this->setPassword($value);
                break;
            case 3:
                $this->setSalt($value);
                break;
            case 4:
                $this->setEmail($value);
                break;
            case 5:
                $this->setCreatedAt($value);
                break;
            case 6:
                $this->setUpdatedAt($value);
                break;
        } // switch()
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = UserTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setUsername($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setPassword($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setSalt($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setEmail($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setCreatedAt($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setUpdatedAt($arr[$keys[6]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(UserTableMap::DATABASE_NAME);

        if ($this->isColumnModified(UserTableMap::ID)) $criteria->add(UserTableMap::ID, $this->id);
        if ($this->isColumnModified(UserTableMap::USERNAME)) $criteria->add(UserTableMap::USERNAME, $this->username);
        if ($this->isColumnModified(UserTableMap::PASSWORD)) $criteria->add(UserTableMap::PASSWORD, $this->password);
        if ($this->isColumnModified(UserTableMap::SALT)) $criteria->add(UserTableMap::SALT, $this->salt);
        if ($this->isColumnModified(UserTableMap::EMAIL)) $criteria->add(UserTableMap::EMAIL, $this->email);
        if ($this->isColumnModified(UserTableMap::CREATED_AT)) $criteria->add(UserTableMap::CREATED_AT, $this->created_at);
        if ($this->isColumnModified(UserTableMap::UPDATED_AT)) $criteria->add(UserTableMap::UPDATED_AT, $this->updated_at);

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = new Criteria(UserTableMap::DATABASE_NAME);
        $criteria->add(UserTableMap::ID, $this->id);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return   int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Higgs\Model\User (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setUsername($this->getUsername());
        $copyObj->setPassword($this->getPassword());
        $copyObj->setSalt($this->getSalt());
        $copyObj->setEmail($this->getEmail());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setUpdatedAt($this->getUpdatedAt());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getUserRoles() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addUserRole($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPosts() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPost($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPostEditeds() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPostEdited($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getSubjects() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSubject($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return                 \Higgs\Model\User Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('UserRole' == $relationName) {
            return $this->initUserRoles();
        }
        if ('Post' == $relationName) {
            return $this->initPosts();
        }
        if ('PostEdited' == $relationName) {
            return $this->initPostEditeds();
        }
        if ('Subject' == $relationName) {
            return $this->initSubjects();
        }
    }

    /**
     * Clears out the collUserRoles collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addUserRoles()
     */
    public function clearUserRoles()
    {
        $this->collUserRoles = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collUserRoles collection loaded partially.
     */
    public function resetPartialUserRoles($v = true)
    {
        $this->collUserRolesPartial = $v;
    }

    /**
     * Initializes the collUserRoles collection.
     *
     * By default this just sets the collUserRoles collection to an empty array (like clearcollUserRoles());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initUserRoles($overrideExisting = true)
    {
        if (null !== $this->collUserRoles && !$overrideExisting) {
            return;
        }
        $this->collUserRoles = new ObjectCollection();
        $this->collUserRoles->setModel('\Higgs\Model\UserRole');
    }

    /**
     * Gets an array of ChildUserRole objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUser is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return Collection|ChildUserRole[] List of ChildUserRole objects
     * @throws PropelException
     */
    public function getUserRoles($criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collUserRolesPartial && !$this->isNew();
        if (null === $this->collUserRoles || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collUserRoles) {
                // return empty collection
                $this->initUserRoles();
            } else {
                $collUserRoles = ChildUserRoleQuery::create(null, $criteria)
                    ->filterByUser($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collUserRolesPartial && count($collUserRoles)) {
                        $this->initUserRoles(false);

                        foreach ($collUserRoles as $obj) {
                            if (false == $this->collUserRoles->contains($obj)) {
                                $this->collUserRoles->append($obj);
                            }
                        }

                        $this->collUserRolesPartial = true;
                    }

                    reset($collUserRoles);

                    return $collUserRoles;
                }

                if ($partial && $this->collUserRoles) {
                    foreach ($this->collUserRoles as $obj) {
                        if ($obj->isNew()) {
                            $collUserRoles[] = $obj;
                        }
                    }
                }

                $this->collUserRoles = $collUserRoles;
                $this->collUserRolesPartial = false;
            }
        }

        return $this->collUserRoles;
    }

    /**
     * Sets a collection of UserRole objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $userRoles A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return   ChildUser The current object (for fluent API support)
     */
    public function setUserRoles(Collection $userRoles, ConnectionInterface $con = null)
    {
        $userRolesToDelete = $this->getUserRoles(new Criteria(), $con)->diff($userRoles);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->userRolesScheduledForDeletion = clone $userRolesToDelete;

        foreach ($userRolesToDelete as $userRoleRemoved) {
            $userRoleRemoved->setUser(null);
        }

        $this->collUserRoles = null;
        foreach ($userRoles as $userRole) {
            $this->addUserRole($userRole);
        }

        $this->collUserRoles = $userRoles;
        $this->collUserRolesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related UserRole objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related UserRole objects.
     * @throws PropelException
     */
    public function countUserRoles(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collUserRolesPartial && !$this->isNew();
        if (null === $this->collUserRoles || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collUserRoles) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getUserRoles());
            }

            $query = ChildUserRoleQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUser($this)
                ->count($con);
        }

        return count($this->collUserRoles);
    }

    /**
     * Method called to associate a ChildUserRole object to this object
     * through the ChildUserRole foreign key attribute.
     *
     * @param    ChildUserRole $l ChildUserRole
     * @return   \Higgs\Model\User The current object (for fluent API support)
     */
    public function addUserRole(ChildUserRole $l)
    {
        if ($this->collUserRoles === null) {
            $this->initUserRoles();
            $this->collUserRolesPartial = true;
        }

        if (!in_array($l, $this->collUserRoles->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddUserRole($l);
        }

        return $this;
    }

    /**
     * @param UserRole $userRole The userRole object to add.
     */
    protected function doAddUserRole($userRole)
    {
        $this->collUserRoles[]= $userRole;
        $userRole->setUser($this);
    }

    /**
     * @param  UserRole $userRole The userRole object to remove.
     * @return ChildUser The current object (for fluent API support)
     */
    public function removeUserRole($userRole)
    {
        if ($this->getUserRoles()->contains($userRole)) {
            $this->collUserRoles->remove($this->collUserRoles->search($userRole));
            if (null === $this->userRolesScheduledForDeletion) {
                $this->userRolesScheduledForDeletion = clone $this->collUserRoles;
                $this->userRolesScheduledForDeletion->clear();
            }
            $this->userRolesScheduledForDeletion[]= clone $userRole;
            $userRole->setUser(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this User is new, it will return
     * an empty collection; or if this User has previously
     * been saved, it will retrieve related UserRoles from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in User.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return Collection|ChildUserRole[] List of ChildUserRole objects
     */
    public function getUserRolesJoinRole($criteria = null, $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildUserRoleQuery::create(null, $criteria);
        $query->joinWith('Role', $joinBehavior);

        return $this->getUserRoles($query, $con);
    }

    /**
     * Clears out the collPosts collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPosts()
     */
    public function clearPosts()
    {
        $this->collPosts = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPosts collection loaded partially.
     */
    public function resetPartialPosts($v = true)
    {
        $this->collPostsPartial = $v;
    }

    /**
     * Initializes the collPosts collection.
     *
     * By default this just sets the collPosts collection to an empty array (like clearcollPosts());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPosts($overrideExisting = true)
    {
        if (null !== $this->collPosts && !$overrideExisting) {
            return;
        }
        $this->collPosts = new ObjectCollection();
        $this->collPosts->setModel('\Higgs\Model\Post');
    }

    /**
     * Gets an array of ChildPost objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUser is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return Collection|ChildPost[] List of ChildPost objects
     * @throws PropelException
     */
    public function getPosts($criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPostsPartial && !$this->isNew();
        if (null === $this->collPosts || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPosts) {
                // return empty collection
                $this->initPosts();
            } else {
                $collPosts = ChildPostQuery::create(null, $criteria)
                    ->filterByUser($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPostsPartial && count($collPosts)) {
                        $this->initPosts(false);

                        foreach ($collPosts as $obj) {
                            if (false == $this->collPosts->contains($obj)) {
                                $this->collPosts->append($obj);
                            }
                        }

                        $this->collPostsPartial = true;
                    }

                    reset($collPosts);

                    return $collPosts;
                }

                if ($partial && $this->collPosts) {
                    foreach ($this->collPosts as $obj) {
                        if ($obj->isNew()) {
                            $collPosts[] = $obj;
                        }
                    }
                }

                $this->collPosts = $collPosts;
                $this->collPostsPartial = false;
            }
        }

        return $this->collPosts;
    }

    /**
     * Sets a collection of Post objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $posts A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return   ChildUser The current object (for fluent API support)
     */
    public function setPosts(Collection $posts, ConnectionInterface $con = null)
    {
        $postsToDelete = $this->getPosts(new Criteria(), $con)->diff($posts);


        $this->postsScheduledForDeletion = $postsToDelete;

        foreach ($postsToDelete as $postRemoved) {
            $postRemoved->setUser(null);
        }

        $this->collPosts = null;
        foreach ($posts as $post) {
            $this->addPost($post);
        }

        $this->collPosts = $posts;
        $this->collPostsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Post objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Post objects.
     * @throws PropelException
     */
    public function countPosts(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPostsPartial && !$this->isNew();
        if (null === $this->collPosts || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPosts) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPosts());
            }

            $query = ChildPostQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUser($this)
                ->count($con);
        }

        return count($this->collPosts);
    }

    /**
     * Method called to associate a ChildPost object to this object
     * through the ChildPost foreign key attribute.
     *
     * @param    ChildPost $l ChildPost
     * @return   \Higgs\Model\User The current object (for fluent API support)
     */
    public function addPost(ChildPost $l)
    {
        if ($this->collPosts === null) {
            $this->initPosts();
            $this->collPostsPartial = true;
        }

        if (!in_array($l, $this->collPosts->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddPost($l);
        }

        return $this;
    }

    /**
     * @param Post $post The post object to add.
     */
    protected function doAddPost($post)
    {
        $this->collPosts[]= $post;
        $post->setUser($this);
    }

    /**
     * @param  Post $post The post object to remove.
     * @return ChildUser The current object (for fluent API support)
     */
    public function removePost($post)
    {
        if ($this->getPosts()->contains($post)) {
            $this->collPosts->remove($this->collPosts->search($post));
            if (null === $this->postsScheduledForDeletion) {
                $this->postsScheduledForDeletion = clone $this->collPosts;
                $this->postsScheduledForDeletion->clear();
            }
            $this->postsScheduledForDeletion[]= clone $post;
            $post->setUser(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this User is new, it will return
     * an empty collection; or if this User has previously
     * been saved, it will retrieve related Posts from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in User.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return Collection|ChildPost[] List of ChildPost objects
     */
    public function getPostsJoinSubject($criteria = null, $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildPostQuery::create(null, $criteria);
        $query->joinWith('Subject', $joinBehavior);

        return $this->getPosts($query, $con);
    }

    /**
     * Clears out the collPostEditeds collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPostEditeds()
     */
    public function clearPostEditeds()
    {
        $this->collPostEditeds = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPostEditeds collection loaded partially.
     */
    public function resetPartialPostEditeds($v = true)
    {
        $this->collPostEditedsPartial = $v;
    }

    /**
     * Initializes the collPostEditeds collection.
     *
     * By default this just sets the collPostEditeds collection to an empty array (like clearcollPostEditeds());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPostEditeds($overrideExisting = true)
    {
        if (null !== $this->collPostEditeds && !$overrideExisting) {
            return;
        }
        $this->collPostEditeds = new ObjectCollection();
        $this->collPostEditeds->setModel('\Higgs\Model\Post');
    }

    /**
     * Gets an array of ChildPost objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUser is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return Collection|ChildPost[] List of ChildPost objects
     * @throws PropelException
     */
    public function getPostEditeds($criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPostEditedsPartial && !$this->isNew();
        if (null === $this->collPostEditeds || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPostEditeds) {
                // return empty collection
                $this->initPostEditeds();
            } else {
                $collPostEditeds = ChildPostQuery::create(null, $criteria)
                    ->filterByEditor($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPostEditedsPartial && count($collPostEditeds)) {
                        $this->initPostEditeds(false);

                        foreach ($collPostEditeds as $obj) {
                            if (false == $this->collPostEditeds->contains($obj)) {
                                $this->collPostEditeds->append($obj);
                            }
                        }

                        $this->collPostEditedsPartial = true;
                    }

                    reset($collPostEditeds);

                    return $collPostEditeds;
                }

                if ($partial && $this->collPostEditeds) {
                    foreach ($this->collPostEditeds as $obj) {
                        if ($obj->isNew()) {
                            $collPostEditeds[] = $obj;
                        }
                    }
                }

                $this->collPostEditeds = $collPostEditeds;
                $this->collPostEditedsPartial = false;
            }
        }

        return $this->collPostEditeds;
    }

    /**
     * Sets a collection of PostEdited objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $postEditeds A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return   ChildUser The current object (for fluent API support)
     */
    public function setPostEditeds(Collection $postEditeds, ConnectionInterface $con = null)
    {
        $postEditedsToDelete = $this->getPostEditeds(new Criteria(), $con)->diff($postEditeds);


        $this->postEditedsScheduledForDeletion = $postEditedsToDelete;

        foreach ($postEditedsToDelete as $postEditedRemoved) {
            $postEditedRemoved->setEditor(null);
        }

        $this->collPostEditeds = null;
        foreach ($postEditeds as $postEdited) {
            $this->addPostEdited($postEdited);
        }

        $this->collPostEditeds = $postEditeds;
        $this->collPostEditedsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Post objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Post objects.
     * @throws PropelException
     */
    public function countPostEditeds(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPostEditedsPartial && !$this->isNew();
        if (null === $this->collPostEditeds || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPostEditeds) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPostEditeds());
            }

            $query = ChildPostQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByEditor($this)
                ->count($con);
        }

        return count($this->collPostEditeds);
    }

    /**
     * Method called to associate a ChildPost object to this object
     * through the ChildPost foreign key attribute.
     *
     * @param    ChildPost $l ChildPost
     * @return   \Higgs\Model\User The current object (for fluent API support)
     */
    public function addPostEdited(ChildPost $l)
    {
        if ($this->collPostEditeds === null) {
            $this->initPostEditeds();
            $this->collPostEditedsPartial = true;
        }

        if (!in_array($l, $this->collPostEditeds->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddPostEdited($l);
        }

        return $this;
    }

    /**
     * @param PostEdited $postEdited The postEdited object to add.
     */
    protected function doAddPostEdited($postEdited)
    {
        $this->collPostEditeds[]= $postEdited;
        $postEdited->setEditor($this);
    }

    /**
     * @param  PostEdited $postEdited The postEdited object to remove.
     * @return ChildUser The current object (for fluent API support)
     */
    public function removePostEdited($postEdited)
    {
        if ($this->getPostEditeds()->contains($postEdited)) {
            $this->collPostEditeds->remove($this->collPostEditeds->search($postEdited));
            if (null === $this->postEditedsScheduledForDeletion) {
                $this->postEditedsScheduledForDeletion = clone $this->collPostEditeds;
                $this->postEditedsScheduledForDeletion->clear();
            }
            $this->postEditedsScheduledForDeletion[]= $postEdited;
            $postEdited->setEditor(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this User is new, it will return
     * an empty collection; or if this User has previously
     * been saved, it will retrieve related PostEditeds from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in User.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return Collection|ChildPost[] List of ChildPost objects
     */
    public function getPostEditedsJoinSubject($criteria = null, $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildPostQuery::create(null, $criteria);
        $query->joinWith('Subject', $joinBehavior);

        return $this->getPostEditeds($query, $con);
    }

    /**
     * Clears out the collSubjects collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addSubjects()
     */
    public function clearSubjects()
    {
        $this->collSubjects = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collSubjects collection loaded partially.
     */
    public function resetPartialSubjects($v = true)
    {
        $this->collSubjectsPartial = $v;
    }

    /**
     * Initializes the collSubjects collection.
     *
     * By default this just sets the collSubjects collection to an empty array (like clearcollSubjects());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initSubjects($overrideExisting = true)
    {
        if (null !== $this->collSubjects && !$overrideExisting) {
            return;
        }
        $this->collSubjects = new ObjectCollection();
        $this->collSubjects->setModel('\Higgs\Model\Subject');
    }

    /**
     * Gets an array of ChildSubject objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUser is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return Collection|ChildSubject[] List of ChildSubject objects
     * @throws PropelException
     */
    public function getSubjects($criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collSubjectsPartial && !$this->isNew();
        if (null === $this->collSubjects || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collSubjects) {
                // return empty collection
                $this->initSubjects();
            } else {
                $collSubjects = ChildSubjectQuery::create(null, $criteria)
                    ->filterByUser($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collSubjectsPartial && count($collSubjects)) {
                        $this->initSubjects(false);

                        foreach ($collSubjects as $obj) {
                            if (false == $this->collSubjects->contains($obj)) {
                                $this->collSubjects->append($obj);
                            }
                        }

                        $this->collSubjectsPartial = true;
                    }

                    reset($collSubjects);

                    return $collSubjects;
                }

                if ($partial && $this->collSubjects) {
                    foreach ($this->collSubjects as $obj) {
                        if ($obj->isNew()) {
                            $collSubjects[] = $obj;
                        }
                    }
                }

                $this->collSubjects = $collSubjects;
                $this->collSubjectsPartial = false;
            }
        }

        return $this->collSubjects;
    }

    /**
     * Sets a collection of Subject objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $subjects A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return   ChildUser The current object (for fluent API support)
     */
    public function setSubjects(Collection $subjects, ConnectionInterface $con = null)
    {
        $subjectsToDelete = $this->getSubjects(new Criteria(), $con)->diff($subjects);


        $this->subjectsScheduledForDeletion = $subjectsToDelete;

        foreach ($subjectsToDelete as $subjectRemoved) {
            $subjectRemoved->setUser(null);
        }

        $this->collSubjects = null;
        foreach ($subjects as $subject) {
            $this->addSubject($subject);
        }

        $this->collSubjects = $subjects;
        $this->collSubjectsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Subject objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Subject objects.
     * @throws PropelException
     */
    public function countSubjects(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collSubjectsPartial && !$this->isNew();
        if (null === $this->collSubjects || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSubjects) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getSubjects());
            }

            $query = ChildSubjectQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUser($this)
                ->count($con);
        }

        return count($this->collSubjects);
    }

    /**
     * Method called to associate a ChildSubject object to this object
     * through the ChildSubject foreign key attribute.
     *
     * @param    ChildSubject $l ChildSubject
     * @return   \Higgs\Model\User The current object (for fluent API support)
     */
    public function addSubject(ChildSubject $l)
    {
        if ($this->collSubjects === null) {
            $this->initSubjects();
            $this->collSubjectsPartial = true;
        }

        if (!in_array($l, $this->collSubjects->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddSubject($l);
        }

        return $this;
    }

    /**
     * @param Subject $subject The subject object to add.
     */
    protected function doAddSubject($subject)
    {
        $this->collSubjects[]= $subject;
        $subject->setUser($this);
    }

    /**
     * @param  Subject $subject The subject object to remove.
     * @return ChildUser The current object (for fluent API support)
     */
    public function removeSubject($subject)
    {
        if ($this->getSubjects()->contains($subject)) {
            $this->collSubjects->remove($this->collSubjects->search($subject));
            if (null === $this->subjectsScheduledForDeletion) {
                $this->subjectsScheduledForDeletion = clone $this->collSubjects;
                $this->subjectsScheduledForDeletion->clear();
            }
            $this->subjectsScheduledForDeletion[]= clone $subject;
            $subject->setUser(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this User is new, it will return
     * an empty collection; or if this User has previously
     * been saved, it will retrieve related Subjects from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in User.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return Collection|ChildSubject[] List of ChildSubject objects
     */
    public function getSubjectsJoinForum($criteria = null, $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildSubjectQuery::create(null, $criteria);
        $query->joinWith('Forum', $joinBehavior);

        return $this->getSubjects($query, $con);
    }

    /**
     * Clears out the collRoles collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addRoles()
     */
    public function clearRoles()
    {
        $this->collRoles = null; // important to set this to NULL since that means it is uninitialized
        $this->collRolesPartial = null;
    }

    /**
     * Initializes the collRoles collection.
     *
     * By default this just sets the collRoles collection to an empty collection (like clearRoles());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initRoles()
    {
        $this->collRoles = new ObjectCollection();
        $this->collRoles->setModel('\Higgs\Model\Role');
    }

    /**
     * Gets a collection of ChildRole objects related by a many-to-many relationship
     * to the current object by way of the user_role cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUser is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|ChildRole[] List of ChildRole objects
     */
    public function getRoles($criteria = null, ConnectionInterface $con = null)
    {
        if (null === $this->collRoles || null !== $criteria) {
            if ($this->isNew() && null === $this->collRoles) {
                // return empty collection
                $this->initRoles();
            } else {
                $collRoles = ChildRoleQuery::create(null, $criteria)
                    ->filterByUser($this)
                    ->find($con);
                if (null !== $criteria) {
                    return $collRoles;
                }
                $this->collRoles = $collRoles;
            }
        }

        return $this->collRoles;
    }

    /**
     * Sets a collection of Role objects related by a many-to-many relationship
     * to the current object by way of the user_role cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $roles A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return ChildUser The current object (for fluent API support)
     */
    public function setRoles(Collection $roles, ConnectionInterface $con = null)
    {
        $this->clearRoles();
        $currentRoles = $this->getRoles();

        $this->rolesScheduledForDeletion = $currentRoles->diff($roles);

        foreach ($roles as $role) {
            if (!$currentRoles->contains($role)) {
                $this->doAddRole($role);
            }
        }

        $this->collRoles = $roles;

        return $this;
    }

    /**
     * Gets the number of ChildRole objects related by a many-to-many relationship
     * to the current object by way of the user_role cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related ChildRole objects
     */
    public function countRoles($criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        if (null === $this->collRoles || null !== $criteria) {
            if ($this->isNew() && null === $this->collRoles) {
                return 0;
            } else {
                $query = ChildRoleQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByUser($this)
                    ->count($con);
            }
        } else {
            return count($this->collRoles);
        }
    }

    /**
     * Associate a ChildRole object to this object
     * through the user_role cross reference table.
     *
     * @param  ChildRole $role The ChildUserRole object to relate
     * @return ChildUser The current object (for fluent API support)
     */
    public function addRole(ChildRole $role)
    {
        if ($this->collRoles === null) {
            $this->initRoles();
        }

        if (!$this->collRoles->contains($role)) { // only add it if the **same** object is not already associated
            $this->doAddRole($role);
            $this->collRoles[] = $role;
        }

        return $this;
    }

    /**
     * @param    Role $role The role object to add.
     */
    protected function doAddRole($role)
    {
        $userRole = new ChildUserRole();
        $userRole->setRole($role);
        $this->addUserRole($userRole);
        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$role->getUsers()->contains($this)) {
            $foreignCollection   = $role->getUsers();
            $foreignCollection[] = $this;
        }
    }

    /**
     * Remove a ChildRole object to this object
     * through the user_role cross reference table.
     *
     * @param ChildRole $role The ChildUserRole object to relate
     * @return ChildUser The current object (for fluent API support)
     */
    public function removeRole(ChildRole $role)
    {
        if ($this->getRoles()->contains($role)) {
            $this->collRoles->remove($this->collRoles->search($role));

            if (null === $this->rolesScheduledForDeletion) {
                $this->rolesScheduledForDeletion = clone $this->collRoles;
                $this->rolesScheduledForDeletion->clear();
            }

            $this->rolesScheduledForDeletion[] = $role;
        }

        return $this;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id = null;
        $this->username = null;
        $this->password = null;
        $this->salt = null;
        $this->email = null;
        $this->created_at = null;
        $this->updated_at = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references to other model objects or collections of model objects.
     *
     * This method is a user-space workaround for PHP's inability to garbage collect
     * objects with circular references (even in PHP 5.3). This is currently necessary
     * when using Propel in certain daemon or large-volume/high-memory operations.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collUserRoles) {
                foreach ($this->collUserRoles as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPosts) {
                foreach ($this->collPosts as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPostEditeds) {
                foreach ($this->collPostEditeds as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collSubjects) {
                foreach ($this->collSubjects as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collRoles) {
                foreach ($this->collRoles as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collUserRoles = null;
        $this->collPosts = null;
        $this->collPostEditeds = null;
        $this->collSubjects = null;
        $this->collRoles = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(UserTableMap::DEFAULT_STRING_FORMAT);
    }

    // timestampable behavior

    /**
     * Mark the current object so that the update date doesn't get updated during next save
     *
     * @return     ChildUser The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged()
    {
        $this->modifiedColumns[UserTableMap::UPDATED_AT] = true;

        return $this;
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {

    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
