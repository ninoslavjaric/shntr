<?php


// fetch bootstrap
require('../../../bootstrap.php');

// check AJAX Request
is_ajax();
/**
 * @var $db mysqli
 * @var $user User
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
        $initLiker = array_map(function($str) {
            return "concat(co.name, if(isnull(st.name), '', concat(st.name, st.alternative_name)), ct.name, ct.asciiname, ct.alternatenames) like '%{$str}%'";
        }, $queries);

        $initLiker = implode(' and ', $initLiker);

        $sqlQueries = [
            'drop temporary table if exists tmp_suggestions;',
            'create temporary table tmp_suggestions (
                coid int(10), 
                stid int(10), 
                ctid int(10), 
                value varchar(255), 
                score int(10) default 0, 
                population int(10),

                city_name varchar(255),
                city_asciiname varchar(255),
                city_alternatenames text,
                state_name varchar(255),
                state_alternative_name varchar(255),
                country_name varchar(255), 
                latitude float,
                longitude float,
                unique (coid, stid, ctid)
            );',
            "insert into tmp_suggestions select 
                    co.id as country_id, 
                    st.id as state_id, 
                    ct.id as city_id, 
                    concat(co.name, if(isnull(st.name), '', concat(' > ', st.name)), ' > ', ct.name) as value,
                    0 as score, 
                    ct.population,
                                   
                    ct.name as city_name,
                    ct.asciiname as city_asciiname,
                    ct.alternatenames as city_alternatenames,
                    st.name as state_name,
                    st.alternative_name as state_alternative_name,
                    co.name as country_name,
                    ct.latitude as latitude,
                    ct.longitude as longitude
                from places as ct
                         left join states as st on st.id = ct.state_id
                         inner join countries as co on co.id = ct.country_id
                where {$initLiker};",
        ];

        foreach ($sqlQueries as $sql) {
            $db->query($sql);
//            echo($sql . PHP_EOL);
        }

        $getMatchCount = function(string $col, string $term): string {
            global $db;

            $term = $db->escape_string($term);

            return "ROUND((LENGTH(LOWER({$col})) - LENGTH(REPLACE(LOWER({$col}), '{$term}', ''))) / LENGTH('{$term}'))";
        };

        $likers = array_map(function($str) use ($getMatchCount) {
            return [
                2048 => ["city_name like '% {$str} %' or city_name like '{$str}'", '2048'],
                1024 => ["city_name like '%{$str}%'", '1024 * ' . $getMatchCount('city_name', $str)],
                512 => ["city_asciiname like '% {$str} %' or city_asciiname like '{$str}'", '512'],
                256 => ["city_asciiname like '%{$str}%'", '256 * ' . $getMatchCount('city_asciiname', $str)],
                128 => ["city_alternatenames like '% {$str} %' or city_alternatenames like '{$str}'", '128'],
                64 => ["city_alternatenames like '%{$str}%'", '64 * ' . $getMatchCount('city_alternatenames', $str)],
                32 => ["state_name like '% {$str} %' or state_name like '{$str}'", '32'],
                16 => ["state_name like '%{$str}%'", '16 * ' . $getMatchCount('state_name', $str)],
                8 => ["state_alternative_name like '% {$str} %' or state_alternative_name like '{$str}'", '8'],
                4 => ["state_alternative_name like '%{$str}%'", '4 * ' . $getMatchCount('state_alternative_name', $str)],
                2 => ["country_name like '% {$str} %' or country_name like '{$str}'", '2'],
                1 => ["country_name like '%{$str}%'", '1 * ' . $getMatchCount('country_name', $str)],
            ];
        }, $queries);

        $likers = array_merge(...$likers);

        foreach ($likers as [$where, $score]) {
            $sql = "update tmp_suggestions set score = score + {$score} where {$where};";
//            echo($sql . PHP_EOL);
            $db->query($sql);
        }

        $place = [
            'latitude' => null,
            'longitude' => null,
        ];
        if (
            ($user_current_place_id = $user->_data['user_current_place_id']
                ?:  $user->_data['user_hometown_place_id'] ?: null)
        ) {
            $place = $db->query(
                "select latitude, longitude from places where id = {$user_current_place_id}"
            )->fetch_assoc();
        }

        $user_longitude = $user->_data['user_longitude'] ?: $place['longitude'] ?: null?: 11.576124; //$user->_data['user_longitude'];
        $user_latitude = $user->_data['user_latitude'] ?: $place['latitude'] ?: null?: 48.137154; //$user->_data['user_latitude'];

        $distanceInHundreds = 0;
        if ($user_longitude && $user_latitude) {
            $distanceInHundreds = "round(coalesce((6371 * acos(
                                           cos(radians(latitude))
                                           * cos(radians({$user_latitude}))
                                           * cos(radians({$user_longitude}) - radians(longitude))
                                       + sin(radians(latitude))
                                               * sin(radians({$user_latitude}))
                               )), 99999))";
        }

        $sql = "select *, score - {$distanceInHundreds} as final_score from tmp_suggestions order by final_score desc, population desc limit 5";
//        echo($sql . PHP_EOL);die;
        break;
}
$dbQuery = $db->query($sql);

$result = $dbQuery->fetch_all(MYSQLI_ASSOC);

Cache::set($cacheKey, $result);

return_json($result);
