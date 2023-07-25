<?php

class UserCrudCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/user/connection');
        $I->fillField('Email','lucie@oclock.io');
        $I->fillField('Password','cameleon');
        $I->click('Se Connecter');
    }

    function createUser(AcceptanceTester $I)
    {
        $I->amOnPage('/user/add');
        $I->fillField("lastname", 'NewUser');
        $I->fillField('firstname','NewUser');
        $I->fillField('email','NewUser@user.com');
        $I->fillField('password','NewUser');
        $I->selectOption('role','catalog-manager');
        $I->selectOption('status','1');
        $I->click('Valider');
        $I->seeResponseCodeIs(200);
    }

    function viewUser(AcceptanceTester $I)
    {
        $I->amOnPage('/user/list');
        $I->see('Liste des utilisateurs');
        $I->amOnPage('/user/21/update');
        $I->seeInField(['name' => 'email'], 'NewUser@user.com');
    }

    function updateUser(AcceptanceTester $I)
    {
        $I->amOnPage('/user/21/update');
        $I->fillField("lastname", 'NewUser');
        $I->fillField('firstname','NewUser');
        $I->fillField('email','NewUser@user.com');
        $I->fillField('password','NewUser');
        $I->selectOption('role','catalog-manager');
        $I->selectOption('status','1');
        $I->click('Valider');
        $I->seeResponseCodeIs(200);
    }

    function deleteUser(AcceptanceTester $I)
    {
        $I->amOnPage('/user/21/delete');
        $I->seeResponseCodeIsSuccessful();
    }
}
