<?php
class ModelBlogsBlogsCategory extends Model {
	////cusstom
	public function addBlogsCategoryJson($data) {

		$this->db->query("INSERT INTO " . DB_PREFIX . "blogs_category SET parent_id = '" . (int)$data['parent_id'] . "', `top` = '" . (isset($data['top']) ? (int)$data['top'] : 0) . "', `column` = '" . (int)$data['column'] . "', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', date_modified = NOW(), date_added = NOW()");

		$blogs_category_id = $this->db->getLastId();

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "blogs_category SET image = '" . $this->db->escape($data['image']) . "' WHERE blogs_category_id = '" . (int)$blogs_category_id . "'");
		}

		foreach ($data['category_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "blogs_category_description SET blogs_category_id = '" . (int)$blogs_category_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		// MySQL Hierarchical Data Closure Table Pattern
		$level = 0;

		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "blogs_category_path` WHERE blogs_category_id = '" . (int)$data['parent_id'] . "' ORDER BY `level` ASC");

		foreach ($query->rows as $result) {
			$this->db->query("INSERT INTO `" . DB_PREFIX . "blogs_category_path` SET `blogs_category_id` = '" . (int)$blogs_category_id . "', `path_id` = '" . (int)$result['path_id'] . "', `level` = '" . (int)$level . "'");

			$level++;
		}

		$this->db->query("INSERT INTO `" . DB_PREFIX . "blogs_category_path` SET `blogs_category_id` = '" . (int)$blogs_category_id . "', `path_id` = '" . (int)$blogs_category_id . "', `level` = '" . (int)$level . "'");

		if (isset($data['category_filter'])) {
			foreach ($data['category_filter'] as $filter_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "blogs_category_filter SET blogs_category_id = '" . (int)$blogs_category_id . "', filter_id = '" . (int)$filter_id . "'");
			}
		}

		if (isset($data['category_store'])) {
			foreach ($data['category_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "blogs_category_to_store SET blogs_category_id = '" . (int)$blogs_category_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

	
		if (isset($data['keyword'])) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'blogs_category_id=" . (int)$blogs_category_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('blogs_category');
		return $blogs_category_id;
	}
	public function deleteBlogsCategoryJson($data) {

		$this->db->query("DELETE FROM " . DB_PREFIX . "blogs_category_path WHERE blogs_category_id = '" . (int)$data['blogs_category_id'] . "'");

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blogs_category_path WHERE path_id = '" . (int)$data['blogs_category_id'] . "'");

		foreach ($query->rows as $result) {
			$this->deleteBlogsCategory($result['blogs_category_id']);
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "blogs_category_path WHERE blogs_category_id = '" . (int)$data['blogs_category_id'] . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "blogs_category_path WHERE path_id = '" . (int)$data['blogs_category_id'] . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "blogs_category WHERE blogs_category_id = '" . (int)$data['blogs_category_id'] . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "blogs_category_description WHERE blogs_category_id = '" . (int)$data['blogs_category_id'] . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "blogs_category_filter WHERE blogs_category_id = '" . (int)$data['blogs_category_id'] . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "blogs_category_to_store WHERE blogs_category_id = '" . (int)$data['blogs_category_id'] . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "blogs_category_to_layout WHERE blogs_category_id = '" . (int)$data['blogs_category_id'] . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_category WHERE blogs_category_id = '" . (int)$data['blogs_category_id'] . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'blogs_category_id=" . (int)$data['blogs_category_id'] . "'");

		$this->cache->delete('blogs_category');

	}
	public function getBlogsCategoryDescriptionsJson($blogs_category_id) {
		$category_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blogs_category_description WHERE blogs_category_id = '" . (int)$blogs_category_id . "'");

		foreach ($query->rows as $result) {
			$category_description_data['lang'.$result['language_id']] = array(
				'name'             => html_entity_decode($result['name']),
				'meta_title'       => html_entity_decode($result['meta_title']),
				'meta_description' => html_entity_decode($result['meta_description']),
				'meta_keyword'     => html_entity_decode($result['meta_keyword']),
				// 'description'      => $result['description']
			);
		}

		return $category_description_data;
	}
	public function editJson($data) {

		$this->db->query("UPDATE " . DB_PREFIX . "blogs_category SET parent_id = '" . (int)$data['parent_id'] . "',  status = '" . (int)$data['status'] . "', date_modified = NOW() WHERE blogs_category_id = '" . (int)$data['blogs_category_id']  . "'");

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "blogs_category SET image = '" . $this->db->escape($data['image']) . "' WHERE blogs_category_id = '" . (int)$data['blogs_category_id']  . "'");
		}

		// $this->db->query("DELETE FROM " . DB_PREFIX . "blogs_category_description WHERE blogs_category_id = '" . (int)$data['blogs_category_id']  . "'");

		foreach ($data['category_description'] as $language_id => $value) {
			$this->db->query("UPDATE " . DB_PREFIX . "blogs_category_description SET name = '" . $this->db->escape($value['name']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "' WHERE blogs_category_id = '" . (int)$data['blogs_category_id'] . "' AND language_id = '" . (int)$language_id . "'");
		}

		// MySQL Hierarchical Data Closure Table Pattern
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "blogs_category_path` WHERE path_id = '" . (int)$data['blogs_category_id']  . "' ORDER BY level ASC");

		if ($query->num_rows) {
			foreach ($query->rows as $category_path) {
				// Delete the path below the current one
				$this->db->query("DELETE FROM `" . DB_PREFIX . "blogs_category_path` WHERE blogs_category_id = '" . (int)$category_path['blogs_category_id'] . "' AND level < '" . (int)$category_path['level'] . "'");

				$path = array();

				// Get the nodes new parents
				$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "blogs_category_path` WHERE blogs_category_id = '" . (int)$data['parent_id'] . "' ORDER BY level ASC");

				foreach ($query->rows as $result) {
					$path[] = $result['path_id'];
				}

				// Get whats left of the nodes current path
				$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "blogs_category_path` WHERE blogs_category_id = '" . (int)$category_path['blogs_category_id'] . "' ORDER BY level ASC");

				foreach ($query->rows as $result) {
					$path[] = $result['path_id'];
				}

				// Combine the paths with a new level
				$level = 0;

				foreach ($path as $path_id) {
					$this->db->query("REPLACE INTO `" . DB_PREFIX . "blogs_category_path` SET blogs_category_id = '" . (int)$category_path['blogs_category_id'] . "', `path_id` = '" . (int)$path_id . "', level = '" . (int)$level . "'");

					$level++;
				}
			}
		} else {
			// Delete the path below the current one
			$this->db->query("DELETE FROM `" . DB_PREFIX . "blogs_category_path` WHERE blogs_category_id = '" . (int)$data['blogs_category_id']  . "'");

			// Fix for records with no paths
			$level = 0;

			$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "blogs_category_path` WHERE blogs_category_id = '" . (int)$data['parent_id'] . "' ORDER BY level ASC");

			foreach ($query->rows as $result) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "blogs_category_path` SET blogs_category_id = '" . (int)$data['blogs_category_id']  . "', `path_id` = '" . (int)$result['path_id'] . "', level = '" . (int)$level . "'");

				$level++;
			}

			$this->db->query("REPLACE INTO `" . DB_PREFIX . "blogs_category_path` SET blogs_category_id = '" . (int)$data['blogs_category_id']  . "', `path_id` = '" . (int)$data['blogs_category_id']  . "', level = '" . (int)$level . "'");
		}


		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'blogs_category_id=" . (int)$data['blogs_category_id']  . "'");

		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'blogs_category_id=" . (int)$data['blogs_category_id']  . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('blogs_category');

		$this->event->trigger('post.admin.category.edit', $data['blogs_category_id'] );
	}
	public function getBlogsCategoryJson($blogs_category_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT GROUP_CONCAT(cd1.name ORDER BY level SEPARATOR '&nbsp;&nbsp;&gt;&nbsp;&nbsp;') FROM " . DB_PREFIX . "blogs_category_path cp LEFT JOIN " . DB_PREFIX . "blogs_category_description cd1 ON (cp.path_id = cd1.blogs_category_id AND cp.blogs_category_id != cp.path_id) WHERE cp.blogs_category_id = c.blogs_category_id AND cd1.language_id = '" . (int)$this->config->get('config_language_id') . "' GROUP BY cp.blogs_category_id) AS path, (SELECT DISTINCT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'blogs_category_id=" . (int)$blogs_category_id . "') AS keyword FROM " . DB_PREFIX . "blogs_category c LEFT JOIN " . DB_PREFIX . "blogs_category_description cd2 ON (c.blogs_category_id = cd2.blogs_category_id) WHERE c.blogs_category_id = '" . (int)$blogs_category_id . "' AND cd2.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}
	public function getCategoriesJson($data = array()) {

		$sql = "SELECT cp.blogs_category_id AS blogs_category_id, GROUP_CONCAT(cd1.name ORDER BY cp.level SEPARATOR '&nbsp;&nbsp;&gt;&nbsp;&nbsp;') AS name, c1.parent_id, c1.sort_order FROM " . DB_PREFIX . "blogs_category_path cp LEFT JOIN " . DB_PREFIX . "blogs_category c1 ON (cp.blogs_category_id = c1.blogs_category_id) LEFT JOIN " . DB_PREFIX . "blogs_category c2 ON (cp.path_id = c2.blogs_category_id) LEFT JOIN " . DB_PREFIX . "blogs_category_description cd1 ON (cp.path_id = cd1.blogs_category_id) LEFT JOIN " . DB_PREFIX . "blogs_category_description cd2 ON (cp.blogs_category_id = cd2.blogs_category_id) WHERE cd1.language_id = '" . (int)$this->config->get('config_language_id') . "' AND cd2.language_id = '" . (int)$this->config->get('config_language_id') . "'";
		
		
		if (!empty($data['filter_name'])) {
			$sql .= " AND cd2.name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";

		}
		$sql .= " GROUP BY cp.blogs_category_id";
		$sort_data = array(
			'cd1.name',
			'blogs_category_id',
			'sort_order'
		);
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY sort_order";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " ".$this->config->get('config_sort');
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
	public function getTotalCategoriesJson() {
		// $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "blogs_category");

		// return $query->row['total'];
		return $this->db->count_all('blogs_category');
	}
	////cusstom
	public function addBlogsCategory($data) {
		$this->event->trigger('pre.admin.category.add', $data);
		$this->db->query("INSERT INTO " . DB_PREFIX . "blogs_category SET parent_id = '" . (int)$data['parent_id'] . "', `top` = '" . (isset($data['top']) ? (int)$data['top'] : 0) . "', `column` = '" . (int)$data['column'] . "', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', date_modified = NOW(), date_added = NOW()");

		$blogs_category_id = $this->db->getLastId();

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "blogs_category SET image = '" . $this->db->escape($data['image']) . "' WHERE blogs_category_id = '" . (int)$blogs_category_id . "'");
		}

		foreach ($data['category_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "blogs_category_description SET blogs_category_id = '" . (int)$blogs_category_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		// MySQL Hierarchical Data Closure Table Pattern
		$level = 0;

		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "blogs_category_path` WHERE blogs_category_id = '" . (int)$data['parent_id'] . "' ORDER BY `level` ASC");

		foreach ($query->rows as $result) {
			$this->db->query("INSERT INTO `" . DB_PREFIX . "blogs_category_path` SET `blogs_category_id` = '" . (int)$blogs_category_id . "', `path_id` = '" . (int)$result['path_id'] . "', `level` = '" . (int)$level . "'");

			$level++;
		}

		$this->db->query("INSERT INTO `" . DB_PREFIX . "blogs_category_path` SET `blogs_category_id` = '" . (int)$blogs_category_id . "', `path_id` = '" . (int)$blogs_category_id . "', `level` = '" . (int)$level . "'");

		if (isset($data['category_filter'])) {
			foreach ($data['category_filter'] as $filter_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "blogs_category_filter SET blogs_category_id = '" . (int)$blogs_category_id . "', filter_id = '" . (int)$filter_id . "'");
			}
		}

		if (isset($data['category_store'])) {
			foreach ($data['category_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "blogs_category_to_store SET blogs_category_id = '" . (int)$blogs_category_id . "', store_id = '" . (int)$store_id . "'");
			}
		}


		if (isset($data['keyword'])) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'blogs_category_id=" . (int)$blogs_category_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('blogs_category');

		return $blogs_category_id;
	}

	
	public function editBlogsCategory($blogs_category_id, $data) {

		$this->db->query("UPDATE " . DB_PREFIX . "blogs_category SET parent_id = '" . (int)$data['parent_id'] . "', `top` = '" . (isset($data['top']) ? (int)$data['top'] : 0) . "', `column` = '" . (int)$data['column'] . "', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', date_modified = NOW() WHERE blogs_category_id = '" . (int)$blogs_category_id . "'");

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "blogs_category SET image = '" . $this->db->escape($data['image']) . "' WHERE blogs_category_id = '" . (int)$blogs_category_id . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "blogs_category_description WHERE blogs_category_id = '" . (int)$blogs_category_id . "'");

		foreach ($data['category_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "blogs_category_description SET blogs_category_id = '" . (int)$blogs_category_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		// MySQL Hierarchical Data Closure Table Pattern
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "blogs_category_path` WHERE path_id = '" . (int)$blogs_category_id . "' ORDER BY level ASC");

		if ($query->num_rows) {
			foreach ($query->rows as $category_path) {
				// Delete the path below the current one
				$this->db->query("DELETE FROM `" . DB_PREFIX . "blogs_category_path` WHERE blogs_category_id = '" . (int)$category_path['blogs_category_id'] . "' AND level < '" . (int)$category_path['level'] . "'");

				$path = array();

				// Get the nodes new parents
				$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "blogs_category_path` WHERE blogs_category_id = '" . (int)$data['parent_id'] . "' ORDER BY level ASC");

				foreach ($query->rows as $result) {
					$path[] = $result['path_id'];
				}

				// Get whats left of the nodes current path
				$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "blogs_category_path` WHERE blogs_category_id = '" . (int)$category_path['blogs_category_id'] . "' ORDER BY level ASC");

				foreach ($query->rows as $result) {
					$path[] = $result['path_id'];
				}

				// Combine the paths with a new level
				$level = 0;

				foreach ($path as $path_id) {
					$this->db->query("REPLACE INTO `" . DB_PREFIX . "blogs_category_path` SET blogs_category_id = '" . (int)$category_path['blogs_category_id'] . "', `path_id` = '" . (int)$path_id . "', level = '" . (int)$level . "'");

					$level++;
				}
			}
		} else {
			// Delete the path below the current one
			$this->db->query("DELETE FROM `" . DB_PREFIX . "blogs_category_path` WHERE blogs_category_id = '" . (int)$blogs_category_id . "'");

			// Fix for records with no paths
			$level = 0;

			$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "blogs_category_path` WHERE blogs_category_id = '" . (int)$data['parent_id'] . "' ORDER BY level ASC");

			foreach ($query->rows as $result) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "blogs_category_path` SET blogs_category_id = '" . (int)$blogs_category_id . "', `path_id` = '" . (int)$result['path_id'] . "', level = '" . (int)$level . "'");

				$level++;
			}

			$this->db->query("REPLACE INTO `" . DB_PREFIX . "blogs_category_path` SET blogs_category_id = '" . (int)$blogs_category_id . "', `path_id` = '" . (int)$blogs_category_id . "', level = '" . (int)$level . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "blogs_category_filter WHERE blogs_category_id = '" . (int)$blogs_category_id . "'");

		if (isset($data['category_filter'])) {
			foreach ($data['category_filter'] as $filter_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "blogs_category_filter SET blogs_category_id = '" . (int)$blogs_category_id . "', filter_id = '" . (int)$filter_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "blogs_category_to_store WHERE blogs_category_id = '" . (int)$blogs_category_id . "'");

		if (isset($data['category_store'])) {
			foreach ($data['category_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "blogs_category_to_store SET blogs_category_id = '" . (int)$blogs_category_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "blogs_category_to_layout WHERE blogs_category_id = '" . (int)$blogs_category_id . "'");

		if (isset($data['category_layout'])) {
			foreach ($data['category_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "blogs_category_to_layout SET blogs_category_id = '" . (int)$blogs_category_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'blogs_category_id=" . (int)$blogs_category_id . "'");

		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'blogs_category_id=" . (int)$blogs_category_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('blogs_category');
	}

	public function deleteBlogsCategory($blogs_category_id) {

		$this->db->query("DELETE FROM " . DB_PREFIX . "blogs_category_path WHERE blogs_category_id = '" . (int)$blogs_category_id . "'");

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blogs_category_path WHERE path_id = '" . (int)$blogs_category_id . "'");

		foreach ($query->rows as $result) {
			$this->deleteBlogsCategory($result['blogs_category_id']);
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "blogs_category WHERE blogs_category_id = '" . (int)$blogs_category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "blogs_category_description WHERE blogs_category_id = '" . (int)$blogs_category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "blogs_category_filter WHERE blogs_category_id = '" . (int)$blogs_category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "blogs_category_to_store WHERE blogs_category_id = '" . (int)$blogs_category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "blogs_category_to_layout WHERE blogs_category_id = '" . (int)$blogs_category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "blogs_to_category WHERE blogs_category_id = '" . (int)$blogs_category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'blogs_category_id=" . (int)$blogs_category_id . "'");

		$this->cache->delete('blogs_category');
	}

	public function repairCategories($parent_id = 0) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blogs_category WHERE parent_id = '" . (int)$parent_id . "'");

		foreach ($query->rows as $category) {
			// Delete the path below the current one
			$this->db->query("DELETE FROM `" . DB_PREFIX . "blogs_category_path` WHERE blogs_category_id = '" . (int)$category['blogs_category_id'] . "'");

			// Fix for records with no paths
			$level = 0;

			$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "blogs_category_path` WHERE blogs_category_id = '" . (int)$parent_id . "' ORDER BY level ASC");

			foreach ($query->rows as $result) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "blogs_category_path` SET blogs_category_id = '" . (int)$category['blogs_category_id'] . "', `path_id` = '" . (int)$result['path_id'] . "', level = '" . (int)$level . "'");

				$level++;
			}

			$this->db->query("REPLACE INTO `" . DB_PREFIX . "blogs_category_path` SET blogs_category_id = '" . (int)$category['blogs_category_id'] . "', `path_id` = '" . (int)$category['blogs_category_id'] . "', level = '" . (int)$level . "'");

			$this->repairCategories($category['blogs_category_id']);
		}
	}

	public function getBlogsCategory($blogs_category_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT GROUP_CONCAT(cd1.name ORDER BY level SEPARATOR '&nbsp;&nbsp;&gt;&nbsp;&nbsp;') FROM " . DB_PREFIX . "blogs_category_path cp LEFT JOIN " . DB_PREFIX . "blogs_category_description cd1 ON (cp.path_id = cd1.blogs_category_id AND cp.blogs_category_id != cp.path_id) WHERE cp.blogs_category_id = c.blogs_category_id AND cd1.language_id = '" . (int)$this->config->get('config_language_id') . "' GROUP BY cp.blogs_category_id) AS path, (SELECT DISTINCT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'blogs_category_id=" . (int)$blogs_category_id . "') AS keyword FROM " . DB_PREFIX . "blogs_category c LEFT JOIN " . DB_PREFIX . "blogs_category_description cd2 ON (c.blogs_category_id = cd2.blogs_category_id) WHERE c.blogs_category_id = '" . (int)$blogs_category_id . "' AND cd2.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getCategories($data = array()) {
		$sql = "SELECT cp.blogs_category_id AS blogs_category_id, GROUP_CONCAT(cd1.name ORDER BY cp.level SEPARATOR '&nbsp;&nbsp;&gt;&nbsp;&nbsp;') AS name, c1.parent_id, c1.sort_order FROM " . DB_PREFIX . "blogs_category_path cp LEFT JOIN " . DB_PREFIX . "blogs_category c1 ON (cp.blogs_category_id = c1.blogs_category_id) LEFT JOIN " . DB_PREFIX . "blogs_category c2 ON (cp.path_id = c2.blogs_category_id) LEFT JOIN " . DB_PREFIX . "blogs_category_description cd1 ON (cp.path_id = cd1.blogs_category_id) LEFT JOIN " . DB_PREFIX . "blogs_category_description cd2 ON (cp.blogs_category_id = cd2.blogs_category_id) WHERE cd1.language_id = '" . (int)$this->config->get('config_language_id') . "' AND cd2.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND cd2.name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}

		$sql .= " GROUP BY cp.blogs_category_id";

		$sort_data = array(
			'name',
			'sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY sort_order";
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

	public function getBlogsCategoryDescriptions($blogs_category_id) {
		$category_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blogs_category_description WHERE blogs_category_id = '" . (int)$blogs_category_id . "'");

		foreach ($query->rows as $result) {
			$category_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
				'meta_title'       => $result['meta_title'],
				'meta_description' => $result['meta_description'],
				'meta_keyword'     => $result['meta_keyword'],
				'description'      => $result['description']
			);
		}

		return $category_description_data;
	}

	public function getBlogsCategoryFilters($blogs_category_id) {
		$category_filter_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blogs_category_filter WHERE blogs_category_id = '" . (int)$blogs_category_id . "'");

		foreach ($query->rows as $result) {
			$category_filter_data[] = $result['filter_id'];
		}

		return $category_filter_data;
	}

	public function getBlogsCategoryStores($blogs_category_id) {
		$category_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blogs_category_to_store WHERE blogs_category_id = '" . (int)$blogs_category_id . "'");

		foreach ($query->rows as $result) {
			$category_store_data[] = $result['store_id'];
		}

		return $category_store_data;
	}

	public function getBlogsCategoryLayouts($blogs_category_id) {
		$category_layout_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blogs_category_to_layout WHERE blogs_category_id = '" . (int)$blogs_category_id . "'");

		foreach ($query->rows as $result) {
			$category_layout_data[$result['store_id']] = $result['layout_id'];
		}

		return $category_layout_data;
	}

	public function getTotalCategories() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "blogs_category");

		return $query->row['total'];
	}
	
	public function getTotalCategoriesByLayoutId($layout_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "blogs_category_to_layout WHERE layout_id = '" . (int)$layout_id . "'");

		return $query->row['total'];
	}	
}
