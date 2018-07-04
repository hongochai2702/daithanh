<?php
class ModelCatalogReviewsev extends Model {
	public function addReviewsev($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "reviewsev SET author = '" . $this->db->escape($data['author']) . "', service_id = '" . (int)$data['service_id'] . "', text = '" . $this->db->escape(strip_tags($data['text'])) . "', rating = '" . (int)$data['rating'] . "', status = '" . (int)$data['status'] . "', date_added = '" . $this->db->escape($data['date_added']) . "'");

		$reviewsev_id = $this->db->getLastId();

		$this->cache->delete('service');

		return $reviewsev_id;
	}

	public function editReviewsev($reviewsev_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "reviewsev SET author = '" . $this->db->escape($data['author']) . "', service_id = '" . (int)$data['service_id'] . "', text = '" . $this->db->escape(strip_tags($data['text'])) . "', rating = '" . (int)$data['rating'] . "', status = '" . (int)$data['status'] . "', date_added = '" . $this->db->escape($data['date_added']) . "', date_modified = NOW() WHERE reviewsev_id = '" . (int)$reviewsev_id . "'");

		$this->cache->delete('service');
	}

	public function deleteReviewsev($reviewsev_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "reviewsev WHERE reviewsev_id = '" . (int)$reviewsev_id . "'");

		$this->cache->delete('service');
	}

	public function getReviewsev($reviewsev_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT pd.name FROM " . DB_PREFIX . "service_description pd WHERE pd.service_id = r.service_id AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS service FROM " . DB_PREFIX . "reviewsev r WHERE r.reviewsev_id = '" . (int)$reviewsev_id . "'");

		return $query->row;
	}

	public function getReviewsevs($data = array()) {
		$sql = "SELECT r.reviewsev_id, pd.name, r.author, r.rating, r.status, r.date_added FROM " . DB_PREFIX . "reviewsev r LEFT JOIN " . DB_PREFIX . "service_description pd ON (r.service_id = pd.service_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_service'])) {
			$sql .= " AND pd.name LIKE '" . $this->db->escape($data['filter_service']) . "%'";
		}

		if (!empty($data['filter_author'])) {
			$sql .= " AND r.author LIKE '" . $this->db->escape($data['filter_author']) . "%'";
		}

		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND r.status = '" . (int)$data['filter_status'] . "'";
		}

		if (!empty($data['filter_date_added'])) {
			$sql .= " AND DATE(r.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		$sort_data = array(
			'pd.name',
			'r.author',
			'r.rating',
			'r.status',
			'r.date_added'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY r.date_added";
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

	public function getTotalReviewsevs($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "reviewsev r LEFT JOIN " . DB_PREFIX . "service_description pd ON (r.service_id = pd.service_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_service'])) {
			$sql .= " AND pd.name LIKE '" . $this->db->escape($data['filter_service']) . "%'";
		}

		if (!empty($data['filter_author'])) {
			$sql .= " AND r.author LIKE '" . $this->db->escape($data['filter_author']) . "%'";
		}

		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND r.status = '" . (int)$data['filter_status'] . "'";
		}

		if (!empty($data['filter_date_added'])) {
			$sql .= " AND DATE(r.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function getTotalReviewsevsAwaitingApproval() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "reviewsev WHERE status = '0'");

		return $query->row['total'];
	}
}