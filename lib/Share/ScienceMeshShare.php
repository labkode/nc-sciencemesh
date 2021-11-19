<?php

namespace OCA\ScienceMesh\Share;

use OCA\ScienceMesh\User\ScienceMeshUserId;

use OCP\Files\Node;
use OCP\Files\NotFoundException;
use OCP\Files\Cache\ICacheEntry;
use OCP\Share\Exceptions\IllegalIDChangeException;
use OCP\Share\IShare;

class ScienceMeshShare implements IShare {
	//private $scienceMeshId => $id
	private $scienceMeshResourceId;
	private $scienceMeshPermissions;
	private $scienceMeshGrantee;
	private $scienceMeshOwner;
	private $scienceMeshCreator;
	private $scienceMeshCTime;
	private $scienceMeshMTime;

	private $id;
	private $providerId;
	private $node;
	private $fileId;
	private $nodeType;
	private $shareType;
	private $sharedWith;
	private $sharedWithDisplayName;
	private $sharedWithAvatar;
	private $sharedBy;
	private $shareOwner;
	private $permissions;
	private $status;
	private $note = '';
	private $expireDate;
	private $password;
	private $sendPasswordByTalk = false;
	private $token;
	private $parent;
	private $target;
	private $shareTime;
	private $mailSend;
	private $label = '';
	private $rootFolder;
	private $userManager;
	private $nodeCacheEntry;
	private $hideDownload = false;

	/**
	 * Set the internal id of the Share
	 * It is only allowed to set the internal id of a share once.
	 * Attempts to override the internal id will result in an IllegalIDChangeException
	 *
	 * @param string $id
	 * @return void
	 * @throws IllegalIDChangeException
	 * @throws \InvalidArgumentException
	 */
	public function setScienceMeshId($id) {
		$this->setId($id);
	}

	/**
	 * Get the internal id of the Share
	 *
	 * @return string
	 */
	public function getScienceMeshId() {
		return $this->getId();
	}

	/**
	 * Set the Resource Id of the Share
	 *
	 * @param string $resourceId
	 * @return void
	 */
	public function setScienceMeshResourceId($resourceId) {
		$this->scienceMeshResourceId = $resourceId;
	}

	/**
	 * Get the Resource Id of the Share
	 *
	 * @return string
	 */
	public function getScienceMeshResourceId() {
		return $this->scienceMeshResourceId;
	}

	/**
	 * Set the ScienceMesh Permissions of the Share
	 *
	 * @param OCA\ScienceMesh\Share\ScienceMeshSharePermissions $permissions
	 * @return void
	 */
	public function setScienceMeshPermissions($permissions) {
		$this->scienceMeshPermissions = $permissions;
	}

	/**
	 * Get the ScienceMesh Permissions
	 *
	 * @return OCA\ScienceMesh\Share\ScienceMeshSharePermissions
	 */
	public function getScienceMeshPermissions() {
		return $this->scienceMeshPermissions;
	}

	/**
	 * Set the Share grantee
	 *
	 * @param array $grantee
	 * @return void
	 */
	public function setScienceMeshGrantee($grantee) {
		$this->scienceMeshGrantee = $grantee;
	}

	/**
	 * Get the Shares grantee
	 *
	 * @return array
	 */
	public function getScienceMeshGrantee() {
		return $this->scienceMeshGrantee;
	}

	/**
	 * Set the ScienceMeshUserId of the Shares owner
	 *
	 * @param OCA\ScienceMesh\User\ScienceMeshUserId $owner
	 * @return void
	 */
	public function setScienceMeshOwner($owner) {
		$this->scienceMeshOwner = $owner;
	}

	/**
	 * Get the ScienceMeshUserId of the Shares owner
	 *
	 * @return OCA\ScienceMesh\User\ScienceMeshUserId
	 */
	public function getScienceMeshOwner() {
		return $this->scienceMeshOwner;
	}
	/**
	 * Set the ScienceMeshUserId of the Shares creator
	 *
	 * @param OCA\ScienceMesh\User\ScienceMeshUserId $creator
	 * @return void
	 */
	public function setScienceMeshCreator($creator) {
		$this->scienceMeshCreator = $creator;
	}
	/**
	 * Get the ScienceMeshUserId of the Shares creator
	 *
	 * @return OCA\ScienceMesh\User\ScienceMeshUserId
	 */
	public function getScienceMeshCreator() {
		return $this->scienceMeshCreator;
	}
	/**
	 * Set Share creation time (Unix Timestamp)
	 *
	 * @param int $ctime
	 * @return void
	 * @throws \InvalidArgumentException
	 */
	public function setScienceMeshCTime($ctime) {
		if (!is_integer($ctime)) {
			throw new \InvalidArgumentException(
				__CLASS__ .
				": ctime has to be an integer."
			);
		} else {
			$this->scienceMeshCTime = $ctime;
		}
	}

