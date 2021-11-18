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
	
	public function setScienceMeshCTime($ctime) {
		if(!is_integer($ctime)){
			throw new \InvalidArgumentException(
				__CLASS__ .
				": ctime has to be an integer."
			);
		} else {
			$this->scienceMeshCTime = $ctime;
		}
	}

	public function getScienceMeshCTime() {
		return $this->scienceMeshCTime;
	}

	public function setScienceMeshMtime($mtime) {
		if(!is_integer($mtime)){
			throw new \InvalidArgumentException(
				__CLASS__ .
				": mtime has to be an integer."
			);
		} else {
			$this->scienceMeshMTime = $mtime;
		}
	}

	public function getScienceMeshMTime() {
		return $this->scienceMeshMTime;
	}

	public function setId($id) {
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

	public function getId() {
		return $this->id;
	}

	public function setProviderId($id) {
		if(!is_string($id)){
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

	public function getFullId() {
		return $this->providerId . ':' . $this->id;
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
