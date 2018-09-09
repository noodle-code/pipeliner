<?php

use PHPUnit\Framework\TestCase;
use Pipeliner\Pipeline;

class SequenceTest extends TestCase {
  
  public function testOneCallableOnSequenceShouldReturnData() {
    
    $pipeline = new Pipeline();

    $pipeline->add(function($load) {

      return $load + 1;
    });

    $function = $pipeline->generate();

    $this->assertEquals($function(1), 2);
  }

  public function testTwoCallableOnSequenceShouldReturnData() {
  
    $pipeline = new Pipeline();

    $pipeline->add(function($load) {

      return $load + 1;
    })->add(function($load) {

      return $load + 3;
    });

    $function = $pipeline->generate();

    $this->assertEquals($function(1), 5);
  }
}