	/**
	 * Get the Unix timestamp of when this share was created
	 *
	 * @return int
	 */
	public function getScienceMeshCTime() {
		return $this->scienceMeshCTime;
	}

	/**
	 * Set the mTime of the Share (Unix Timestamp)
	 * @param int
	 * @return void
	 * @throws \InvalidArgumentException
	 */
	public function setScienceMeshMtime($mtime) {
		if (!is_integer($mtime)) {
			throw new \InvalidArgumentException(
				__CLASS__ .
				": mtime has to be an integer."
			);
		} else {
			$this->scienceMeshMTime = $mtime;
		}
	}

	/**
	 * Get the Unix timestamp of when this share was last modified
	 *
	 * @return int
	 */
	public function getScienceMeshMTime() {
		return $this->scienceMeshMTime;
	}

	/**
	 * @inheritdoc
	 */
	public function setId($id) {
		if (is_int($id)) {
			$id = (string)$id;
		}
		if (!is_string($id)) {
			throw(new \InvalidArgumentException(
				__CLASS__ .
				": Id has to be of type String."
			));
		} elseif (isset($this->id)) {
			throw(new IllegalIDChangeException(
				__CLASS__ .
				": It is only allowed to set the internal id of a share once."
			));
		} else {
			$this->id = $id;
		}
		return $this;
	}

	/**
	 * @inheritdoc
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @inheritdoc
	 */
	public function setProviderId($id) {
		if (!is_string($id)) {
			throw(new \InvalidArgumentException(
				__CLASS__ .
				": ProviderId has to be of type String."
			));
		} elseif (isset($this->providerId)) {
			throw(new IllegalIDChangeException(
				__CLASS__ .
				": It is only allowed to set the provider id of a share once."
			));
		} else {
			$this->providerId = $id;
		}
		return $this;
	}

	/**
	 * @inheritdoc
	 */
	public function getFullId() {
		if (!isset($this->providerId) || !isset($this->id)) {
			throw new \UnexpectedValueException;
		}
		return $this->providerId . ':' . $this->id;
	}

	/**
	 * @inheritdoc
	 */
	public function setNode(Node $node) {
		$this->node = $node;
		return $this;
	}

	/**
	 * @inheritdoc
	 */
	public function getNode() {
		if (isset($this->node)) {
			return $this->node;
		} else {
			throw new NotFoundException(
				__CLASS__ .
				": Node not found."
			);
		}
	}

	/**
	 * @inheritdoc
	 */
	public function setNodeId($fileId) {
		$this->node = null;
		$this->fileId = $fileId;
		return $this;
	}

	/**
	 * @inheritdoc
	 */
	public function getNodeId() {
		if (!isset($this->fileId)) {
			$this->fileId = $this->getNode()->getId();
		}

		return $this->fileId;
	}

	/**
	 * @inheritdoc
	 */
	public function setNodeType($type) {
		if ($type !== 'file' && $type !== 'folder') {
			throw new \InvalidArgumentException();
		}

		$this->nodeType = $type;
		return $this;
	}

	/**
	 * @inheritdoc
	 */
	public function getNodeType() {
		if (!isset($this->nodeType)) {
			$node = $this->getNode();
			$this->nodeType = $node instanceof File ? 'file' : 'folder';
		}
		return $this->nodeType;
	}

	/**
	 * @inheritdoc
	 */
	public function setShareType($shareType) {
		$this->shareType = $shareType;
		return $this;
	}

	/**
	 * @inheritdoc
	 */
	public function getShareType() {
		return $this->shareType;
	}

	/**
	 * @inheritdoc
	 */
	public function setSharedWith($sharedWith) {
		if (!is_string($sharedWith)) {
			throw new \InvalidArgumentException();
		}
		$this->sharedWith = $sharedWith;
		return $this;
	}

	/**
	 * @inheritdoc
	 */
	public function getSharedWith() {
		return $this->sharedWith;
	}

	/**
	 * @inheritdoc
	 */
	public function setSharedWithDisplayName($displayName) {
		if (!is_string($displayName)) {
			throw new \InvalidArgumentException();
		}
		$this->sharedWithDisplayName = $displayName;
		return $this;
	}

	/**
	 * @inheritdoc
	 */
	public function getSharedWithDisplayName() {
		return $this->sharedWithDisplayName;
	}

