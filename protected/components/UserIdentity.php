<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	private $_id;

	/**
	 * Authenticates a user.
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate($school_id = NULL)
	{
            /*try
            {
                Yii::app()->db->setActive(false);
                Yii::app()->db->connectionString = 'mysql:host=localhost;port=3306;dbname='.$school_id;
                Yii::app()->db->setActive(true);
            }
            catch(Exception $e)
            {
                Yii::app()->db->setActive(false);
                Yii::app()->db->connectionString = 'mysql:host=localhost;port=3306;dbname=osv_ms';
                Yii::app()->db->setActive(true);
                $this->errorCode=self::ERROR_USERNAME_INVALID;
                return -11;
            }	
               Yii::app()->session['school_id'] = $school_id;*/
               $user=User::model()->find('LOWER(username)=?',array(strtolower($this->username)));
               if($user->activated==0)
                   $this->password = substr($this->password,3,4);
		if($user===null)
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		else if(!$user->validatePassword($this->password))
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else
		{
			$this->_id=$user->id;
			Yii::app()->user->setState('username', $user->username);
			$this->username=$user->username;
			$this->errorCode=self::ERROR_NONE;
		}
                
            return $this->errorCode==self::ERROR_NONE;
	}

	/**
	 * @return integer the ID of the user record
	 */
	public function getId()
	{
		return $this->_id;
	}
}