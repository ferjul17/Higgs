<?php

namespace Higgs\Model;

use Higgs\Model\om\BaseUser;


/**
 * Skeleton subclass for representing a row from the 'user' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.Higgs.Model
 */
class User extends BaseUser
{
	
	public function getSalt() {
		$salt = parent::getSalt();
		if ($salt)
			return $salt;
		$this->setSalt($this->generateSalt());
		return parent::getSalt();
	}
	
	protected function generateSalt() {
		return sha1(uniqid(rand(),true));
	}
	
}
