<?php

namespace Higgs\Provider;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Higgs\Provider\AuthentificateUser;

class UserProvider implements UserProviderInterface {
	
	public function loadUserByUsername($username) {
		
		$user = \Higgs\Model\UserQuery::create()
			->filterByEmail($username)
			->_or()
			->filterByUsername($username)
			->findOne();
		if (!($user instanceof \Higgs\Model\User)) {
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
				function(\Higgs\Model\Role $role){
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