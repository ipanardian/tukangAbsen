<?php 
require (dirname(__FILE__).'/../_bootstrap.php');

$I = new AcceptanceTester($scenario);
$I->wantTo('Checkout');
$I->amOnPage('/');
$I->waitForText('Workforce', 15);
$I->fillField('Email', $account['email']);
$I->fillField('Password', $account['password']);
$I->click('Sign In');
$I->waitForText('Employee Information', 15);
$I->amOnPage('#/attendee/outgoing-request?_k=9b4hza');
$I->waitForElement('td button', 10);
$I->click('//*[@id="page-content"]/div/div[2]/div/div/table/tbody/tr[1]/td[11]/button');
$I->waitForElement('input[type=button]');
$I->click('Yes');
$I->waitForElement('#checkout');
$time = time();
$absen_time = date('H:i:s', $time); 
$date = date('Y-m-d', $time);
$absen_date = $I->grabValueFrom('#attendance-date');
if ($date != $absen_date) {
	echo('Wrong date');
	exit();
}
$I->fillField('#checkout', $absen_time);
$I->selectOption('form select[name=attendance_type]', 'manualentry');
$I->click('#attendance-request-save');
$I->waitForElement('div.alert-success', 15);
$I->expect('success absen sore at '.$absen_date.' '.$absen_time);
$I->makeScreenshot('debug_checkout');
$I->amOnPage('#/logout');

