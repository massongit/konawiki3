/* file:info.sqlite */

/* ユーザー情報 */
CREATE TABLE users (
  user_id INTEGER PRIMARY KEY,
  name TEXT,
  email TEXT,
  password TEXT,
  token TEXT,
  perm TEXT DEFAULT 'normal', /* normal or admin  */
  enabled INTEGER DEFAULT 0, /* 0:disabled 1:enabled */
  auth_type TEXT DEFAULT 'email',
  memo TEXT DEFAULT '',
  ctime INTEGER DEFAULT 0,
  mtime INTEGER DEFAULT 0
);

/* ページ情報 */
CREATE TABLE pages (
  page_id INTEGER PRIMARY KEY,
  name TEXT,
  ctime INTEGER,
  mtime INTEGER
);

/* ページ更新履歴 */
CREATE TABLE page_history (
  history_id INTEGER PRIMARY KEY,
  page_id INTEGER,
  user_id INTEGER,
  body TEXT,
  hash TEXT,
  mtime INTEGER
);

CREATE TABLE email_logs (
  email_log_id INTEGER PRIMARY KEY,
  mailto TEXT,
  body TEXT,
  title TEXT,
  ctime INTEGER
);

