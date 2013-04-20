twstreamgetter
==============

twitterのstreaming APIから取得したtweetをリアルタイムに保存していく


## how to use

```
$ mysql -u user_name -p schema_name < DDL.sql

```

```
$ vi app/Config/database.php
```

```
$ cd app/Console
$ ./cake stream HASH_TAG | ./cake save ISSUE_NAME &

```