<?php
class ModelPostTypePages extends Model {
	public function addPostType($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "post_type SET modules = '" . $this->db->escape($data['modules']) . "', type = '" . $this->db->escape($data['type']) . "',sort_order = '" . (int)$data['sort_order'] . "', bottom = '" . (isset($data['bottom']) ? (int)$data['bottom'] : 0) . "', status = '" . (int)$data['status'] . "'");

		$post_type_id = $this->db->getLastId();

		foreach ($data['post_type_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "post_type_description SET post_type_id = '" . (int)$post_type_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', description = '" . $this->db->escape($value['description']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		if (isset($data['post_type_store'])) {
			foreach ($data['post_type_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "post_type_to_store SET post_type_id = '" . (int)$post_type_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		if (isset($data['post_type_store'])) {
			foreach ($data['post_type_store'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "post_type_to_layout SET post_type_id = '" . (int)$post_type_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}

		if (isset($data['keyword'])) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'post_type_id=" . (int)$post_type_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('post_type');

		return $post_type_id;
	}

	public function editPostType($post_type_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "post_type SET modules = '" . $this->db->escape($data['modules']) . "', type = '" . $this->db->escape($data['type']) . "', sort_order = '" . (int)$data['sort_order'] . "', bottom = '" . (isset($data['bottom']) ? (int)$data['bottom'] : 0) . "', status = '" . (int)$data['status'] . "' WHERE post_type_id = '" . (int)$post_type_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "post_type_description WHERE post_type_id = '" . (int)$post_type_id . "'");

		foreach ($data['post_type_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "post_type_description SET post_type_id = '" . (int)$post_type_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', description = '" . $this->db->escape($value['description']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "post_type_to_store WHERE post_type_id = '" . (int)$post_type_id . "'");

		if (isset($data['post_type_store'])) {
			foreach ($data['post_type_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "post_type_to_store SET post_type_id = '" . (int)$post_type_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "post_type_to_layout WHERE post_type_id = '" . (int)$post_type_id . "'");

		if (isset($data['post_type_store'])) {
			foreach ($data['post_type_store'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "post_type_to_layout SET post_type_id = '" . (int)$post_type_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'post_type_id=" . (int)$post_type_id . "'");

		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'post_type_id=" . (int)$post_type_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('post_type');
	}

	public function deletePostType($post_type_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "post_type WHERE post_type_id = '" . (int)$post_type_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "post_type_description WHERE post_type_id = '" . (int)$post_type_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "post_type_to_store WHERE post_type_id = '" . (int)$post_type_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "post_type_to_layout WHERE post_type_id = '" . (int)$post_type_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'post_type_id=" . (int)$post_type_id . "'");

		$this->cache->delete('post_type');
	}

	public function getPostType($post_type_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'post_type_id=" . (int)$post_type_id . "') AS keyword FROM " . DB_PREFIX . "post_type WHERE post_type_id = '" . (int)$post_type_id . "'");

		return $query->row;
	}

	public function getPostTypes($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "post_type i LEFT JOIN " . DB_PREFIX . "post_type_description id ON (i.post_type_id = id.post_type_id) WHERE id.language_id = '" . (int)$this->config->get('config_language_id') . "'";

			$sort_data = array(
				'id.title',
				'i.sort_order'
			);

			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];
			} else {
				$sql .= " ORDER BY id.title";
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
		} else {
			$post_type_data = $this->cache->get('post_type.' . (int)$this->config->get('config_language_id'));

			if (!$post_type_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "post_type i LEFT JOIN " . DB_PREFIX . "post_type_description id ON (i.post_type_id = id.post_type_id) WHERE id.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY id.title");

				$post_type_data = $query->rows;

				$this->cache->set('post_type.' . (int)$this->config->get('config_language_id'), $post_type_data);
			}

			return $post_type_data;
		}
	}

	public function getPostTypeDescriptions($post_type_id) {
		$post_type_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "post_type_description WHERE post_type_id = '" . (int)$post_type_id . "'");

		foreach ($query->rows as $result) {
			$post_type_description_data[$result['language_id']] = array(
				'title'            => $result['title'],
				'description'      => $result['description'],
				'meta_title'       => $result['meta_title'],
				'meta_description' => $result['meta_description'],
				'meta_keyword'     => $result['meta_keyword']
			);
		}

		return $post_type_description_data;
	}

	public function getPostTypeStores($post_type_id) {
		$post_type_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "post_type_to_store WHERE post_type_id = '" . (int)$post_type_id . "'");

		foreach ($query->rows as $result) {
			$post_type_store_data[] = $result['store_id'];
		}

		return $post_type_store_data;
	}

	public function getPostTypeLayouts($post_type_id) {
		$post_type_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "post_type_to_layout WHERE post_type_id = '" . (int)$post_type_id . "'");

		foreach ($query->rows as $result) {
			$post_type_store_data[$result['store_id']] = $result['layout_id'];
		}

		return $post_type_store_data;
	}

	public function getTotalPostTypes() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "post_type");

		return $query->row['total'];
	}

	public function getTotalPostTypesByLayoutId($layout_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "post_type_to_layout WHERE layout_id = '" . (int)$layout_id . "'");

		return $query->row['total'];
	}
}