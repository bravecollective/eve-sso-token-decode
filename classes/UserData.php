<?php

namespace EVE;

use Exception;
use stdClass;

/**
 * https://docs.esi.evetech.net/docs/sso/validating_eve_jwt.html
 *
 * Example access token:
 * {
 *   "scp": [
 *     "esi-skills.read_skills.v1",
 *     "esi-skills.read_skillqueue.v1"
 *   ],
 *   "jti": "998e12c7-3241-43c5-8355-2c48822e0a1b",
 *   "kid": "JWT-Signature-Key",
 *   "sub": "CHARACTER:EVE:123123",
 *   "azp": "my3rdpartyclientid",
 *   "tenant": "tranquility",
 *   "tier": "live",
 *   "region": "world",
 *   "aud": ["my3rdpartyclientid", "EVE Online"],
 *   "name": "Some Bloke",
 *   "owner": "8PmzCeTKb4VFUDrHLc/AeZXDSWM=",
 *   "exp": 1648563218,
 *   "iat": 1648562018,
 *   "iss": "login.eveonline.com"
 * }
 */
final class UserData
{
    public readonly int $id;

    public readonly string $fullName;

    public readonly string $userName;

    /**
     * @throws Exception
     */
    public function __construct(stdClass $payload)
    {
        $charId = (int)str_replace('CHARACTER:EVE:', '', $payload->sub);
        if ($charId === 0) {
            throw new Exception('Invalid ID');
        }

        // see also https://support.eveonline.com/hc/en-us/articles/8563435867804-EVE-Online-Naming-Policy
        $login = trim(strtolower(preg_replace('/[^a-zA-Z0-9-.]/', '_', $payload->name)), '_-.');
        if ($login === '') {
            $login = uniqid('u_');
        }

        $this->id = $charId;
        $this->fullName = (string)$payload->name;
        $this->userName = $login;
    }
}
