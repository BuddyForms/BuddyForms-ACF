<?php
/** @var Codeception\Scenario $scenario */
/** @var AcceptanceTester $I */
$I = new AcceptanceTester( $scenario );

$I->loginAs( 'admin', 'admin' );
$I->amOnAdminPage( '/' );
$I->see( 'Dashboard' );

$I->wantTo( 'Check if the conditional logic from ACF is working' );
$I->amOnPage( '/submissions-management/create/form-with-a-group/' );
$I->see( 'Submissions Management' );
$I->seeElementInDOM( 'label[for="_acf-field_5e85fe10cf7dc"]' );
$I->scrollTo( '#form-with-a-group' );
$I->see( 'Field B' );
$I->dontSeeCheckboxIsChecked( 'input[name="acf[field_5e85fe10cf7dc][]"][value="Option 1"]' );
$I->moveMouseOver( '#form-with-a-group' );
$I->click( 'input[name="acf[field_5e85fe10cf7dc][]"][value="Option 1"]' );
$I->see( 'Field C' );
