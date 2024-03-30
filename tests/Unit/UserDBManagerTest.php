<?php


namespace Tests\Unit;

use App\Entity\User;
use App\Service\DbDto;
use App\Service\User\UserDbManager;
use Tests\Support\UnitTester;

class UserDBManagerTest extends \Codeception\Test\Unit
{
    protected UnitTester $tester;
    public function invalidIdProvider():array
    {
        return [
            'when the id does not exist' => [
                'id' => 0
            ],
            'when the id = 0' => [
                'id' => 0
            ],
            'when id is negative' =>[
                'id' => -1
            ]
        ];
    }

    /**
     * @dataProvider invalidIdProvider
     */
    public function testInvalidId(int $id)
    {
        $userDBManager = new UserDbManager();
        $dto = new DbDto('pgsql','database','app','postgres','postgres','public/database.sql', $id);
        $result = $userDBManager->getUser($dto);
        $this->tester->assertNull($result);
    }

    public function validIdProvider():array
    {
        return [
            'when the id is exist' => [
                'id' => 1
            ]
        ];
    }

    /**
     * @dataProvider validIdProvider
     */
    public function testValidId(int $id)
    {
        $userDBManager = new UserDbManager();
        $dto = new DbDto('pgsql','database','app','postgres','postgres','public/database.sql', $id);
        $expectedResult = $userDBManager->getUser($dto);
        $actualResult = array('login 1', '012345678910', '123456789');
        $this->tester->assertEquals($expectedResult->getArray(), $actualResult);
    }

    public function testAddUser(){
        $userDBManager = new UserDbManager();
        $dto = new DbDto('pgsql','database','app','postgres','postgres','public/database.sql', 0);

        $user = new User('tmp user', '012345678910', '123456789');
        $id = $userDBManager->addUser($user, $dto);
        
        $dto = new DbDto('pgsql','database','app','postgres','postgres','public/database.sql', $id);
        $result = $userDBManager->getUser($dto);

        $this->tester->assertEquals($user->getArray(), $result->getArray());

        $userDBManager->deleteUser($dto);
    }

    public function testEditUser(){
        $userDBManager = new UserDbManager();
        $dto = new DbDto('pgsql','database','app','postgres','postgres','public/database.sql', 0);

        $user = new User('tmp user', '012345678910', '123456789');
        $id = $userDBManager->addUser($user, $dto);
        
        $dto = new DbDto('pgsql','database','app','postgres','postgres','public/database.sql', $id);
        $user = new User('tmp user 2', '000000000000', '999999999');
        $userDBManager->editUser($user, $dto);
        $result = $userDBManager->getUser($dto);

        $this->tester->assertEquals($user->getArray(), $result->getArray());

        $userDBManager->deleteUser($dto);
    }

    public function testDeleteUser(){
        $userDBManager = new UserDbManager();
        $dto = new DbDto('pgsql','database','app','postgres','postgres','public/database.sql', 0);

        $user = new User('tmp user', '012345678910', '123456789');
        $id = $userDBManager->addUser($user, $dto);
        
        $dto = new DbDto('pgsql','database','app','postgres','postgres','public/database.sql', $id);
        $userDBManager->deleteUser($dto);

        $this->tester->assertNull($userDBManager->getUser($dto));

        $userDBManager->deleteUser($dto);
    }

    public function testGetUser()
    {
        $userDBManager = new UserDbManager();
        $dto = new DbDto('pgsql','database','app','postgres','postgres','public/database.sql', 1);
        $expectedResult = $userDBManager->getUser($dto);
        $actualResult = array('login 1', '012345678910', '123456789');
        $this->tester->assertEquals($expectedResult->getArray(), $actualResult);
    }
}
