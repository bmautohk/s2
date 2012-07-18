<?
class CustomPaginatorHelper extends AppHelper {
	
	function hasPrev($params) {
		if (!empty($params)) {
			if ($params["prevPage"] == true) {
				return true;
			}
		}
		return false;
	}
	
	function hasNext($params) {
		if (!empty($params)) {
			if ($params["nextPage"] == true) {
				return true;
			}
		}
		return false;
	}


	function prevButton($model, $class) {
	var_dump($this->params);
		$params = $this->params['paging'][$model];
		if (hasPrev($params)) {
			$page = $params['page'];
			return '<input id="'.$page.'" class="'.$class.'" />';
		}
		else {
			return '<input id="prev" class="'.$class.'" disable="disable" />';
		}
	}

	/**
	* Reference first()
	*/
	function firstTag($first = '<< first', $options = array()) {
		$options = array_merge(
			array(
				'tag' => 'span',
				'after'=> null,
				'model' => $this->defaultModel(),
				'separator' => ' | ',
			),
		(array)$options);

		$params = array_merge(array('page'=> 1), (array)$this->params($options['model']));
		unset($options['model']);

/*		if ($params['pageCount'] <= 1) {
			return false;
		}*/
		extract($options);
		unset($options['tag'], $options['after'], $options['model'], $options['separator']);

		$out = '';

		if (is_int($first) && $params['page'] > $first) {
			if ($after === null) {
				$after = '...';
			}
			for ($i = 1; $i <= $first; $i++) {
				$out .= $this->Html->tag($tag, $this->link($i, array('page' => $i), $options));
				if ($i != $first) {
					$out .= $separator;
				}
			}
			$out .= $after;
		} elseif ($params['page'] > 1) {
			$out = $this->Html->tag($tag, $this->link($first, array('page' => 1), $options))
				. $after;
		} else {
			$out = $this->Html->tag($tag, $first, $options)
				. $after;
		}
		return $out;
	}
	
	/**
	* Reference: last()
	*/
	function lastTag($last = 'last >>', $options = array()) {
		
		return $out;
	}
}
?>