<?php

namespace OCA\ScienceMesh\Tests\Unit\Share;

use PHPUnit_Framework_TestCase;

use OCA\ScienceMesh\Share\ScienceMeshShare;

use OCP\Files\NotFoundException;
use OCP\Share\Exceptions\IllegalIDChangeException;

class ScienceMeshShareTest extends PHPUnit_Framework_TestCase {
	public function setUp() {
	}
	/*
		public function testFromJson() {  //TODO
			return(false);
		}
		*/

	public function testScienceMeshId() {
		$share = new ScienceMeshShare();
		$share->setScienceMeshId('deadbeef');
		$this->assertEquals($share->getScienceMeshId(), 'deadbeef');
		$this->expectException(IllegalIDChangeException::class);
		$share->setScienceMeshId('decafbad');
	}

	public function testScienceMeshIdInvalidId() {
		$share = new ScienceMeshShare();
		$this->expectException(\InvalidArgumentException::class);
		$share->setScienceMeshId(null);
	}

	public function testScienceMeshResourceId() {
		$share = new ScienceMeshShare();
		$share->setScienceMeshResourceId('deadbeef');
		$this->assertEquals($share->getScienceMeshResourceId(), 'deadbeef');
	}

	public function testNode() {
		$share = new ScienceMeshShare();
		$node = $this->getMockBuilder("OCP\Files\Node")->getMock();
		$node->method("getId")
			->willReturn(1);
		$share->setNode($node);
		$this->assertEquals($share->getNode(), $node);
		$node->method("getId")
			->will($this->throwException(new NotFoundException()));
		$this->expectException(NotFoundException::class);
		$share->getNode($node);
	}


	public function testScienceMeshPermissions() {
		$permissions = $this->getMockBuilder("OCA\ScienceMesh\Share\ScienceMeshSharePermissions")->disableOriginalConstructor()->getMock();
		$share = new ScienceMeshShare();
		$share->setScienceMeshPermissions($permissions);
		$this->assertEquals($permissions, $share->getScienceMeshPermissions());
	}

	public function testScienceMeshGrantee() {
		$granteeId = $this->getMockBuilder("OCA\ScienceMesh\User\ScienceMeshUserId")->disableOriginalConstructor()->getMock();
		$grantee = [
			"Id" => [
				"userId" => $granteeId
			]];
		$share = new ScienceMeshShare();
		$share->setScienceMeshGrantee($grantee);
		$this->assertEquals($granteeId, $share->getScienceMeshGrantee()['Id']['userId']);
	}

	public function testScienceMeshOwner() {
		$owner = $this->getMockBuilder("OCA\ScienceMesh\User\ScienceMeshUserId")->disableOriginalConstructor()->getMock();
		$share = new ScienceMeshShare();
		$share->setScienceMeshOwner($owner);
		$this->assertEquals($owner, $share->getScienceMeshOwner());
	}

	public function testScienceMeshCreator() {
		$creator = $this->getMockBuilder("OCA\ScienceMesh\User\ScienceMeshUserId")->disableOriginalConstructor()->getMock();
		$share = new ScienceMeshShare();
		$share->setScienceMeshCreator($creator);
		$this->assertEquals($creator, $share->getScienceMeshCreator());
	}
	
	public function testScienceMeshCTime() {
		$share = new ScienceMeshShare();
		$share->setScienceMeshCTime(1234567890);
		$this->assertEquals($share->getScienceMeshCTime(), 1234567890);
		$this->expectException(\InvalidArgumentException::class);
		$share->setScienceMeshCTime('deadbeef');
	}

	public function testScienceMeshMTime() {
		$share = new ScienceMeshShare();
		$share->setScienceMeshMTime(1234567890);
		$this->assertEquals($share->getScienceMeshMTime(), 1234567890);
		$this->expectException(\InvalidArgumentException::class);
		$share->setScienceMeshMTime('deadbeef');
	}

	public function testShareProvider() {
		$share = new ScienceMeshShare();
		$share->setProviderId('providerid')
			->setId('internalid');
		$this->assertEquals($share->getFullId(),'providerid:internalid');
		$this->expectException(IllegalIDChangeException::class);
		$share->setProviderId('diredivorp');
	}

	public function testShareProviderInvalidArgument() {
		$share = new ScienceMeshShare();
		$this->expectException(\InvalidArgumentException::class);
		$share->setProviderId(['answer' => 42]);
	}

	/*
			public function testShareNode() {  //TODO
				return(false);
			}

			public function testShareType() {  //TODO
				return(false);
			}

			public function testSharedWith() {  //TODO
				return(false);
			}

			public function testSharedWithDisplayName() {  //TODO
				return(false);
			}

			public function testSharedWithAvatar() {  //TODO
				return(false);
			}

			public function testSharePermisions() {  //TODO
				return(false);
			}

			public function testShareStatus() {  //TODO
				return(false);
			}

			public function testShareNote() {  //TODO
				return(false);
			}

			public function testShareExpirationDate() {  //TODO
				return(false);
			}

			public function testShareLabel() {  //TODO
				return(false);
			}

			public function testSharedBy() {  //TODO
				return(false);
			}

			public function testShareOwner() {  //TODO
				return(false);
			}

			public function testSharePassword() {  //TODO
				return(false);
			}

			public function testShareSendPasswordByTalk() {  //TODO
				return(false);
			}

			public function testShareToken() {  //TODO
				return(false);
			}

			public function testShareTarget() {  //TODO
				return(false);
			}

			public function testShareTime() {  //TODO
				return(false);
			}

			public function testShareMailSend() {  //TODO
				return(false);
			}

			public function testShareNodeCacheEntry() {  //TODO
				return(false);
			}

			public function testShareHideDownload() {  //TODO
				return(false);
			}*/
}
