<?php

namespace Shippinno\Labs\Tests\Unit\Infrastructure\Domain\Model\User;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Shippinno\Labs\Domain\Model\User\User;
use Shippinno\Labs\Domain\Model\User\UserId;
use Shippinno\Labs\Infrastructure\Domain\Model\User\Auth0UserRepository;

class Auth0UserRepositoryTest extends TestCase
{
//    public function testItReturnsUserOfId()
//    {
//        $userId = new UserId('google-oauth2|103940066570414158309');
//        $repository = new Auth0UserRepository(new Client());
//        $user = $repository->userOfId($userId);
//        $this->assertTrue($user->userId()->equals($userId));
//        $this->assertSame('hirofumi.tanigami', $user->nickname());
//    }
//
//    public function testItReturnsNullIfUserOfIdNotFound()
//    {
//        $userId = new UserId('google-oauth2|0000000000000000000000');
//        $repository = new Auth0UserRepository(new Client());
//        $user = $repository->userOfId($userId);
//        $this->assertNull($user);
//    }
//
//    public function estItUpdatesUser()
//    {
//        // testable?
//
//        $user = new User(
//            new UserId('google-oauth2|103940066570414158309'),
//            'htanigami'
//        );
//        $repository = new Auth0UserRepository(new Client());
//        $repository->save($user);
//    }
//
//    public function testItRemovesUser()
//    {
//        // testable?
//
//        $user = new User(
//            new UserId('google-oauth2|103940066570414158309'),
//            'vvvv'
//        );
//        $repository = new Auth0UserRepository(new Client());
//        $repository->remove($user);
//    }
}