<?php
class ModelCatalogAttributesevGroup extends Model {
	public function addAttributesevGroup($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "attributesev_group SET sort_order = '" . (int)$data['sort_order'] . "'");

		$attributesev_group_id = $this->db->getLastId();

		foreach ($data['attributesev_group_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "attributesev_group_description SET attributesev_group_id = '" . (int)$attributesev_group_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}

		return $attributesev_group_id;
	}

	public function editAttributesevGroup($attributesev_group_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "attributesev_group SET sort_order = '" . (int)$data['sort_order'] . "' WHERE attributesev_group_id = '" . (int)$attributesev_group_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "attributesev_group_description WHERE attributesev_group_id = '" . (int)$attributesev_group_id . "'");

		foreach ($data['attributesev_group_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "attributesev_group_description SET attributesev_group_id = '" . (int)$attributesev_group_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}
	}

	public function deleteAttributesevGroup($attributesev_group_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "attributesev_group WHERE attributesev_group_id = '" . (int)$attributesev_group_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "attributesev_group_description WHERE attributesev_group_id = '" . (int)$attributesev_group_id . "'");
	}

	public function getAttributesevGroup($attributesev_group_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "attributesev_group WHERE attributesev_group_id = '" . (int)$attributesev_group_id . "'");

		return $query->row;
	}

	public function getAttributesevGroups($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "attributesev_group ag LEFT JOIN " . DB_PREFIX . "attributesev_group_description agd ON (ag.attributesev_group_id = agd.attributesev_group_id) WHERE agd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		$sort_data = array(
			'agd.name',
			'ag.sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY agd.name";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getAttributesevGroupDescriptions($attributesev_group_id) {
		$attributesev_group_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "attributesev_group_description WHERE attributesev_group_id = '" . (int)$attributesev_group_id . "'");

		foreach ($query->rows as $result) {
			$attributesev_group_data[$result['language_id']] = array('name' => $result['name']);
		}

		return $attributesev_group_data;
	}

	public function getTotalAttributesevGroups() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "attributesev_group");

		return $query->row['total'];
	}
}