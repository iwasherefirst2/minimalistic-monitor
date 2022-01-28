<?php

$config = require __DIR__ .'/config.php';

if(file_exists(__DIR__ . '/' . $config['db'])){
	return;
}

$db = new SQLite3($config['db']);

$sql =<<<EOF
      CREATE TABLE requests
      (ID INTEGER PRIMARY KEY     NOT NULL,
      available           BOOL    NOT NULL,
      http_code	  INT,	
      duration_request            INT,
      duration_dns INT,
      create_at DATE 	DEFAULT (datetime('now','localtime'))
	);
EOF;

$return = $db->exec($sql);
if(!$return){
    echo $db->lastErrorMsg();
}else {
    echo "Table created successfully\n";
}
$db->close();
