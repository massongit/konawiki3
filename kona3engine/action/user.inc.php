<?php

function kona3_action_user() {
  global $kona3conf;

  $name = $kona3conf['page'];
  $u = kona3db_getUserByName($name);
  // admin user?
  if (!$u) {
    $admin_users = kona3getAdminUsers();
    if (isset($admin_users[$name])) {
      $u = [
        "user_id" => 0,
        "user" => $name,
        "name" => $name,
      ];
    }
  }
  if (!$u) {
    return kona3error('NG', 'Sorry, unknown user');
  }
  $user_id = $u['user_id'];
  $pages = kona3db_getPageHistoryByUserId($user_id);
  $edit_token = kona3_getEditToken();
  kona3template("user.html",[
    "pages" => $pages,
    "user_id" => $user_id,
    "name" => $name,
    "userList_link" => kona3getPageURL($name, 'users', '', "edit_token=$edit_token"),
    "emailLogs_link" => kona3getPageURL($name, 'emailLogs'),
    "editConf_link" => kona3getPageURL($name, 'editConf'),
  ]);
}

