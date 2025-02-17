<?php

declare(strict_types=1);

return [
  ['GET', '/hello-world', static function (): void {
    echo 'Hello World';
  }],

  ['GET', '/another-route', static function (): void {
    echo 'This works too';
  }],
];
