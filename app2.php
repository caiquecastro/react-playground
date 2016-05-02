<?php
require_once 'vendor/autoload.php';

$loop = React\EventLoop\Factory::create();
$socket = new React\Socket\Server($loop);

$socket->on('connection', function ($conn) use ($loop) {
  $conn->write("Successfully connected to the writing servern");
  echo 'client connected' . PHP_EOL;
  $dataStream = new React\Stream\Stream(fopen('data.txt', 'w'), $loop);

  $conn->on('data', function($data) use ($conn, $dataStream) {
      $dataStream->write($data);
    });

  $conn->on('end', function() {
      echo 'connection closed' . PHP_EOL;
    });
});

$socket->listen(4000);
$loop->run();
