<?php

class SigninCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    public function signInSuccessfully(AcceptanceTester $I)
    {
        $I->amOnPage('/user/connection');
        $I->fillField('Email','lucie@oclock.io');
        $I->fillField('Password','cameleon');
        $I->click('Se Connecter');
        $I->see('Bienvenue dans le backOffice');
    }
}
