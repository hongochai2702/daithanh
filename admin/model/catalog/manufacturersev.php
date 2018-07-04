<?php
class ModelCatalogManufacturersev extends Model {
	public function addManufacturersev($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "manufacturersev SET name = '" . $this->db->escape($data['name']) . "', sort_order = '" . (int)$data['sort_order'] . "'");

		$manufacturersev_id = $this->db->getLastId();

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "manufacturersev SET image = '" . $this->db->escape($data['image']) . "' WHERE manufacturersev_id = '" . (int)$manufacturersev_id . "'");
		}

		if (isset($data['manufacturersev_store'])) {
			foreach ($data['manufacturersev_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "manufacturersev_to_store SET manufacturersev_id = '" . (int)$manufacturersev_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		if (isset($data['keyword'])) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'manufacturersev_id=" . (int)$manufacturersev_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('manufacturersev');

		return $manufacturersev_id;
	}

	public function editManufacturersev($manufacturersev_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "manufacturersev SET name = '" . $this->db->escape($data['name']) . "', sort_order = '" . (int)$data['sort_order'] . "' WHERE manufacturersev_id = '" . (int)$manufacturersev_id . "'");

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "manufacturersev SET image = '" . $this->db->escape($data['image']) . "' WHERE manufacturersev_id = '" . (int)$manufacturersev_id . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "manufacturersev_to_store WHERE manufacturersev_id = '" . (int)$manufacturersev_id . "'");

		if (isset($data['manufacturersev_store'])) {
			foreach ($data['manufacturersev_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "manufacturersev_to_store SET manufacturersev_id = '" . (int)$manufacturersev_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'manufacturersev_id=" . (int)$manufacturersev_id . "'");

		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'manufacturersev_id=" . (int)$manufacturersev_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('manufacturersev');
	}

	public function deleteManufacturersev($manufacturersev_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "manufacturersev WHERE manufacturersev_id = '" . (int)$manufacturersev_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "manufacturersev_to_store WHERE manufacturersev_id = '" . (int)$manufacturersev_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'manufacturersev_id=" . (int)$manufacturersev_id . "'");

		$this->cache->delete('manufacturersev');
	}

	public function getManufacturersev($manufacturersev_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'manufacturersev_id=" . (int)$manufacturersev_id . "') AS keyword FROM " . DB_PREFIX . "manufacturersev WHERE manufacturersev_id = '" . (int)$manufacturersev_id . "'");

		return $query->row;
	}

	public function getManufacturersevs($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "manufacturersev";

		if (!empty($data['filter_name'])) {
			$sql .= " WHERE name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		$sort_data = array(
			'name',
			'sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY name";
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

	public function getManufacturersevStores($manufacturersev_id) {
		$manufacturersev_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "manufacturersev_to_store WHERE manufacturersev_id = '" . (int)$manufacturersev_id . "'");

		foreach ($query->rows as $result) {
			$manufacturersev_store_data[] = $result['store_id'];
		}

		return $manufacturersev_store_data;
	}

	public function getTotalManufacturersevs() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "manufacturersev");

		return $query->row['total'];
	}
}
