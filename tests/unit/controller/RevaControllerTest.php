<?php

namespace OCA\ScienceMesh\Tests\Unit\Controller;

use PHPUnit_Framework_TestCase;

use OCP\AppFramework\Http\TemplateResponse;
use OCP\Files\IRootFolder;
use OCA\ScienceMesh\Controller\RevaController;
use OCA\ScienceMesh\Service\UserService;


class RevaControllerTest extends PHPUnit_Framework_TestCase {

	private $controller;
	private $appName = "sciencemesh";
	private $rootFolder;
	private $request;
	private $session;
	private $userManager;
	private $urlGenerator;
	private $userId = "einstein";
	private $config;
	private $userService;
	private $trashManager;

	public function setUp() {

		// arg names: $AppName, IRootFolder $rootFolder, IRequest $request, ISession $session,
		// IUserManager $userManager, IURLGenerator $urlGenerator, $userId, IConfig $config,
		// \OCA\ScienceMesh\Service\UserService $UserService, ITrashManager $trashManager)

		$this->rootFolder = $this->getMockBuilder("OCP\Files\IRootFolder")->getMock();
		$this->request = $this->getMockBuilder("OCP\IRequest")->getMock();
		$this->session =  $this->getMockBuilder("OCP\ISession")->getMock();
		$this->userManager =  $this->getMockBuilder("OCP\IUserManager")->getMock();
		$this->urlGenerator =  $this->getMockBuilder("OCP\IURLGenerator")->getMock();
		$this->config =  $this->getMockBuilder("OCP\IConfig")->getMock();
		$this->userService  =  new UserService($this->session);

		$this->trashManager =  $this->getMockBuilder("OCA\Files_Trashbin\Trash\ITrashManager")->getMock();

	}

	public function testAuthenticateOK() {

		$user =  $this->getMockBuilder("OCP\IUser")->getMock();
		$this->request->method("getParam")
						 ->willReturn("whatever");
	  $this->userManager->method("checkPassword")
						 ->willReturn($user);
		$controller = new RevaController(
			$this->appName, $this->rootFolder, $this->request, $this->session,
			$this->userManager, $this->urlGenerator, $this->userId, $this->config,
			$this->userService, $this->trashManager
		);
		$result = $controller->Authenticate($this->userId);
		$this->assertEquals($result->getData(), "Logged in");
	}


	public function testAuthenticateWrong() {

		$this->request->method("getParam")
						 ->willReturn("whatever");
	  $this->userManager->method("checkPassword")
						 ->willReturn(false);
		$controller = new RevaController(
			$this->appName, $this->rootFolder, $this->request, $this->session,
			$this->userManager, $this->urlGenerator, $this->userId, $this->config,
			$this->userService, $this->trashManager
		);
		$result = $controller->Authenticate($this->userId);
		$this->assertEquals($result->getData(), "Username / password not recognized");
	}


	public function testCreateDir(){

		$userFolder = $this->getMockBuilder("OCP\Files\Folder")->getMock();
		$sciencemeshFolder = $this->getMockBuilder("OCP\Files\Folder")->getMock();
		$userFolder->method("nodeExists")
									->willReturn(true);
		$userFolder->method("get")
									->willReturn($sciencemeshFolder);
		$this->rootFolder->method("getUserFolder")
									->willReturn($userFolder);
		$this->request->method("getParam")
									->willReturn("/test");
		$controller = new RevaController(
			$this->appName, $this->rootFolder, $this->request, $this->session,
			$this->userManager, $this->urlGenerator, $this->userId, $this->config,
			$this->userService, $this->trashManager
		);
		$sciencemeshFolder->expects($this->once())
				 ->method('newFolder')
				 ->with($this->equalTo('test'));;
		$result = $controller->createDir($this->userId);
		$this->assertEquals($result->getData(), "OK");
	}


	public function testCreateHome(){

		$userFolder = $this->getMockBuilder("OCP\Files\Folder")->getMock();
		$sciencemeshFolder = $this->getMockBuilder("OCP\Files\Folder")->getMock();
		$userFolder->method("nodeExists")
									->willReturn(true);
		$this->rootFolder->method("getUserFolder")
									->willReturn($userFolder);
		$userFolder->method("get")
									->willReturn($sciencemeshFolder);
		$this->controller = new RevaController(
			$this->appName, $this->rootFolder, $this->request, $this->session,
			$this->userManager, $this->urlGenerator, $this->userId, $this->config,
			$this->userService, $this->trashManager
		);
		$result = $this->controller->CreateHome($this->userId);
		$this->assertEquals($result->getData(), "OK");
	}

	public function testCreateReference(){

		$userFolder = $this->getMockBuilder("OCP\Files\Folder")->getMock();
		$sciencemeshFolder = $this->getMockBuilder("OCP\Files\Folder")->getMock();
		$this->rootFolder->method("getUserFolder")
									->willReturn($userFolder);
		$userFolder->method("nodeExists")
									->willReturn(true);
		$userFolder->method("get")
									->willReturn($sciencemeshFolder);
		$this->request->method("getParam")
									->willReturn("/test");
		$this->controller = new RevaController(
			$this->appName, $this->rootFolder, $this->request, $this->session,
			$this->userManager, $this->urlGenerator, $this->userId, $this->config,
			$this->userService, $this->trashManager
		);
 		$result = $this->controller->CreateReference($this->userId);
		$this->assertEquals($result->getData(), "Not implemented");
	}

	public function testDelete(){

		$userFolder = $this->getMockBuilder("OCP\Files\Folder")->getMock();
		$sciencemeshFolder = $this->getMockBuilder("OCP\Files\Folder")->getMock();
		$testFolder = $this->getMockBuilder("OCP\Files\Folder")->getMock();
		$userFolder->method("nodeExists")
									->willReturn(true);
		$userFolder->method("get")
									->willReturn($sciencemeshFolder);
		$sciencemeshFolder->method("get")
									->willReturn($testFolder);
		$sciencemeshFolder->method("nodeExists")
							->willReturn(true);
		$this->rootFolder->method("getUserFolder")
									->willReturn($userFolder);
		$this->request->method("getParam")
									->willReturn("/test");
		$this->controller = new RevaController(
			$this->appName, $this->rootFolder, $this->request, $this->session,
			$this->userManager, $this->urlGenerator, $this->userId, $this->config,
			$this->userService, $this->trashManager
		);
		$sciencemeshFolder->expects($this->once())
				 ->method('get')
				 ->with($this->equalTo('test'));
	 $testFolder->expects($this->once())
					->method('delete');
		$result = $this->controller->Delete($this->userId);
		$this->assertEquals($result->getData(), "OK");
	}
}
