<?php
namespace Pipeliner;

/**
 * Pipeline sequence generator class.
 *
 * An immutable pipeline sequence library implemented using 
 * generators.
 * 
 * @package Pipeliner
 * @author  Aldrin Thomas Labarda  <aldrinthomaslab@gmail.com>
 *
 */

use Pipeliner\Pipe;

class Pipeline {

  private $pipes;
  
  private $instanceType;


  public function __construct() {
    
    $this->pipes = new Pipe();
    // $this->instanceType = $loadType;
  }

  
  /**
   * Add a callable to the pipe sequence.
   *
   * @param callable $pipe  Callable method or object for the 
   *                        pipe sequence.
   *
   * @return Pipeline       Current instance of Pipeline class.
   *
   */

  public function add($pipe) {
    
    if(is_array($pipe)) {
      
      return $this->batchAdd($pipe);
    }

    $this->pipes = $this->pipes->addPipe($pipe);

    return $this;
  }


  /**
   * Add a batch (an array) of callable pipes.
   *
   * @param array $pipes  An array of pipes that would be added
   *                      to the sequence.
   *
   * @return Pipeline     Current instance of Pipeline class.
   */

  private function batchAdd($pipes) {
    
    foreach($pipes as $pipe) {
    
      $this->pipes = $this->pipes->add($pipe);
    }

    return $this;
  }


  /**
   * Create an anonymous function that can be called 
   * to execute the pipeline sequence.
   *
   * @return callable   Returns an anonymous function that can be called 
   *                    initiate the sequence.
   *
   */
  public function generate() {

    return function($load) {
      
      //if(!$load instanceof $this->instanceType) {

        //return false;
      //}

      foreach($this->pipes->flow($load) as $result) {
        
        return $result;
      }
    };
  }
}
