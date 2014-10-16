<?php

namespace NetTeam\DDD\Test\Service;

use NetTeam\DDD\Service\CrudService;

/**
 * Description of CrudServiceTest
 *
 * @author Paweł A. Wacławczyk <pawel.waclawczyk@netteam.pl>
 */
class CrudServiceTest extends \PHPUnit_Framework_TestCase
{

    private $crudService;
    private $objectManager;
    private $repository;

    public function setUp()
    {
        parent::setUp();
        $this->objectManager = $this->getMock('Doctrine\Common\Persistence\ObjectManager', array('flush', 'find', 'persist', 'remove', 'merge', 'clear', 'detach', 'refresh', 'getRepository', 'getClassMetadata', 'getMetadataFactory', 'initializeObject', 'contains'));
        $this->repository = $this->getMock('NetTeam\DDD\Repository\RepositoryInterface', array('find', 'findAll', 'findOneBy', 'findBy', 'getClassName', 'persist', 'remove', 'repositoryMethod'));
        $this->crudService = new CrudService('NetTeam\DDD\Test\Service\TestClass', $this->objectManager, $this->repository, array('repositoryMethod'));
    }

    public function testObjectCreation()
    {
        $this->objectManager->expects($this->never())->method('flush');
        $object = $this->crudService->create();
        $this->assertInstanceOf('NetTeam\DDD\Test\Service\TestClass', $object);
    }

    public function testObjectFinding()
    {
        $this->repository->expects($this->once())->method('find');
        $this->crudService->find(1);
    }

    public function testObjectFindAll()
    {
        $this->repository->expects($this->once())->method('findAll');
        $this->crudService->findAll();
    }

    public function testObjectUpdating()
    {
        $object = new TestClass();

        $this->objectManager->expects($this->once())->method('persist');
        $this->objectManager->expects($this->once())->method('flush');
        $this->crudService->update($object);
    }

    public function testObjectRemoving()
    {
        $object = new TestClass();

        $this->repository->expects($this->once())->method('remove');
        $this->objectManager->expects($this->once())->method('flush');
        $this->crudService->remove($object);
    }

    public function testCallingRepositoryMethod()
    {
        $this->repository->expects($this->once())->method('repositoryMethod');
        $this->crudService->repositoryMethod();
    }
}

class TestClass
{

}
