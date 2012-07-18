<?
class PagingComponent extends Object {
	var $limit = 0;
	var $fields = array();
	
	function paginate($object = null, $conditions = null, $limit = NULL, $page = NULL, $count = -1) {
		if ($count < 0) {
			$count = $object->find('count', $conditions);
		}

		$pageCount = intval(ceil($count / $limit));
		
		$parameters = compact('conditions', 'fields', 'order', 'limit', 'page');
		$results = $object->find('all', $parameters);
		
		$paging = array(
			'page'		=> $page,
			'current'	=> count($results),
			'count'		=> $count,
			'prevPage'	=> ($page > 1),
			'nextPage'	=> ($count > ($page * $limit)),
			'pageCount'	=> $pageCount
		);
		
		$controller->params['paging'][$object->alias] = $paging;
		
		return $results;
	}
}
?>