<?php

// Variables
$id = $modx->resource->get('id');
$tpl = $modx->getOption('tpl', $scriptProperties, '');
$tplRss = $modx->getOption('tplRss', $scriptProperties, '');
$copyfrom = $modx->getOption('copyFrom', $scriptProperties, '');
$copytill = $modx->getOption('copyTill', $scriptProperties, '');
$separator = $modx->getOption('copySeparator', $scriptProperties, '');
$rss = $modx->getOption('rss', $scriptProperties, '');

// pdoTools joining
$pdo = $modx->getService('pdoTools');

// Copyright generate
if (!empty($copyfrom) && !empty($copytill) && $copyfrom != $copytill) {
	$copyyears = $copyfrom . $separator . $copytill;
} elseif ((empty($copyfrom) && !empty($copytill)) || (!empty($copytill) && $copytill == $copyfrom)) {
	$copyyears = $copytill;
} elseif (!empty($copyfrom) && empty($copytill)) {
	$copyyears = $copyfrom . $separator . date('Y');
}

// Output call
$output = array(
	'robots' => 'noindex, nofollow',
	'createdby' => $modx->getOption('site_name'),
	'canonical' => $modx->getOption('site_url'),
	'copyyears' => $copyyears ?: date('Y'),
	'copyfrom' => $copyfrom,
	'copytill' => $copytill,
);

// Robots meta
if ($modx->resource->get('searchable')) $output['robots'] = 'index, follow';

// Author meta
if (!empty($created = $modx->resource->get('createdby'))) {
	$user = $modx->getObject('modUser', $created);
	if($user) $output['createdby'] = $user->getOne('Profile')->get('fullname');
}

// Canonical meta
if ($id != $modx->getOption('site_start')) $output['canonical'] = $modx->makeUrl($id, '', '', 'full');

// RSS
$resources = explode(',', $rss);

$count = count($resources);

foreach ($resources as $index => $id) {
	$resource = $modx->getObject('modResource',array('id' => $id));

	if ($resource) {
		$data = array('link' => $modx->makeUrl($id, '', '', 'full'), 'title' => $resource->get('pagetitle'));
		if($tpl && $tplRss) {
			$output['rss'] .= $pdo->getChunk($tplRss, $data);
			if($index != $count) $output['rss'] .= PHP_EOL;
		} else {
			$rsslog[] = $data;
		}
	}
}

if(empty($tpl)) {
	$output['rss'] = $rsslog;
	return '<pre>' . print_r($output, true) . '</pre>';
}

return $pdo->getChunk($tpl, $output);