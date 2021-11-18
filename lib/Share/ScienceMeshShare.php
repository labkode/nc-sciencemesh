<?php

namespace OCA\ScienceMesh\Share;

use OCP\Files\Node;
use OCP\Files\NotFoundException;
use OCP\Share\Exceptions\IllegalIDChangeException;

class ScienceMeshShare {
	private $scienceMeshResourceId;
	private $scienceMeshPermissions;
	private $scienceMeshGrantee;
	private $scienceMeshOwner;
	private $scienceMeshCreator;
	private $scienceMeshCTime;
	private $scienceMeshMTime;

	private $id;
	private $node;

	public function setScienceMeshId($id) {
		$this->setId($id);
	}

	public function getScienceMeshId() {
		return $this->getId();
	}

	public function setScienceMeshResourceId($rid) {
		$this->scienceMeshResourceId = $rid;
	}

	public function getScienceMeshResourceId() {
		return $this->scienceMeshResourceId;
	}

	public function setScienceMeshPermissions($permissions) {
		$this->scienceMeshPermissions = $permissions;
	}

	public function getScienceMeshPermissions() {
		return $this->scienceMeshPermissions;
	}

	public function setScienceMeshGrantee($grantee) {
		$this->scienceMeshGrantee = $grantee;
	}

	public function getScienceMeshGrantee() {
		return $this->scienceMeshGrantee;
	}

	public function setScienceMeshOwner($owner) {
		$this->scienceMeshOwner = $owner;
	}

	public function getScienceMeshOwner() {
		return $this->scienceMeshOwner;
	}

	public function setScienceMeshCreator($creator) {
		$this->scienceMeshCreator = $creator;
	}

	public function getScienceMeshCreator() {
		return $this->scienceMeshCreator;
	}

	public function setId($id) {
		if (!is_string($id)) {
			throw(new \InvalidArgumentException(
				__CLASS__ .
				": Id has to be of type String."
			));
		} elseif ($this->id != null) {
			throw(new IllegalIDChangeException(
				__CLASS__ .
				": It is only allowed to set the internal id of a share once."
			));
		} else {
			$this->id = $id;
			return $this;
		}
	}

	public function getId() {
		return $this->id;
	}

	public function setNode(Node $node) {
		$this->node = $node;
		return $this;
	}

	public function getNode() {
		try {
			$nodeId = $this->node->getId();
		} catch (NotFoundException $e) {
			throw $e;
		}
		return $this->node;
	}
}
