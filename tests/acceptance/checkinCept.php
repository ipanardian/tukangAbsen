<?php 
require (dirname(__FILE__).'/../_bootstrap.php');

$I = new AcceptanceTester($scenario);
$I->wantTo('Checkin');
$I->amOnPage('/');
$I->waitForText('Workforce', 15);
$I->fillField('Email', $account['email']);
$I->fillField('Password', $account['password']);
$I->click('Sign In');
$I->waitForText('Employee Information', 15);
$I->amOnPage('#/attendee/ess?_k=h7tw1y');
$I->waitForElement('button.btn-primary');
$I->click('Add');
$I->waitForElement('#checkin');
$tolerance = 180;
$time = time() - $tolerance;
$absen_time = date('H:i:s', $time);
$date = date('Y-m-d', $time);
$absen_date = $I->grabValueFrom('#attendance-date');
if ($date != $absen_date) {
	echo("Wrong date\n");
	exit();
}
$I->fillField('#checkin', $absen_time);
$I->selectOption('form select[name=attendance_type]', 'manualentry');
$I->click('#attendance-request-save');
$I->waitForElement('div.alert-success', 15);
$I->expect('success absen pagi at '.$absen_date.' '.$absen_time);
$I->makeScreenshot('debug_checkin');
$I->amOnPage('#/logout');


