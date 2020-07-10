# konawiki3

 - Wiki clone
 - Konawiki --- http://kujirahand.com/konawiki3/

## Konawiki3の目標

Konawikiは原稿の執筆やマニュアルの作成に特化したシンプルなWikiです。Wikiのデータはただのテキストファイルなので、Gitと連携して詳細な差分を取ることもできます。開発者は何年もテキストエディタの代わりにKonawiki3を使用しています。小さくシンプルなKonawikiを使って大きな仕事を成し遂げよう！

## セキュリティアップデートのお知らせ (2020/07/10)

Konawiki3.1.0 以前のバージョンに不正なページ名を指定した時にディレクトリトラバーサルの脆弱性がありました。
現在は修正されています。最新版にアップデートしてください。

## Konawiki3 is simple.

It is very simple PHP wiki engine. (Looks like PukiWiki).

```
* header

text text text text

** header2

table:

| table | test
| aaa | bbb

list:

- item1
- item2
- item3

code:

{{{#code(js)
console.log('hello');
}}}
```

## 日本語Wiki記法のサポート

Konawiki2に由来する、日本語Wiki記法をサポートしています。

```
■大見出し

text text text text

●中見出し

text text text text

▲小見出し

text text text text

リスト

・item1
・item2
・item3
```

# How to install Konawiki3

- 1. Install WebServer and PHP7
- 2. Download
 - ``git clone https://github.com/kujirahand/konawiki3.git``
- 3. Change Current Directory
 - ``cd konawiki3``
- 4. Copy Config file
 - ``cp tmp-konawiki3.ini.php konawiki3.ini.php``

## Install Library

- 5. Execute commands

```
cd kona3engine
composer install
```

## Git support

You can commit and push wiki diffs to your git repository.

```
# set your remote repository in data/
$ cd data
$ git remote add origin git@github.com:hoge/fuga.git

# run setup script
$ cd ../kona3engine
$ bash enable_git_support.sh
```
