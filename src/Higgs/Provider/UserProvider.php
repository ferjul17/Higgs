<?php

namespace Higgs\Provider;

use Higgs\Model\Role;
use Higgs\Model\User;
use Higgs\Model\UserQuery;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Higgs\Provider\AuthentificateUser;

class UserProvider implements UserProviderInterface {
	
	public function loadUserByUsername($username) {
		
		$user = UserQuery::create()
			->filterByEmail($username)
			->_or()
			->filterByUsername($username)
			->findOne();
		if (!($user instanceof User)) {
			$error = new UsernameNotFoundException;
			$error->setUsername($username);
			throw $error;
		}
		
		if (!is_array($roles = $user->getRoles())) {
			$roles = array();
		}		
		
		return new AuthentificateUser(
			$user->getUsername(),
			$user->getPassword(),
			$user->getSalt(),
			array_map(
				function(Role $role){
					return $role->getName();
				},
				$roles
			)
		);
		
	}

	public function refreshUser(UserInterface $user) {
		
		if (!($user instanceof AuthentificateUser)) {
			throw new UnsupportedUserException;
		}
		
		return $this->loadUserByUsername($user->getUsername());
		
	}

	public function supportsClass($class) {
		
		return $class === 'Higgs\Model\User';
		
	}
	
}