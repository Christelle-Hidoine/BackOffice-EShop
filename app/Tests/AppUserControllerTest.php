<?php

namespace App\Tests;

use AltoRouter;
use App\Controllers\AppUserController;
use App\Controllers\CoreController;
use App\Models\AppUser;
use PHPUnit\Framework\TestCase;
use ReflectionProperty;

require_once './app/Controllers/CoreController.php';

/**
 * @runTestsInSeparateProcesses
 */
class AppUserControllerTest extends TestCase
{
    public function testCheckPasswordFunction() 
    {
        // case with password containing 1 UpperCase, 1 lowCase, 1 number, 1 Special Chars and mini 8 characters
        $password = 'Carbon@r1';
        $result = AppUserController::checkPassword($password);
        $this->assertTrue($result);
        
        // case without UpperCase, number, Special Chars and less than 8 characters
        $password1 = 'geal';
        $result1 = AppUserController::checkPassword($password1);
        $this->assertFalse($result1);

        // case without number, Special Chars and less than 8 characters
        $password1 = 'Geal';
        $result1 = AppUserController::checkPassword($password1);
        $this->assertFalse($result1);

        // case without Special Chars
        $password1 = 'Geal1';
        $result1 = AppUserController::checkPassword($password1);
        $this->assertFalse($result1);
    }

    /**
     * 
     * @dataProvider getUrls
     * 
     * @param [string] $url
     * 
     * @return void
     */
    public function TestAccessUser($url, $email, $codeStatus): void
    {
        $user = new AppUser;
        $newUser = $user->findByEmail($email);

        // Mock the CoreController class
        $coreControllerMock = $this->getMockBuilder(CoreController::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();

        // Use reflection to set the mocked AppUser object in the CoreController instance
        $reflection = new ReflectionProperty(CoreController::class, 'appUser');
        $reflection->setAccessible(true);
        $reflection->setValue($coreControllerMock, $newUser);

        // Mock the HTTP status code function
        $this->expectOutputString((string) $codeStatus);

    }

    /**
     * functions parameters
     * 
     * @return array
     */
    public function getUrls()
    {
        // connection as role catalog-manager on route with permission only role admin
        yield ['user-list', 'nicole@oclock.io', http_response_code(403) ];
        yield ['user-create', 'nicole@oclock.io', http_response_code(403)];
        
    }

}