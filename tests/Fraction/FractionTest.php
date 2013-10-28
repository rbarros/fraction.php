<?php

use Fraction\AbstractTest as AbstractTest;
use Fraction\Fraction;

class FractionTest extends AbstractTest {
    public $instance;

    /**
     * Antes de cada teste verifica se a classe existe
     * e cria uma instancia da mesma
     * @return void
     */
    public function assertPreConditions()
    {   
        $this->assertTrue(
                class_exists($class = 'Fraction\Fraction'),
                'Class not found: '.$class
        );
        $this->instance = new Fraction();
    }

    public function testInstantiationWithoutArgumentsShouldWork(){
        $this->assertInstanceOf('Fraction\Fraction', $this->instance);
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage Você deve informar um inteiro ou decimal.
     */
    public function testSetStrWithInvalidDataShouldWork()
    {
        $instance = new Fraction("1");
    }

    /**
     * @depends testInstantiationWithoutArgumentsShouldWork
     */
    public function testSetStrWithValidDataShouldWork()
    {
        $this->assertEquals(new Fraction(), $this->instance, 'Returned value should be the same instance for fluent interface');
        
        $integer = 1;
        $instance = new Fraction($integer);
        $this->assertAttributeEquals("1", 'str', $instance, 'Attribute was not correctly set');
        $this->assertAttributeEquals(null, 'c_virgula', $instance, 'Attribute was not correctly set');
        $this->assertAttributeEquals("1/1", 'fraction', $instance, 'Attribute was not correctly set');

        $integer = 1.5;
        $instance = new Fraction($integer);
        $this->assertAttributeEquals("1.5", 'str', $instance, 'Attribute was not correctly set');
        $this->assertAttributeEquals(1, 'c_virgula', $instance, 'Attribute was not correctly set');
        $this->assertAttributeEquals("3/2", 'fraction', $instance, 'Attribute was not correctly set');

        $integer = 0.175;
        $instance = new Fraction($integer);
        $this->assertAttributeEquals("0.175", 'str', $instance, 'Attribute was not correctly set');
        $this->assertAttributeEquals(3, 'c_virgula', $instance, 'Attribute was not correctly set');
        $this->assertAttributeEquals("7/40", 'fraction', $instance, 'Attribute was not correctly set');

        $integer = 0.666666666;
        $instance = new Fraction($integer);
        $this->assertAttributeEquals("0.666666666", 'str', $instance, 'Attribute was not correctly set');
        $this->assertAttributeEquals(9, 'c_virgula', $instance, 'Attribute was not correctly set');
        $this->assertAttributeEquals("2/3", 'fraction', $instance, 'Attribute was not correctly set');

        $integer = 0.166666666;
        $instance = new Fraction($integer);
        $this->assertAttributeEquals("0.166666666", 'str', $instance, 'Attribute was not correctly set');
        $this->assertAttributeEquals(9, 'c_virgula', $instance, 'Attribute was not correctly set');
        $this->assertAttributeEquals("1/6", 'fraction', $instance, 'Attribute was not correctly set');
    }

    /**
    * @depends testInstantiationWithoutArgumentsShouldWork
    */
    public function testInteger() {
        $instance = new Fraction(1);
        $this->assertEquals($instance->getFraction(), "1/1");

        $instance = new Fraction(2);
        $this->assertEquals($instance->getFraction(), "2/1");

        $instance = new Fraction(15);
        $this->assertEquals($instance->getFraction(), "15/1");

        $instance = new Fraction(20);
        $this->assertEquals($instance->getFraction(), "20/1");

        $instance = new Fraction(500);
        $this->assertEquals($instance->getFraction(), "500/1");
    }

    /**
    * @depends testInstantiationWithoutArgumentsShouldWork
    */
   public function testOneDecimal() {
        $instance = new Fraction(0.5);
        $this->assertEquals($instance->getFraction(), "1/2");

        $instance = new Fraction(0.6);
        $this->assertEquals($instance->getFraction(), "3/5");

        $instance = new Fraction(1.2);
        $this->assertEquals($instance->getFraction(), "6/5");

        $instance = new Fraction(0.2);
        $this->assertEquals($instance->getFraction(), "1/5");

        $instance = new Fraction(1.5);
        $this->assertEquals($instance->getFraction(), "3/2");

        $instance = new Fraction(12.5);
        $this->assertEquals($instance->getFraction(), "25/2");
   }

   /**
    * @depends testInstantiationWithoutArgumentsShouldWork
    */
   public function testTwoDecimal() {
        $instance = new Fraction(0.08);
        $this->assertEquals($instance->getFraction(), "2/25");

        $instance = new Fraction(0.17);
        $this->assertEquals($instance->getFraction(), "17/100");

        $instance = new Fraction(0.25);
        $this->assertEquals($instance->getFraction(), "1/4");

        $instance = new Fraction(0.33);
        $this->assertEquals($instance->getFraction(), "33/100");

        $instance = new Fraction(0.75);
        $this->assertEquals($instance->getFraction(), "3/4");
   }

   /**
    * @depends testInstantiationWithoutArgumentsShouldWork
    */
   public function testThreeDecimal() {
        $instance = new Fraction(0.175);
        $this->assertEquals($instance->getFraction(), "7/40");

        $instance = new Fraction(0.200);
        $this->assertEquals($instance->getFraction(), "1/5");

        $instance = new Fraction(0.125);
        $this->assertEquals($instance->getFraction(), "1/8");
   }

   /**
    * @depends testInstantiationWithoutArgumentsShouldWork
    */
   public function testDizimaSimples() {
        $instance = new Fraction(0.666666666);
        $this->assertEquals($instance->getFraction(), "2/3");

        $instance = new Fraction(0.333333333);
        $this->assertEquals($instance->getFraction(), "1/3");
   }

   /**
    * @depends testInstantiationWithoutArgumentsShouldWork
    */
   public function testDizimaComposta() {
        $instance = new Fraction(0.166666666);
        $this->assertEquals($instance->getFraction(), "1/6");

        $instance = new Fraction(0.022222222);
        $this->assertEquals($instance->getFraction(), "1/45");

        $instance = new Fraction(0.125252525);
        $this->assertEquals($instance->getFraction(), "62/495");

        $instance = new Fraction(0.047777777);
        $this->assertEquals($instance->getFraction(), "43/900");

        $instance = new Fraction(0.012345679);
        $this->assertEquals($instance->getFraction(), "1/81");

        $instance = new Fraction(0.225252525);
        $this->assertEquals($instance->getFraction(), "223/990");
   }

}