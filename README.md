# EVE SSO Token Decode

A simple web application that decodes an EVE Online SSO JSON web token. It does _not_ verify
the token signature or any other data.

Provides different URLs for results that are compatible with different OAuth2 providers. 
Available providers:

- [Gitea](https://gitea.com)

## Install

Requires an HTTP Server with PHP >= 8.1 support.

- Clone the repository.
- Copy `app.ini.dist` to `app.ini` and adjust values.
- Point the directory root of your webserver to the `public` directory.

## How to Use

You can use the URL for applications that support login via OAuth2 but do not support EVE Online
directly. For example, use this as the "Profile URL" with the "Gitea" provider with custom URLs for
[Forgejo](https://forgejo.org/).
