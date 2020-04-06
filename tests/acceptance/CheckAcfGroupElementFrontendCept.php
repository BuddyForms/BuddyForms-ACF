<?php
/** @var Codeception\Scenario $scenario */
/** @var AcceptanceTester $I */
$I = new AcceptanceTester($scenario);

$I->loginAs( 'admin', 'admin' );
$I->amOnAdminPage( '/' );
$I->see( 'Dashboard' );

//Check if the form is showing the placeholder
$I->wantTo( 'Check Frontend BF ACf Group fields are present with placeholders' );
$I->goToBuddyFormsPage();
$I->click( 'Form with a group' );
$I->see( 'Form with a group' );
$I->see( 'Form Designer' );
$I->expect( 'The ACF Group field appear in the form' );
$I->see( 'acf-group' );

//Change to placeholder
$I->click( '#buddyforms_form_designer li.activelabels_nav' );
$I->see( 'Use labels as placeholders?' );
$I->scrollTo( '#buddyforms_form_designer' );
$I->click( 'input[name="buddyforms_options[layout][labels_layout]"][value=inline]' );
$I->seeCheckboxIsChecked( 'input[name="buddyforms_options[layout][labels_layout]"][value=inline]' );
$I->makeScreenshot( 'Change to inline' );
$I->scrollTo( '#title' );
$I->scrollTo( '#title' );
$I->moveMouseOver( 'input#publish.button.button-primary.button-large' );
$I->click( 'input#publish.button.button-primary.button-large' );
$I->see( 'Use labels as placeholders?' );
$I->seeCheckboxIsChecked( 'input[name="buddyforms_options[layout][labels_layout]"][value=inline]' );

$I->amOnPage( '/submissions-management/create/form-with-a-group/' );
$I->see( 'Submissions Management' );
$I->scrollTo( '.post-inner' );
$I->seeElementInDOM( [ 'id' => 'buddyforms_form_title' ], [ 'placeholder' => 'Title' ] );
$I->seeElementInDOM( [ 'id' => 'buddyforms_form_content' ], [ 'placeholder' => 'Content' ] );
$I->seeElementInDOM( [ 'id' => 'acf-field_5e85fdf6cf7db' ], [ 'placeholder' => 'Field A  * ' ] );
$I->seeElementInDOM( 'label[for="_acf-field_5e85fe10cf7dc"]' );
$I->see( 'Field B' );
$I->makeScreenshot( 'Check inline in frontend' );

//Check if the acf file is showing the label.
$I->wantTo( 'Change to show the labels of the forms' );
$I->goToBuddyFormsPage();
$I->click( 'Form with a group' );
$I->see( 'Form with a group' );
$I->see( 'Form Designer' );
$I->expect( 'Change the label from placeholders to labels' );
$I->scrollTo( '#buddyforms_form_designer' );
$I->click( '#buddyforms_form_designer li.activelabels_nav' );
$I->see( 'Use labels as placeholders?' );
$I->click( 'input[name="buddyforms_options[layout][labels_layout]"][value=label]' );
$I->seeCheckboxIsChecked( 'input[name="buddyforms_options[layout][labels_layout]"][value=label]' );
$I->makeScreenshot( 'Change to label' );
$I->scrollTo( '#title' );
$I->moveMouseOver( 'input#publish.button.button-primary.button-large' );
$I->click( 'input#publish.button.button-primary.button-large' );
$I->see( 'Use labels as placeholders?' );
$I->seeCheckboxIsChecked( 'input[name="buddyforms_options[layout][labels_layout]"][value=label]' );

$I->amOnPage( '/submissions-management/create/form-with-a-group/' );
$I->see( 'Submissions Management' );
$I->scrollTo( '.post-inner' );
$I->seeElementInDOM( 'label[for="buddyforms_form_title"]' );
$I->see( 'Title' );
$I->seeElementInDOM( 'label[for="buddyforms_form_content"]' );
$I->see( 'Content' );
$I->seeElementInDOM( 'label[for="_acf-field_5e85fdf6cf7db"]' );
$I->see( 'Field A * ');
$I->seeElementInDOM( 'label[for="_acf-field_5e85fe10cf7dc"]' );
$I->see( 'Field B' );
$I->makeScreenshot( 'Check label in frontend' );

