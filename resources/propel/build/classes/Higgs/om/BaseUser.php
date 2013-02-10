<?php


/**
 * Base class that represents a row from the 'user' table.
 *
 *
 *
 * @package    propel.generator.Higgs.om
 */
abstract class BaseUser extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'UserPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        UserPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinit loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

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
     * The value for the email field.
     * @var        string
     */
    protected $email;

    /**
     * The value for the author_id field.
     * @var        int
     */
    protected $author_id;

    /**
     * The value for the created_at field.
     * @var        string
     */
    protected $created_at;

    /**
     * @var        PropelObjectCollection|Post[] Collection to store aggregation of Post objects.
     */
    protected $collPosts;
    protected $collPostsPartial;

    /**
     * @var        PropelObjectCollection|Post[] Collection to store aggregation of Post objects.
     */
    protected $collPosts;
    protected $collPostsPartial;

    /**
     * @var        PropelObjectCollection|Subject[] Collection to store aggregation of Subject objects.
     */
    protected $collPosts;
    protected $collPostsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     * @var        boolean
     */
    protected $alreadyInSave = false;

    /**
     * Flag to prevent endless validation loop, if this object is referenced
     * by another object which falls in this transaction.
     * @var        boolean
     */
    protected $alreadyInValidation = false;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $postsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $postsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $postsScheduledForDeletion = null;

    /**
     * Get the [id] column value.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [username] column value.
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Get the [password] column value.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Get the [email] column value.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get the [author_id] column value.
     *
     * @return int
     */
    public function getAuthorId()
    {
        return $this->author_id;
    }

    /**
     * Get the [optionally formatted] temporal [created_at] column value.
     *
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null, and 0 if column value is 0000-00-00 00:00:00
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getCreatedAt($format = null)
    {
        if ($this->created_at === null) {
            return null;
        }

        if ($this->created_at === '0000-00-00 00:00:00') {
            // while technically this is not a default value of null,
            // this seems to be closest in meaning.
            return null;
        } else {
            try {
                $dt = new DateTime($this->created_at);
            } catch (Exception $x) {
                throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->created_at, true), $x);
            }
        }

        if ($format === null) {
            // Because propel.useDateTimeClass is true, we return a DateTime object.
            return $dt;
        } elseif (strpos($format, '%') !== false) {
            return strftime($format, $dt->format('U'));
        } else {
            return $dt->format($format);
        }
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return User The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[] = UserPeer::ID;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [username] column.
     *
     * @param string $v new value
     * @return User The current object (for fluent API support)
     */
    public function setUsername($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->username !== $v) {
            $this->username = $v;
            $this->modifiedColumns[] = UserPeer::USERNAME;
        }


        return $this;
    } // setUsername()

    /**
     * Set the value of [password] column.
     *
     * @param string $v new value
     * @return User The current object (for fluent API support)
     */
    public function setPassword($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->password !== $v) {
            $this->password = $v;
            $this->modifiedColumns[] = UserPeer::PASSWORD;
        }


        return $this;
    } // setPassword()

    /**
     * Set the value of [email] column.
     *
     * @param string $v new value
     * @return User The current object (for fluent API support)
     */
    public function setEmail($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->email !== $v) {
            $this->email = $v;
            $this->modifiedColumns[] = UserPeer::EMAIL;
        }


        return $this;
    } // setEmail()

    /**
     * Set the value of [author_id] column.
     *
     * @param int $v new value
     * @return User The current object (for fluent API support)
     */
    public function setAuthorId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->author_id !== $v) {
            $this->author_id = $v;
            $this->modifiedColumns[] = UserPeer::AUTHOR_ID;
        }


        return $this;
    } // setAuthorId()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return User The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created_at !== null || $dt !== null) {
            $currentDateAsString = ($this->created_at !== null && $tmpDt = new DateTime($this->created_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->created_at = $newDateAsString;
                $this->modifiedColumns[] = UserPeer::CREATED_AT;
            }
        } // if either are not null


        return $this;
    } // setCreatedAt()

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
        // otherwise, everything was equal, so return true
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
     * @param array $row The row returned by PDOStatement->fetch(PDO::FETCH_NUM)
     * @param int $startcol 0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false)
    {
        try {

            $this->id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->username = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
            $this->password = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
            $this->email = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
            $this->author_id = ($row[$startcol + 4] !== null) ? (int) $row[$startcol + 4] : null;
            $this->created_at = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 6; // 6 = UserPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating User object", $e);
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
     * @param boolean $deep (optional) Whether to also de-associated any related objects.
     * @param PropelPDO $con (optional) The PropelPDO connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getConnection(UserPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = UserPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collPosts = null;

            $this->collPosts = null;

            $this->collPosts = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param PropelPDO $con
     * @return void
     * @throws PropelException
     * @throws Exception
     * @see        BaseObject::setDeleted()
     * @see        BaseObject::isDeleted()
     */
    public function delete(PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getConnection(UserPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = UserQuery::create()
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
     * @param PropelPDO $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @throws Exception
     * @see        doSave()
     */
    public function save(PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getConnection(UserPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        $isInsert = $this->isNew();
        try {
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // timestampable behavior
                if (!$this->isColumnModified(UserPeer::CREATED_AT)) {
                    $this->setCreatedAt(time());
                }
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                UserPeer::addInstanceToPool($this);
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
     * @param PropelPDO $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see        save()
     */
    protected function doSave(PropelPDO $con)
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

            if ($this->postsScheduledForDeletion !== null) {
                if (!$this->postsScheduledForDeletion->isEmpty()) {
                    PostQuery::create()
                        ->filterByPrimaryKeys($this->postsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->postsScheduledForDeletion = null;
                }
            }

            if ($this->collPosts !== null) {
                foreach ($this->collPosts as $referrerFK) {
                    if (!$referrerFK->isDeleted()) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->postsScheduledForDeletion !== null) {
                if (!$this->postsScheduledForDeletion->isEmpty()) {
                    foreach ($this->postsScheduledForDeletion as $post) {
                        // need to save related object because we set the relation to null
                        $post->save($con);
                    }
                    $this->postsScheduledForDeletion = null;
                }
            }

            if ($this->collPosts !== null) {
                foreach ($this->collPosts as $referrerFK) {
                    if (!$referrerFK->isDeleted()) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->postsScheduledForDeletion !== null) {
                if (!$this->postsScheduledForDeletion->isEmpty()) {
                    SubjectQuery::create()
                        ->filterByPrimaryKeys($this->postsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->postsScheduledForDeletion = null;
                }
            }

            if ($this->collPosts !== null) {
                foreach ($this->collPosts as $referrerFK) {
                    if (!$referrerFK->isDeleted()) {
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
     * @param PropelPDO $con
     *
     * @throws PropelException
     * @see        doSave()
     */
    protected function doInsert(PropelPDO $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[] = UserPeer::ID;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . UserPeer::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(UserPeer::ID)) {
            $modifiedColumns[':p' . $index++]  = '`ID`';
        }
        if ($this->isColumnModified(UserPeer::USERNAME)) {
            $modifiedColumns[':p' . $index++]  = '`USERNAME`';
        }
        if ($this->isColumnModified(UserPeer::PASSWORD)) {
            $modifiedColumns[':p' . $index++]  = '`PASSWORD`';
        }
        if ($this->isColumnModified(UserPeer::EMAIL)) {
            $modifiedColumns[':p' . $index++]  = '`EMAIL`';
        }
        if ($this->isColumnModified(UserPeer::AUTHOR_ID)) {
            $modifiedColumns[':p' . $index++]  = '`AUTHOR_ID`';
        }
        if ($this->isColumnModified(UserPeer::CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = '`CREATED_AT`';
        }

        $sql = sprintf(
            'INSERT INTO `user` (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '`ID`':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case '`USERNAME`':
                        $stmt->bindValue($identifier, $this->username, PDO::PARAM_STR);
                        break;
                    case '`PASSWORD`':
                        $stmt->bindValue($identifier, $this->password, PDO::PARAM_STR);
                        break;
                    case '`EMAIL`':
                        $stmt->bindValue($identifier, $this->email, PDO::PARAM_STR);
                        break;
                    case '`AUTHOR_ID`':
                        $stmt->bindValue($identifier, $this->author_id, PDO::PARAM_INT);
                        break;
                    case '`CREATED_AT`':
                        $stmt->bindValue($identifier, $this->created_at, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', $e);
        }
        $this->setId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param PropelPDO $con
     *
     * @see        doSave()
     */
    protected function doUpdate(PropelPDO $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();
        BasePeer::doUpdate($selectCriteria, $valuesCriteria, $con);
    }

    /**
     * Array of ValidationFailed objects.
     * @var        array ValidationFailed[]
     */
    protected $validationFailures = array();

    /**
     * Gets any ValidationFailed objects that resulted from last call to validate().
     *
     *
     * @return array ValidationFailed[]
     * @see        validate()
     */
    public function getValidationFailures()
    {
        return $this->validationFailures;
    }

    /**
     * Validates the objects modified field values and all objects related to this table.
     *
     * If $columns is either a column name or an array of column names
     * only those columns are validated.
     *
     * @param mixed $columns Column name or an array of column names.
     * @return boolean Whether all columns pass validation.
     * @see        doValidate()
     * @see        getValidationFailures()
     */
    public function validate($columns = null)
    {
        $res = $this->doValidate($columns);
        if ($res === true) {
            $this->validationFailures = array();

            return true;
        } else {
            $this->validationFailures = $res;

            return false;
        }
    }

    /**
     * This function performs the validation work for complex object models.
     *
     * In addition to checking the current object, all related objects will
     * also be validated.  If all pass then <code>true</code> is returned; otherwise
     * an aggreagated array of ValidationFailed objects will be returned.
     *
     * @param array $columns Array of column names to validate.
     * @return mixed <code>true</code> if all validations pass; array of <code>ValidationFailed</code> objets otherwise.
     */
    protected function doValidate($columns = null)
    {
        if (!$this->alreadyInValidation) {
            $this->alreadyInValidation = true;
            $retval = null;

            $failureMap = array();


            if (($retval = UserPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }


                if ($this->collPosts !== null) {
                    foreach ($this->collPosts as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collPosts !== null) {
                    foreach ($this->collPosts as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collPosts !== null) {
                    foreach ($this->collPosts as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }


            $this->alreadyInValidation = false;
        }

        return (!empty($failureMap) ? $failureMap : true);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param string $name name
     * @param string $type The type of fieldname the $name is of:
     *               one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *               BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *               Defaults to BasePeer::TYPE_PHPNAME
     * @return mixed Value of field.
     */
    public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = UserPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos position in xml schema
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
                return $this->getEmail();
                break;
            case 4:
                return $this->getAuthorId();
                break;
            case 5:
                return $this->getCreatedAt();
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
     * @param     string  $keyType (optional) One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
     *                    BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *                    Defaults to BasePeer::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to true.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {
        if (isset($alreadyDumpedObjects['User'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['User'][$this->getPrimaryKey()] = true;
        $keys = UserPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getUsername(),
            $keys[2] => $this->getPassword(),
            $keys[3] => $this->getEmail(),
            $keys[4] => $this->getAuthorId(),
            $keys[5] => $this->getCreatedAt(),
        );
        if ($includeForeignObjects) {
            if (null !== $this->collPosts) {
                $result['Posts'] = $this->collPosts->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collPosts) {
                $result['Posts'] = $this->collPosts->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collPosts) {
                $result['Posts'] = $this->collPosts->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param string $name peer name
     * @param mixed $value field value
     * @param string $type The type of fieldname the $name is of:
     *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *                     Defaults to BasePeer::TYPE_PHPNAME
     * @return void
     */
    public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = UserPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

        $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos position in xml schema
     * @param mixed $value field value
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
                $this->setEmail($value);
                break;
            case 4:
                $this->setAuthorId($value);
                break;
            case 5:
                $this->setCreatedAt($value);
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
     * of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
     * BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     * The default key type is the column's BasePeer::TYPE_PHPNAME
     *
     * @param array  $arr     An array to populate the object from.
     * @param string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
    {
        $keys = UserPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setUsername($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setPassword($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setEmail($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setAuthorId($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setCreatedAt($arr[$keys[5]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(UserPeer::DATABASE_NAME);

        if ($this->isColumnModified(UserPeer::ID)) $criteria->add(UserPeer::ID, $this->id);
        if ($this->isColumnModified(UserPeer::USERNAME)) $criteria->add(UserPeer::USERNAME, $this->username);
        if ($this->isColumnModified(UserPeer::PASSWORD)) $criteria->add(UserPeer::PASSWORD, $this->password);
        if ($this->isColumnModified(UserPeer::EMAIL)) $criteria->add(UserPeer::EMAIL, $this->email);
        if ($this->isColumnModified(UserPeer::AUTHOR_ID)) $criteria->add(UserPeer::AUTHOR_ID, $this->author_id);
        if ($this->isColumnModified(UserPeer::CREATED_AT)) $criteria->add(UserPeer::CREATED_AT, $this->created_at);

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
        $criteria = new Criteria(UserPeer::DATABASE_NAME);
        $criteria->add(UserPeer::ID, $this->id);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param  int $key Primary key.
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
     * @param object $copyObj An object of User (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setUsername($this->getUsername());
        $copyObj->setPassword($this->getPassword());
        $copyObj->setEmail($this->getEmail());
        $copyObj->setAuthorId($this->getAuthorId());
        $copyObj->setCreatedAt($this->getCreatedAt());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

            foreach ($this->getPosts() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPost($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPosts() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPost($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPosts() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPost($relObj->copy($deepCopy));
                }
            }

            //unflag object copy
            $this->startCopy = false;
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
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return User Clone of current object.
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
     * Returns a peer instance associated with this om.
     *
     * Since Peer classes are not to have any instance attributes, this method returns the
     * same instance for all member of this class. The method could therefore
     * be static, but this would prevent one from overriding the behavior.
     *
     * @return UserPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new UserPeer();
        }

        return self::$peer;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('Post' == $relationName) {
            $this->initPosts();
        }
        if ('Post' == $relationName) {
            $this->initPosts();
        }
        if ('Post' == $relationName) {
            $this->initPosts();
        }
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
        $this->collPosts = null; // important to set this to null since that means it is uninitialized
        $this->collPostsPartial = null;
    }

    /**
     * reset is the collPosts collection loaded partially
     *
     * @return void
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
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPosts($overrideExisting = true)
    {
        if (null !== $this->collPosts && !$overrideExisting) {
            return;
        }
        $this->collPosts = new PropelObjectCollection();
        $this->collPosts->setModel('Post');
    }

    /**
     * Gets an array of Post objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this User is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Post[] List of Post objects
     * @throws PropelException
     */
    public function getPosts($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collPostsPartial && !$this->isNew();
        if (null === $this->collPosts || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPosts) {
                // return empty collection
                $this->initPosts();
            } else {
                $collPosts = PostQuery::create(null, $criteria)
                    ->filterByUser($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collPostsPartial && count($collPosts)) {
                      $this->initPosts(false);

                      foreach($collPosts as $obj) {
                        if (false == $this->collPosts->contains($obj)) {
                          $this->collPosts->append($obj);
                        }
                      }

                      $this->collPostsPartial = true;
                    }

                    return $collPosts;
                }

                if($partial && $this->collPosts) {
                    foreach($this->collPosts as $obj) {
                        if($obj->isNew()) {
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
     * @param PropelCollection $posts A Propel collection.
     * @param PropelPDO $con Optional connection object
     */
    public function setPosts(PropelCollection $posts, PropelPDO $con = null)
    {
        $this->postsScheduledForDeletion = $this->getPosts(new Criteria(), $con)->diff($posts);

        foreach ($this->postsScheduledForDeletion as $postRemoved) {
            $postRemoved->setUser(null);
        }

        $this->collPosts = null;
        foreach ($posts as $post) {
            $this->addPost($post);
        }

        $this->collPosts = $posts;
        $this->collPostsPartial = false;
    }

    /**
     * Returns the number of related Post objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Post objects.
     * @throws PropelException
     */
    public function countPosts(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collPostsPartial && !$this->isNew();
        if (null === $this->collPosts || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPosts) {
                return 0;
            } else {
                if($partial && !$criteria) {
                    return count($this->getPosts());
                }
                $query = PostQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByUser($this)
                    ->count($con);
            }
        } else {
            return count($this->collPosts);
        }
    }

    /**
     * Method called to associate a Post object to this object
     * through the Post foreign key attribute.
     *
     * @param    Post $l Post
     * @return User The current object (for fluent API support)
     */
    public function addPost(Post $l)
    {
        if ($this->collPosts === null) {
            $this->initPosts();
            $this->collPostsPartial = true;
        }
        if (!$this->collPosts->contains($l)) { // only add it if the **same** object is not already associated
            $this->doAddPost($l);
        }

        return $this;
    }

    /**
     * @param	Post $post The post object to add.
     */
    protected function doAddPost($post)
    {
        $this->collPosts[]= $post;
        $post->setUser($this);
    }

    /**
     * @param	Post $post The post object to remove.
     */
    public function removePost($post)
    {
        if ($this->getPosts()->contains($post)) {
            $this->collPosts->remove($this->collPosts->search($post));
            if (null === $this->postsScheduledForDeletion) {
                $this->postsScheduledForDeletion = clone $this->collPosts;
                $this->postsScheduledForDeletion->clear();
            }
            $this->postsScheduledForDeletion[]= $post;
            $post->setUser(null);
        }
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
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Post[] List of Post objects
     */
    public function getPostsJoinSubject($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = PostQuery::create(null, $criteria);
        $query->joinWith('Subject', $join_behavior);

        return $this->getPosts($query, $con);
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
        $this->collPosts = null; // important to set this to null since that means it is uninitialized
        $this->collPostsPartial = null;
    }

    /**
     * reset is the collPosts collection loaded partially
     *
     * @return void
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
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPosts($overrideExisting = true)
    {
        if (null !== $this->collPosts && !$overrideExisting) {
            return;
        }
        $this->collPosts = new PropelObjectCollection();
        $this->collPosts->setModel('Post');
    }

    /**
     * Gets an array of Post objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this User is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Post[] List of Post objects
     * @throws PropelException
     */
    public function getPosts($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collPostsPartial && !$this->isNew();
        if (null === $this->collPosts || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPosts) {
                // return empty collection
                $this->initPosts();
            } else {
                $collPosts = PostQuery::create(null, $criteria)
                    ->filterByUser($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collPostsPartial && count($collPosts)) {
                      $this->initPosts(false);

                      foreach($collPosts as $obj) {
                        if (false == $this->collPosts->contains($obj)) {
                          $this->collPosts->append($obj);
                        }
                      }

                      $this->collPostsPartial = true;
                    }

                    return $collPosts;
                }

                if($partial && $this->collPosts) {
                    foreach($this->collPosts as $obj) {
                        if($obj->isNew()) {
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
     * @param PropelCollection $posts A Propel collection.
     * @param PropelPDO $con Optional connection object
     */
    public function setPosts(PropelCollection $posts, PropelPDO $con = null)
    {
        $this->postsScheduledForDeletion = $this->getPosts(new Criteria(), $con)->diff($posts);

        foreach ($this->postsScheduledForDeletion as $postRemoved) {
            $postRemoved->setUser(null);
        }

        $this->collPosts = null;
        foreach ($posts as $post) {
            $this->addPost($post);
        }

        $this->collPosts = $posts;
        $this->collPostsPartial = false;
    }

    /**
     * Returns the number of related Post objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Post objects.
     * @throws PropelException
     */
    public function countPosts(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collPostsPartial && !$this->isNew();
        if (null === $this->collPosts || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPosts) {
                return 0;
            } else {
                if($partial && !$criteria) {
                    return count($this->getPosts());
                }
                $query = PostQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByUser($this)
                    ->count($con);
            }
        } else {
            return count($this->collPosts);
        }
    }

    /**
     * Method called to associate a Post object to this object
     * through the Post foreign key attribute.
     *
     * @param    Post $l Post
     * @return User The current object (for fluent API support)
     */
    public function addPost(Post $l)
    {
        if ($this->collPosts === null) {
            $this->initPosts();
            $this->collPostsPartial = true;
        }
        if (!$this->collPosts->contains($l)) { // only add it if the **same** object is not already associated
            $this->doAddPost($l);
        }

        return $this;
    }

    /**
     * @param	Post $post The post object to add.
     */
    protected function doAddPost($post)
    {
        $this->collPosts[]= $post;
        $post->setUser($this);
    }

    /**
     * @param	Post $post The post object to remove.
     */
    public function removePost($post)
    {
        if ($this->getPosts()->contains($post)) {
            $this->collPosts->remove($this->collPosts->search($post));
            if (null === $this->postsScheduledForDeletion) {
                $this->postsScheduledForDeletion = clone $this->collPosts;
                $this->postsScheduledForDeletion->clear();
            }
            $this->postsScheduledForDeletion[]= $post;
            $post->setUser(null);
        }
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
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Post[] List of Post objects
     */
    public function getPostsJoinSubject($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = PostQuery::create(null, $criteria);
        $query->joinWith('Subject', $join_behavior);

        return $this->getPosts($query, $con);
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
        $this->collPosts = null; // important to set this to null since that means it is uninitialized
        $this->collPostsPartial = null;
    }

    /**
     * reset is the collPosts collection loaded partially
     *
     * @return void
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
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPosts($overrideExisting = true)
    {
        if (null !== $this->collPosts && !$overrideExisting) {
            return;
        }
        $this->collPosts = new PropelObjectCollection();
        $this->collPosts->setModel('Subject');
    }

    /**
     * Gets an array of Subject objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this User is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Subject[] List of Subject objects
     * @throws PropelException
     */
    public function getPosts($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collPostsPartial && !$this->isNew();
        if (null === $this->collPosts || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPosts) {
                // return empty collection
                $this->initPosts();
            } else {
                $collPosts = SubjectQuery::create(null, $criteria)
                    ->filterByUser($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collPostsPartial && count($collPosts)) {
                      $this->initPosts(false);

                      foreach($collPosts as $obj) {
                        if (false == $this->collPosts->contains($obj)) {
                          $this->collPosts->append($obj);
                        }
                      }

                      $this->collPostsPartial = true;
                    }

                    return $collPosts;
                }

                if($partial && $this->collPosts) {
                    foreach($this->collPosts as $obj) {
                        if($obj->isNew()) {
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
     * @param PropelCollection $posts A Propel collection.
     * @param PropelPDO $con Optional connection object
     */
    public function setPosts(PropelCollection $posts, PropelPDO $con = null)
    {
        $this->postsScheduledForDeletion = $this->getPosts(new Criteria(), $con)->diff($posts);

        foreach ($this->postsScheduledForDeletion as $postRemoved) {
            $postRemoved->setUser(null);
        }

        $this->collPosts = null;
        foreach ($posts as $post) {
            $this->addPost($post);
        }

        $this->collPosts = $posts;
        $this->collPostsPartial = false;
    }

    /**
     * Returns the number of related Subject objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Subject objects.
     * @throws PropelException
     */
    public function countPosts(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collPostsPartial && !$this->isNew();
        if (null === $this->collPosts || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPosts) {
                return 0;
            } else {
                if($partial && !$criteria) {
                    return count($this->getPosts());
                }
                $query = SubjectQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByUser($this)
                    ->count($con);
            }
        } else {
            return count($this->collPosts);
        }
    }

    /**
     * Method called to associate a Subject object to this object
     * through the Subject foreign key attribute.
     *
     * @param    Subject $l Subject
     * @return User The current object (for fluent API support)
     */
    public function addPost(Subject $l)
    {
        if ($this->collPosts === null) {
            $this->initPosts();
            $this->collPostsPartial = true;
        }
        if (!$this->collPosts->contains($l)) { // only add it if the **same** object is not already associated
            $this->doAddPost($l);
        }

        return $this;
    }

    /**
     * @param	Post $post The post object to add.
     */
    protected function doAddPost($post)
    {
        $this->collPosts[]= $post;
        $post->setUser($this);
    }

    /**
     * @param	Post $post The post object to remove.
     */
    public function removePost($post)
    {
        if ($this->getPosts()->contains($post)) {
            $this->collPosts->remove($this->collPosts->search($post));
            if (null === $this->postsScheduledForDeletion) {
                $this->postsScheduledForDeletion = clone $this->collPosts;
                $this->postsScheduledForDeletion->clear();
            }
            $this->postsScheduledForDeletion[]= $post;
            $post->setUser(null);
        }
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
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Subject[] List of Subject objects
     */
    public function getPostsJoinSubcategory($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = SubjectQuery::create(null, $criteria);
        $query->joinWith('Subcategory', $join_behavior);

        return $this->getPosts($query, $con);
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id = null;
        $this->username = null;
        $this->password = null;
        $this->email = null;
        $this->author_id = null;
        $this->created_at = null;
        $this->alreadyInSave = false;
        $this->alreadyInValidation = false;
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
     * when using Propel in certain daemon or large-volumne/high-memory operations.
     *
     * @param boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collPosts) {
                foreach ($this->collPosts as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPosts) {
                foreach ($this->collPosts as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPosts) {
                foreach ($this->collPosts as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        if ($this->collPosts instanceof PropelCollection) {
            $this->collPosts->clearIterator();
        }
        $this->collPosts = null;
        if ($this->collPosts instanceof PropelCollection) {
            $this->collPosts->clearIterator();
        }
        $this->collPosts = null;
        if ($this->collPosts instanceof PropelCollection) {
            $this->collPosts->clearIterator();
        }
        $this->collPosts = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(UserPeer::DEFAULT_STRING_FORMAT);
    }

    /**
     * return true is the object is in saving state
     *
     * @return boolean
     */
    public function isAlreadyInSave()
    {
        return $this->alreadyInSave;
    }

}
