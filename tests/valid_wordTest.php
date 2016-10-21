<?php
use PHPUnit\Framework\TestCase;

class valid_wordTest extends TestCase { 

  public function testCanCreateFromString() {    
    $this->assertEquals((new valid_word("test"))->get(),"test");
    $this->assertEquals((new valid_word("పరీక్ష"))->get(),"పరీక్ష");    
  }  
  
  /**
   * @expectedException InvalidArgumentException
   */
  public function testNumberThrowsExceptionInvalidArgumentException() {
    new valid_word("1");
  } 
  
  /**
   * @expectedException InvalidArgumentException
   */
  public function testWordsThrowsExceptionInvalidArgumentException() {
    new valid_word("test test");
  } 

  /**
   * @expectedException InvalidArgumentException
   */
  public function testHiraganaThrowsExceptionInvalidArgumentException() {
    new valid_word("です");
  }
  
}