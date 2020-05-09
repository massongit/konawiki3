<?php
// file: kona3database.inc.php

function kona3db_getPageId($page, $canCreate = TRUE) {
  $r = db_get1(
    "SELECT * FROM pages ".
    "WHERE name = ? ".
    "LIMIT 1", [$page]);
  if ($r) {
    $page_id = $r['page_id'];
    return $page_id;
  }
  if ($canCreate) {
    $page_id = db_insert(
      "INSERT INTO pages (name, ctime, mtime)".
      "VALUES(?, ?, ?)",
      [$page, time(), time()]);
    return $page_id;
  }
  return 0;
}


function kona3db_getPageNameById($page_id) {
  global $kona3db_pagenames;
  if (isset($kona3db_pagenames[$page_id])) {
    return $kona3db_pagenames[$page_id];
  }
  if (!isset($kona3db_pagenames)) {
    $kona3db_pagenames = [];
  }
  
  $r = db_get1(
    "SELECT * FROM pages ".
    "WHERE page_id = ? ".
    "LIMIT 1", [$page_id]);
  if ($r) {
    $name = $kona3db_pagenames[$page_id] = $r['name'];
    return $name;
  }
  return '';
}

function kona3db_writePage($page, $body, $user_id=0) {
  $page_id = kona3db_getPageId($page);
  $hash = kona3getHash($body);
  // check 1 hour history
  $recent_time = time() - (60 * 60 * 1);
  $r = db_get1(
    "SELECT * FROM page_history ".
    "WHERE page_id=? AND mtime > ? AND user_id=?",
    [$page_id, $recent_time, $user_id]);
  if ($r) {
    $history_id = $r['history_id'];
    db_exec(
      "UPDATE page_history SET ".
      "body=?,hash=?,mtime=?,user_id=? ".
      "WHERE history_id=?",
      [$body, $hash, time(), $user_id, $history_id]);
  } else {
    db_exec(
      "INSERT INTO page_history".
      "(page_id,user_id,body,hash,mtime)".
      "VALUES(?,?,?,?,?)",
      [$page_id, $user_id, $body, $hash, time()]);
  }
  return TRUE;
}

function kona3db_getUserById($user_id) {
  // check cache
  global $kona3db_users;
  if (!isset($kona3db_users)) { $kona3db_users = []; }
  if (isset($kona3db_users[$user_id])) {
    return $kona3db_users[$user_id]; 
  }
  if ($user_id == 0) {
    $u = kona3getLoginInfo();
    $Kona3db_users[0] = $u;
    return $u;
  }
  // select
  $r = db_get1("SELECT * FROM users WHERE user_id=?",
    [$user_id]);
  $kona3db_users[$user_id] = $r;
  return $r;
}

function kona3db_getUserNameById($user_id) {
  $u = kona3db_getUserById($user_id);
  return $u['name'];
}


function kona3db_getPageHistory($page) {
  $page_id = kona3db_getPageId($page);
  $r = db_get(
    "SELECT * FROM page_history ".
    "WHERE page_id=? ORDER BY history_id DESC",
    [$page_id]);
  if ($r) {
    foreach ($r as &$v) {
      $v['user'] = kona3db_getUserNameById($v['user_id']);
      $v['link'] = kona3getPageURL($page, "edit", "",
        kona3getURLParams([
          "q" => "history",
          "history_id" => $v['history_id'],
        ]));
      $v['delete_link'] = kona3getPageURL(
        $page, "edit", "",
        kona3getURLParams([
          "cmd" => "history_delete",
          "history_id" => $v['history_id'],
          "hash" => $v['hash'],
        ]));
      $v['size'] = strlen($v['body']);
    }
  }
  return $r;
}

function kona3db_getPageHistoryById($history_id) {
  $r = db_get1(
    "SELECT * FROM page_history ".
    "WHERE history_id=?",
    [$history_id]);
  return $r;
}

function kona3db_getPageHistoryByUserId($user_id) {
  $r = db_get(
    "SELECT * FROM page_history ".
    "WHERE user_id=? "
    [$user_id]);
  foreach ($r as &$v) {
    $page_id = $v['page_id'];
    $v['page'] = kona3db_getPageNameById($page_id);
  }
  return $r;
}


