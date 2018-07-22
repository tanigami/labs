<?php

namespace Shippinno\Labs\Infrastructure\Domain\Model\User;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Shippinno\Labs\Domain\Model\User\User;
use Shippinno\Labs\Domain\Model\User\UserId;
use Shippinno\Labs\Domain\Model\User\UserRepository;
use Tanigami\ValueObjects\Web\HttpMethod;

class Auth0UserRepository implements UserRepository
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var string
     */
    private $token;

    /**
     * Auth0UserRepository constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * {@inheritdoc}
     */
    public function userOfId(UserId $userId): ?User
    {
        $response = $this->request(
            HttpMethod::get(),
            'https://learnapptest.auth0.com/api/v2/users/' . $userId->id()
        );
        return new User(
            new UserId($response['user_id']),
            $response['nickname']
        );
    }

    /**
     * @param $specification
     * @param bool $singleResult
     * @return User[]|User|null
     */
    public function satisfying($specification, bool $singleResult = false)
    {
        // TODO: Implement satisfying() method.
    }

    /**
     * {@inheritdoc}
     */
    public function save(User $user): void
    {
        $this->request(
            HttpMethod::patch(),
            'https://learnapptest.auth0.com/api/v2/users/' . $user->userId()->id(),
            [
                'username' => $user->nickname(),
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function remove(User $user): void
    {
        $this->request(
            HttpMethod::delete(),
            'https://learnapptest.auth0.com/api/v2/users/' . $user->userId()->id()
        );
    }

    private function request(HttpMethod $method, string $path, array $params = []): array
    {
        if (is_null($this->token)) {
            $this->token = '';
        }
        $options = ['headers' => ['Authorization' => 'Bearer ' . $this->token]];
        if ($method->equals(HttpMethod::get())) {
            $params = ['query' => $params];
        } else {
            $params = ['json' => $params];
        }
        $options = array_merge($options, $params);
        var_dump($options);
        $response = $this->client
            ->request($method->toString(), $path, $options)
            ->getBody()
            ->getContents();

        return json_decode($response, true);
    }
}

//        {
//            "email": "hirofumi.tanigami@shippinno.co.jp",
//  "email_verified": true,
//  "name": "谷上周史",
//  "given_name": "周史",
//  "family_name": "谷上",
//  "picture": "https://lh5.googleusercontent.com/-pXRISIjtwsA/AAAAAAAAAAI/AAAAAAAAAAs/E3IMkN3PwmQ/photo.jpg",
//  "locale": "ja",
//  "updated_at": "2018-07-20T11:52:42.602Z",
//  "user_id": "google-oauth2|103940066570414158309",
//  "nickname": "hirofumi.tanigami",
//  "identities": [
//    {
//        "provider": "google-oauth2",
//      "access_token": "ya29.Glz-BQatPWDru6Wy8Kh-RQGLVLJhZTH7QvZ5WPpC2d9_IHK-Ns4lk4AVcx3iNxzrBwDtwQZZmQ8uujk65aERzahmZBmQJ3h-ixZYbf9sptJh9jgXEGR8-C6CnC1mgA",
//      "expires_in": 3599,
//      "user_id": "103940066570414158309",
//      "connection": "google-oauth2",
//      "isSocial": true
//    }
//  ],
//  "created_at": "2018-07-19T14:06:05.549Z",
//  "last_ip": "126.233.1.233",
//  "last_login": "2018-07-20T11:52:42.602Z",
//  "logins_count": 20
//}