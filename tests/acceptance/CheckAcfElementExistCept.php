<?php
/** @var Codeception\Scenario $scenario */
/** @var AcceptanceTester $I */
$I = new AcceptanceTester( $scenario );

$I->loginAs( 'admin', 'admin' );
$I->amOnAdminPage( '/' );
$I->see( 'Dashboard' );

$I->wantTo( 'Check if BF ACf Single fields are present in the form' );
$I->goToBuddyFormsPage();
$I->click( 'Form with a single field' );
$I->see( 'Form with a single field' );
$I->see( 'Form Setup' );
$I->expect( 'The ACF Single field appear' );
$I->see( 'acf-field' );

$I->wantTo( 'Check if BF ACf Group fields are present in the form' );
$I->goToBuddyFormsPage();
$I->click( 'Form with a group' );
$I->see( 'Form with a group' );
$I->see( 'Form Setup' );
$I->expect( 'The ACF Group field appear' );
$I->see( 'acf-group' );