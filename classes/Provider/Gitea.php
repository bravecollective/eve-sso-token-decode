<?php

namespace EVE\Provider;

use EVE\ProviderInterface;
use EVE\Settings;
use EVE\UserData;
use stdClass;

/**
 * https://gitea.com/api/v1/user
 * https://gitea.com/api/swagger#/user/userGetCurrent
 *
 * Example response:
 * {
 *   "active": true,
 *   "avatar_url": "string",
 *   "created": "2024-07-10T19:18:25.490Z",
 *   "description": "string",
 *   "email": "user@example.com",
 *   "followers_count": 0,
 *   "following_count": 0,
 *   "full_name": "string",
 *   "html_url": "string",
 *   "id": 0,
 *   "is_admin": true,
 *   "language": "string",
 *   "last_login": "2024-07-10T19:18:25.490Z",
 *   "location": "string",
 *   "login": "string",
 *   "login_name": "empty",
 *   "prohibit_login": true,
 *   "restricted": true,
 *   "source_id": 0,
 *   "starred_repos_count": 0,
 *   "visibility": "string",
 *   "website": "string"
 * }
 */
final class Gitea implements ProviderInterface
{
    private Settings $settings;

    public function __construct(Settings $settings)
    {
        $this->settings = $settings;
    }

    public function getTokenFromRequest(): ?string
    {
        return $_GET['access_token'] ?? null;
    }

    public function buildResponse(UserData $data): stdClass
    {
        $result = new stdClass();

        $result->email = $data->id . "@{$this->settings->emailDomain}";
        $result->full_name = $data->fullName;
        $result->id = $data->id;
        $result->login = $data->userName;

        return $result;
    }
}
