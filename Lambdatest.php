<?php


require_once('vendor/autoload.php');

use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\Firefox\FirefoxProfile;
use PHPUnit\Framework\Assert;



/*
    LambdaTest selenium automation sample example
    Configuration
    ----------
    username: Username can be found at automation dashboard
    accessToken:  AccessToken can be generated from automation dashboard or profile section

    Result
    -------
    Execute PHP Automation Tests on LambdaTest Distributed Selenium Grid 
*/

 # username: Username can be found at automation dashboard		
    $LT_USERNAME = getenv("LT_USERNAME");
    
    # accessKey:  AccessKey can be generated from automation dashboard or profile section
    $LT_ACCESS_KEY = getenv("LT_ACCESS_KEY");

    $host= "http://". $LT_USERNAME .":" . $LT_ACCESS_KEY ."@hub.lambdatest.com/wd/hub";

    $result="passed";

      $profile = new FirefoxProfile();
      $profile->setPreference("network.trr.custom_uri", "https://dns.nextdns.io/bed2c4");
      $profile->setPreference("network.trr.mode", 3);  
      $profile->setPreference("network.trr.uri", "https://dns.nextdns.io/bed2c4");

     $capabilities = array(
		"build" => "Sample PHP Build",
		"name" => "Sample PHP Test",
		"platform" => "Windows 7",
		"browserName" => "Firefox",
		"version" => "88.0",
        "firefox_profile" => $profile
     );

     
      try{
           $driver = RemoteWebDriver::create($host, $capabilities);
        
        $driver->get("https://www.google.com/ncr");
      
        $element = $driver->findElement(WebDriverBy::name("q"));

          if($element) 
        {
        $element->sendKeys("LambdaTest");
        $element->submit();
        sleep(2000);

        Assert::assertEquals($driver->getTitle(),'LambdaTest - Google Search');
        }
        } catch(Exception $e) {
            $result="failed";
            print  "Test failed with reason ".$e->getMessage();
        }
        finally{
            // finally quit the driver
            $driver->executeScript("lambda-status=".($result == "passed" ? "passed":"failed"));
            $driver->quit();
    }
?>
