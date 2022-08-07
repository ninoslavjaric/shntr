<?php


// fetch bootstrap
require('../../../bootstrap.php');

// check AJAX Request
is_ajax();
/**
 * @var $db mysqli
 */

if (!array_key_exists('query', $_GET) || !array_key_exists('type', $_GET)) {
    _error(400);
}
$query = $_GET['query'];

$queries = explode(' ', $query);

$cacheKey = md5(__FILE__) . '::' . $_GET['type'] . '::' . urlencode($_GET['query']);

if ($cacheResult = Cache::get($cacheKey)) {
    return_json($cacheResult);
}

switch ($_GET['type']) {
    case 'countries':
        $liker = array_map(function($str) {
            return "name like '%{$str}%'";
        }, $queries);

        $liker = implode(' and ', $liker);

        $sql = "select 
            id as country_id, null as state_id, null as city_id, name as value 
        from countries where {$liker}
        order by countries.name";
        break;

    case 'states':
        $liker = array_map(function($str) {
            return "concat(co.name, st.name, st.alternative_name) like '%{$str}%'";
        }, $queries);

        $liker = implode(' and ', $liker);

        $sql = "select
                    co.id as country_id, 
                    st.id as state_id, 
                    concat(co.name, ' > ', st.name) as value
                from states as st
                         inner join countries as co on co.id = st.country_id
                where {$liker}
                order by co.name, st.alternative_name";
        break;

    case 'places':
        $liker = array_map(function($str) {
            return "concat(co.name, if(isnull(st.name), '', concat(st.name, st.alternative_name)), ct.name, ct.asciiname, ct.alternatenames) like '%{$str}%'";
        }, $queries);

        $liker = implode(' and ', $liker);

        $sql = "select
                    co.id as country_id, 
                    st.id as state_id, 
                    ct.id as city_id, 
                    concat(co.name, if(isnull(st.name), '', concat(' > ', st.name)), ' > ', ct.name) as value
                from places as ct
                         left join states as st on st.id = ct.state_id
                         inner join countries as co on co.id = ct.country_id
                where {$liker}
                order by ct.population desc, ct.asciiname, st.alternative_name, co.name";
        break;
}

$dbQuery = $db->query($sql);

$result = $dbQuery->fetch_all(MYSQLI_ASSOC);

Cache::set($cacheKey, $result);

return_json($result);
