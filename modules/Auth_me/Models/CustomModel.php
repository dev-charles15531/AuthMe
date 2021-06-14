<?php
/**
 *** CustomModel ***
 * @author Charles Paul, dev.charles15531@gmail.com
 * @package AuthMe - lightweight & easy to use codeigniter 4 authentication module
 * @version 1.0.0
 * @license M I T
 */

namespace Modules\AuthMe\Models;
use CodeIgniter\Model;

class CustomModel extends Model {

 
	/**
	 * To Check If Login Post Request Is Acceptable
	 * @param $public_key => The public_key provided for login
	 * @param $private_key => The private_key provided for login
	 * @param $ip => The client's current IP address :{NULL for now}
	 * @return [0] if user passes all login checks
	 * @return [1] if argument public_key$public_key is not found in DB
	 * @return [2] if argument private_key does not match that in DB
	 * @return [3] if queried account is inactive
	 */
	public function can_login($public_key, $private_key, $loginConditions = null)
	{
    # Get passer via session
		$passer = session('authMePasser');

    # Load config and get specific passer credentials
    $config = Config('Config');
    $_table = $config->loginConstraints[$passer]['table'];        // get table name
    $pub_key = $config->loginConstraints[$passer]['public_key'];  // get public key
    $pvt_key = $config->loginConstraints[$passer]['private_key']; // get private key

    # Query Builder 
    $builder = $this->db->table($_table);
    $builder->select('*');
    $builder->where([$pub_key=>$public_key]);
    $query = $builder->get();
    $result = $query->getResult();  // I'll call this "login-query-result"
    # If Query Result Is > 0
    if(count($result) > 0) {
      # Get table comlumn names as $keys and values as that satisfies our login condition as $values from our Config class
      $keys = array_keys($loginConditions);
      $values = array_values($loginConditions);
      foreach($result as $row) {
        $db_key = $row->$pvt_key;
        
        # If $loginConditions is not null, assign the $keys elements to $key0, $key1 and $key2 if they are not empty
        # Conditioning follows the order in which they are written in our Config class 
        # So, $key0 condition executes before $key1 and so on. 
        if($loginConditions != null) {
          $key0 = (count($keys) >=1)? (String)$keys[0]:null;
          $key1 = (count($keys) >=2)? (String)$keys[1]:null;
          $key2 = (count($keys) >=3)? (String)$keys[2]:null;

          # If key(0, 1 & 2) are columns from login-query-result returned row
          if ($key0 != null) {
            $key_condition1 = $row->$key0;
          }
          if ($key1 != null) {
            $key_condition2 = $row->$key1;
          }
          if ($key2 != null) {
            $key_condition3 = $row->$key2;
          }
        }
      }
      # If Argument Password = Password In DB
      if(password_verify($private_key, $db_key)) {
      
        #~~~~~~~~~~~~~~~~~~~ We start testing our login conditions here ~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        # If first condition value is set in the $loginConditions array
        if(count($loginConditions) >= 1) {
          # If first condition is met 
          if($key_condition1 == $values[0]) {

            # If second condition value is set in the $loginConditions array
            if(count($loginConditions) >= 2) {
               # If second condition is met 
              if($key_condition2 == $values[1]) {
  
                # If third condition value is set in the $loginConditions array
                if(count($loginConditions) >= 3) {
                  # If third condition is met  
                  if($key_condition3 == $values[2]) {
                    return 0;
                  }
                  # If third condition is not met
                  else {
                    return 12;
                  }	
                }
                else {
                  return 0;
                }
                
    
              }
              # If second condition is not met
              else {
                return 11;
              }	
            } 
            else {
              return 0;
            }
            
  
          }
          # If first condition is not met
          else {
            return 10;
          }
        } 
        else {
          return 0;
        }
        	
        #~~~~~~~~~~~~~~~~~ End testing login conditions ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        
      }
      # If Argument Password != Password In DB
      else {
        return 2;
      }
    }
    # If Query Result Is Not > 0
    else {
      return 1;
    }
  }
  

  
}

