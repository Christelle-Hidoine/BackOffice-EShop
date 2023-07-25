<?php 

namespace App\Tests;

use App\Models\AppUser;
use PHPUnit\Framework\TestCase;

class AppUserTest extends TestCase
{
    public function testGetAppUserFirstName()
    {
        $appUser = new AppUser;
        $appUser->setFirstname('Bob');

        $this->assertEquals($appUser->getFirstname(), 'Bob');
    }

    public function testFindEmailUser()
    {
        $appUser = new AppUser;
        $userEmail = $appUser->findByEmail("test@test.com");

        $this->assertEmpty($userEmail);
    }
}