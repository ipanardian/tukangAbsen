<?php
/**
*  TukangAbsen
*  (c) 2017 Ipan Ardian
*
*  When engineers doesn't want to fill out attendance manually, tukangAbsen is the answer!
*  For details, see the web site: https://github.com/ipanardian/tukangAbsen
*  The GPL 3.0 License
*/

require('./app.php');

(new TukangAbsen($argv))->run();