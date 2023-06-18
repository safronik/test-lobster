<?php

namespace LobsterTest\DB;

class DBConfig
{
    public function __construct(
        public string $dsn,
        public string $username,
        public string $password
    ){}
}