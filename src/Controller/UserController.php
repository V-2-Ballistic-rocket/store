<?php
namespace App\Controller;

use App\Core\Body;
use App\Entity\User;
use App\Core\HttpCode;
use App\Service\UserDBManager;
use App\Service\Validator\User\UserValidator;
use App\Service\Validator\User\UserSchemeValidator;

class UserController implements EntityControllerInterface
{
    public function __construct(
        private UserDBManager $dbManager,
        private UserValidator $userValidator,
        private UserSchemeValidator $userSchemeValidator
        )
    {
    }

    public function getEntity(Body $body):User
    {
        if(null === $this->dbManager->getUser($body->getDBDTO()))
        {
            throw new \Exception("Not found", HttpCode::NOT_FOUND);
        }
        
        return $this->dbManager->getUser($body->getDBDTO());
    }

    public function addEntity(Body $body):void
    {
        if(!$this->userSchemeValidator->isValidScheme($body->getPhpInputData()))
        {
            throw new \Exception("Scheme invalid", HttpCode::BAD_REQUEST);
        }

        $user = User::createUserByAssocArr($body->getPhpInputData());

        if(!$this->userValidator->isValidUser($user))
        {
            throw new \Exception("User invalid", HttpCode::BAD_REQUEST);
        }
        $this->dbManager->addUser($user, $body->getDBDTO());
    }

    public function deleteEntity(Body $body):void
    {
        $this->dbManager->deleteUser($body->getDBDTO());
    }

    public function editEntity(Body $body):void
    {
        if(!$this->userSchemeValidator->isValidScheme($body->getPhpInputData()))
        {
            throw new \Exception("Scheme invalid", HttpCode::BAD_REQUEST);
        }

        $user = User::createUserByAssocArr($body->getPhpInputData());

        if(!$this->userValidator->isValidUser($user))
        {
            throw new \Exception("User invalid", HttpCode::BAD_REQUEST);
        }

        $this->dbManager->editUser($user, $body->getDBDTO());
    }
}
