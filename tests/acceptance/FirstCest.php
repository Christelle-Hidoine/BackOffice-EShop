<?php

class FirstCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    public function homepageWork(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->see('Bienvenue dans le backOffice');

    }
}
