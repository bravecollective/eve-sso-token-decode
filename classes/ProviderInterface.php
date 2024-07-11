<?php

namespace EVE;

use stdClass;

interface ProviderInterface
{
    public function __construct(Settings $settings);

    public function getTokenFromRequest(): ?string;

    public function buildResponse(UserData $data): stdClass;
}
