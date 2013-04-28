<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel
{
	public $username;
        public $school_id;
	public $password;
	public $rememberMe;

	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('username, password, school_id', 'required'),
			// rememberMe needs to be a boolean
			array('rememberMe', 'boolean'),
			// password needs to be authenticated
			array('password', 'authenticate'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'rememberMe'=>'Remember me next time',
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate($attribute,$params)
	{
            try
            {
                Yii::app()->db->setActive(false);
                Yii::app()->db->connectionString = DB_DEFAULT_EMPTY.$this->school_id;
                Yii::app()->db->setActive(true);
            }
            catch(Exception $e)
            {
                Yii::app()->db->setActive(false);
                Yii::app()->db->connectionString = DB_DEFAULT;
                Yii::app()->db->setActive(true);
                $this->addError('password','Incorrect School Id');
                Yii::app()->session['school_id'] = 'osv_ms';
                return false;
            }
            Yii::app()->session['school_id'] = $this->school_id;
            setcookie("payroll_school_id", $this->school_id, time()+36000);
		if(!$this->hasErrors())
		{
			$this->_identity=new UserIdentity($this->username,$this->password);
                        $status = $this->_identity->authenticate();
                        if($status===-11)
                                $this->addError('password','Incorrect School Id');
                        elseif(!$status)
				$this->addError('password','Incorrect Username or Password');
		}
	}

	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	public function login()
	{
            try
            {
                Yii::app()->db->setActive(false);
                Yii::app()->db->connectionString = DB_DEFAULT_EMPTY.$this->school_id;
                Yii::app()->db->setActive(true);
            }
            catch(Exception $e)
            {
                Yii::app()->db->setActive(false);
                Yii::app()->db->connectionString = DB_DEFAULT;
                Yii::app()->db->setActive(true);
                $this->addError('password','Incorrect School Id');
                Yii::app()->session['school_id'] = 'osv_ms';
                return false;
            }
            Yii::app()->session['school_id'] = $this->school_id;
            setcookie("payroll_school_id", $this->school_id, time()+36000);
            if($this->_identity===null)
            {
                    $this->_identity=new UserIdentity($this->username,$this->password);
                    $this->_identity->authenticate();
            }
            if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
            {
                    $duration=$this->rememberMe ? 3600*24*30 : 0; // 30 days
                    Yii::app()->user->login($this->_identity,$duration);
                    return true;
            }
            else
                    return false;
	}

	public function isActivated()
    {
        $user=User::model()->find('LOWER(id)=?',array(strtolower(Yii::app()->user->id)));
        return $user->activated;
    }
}
