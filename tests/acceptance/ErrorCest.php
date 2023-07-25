<?php

class ErrorCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/user/connection');
        $I->fillField('Email','nicole@oclock.io');
        $I->fillField('Password','onews');
        $I->click('Se Connecter');
        $I->see('Bienvenue dans le backOffice');
    }

    public function notFoundError(AcceptanceTester $I)
    {
        $I->amOnPage('user/list/3');
        $I->seePageNotFound();
    }

    public function forbiddenAccessUserListError(AcceptanceTester $I)
    {
        $I->amOnPage('user/list');
        $I->seeResponseCodeIs(403);
    }

    public function forbiddenAccessUserAddError(AcceptanceTester $I)
    {
        $I->amOnPage('user/add');
        $I->seeResponseCodeIs(403);
    }

    public function forbiddenAccessUserEditError(AcceptanceTester $I)
    {
        $I->amOnPage('user/21/update');
        $I->seeResponseCodeIs(403);
    }

    public function forbiddenAccessUserDeleteError(AcceptanceTester $I)
    {
        $I->amOnPage('user/21/delete');
        $I->seeResponseCodeIs(403);
    }
    
}
