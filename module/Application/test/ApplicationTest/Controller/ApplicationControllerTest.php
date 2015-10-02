<?php

namespace ApplicationTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class ApplicationControllerTest extends AbstractHttpControllerTestCase {
    
    public function setUp() {
        // getcwd() reports the tests execute from the BBCTest directory:
        $configFile = realpath('config/application.config.php');
        $this->setApplicationConfig(
            include $configFile
        );
        parent::setUp();
    }

    public function testIndexActionCanBeAccessed() {
        $this->dispatch('/');
        $this->assertResponseStatusCode(200);

        $this->assertModuleName('Application');
        $this->assertControllerName('Application\Controller\Index');
        $this->assertControllerClass('IndexController');
        $this->assertMatchedRouteName('home');
    }
}