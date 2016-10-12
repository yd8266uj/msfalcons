<?php
use PHPUnit\Framework\TestCase;

class databaseTest extends TestCase {
  
  public function testCanGetInstance() {
    $instance = database::get_instance();
    $this->assertNotNull($instance);
    return $instance;
  }
  
  /**
   * @depends testCanGetInstance
   */
  public function testGetInstanceIsPdo( $instance ) {
    $this->assertInstanceOf(PDO::class, $instance); 
  }
 
  /**
   * @depends testCanGetInstance
   */
  public function testIsSameInstance( $instance ) {
    $new_instance = database::get_instance();
    $this->assertEquals($new_instance,$instance);
  }
  
}

?>