	/**
	 * @inheritdoc
	 */
	public function setSharedWithAvatar($src) {
		if (!is_string($src)) {
			throw new \InvalidArgumentException();
		}
		$this->sharedWithAvatar = $src;
		return $this;
	}

	/**
	 * @inheritdoc
	 */
	public function getSharedWithAvatar() {
		return $this->sharedWithAvatar;
	}

	/**
	 * @inheritdoc
	 */
	public function setPermissions($permissions) {
		$this->permissions = $permissions;
		return $this;
	}

	/**
	 * @inheritdoc
	 */
	public function getPermissions() {
		return $this->permissions;
	}

	/**
	 * @inheritdoc
	 */
	public function setStatus(int $status): IShare {
		$this->status = $status;
		return $this;
	}

	/**
	 * @inheritdoc
	 */
	public function getStatus(): int {
		return $this->status;
	}

	/**
	 * @inheritdoc
	 */
	public function setNote($note) {
		$this->note = $note;
		return $this;
	}

	/**
	 * @inheritdoc
	 */
	public function getNote() {
		if (is_string($this->note)) {
			return $this->note;
		}
		return '';
	}

	/**
	 * @inheritdoc
	 */
	public function setLabel($label) {
		$this->label = $label;
		return $this;
	}

	/**
	 * @inheritdoc
	 */
	public function getLabel() {
		return $this->label;
	}

	/**
	 * @inheritdoc
	 */
	public function setExpirationDate($expireDate) {
		//TODO checks

		$this->expireDate = $expireDate;
		return $this;
	}

	/**
	 * @inheritdoc
	 */
	public function getExpirationDate() {
		return $this->expireDate;
	}

	/**
	 * @inheritdoc
	 */
	public function isExpired() {
		return $this->getExpirationDate() !== null &&
			$this->getExpirationDate() <= new \DateTime();
	}

	/**
	 * @inheritdoc
	 */
	public function setSharedBy($sharedBy) {
		if (!is_string($sharedBy)) {
			throw new \InvalidArgumentException();
		}
		//TODO checks
		$this->sharedBy = $sharedBy;

		return $this;
	}

	/**
	 * @inheritdoc
	 */
	public function getSharedBy() {
		//TODO check if set
		return $this->sharedBy;
	}

	/**
	 * @inheritdoc
	 */
	public function setShareOwner($shareOwner) {
		if (!is_string($shareOwner)) {
			throw new \InvalidArgumentException();
		}
		//TODO checks

		$this->shareOwner = $shareOwner;
		return $this;
	}

	/**
	 * @inheritdoc
	 */
	public function getShareOwner() {
		//TODO check if set
		return $this->shareOwner;
	}

	/**
	 * @inheritdoc
	 */
	public function setPassword($password) {
		$this->password = $password;
		return $this;
	}

	/**
	 * @inheritdoc
	 */
	public function getPassword() {
		return $this->password;
	}

	/**
	 * @inheritdoc
	 */
	public function setSendPasswordByTalk(bool $sendPasswordByTalk) {
		$this->sendPasswordByTalk = $sendPasswordByTalk;
		return $this;
	}

	/**
	 * @inheritdoc
	 */
	public function getSendPasswordByTalk(): bool {
		return $this->sendPasswordByTalk;
	}

	/**
	 * @inheritdoc
	 */
	public function setToken($token) {
		$this->token = $token;
		return $this;
	}

	/**
	 * @inheritdoc
	 */
	public function getToken() {
		return $this->token;
	}

	/**
	 * @inheritdoc
	 */
	public function setTarget($target) {
		$this->target = $target;
		return $this;
	}

	/**
	 * @inheritdoc
	 */
	public function getTarget() {
		return $this->target;
	}

	/**
	 * @inheritdoc
	 */
	public function setShareTime(\DateTime $shareTime) {
		$this->shareTime = $shareTime;
		return $this;
	}

	/**
	 * @inheritdoc
	 */
	public function getShareTime() {
		return $this->shareTime;
	}

	/**
	 * @inheritdoc
	 */
	public function setMailSend($mailSend) {
		$this->mailSend = $mailSend;
		return $this;
	}

	/**
	 * @inheritdoc
	 */
	public function getMailSend() {
		return $this->mailSend;
	}

	/**
	 * @inheritdoc
	 */
	public function setNodeCacheEntry(ICacheEntry $entry) {
		$this->nodeCacheEntry = $entry;
	}

	/**
	 * @inheritdoc
	 */
	public function getNodeCacheEntry() {
		return $this->nodeCacheEntry;
	}

	public function setHideDownload(bool $hide): IShare {
		$this->hideDownload = $hide;
		return $this;
	}

	public function getHideDownload(): bool {
		return $this->hideDownload;
	}
}
