<?php
namespace Pipeliner;

class Pipe {
  
  private $load;

  public function __construct($load = null) {
    
    if(is_callable($load)) {

      $this->load = $load;
    }
  }

  public function addPipe($pipe) {
    
    $callable = function($load) use ($pipe) {
      
      if(is_callable($this->load)) {
        
        foreach(call_user_func($this->load, $load) as $item) {
          
          yield $pipe($item);
        }
      } else {
      
        yield $pipe($load);
      }
    };

    return new self($callable); 
  }

  public function flow($load) {
    
    if(is_callable($this->load)) {
      
      foreach(call_user_func($this->load, $load) as $item) {
        
        yield $item;
      }
    } else {
      
      yield $load;
    }
  }
}
