<?php
/** @var Codeception\Scenario $scenario */
/** @var AcceptanceTester $I */
$I = new AcceptanceTester( $scenario );

$I->loginAs( 'admin', 'admin' );
$I->amOnAdminPage( '/' );
$I->see( 'Dashboard' );

//Check if the form is showing the placeholder
$I->wantTo( 'Check Frontent BF ACf Single fields are present with placeholders' );
$I->goToBuddyFormsPage();
$I->click( 'Form with a single field' );
$I->see( 'Form with a single field' );
$I->see( 'Form Designer' );
$I->expect( 'The ACF Single field appear in the form' );
$I->see( 'acf-field' );

//Change to placeholder
$I->click( '#buddyforms_form_designer li.activelabels_nav' );
$I->see( 'Use labels as placeholders?' );
$I->scrollTo( '#buddyforms_form_designer' );
$I->click( 'input[name="buddyforms_options[layout][labels_layout]"][value=inline]' );
$I->seeCheckboxIsChecked( 'input[name="buddyforms_options[layout][labels_layout]"][value=inline]' );
$I->makeScreenshot( 'Change to inline' );
$I->scrollTo( '#title' );
$I->moveMouseOver( 'input#publish.button.button-primary.button-large' );
$I->click( 'input#publish.button.button-primary.button-large' );
$I->see( 'Use labels as placeholders?' );
$I->seeCheckboxIsChecked( 'input[name="buddyforms_options[layout][labels_layout]"][value=inline]' );

$I->amOnPage( '/submissions-management/create/form-with-a-single-field/' );
$I->see( 'Submissions Management' );
$I->scrollTo( '.post-inner' );
$I->seeElementInDOM( [ 'id' => 'buddyforms_form_title' ], [ 'placeholder' => 'Title' ] );
$I->seeElementInDOM( [ 'id' => 'buddyforms_form_content' ], [ 'placeholder' => 'Content' ] );
//$I->seeElementInDOM(['id' => 'acf-field_5e85fdf6cf7db'], ['placeholder' => 'Field A']);
$I->makeScreenshot( 'Check inline in frontend' );

//Check if the acf file is showing the label.
$I->wantTo( 'Change to show the labels of the forms' );
$I->goToBuddyFormsPage();
$I->click( 'Form with a single field' );
$I->see( 'Form with a single field' );
$I->see( 'Form Designer' );
$I->expect( 'Change the label from placeholders to labels' );
$I->scrollTo( '#buddyforms_form_designer' );
$I->click( '#buddyforms_form_designer li.activelabels_nav' );
$I->see( 'Use labels as placeholders?' );
$I->seeCheckboxIsChecked( 'input[name="buddyforms_options[layout][labels_layout]"][value=inline]' );
$I->dontSeeCheckboxIsChecked( 'input[name="buddyforms_options[layout][labels_layout]"][value=label]' );
$I->click( 'input[name="buddyforms_options[layout][labels_layout]"][value=label]' );
$I->makeScreenshot( 'Change to label' );
$I->scrollTo( '#title' );
$I->moveMouseOver( 'input#publish.button.button-primary.button-large' );
$I->click( 'input#publish.button.button-primary.button-large' );
$I->see( 'Use labels as placeholders?' );
$I->dontSeeCheckboxIsChecked( 'input[name="buddyforms_options[layout][labels_layout]"][value=inline]' );
$I->seeCheckboxIsChecked( 'input[name="buddyforms_options[layout][labels_layout]"][value=label]' );

$I->amOnPage( '/submissions-management/create/form-with-a-single-field/' );
$I->see( 'Submissions Management' );
$I->scrollTo( '.post-inner' );
$I->seeElementInDOM( 'label[for="buddyforms_form_title"]' );
$I->see( 'Title' );
$I->seeElementInDOM( 'label[for="buddyforms_form_content"]' );
$I->see( 'Content' );
$I->seeElementInDOM( 'label[for="_acf-field_5e85fdf6cf7db"]' );
$I->see( 'Field A' );
$I->makeScreenshot( 'Check label in frontend' );