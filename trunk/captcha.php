<?php 
		  		  require('php-captcha.inc.php');
				  
				  $aFonts = array('fonts/VeraBd.ttf', 'fonts/VeraIt.ttf', 'fonts/Vera.ttf');
				  $oVisualCaptcha = new PhpCaptcha($aFonts, 200, 60);
				  $oVisualCaptcha->SetNumChars(4);
				  $oVisualCaptcha->CaseInsensitive(false);
				  $oVisualCaptcha->Create();
  			?>