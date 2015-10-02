<?php

namespace ApplicationTest\Controller;
namespace Application\Controller;

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

    public function testConvertion() {
        $index = new IndexController();

        // Nothing was done yet:
        $this->assertSame($index->getMethod(), NORMAL);
        $this->assertSame($index->getNumber(), 0);
        $this->assertSame($index->getResult(), 'nulla');
        
        // Setters and getters:
        $index->setNumber(769);
        $index->setMethod(TRADITIONAL);
        $this->assertSame($index->getNumber(), 769);
        $this->assertSame($index->getMethod(), TRADITIONAL);

        // Generator for medieval numeral:
        $index->setMethod(MEDIEVAL);
        $index->generateRomanNumeral();
        $this->assertSame($index->getResult(), 'PHOZI');

        // Generator for traditional numeral:
        $index->setMethod(TRADITIONAL);
        $index->generateRomanNumeral();
        $this->assertSame($index->getResult(), 'DCCLXVIIII');

        // Generator for normal numeral:
        $index->setMethod(NORMAL);
        $index->generateRomanNumeral();
        $this->assertSame($index->getResult(), 'DCCLXIX');

        // Negative integer:
        $index->setNumber(-2);
        $index->generateRomanNumeral();
        $this->assertSame($index->getResult(), 'nulla');

        // Rounded float:
        $index->setNumber(10.99);
        $index->generateRomanNumeral();
        $this->assertSame($index->getResult(), 'XI');

        // Rounded float (2):
        $index->setNumber(10.4999999);
        $index->generateRomanNumeral();
        $this->assertSame($index->getResult(), 'X');

        // Negative float:
        $index->setNumber(-10.4999999);
        $index->generateRomanNumeral();
        $this->assertSame($index->getResult(), 'nulla');

        // Large number:
        // $index->setNumber(10001);
        // $index->generateRomanNumeral();
        // $this->assertSame($index->getResult(), 'nimis magna');
    }
}