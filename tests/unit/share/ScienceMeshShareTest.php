<?php

namespace OCA\ScienceMesh\Tests\Unit\Share;

use PHPUnit_Framework_TestCase;

use OCA\ScienceMesh\Share\ScienceMeshShare;

use OCP\Files\NotFoundException;
use OCP\Share\Exceptions\IllegalIDChangeException;

class ScienceMeshShareTest extends PHPUnit_Framework_TestCase {
	public function setUp() {
	}
	public function testScienceMeshId() {
		$share = new ScienceMeshShare();
		$share->setScienceMeshId(1337);
		$this->assertEquals($share->getScienceMeshId(), '1337');
		$this->expectException(IllegalIDChangeException::class);
		$share->setScienceMeshId('deadbeef');
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
		$this->assertEquals($node->getId(), $share->getNodeId());
		$this->assertEquals($share->getNodeType(), 'folder');
		$node->method("getId")
			->will($this->throwException(new NotFoundException()));
		$share->setNodeId(2);
		$share->setNodeType('file');
		$this->assertEquals($share->getNodeId(), 2);
		$this->assertEquals($share->getNodeType(), 'file');
		$this->expectException(NotFoundException::class);
		$share->getNode($node);
	}
	public function testSetInvalidNodeType() {
		$share = new ScienceMeshShare();
		$this->expectException(\InvalidArgumentException::class);
		$share->setNodeType('notafileorfolder');
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

	public function testShareProviderWithMissingData() {
		$share = new ScienceMeshShare();
		$share->setProviderId('providerid');
		$this->expectException(\UnexpectedValueException::class);
		$share->getFullId();
	}

	public function testShareProviderInvalidArgument() {
		$share = new ScienceMeshShare();
		$this->expectException(\InvalidArgumentException::class);
		$share->setProviderId(['answer' => 42]);
	}

	public function testShareType() {
		$share = new ScienceMeshShare();
		$share->setShareType(42);
		$this->assertEquals($share->getShareType(), 42);
	}

	public function testSharedWith() {
		$share = new ScienceMeshShare();
		$share->setSharedWith('whatever, a string i guess');
		$this->assertEquals($share->getSharedWith(), 'whatever, a string i guess');
		$this->expectException(\InvalidArgumentException::class);
		$share->setSharedWith(['not a' => 'string']);
	}

	public function testSharedWithDisplayName() {
		$share = new ScienceMeshShare();
		$share->setSharedWithDisplayName('whatever, a string i guess');
		$this->assertEquals($share->getSharedWithDisplayName(), 'whatever, a string i guess');
		$this->expectException(\InvalidArgumentException::class);
		$share->setSharedWithDisplayName(['not a' => 'string']);
	}

	public function testSharedWithAvatar() {
		$share = new ScienceMeshShare();
		$share->setSharedWithAvatar('whatever, a string i guess');
		$this->assertEquals($share->getSharedWithAvatar(), 'whatever, a string i guess');
		$this->expectException(\InvalidArgumentException::class);
		$share->setSharedWithAvatar(['not a' => 'string']);
	}

	public function testSharePermisions() {
		$share = new ScienceMeshShare();
		$share->setPermissions(42);
		$this->assertEquals($share->getPermissions(),42);
	}

	public function testShareStatus() {
		$share = new ScienceMeshShare();
		$share->setStatus(42);
		$this->assertEquals($share->getStatus(), 42);
	}

	public function testShareNote() {
		$share = new ScienceMeshShare();
		$this->assertEquals($share->getNote(), '');
		$share->setNote('notice me, senpai');
		$this->assertEquals($share->getNote(), 'notice me, senpai');
		$share->setNote(1);
		$this->assertEquals($share->getNote(), '');
	}

	public function testShareExpirationDate() {
		$share = new ScienceMeshShare();
		$date = getdate(time() - 1);
		$share->setExpirationDate($date);
		$this->assertEquals($share->getExpirationDate(), $date);
		$this->assertTrue($share->isExpired());
	}

	public function testShareLabel() {
		$share = new ScienceMeshShare();
		$share->setLabel('once you label me, you negate me');
		$this->assertEquals($share->getLabel(), 'once you label me, you negate me');
	}

	public function testSharedBy() {
		$share = new ScienceMeshShare();
		$share->setSharedBy('sharer');
		$this->assertEquals($share->getSharedBy(), 'sharer');
		$this->expectException(\InvalidArgumentException::class);
		$share->setSharedBy(['not a' => 'string']);
	}

	public function testShareOwner() {
		$share = new ScienceMeshShare();
		$share->setShareOwner('owner');
		$this->assertEquals($share->getShareOwner(), 'owner');
		$this->expectException(\InvalidArgumentException::class);
		$share->setShareOwner(['not a' => 'string']);
	}

	public function testSharePassword() {
		$share = new ScienceMeshShare();
		$share->setPassword('secret');
		$this->assertEquals($share->getPassword(), 'secret');
	}

	public function testShareSendPasswordByTalk() {
		$share = new ScienceMeshShare();
		$this->assertFalse($share->getSendPasswordByTalk());
		$share->setSendPasswordByTalk(true);
		$this->assertTrue($share->getSendPasswordByTalk());
	}

	public function testShareToken() {
		$share = new ScienceMeshShare();
		$share->setToken('token');
		$this->assertEquals($share->getToken(), 'token');
	}

	public function testShareTarget() {
		$share = new ScienceMeshShare();
		$share->setTarget('target');
		$this->assertEquals($share->getTarget(), 'target');
	}

	public function testShareTime() {
		$share = new ScienceMeshShare();
		$time = new \DateTime();
		$share->setShareTime($time);
		$this->assertEquals($share->getShareTime(), $time);
	}

	public function testShareMailSend() {
		$share = new ScienceMeshShare();
		$share->setMailSend(true);
		$this->assertTrue($share->getMailSend());
	}

	public function testShareNodeCacheEntry() {
		$share = new ScienceMeshShare();
		$cacheentry = $this->getMockBuilder('OCP\Files\Cache\ICacheEntry')->getMock();
		$share->setNodeCacheEntry($cacheentry);
		$this->assertEquals($share->getNodeCacheEntry(), $cacheentry);
	}

	public function testShareHideDownload() {
		$share = new ScienceMeshShare();
		$this->assertFalse($share->getHideDownload());
		$share->setHideDownload(true);
		$this->assertTrue($share->getHideDownload());
	}
}
