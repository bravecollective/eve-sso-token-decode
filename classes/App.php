<?php

namespace EVE;

use EVE\Provider\Gitea;
use Exception;
use stdClass;

final class App
{
    public static function run(string $className): void
    {
        $ini = parse_ini_file(__DIR__ . '/../app.ini');
        $settings = new Settings($ini['EMAIL_DOMAIN'] ?? '');

        match ($className) {
            Gitea::class => $provider = new Gitea($settings),
            default => $provider = null,
        };
        if (!$provider) {
            error_log('Missing provider.');
            self::output(null);
            return;
        }

        $token = $provider->getTokenFromRequest();
        if (!is_string($token) || $token === '') {
            error_log('Missing token.');
            self::output(null);
            return;
        }

        $payload = json_decode(
            base64_decode(
                str_replace(
                    ['-', '_'],
                    ['+', '/'],
                    explode('.', $token)[1]
                )
            )
        );
        try {
            $tokenData = new UserData($payload);
        } catch (Exception $e) {
            error_log($e->getMessage());
            self::output(null);
            return;
        }

        $result = $provider->buildResponse($tokenData);
        self::output($result);
    }

    private static function output(?stdClass $data): void
    {
        header('Content-type: application/json');
        if ($data === null) {
            header('HTTP/1.1 400 Bad Request');
        } else {
            echo json_encode($data);
        }
    }
}
