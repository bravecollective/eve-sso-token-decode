<?php

namespace EVE;

final class Settings
{
    public function __construct(
        public readonly string $emailDomain,
    ) {
    }
}
