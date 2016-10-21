<?php
use PHPUnit\Framework\TestCase;

class valid_intTest extends TestCase {
  
  public function testCanCreateFromInt() {
    $this->assertEquals((new valid_int(1))->get(),1);
  }
  
  /**
   * @expectedException InvalidArgumentException
   */
  public function testThrowsExceptionInvalidArgumentException() {
    new valid_int("1");
  }
  
}