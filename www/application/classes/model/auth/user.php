<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * Default auth user
 *
 * @package    Kohana/Auth
 * @author     Kohana Team
 * @copyright  (c) 2007-2011 Kohana Team
 * @license    http://kohanaframework.org/license
 */
class Model_Auth_User extends ORM {

        protected $_table_name = 'dg_usrs';
    /**
	 * A user has many tokens and roles
	 *
	 * @var array Relationhips
	 */
	protected $_has_many = array(
            'user_tokens' => array('model' => 'user_token'),
            'roles'       => array('model' => 'role',    'through'     => 'dg_rls_usrs'),
            'students' 	  => array('model' => 'student', 'foreign_key' => 'student_id'),
            'teachers' 	  => array('model' => 'teacher', 'foreign_key' => 'teacher_id'),
            'admins' 	  => array('model' => 'admin',   'foreign_key' => 'admin_id'),
  	);
        


          
          
         /**
	 * Rules for the user model. Because the password is _always_ a hash
	 * when it's set,you need to run an additional not_empty rule in your controller
	 * to make sure you didn't hash an empty string. The password rules
	 * should be enforced outside the model or with a model helper method.
	 *
	 * @return array Rules
	 */
	public function rules()
	{
		return array(
			'username' => array(
				array('not_empty'),
				array('max_length', array(':value', 50)),
			),
			'password' => array(
				array('not_empty'),
			),
//			'email' => array(
//				array('not_empty'),
//				array('email'),
//				array(array($this, 'unique'), array('email', ':value')),
//			),
		);
	}

	/**
	 * Filters to run when data is set in this model. The password filter
	 * automatically hashes the password when it's set in the model.
	 *
	 * @return array Filters
	 */
	public function filters()
	{
		return array(
			'password' => array(
				array(array(Auth::instance(), 'hash'))
			)
		);
	}

	/**
	 * Labels for fields in this model
	 *
	 * @return array Labels
	 */
	public function labels()
	{
		return array(
			'username'        => 'Username',
			'email'           => 'Email address',
			'password'        => 'Password',
		);
	}

	/**
	 * Complete the login for a user by incrementing the logins and saving login timestamp
	 *
	 * @return void
	 */
	public function complete_login()
	{
		if ($this->_loaded)
		{
			// Update the number of logins
			$this->logins = new Database_Expression('logins + 1');

			// Set the last login date
			$this->last_login = time();

			// Save the user
			$this->update();
		}
	}

	/**
	 * Tests if a unique key value exists in the database.
	 *
	 * @param   mixed    the value to test
	 * @param   string   field name
	 * @return  boolean
	 */
	public function unique_key_exists($value, $field = NULL)
	{
		if ($field === NULL)
		{
			// Automatically determine field by looking at the value
			$field = $this->unique_key($value);
		}

		return (bool) DB::select(array('COUNT("*")', 'total_count'))
			->from($this->_table_name)
			->where($field, '=', $value)
			->where($this->_primary_key, '!=', $this->pk())
			->execute($this->_db)
			->get('total_count');
	}

	/**
	 * Allows a model use both email and username as unique identifiers for login
	 *
	 * @param   string  unique value
	 * @return  string  field name
	 */
	public function unique_key($value)
	{
		return Valid::email($value) ? 'email' : 'username';
	}

	/**
	 * Password validation for plain passwords.
	 *
	 * @param array $values
	 * @return Validation
	 */
	public static function get_password_validation($values)
	{
		return Validation::factory($values)
			->rule('password', 'min_length', array(':value', 6))
			->rule('password_confirm', 'matches', array(':validation', ':field', 'password'));
	}
        
	public static function get_email_validation($values, $extra_validation = false)
	{
            if($extra_validation)
            {
                $extra_validation
			->rule('email', 'email')
			->rule('email', array($this, 'unique_key_exists'), array('email', ':value'));
                return $extra_validation;
            }
            else
		return Validation::factory($values)
			->rule('email', 'email')
			->rule('email', array($this, 'unique_key_exists'), array('email', ':value'));
	}

	/**
	 * Create a new user
	 *
	 * Example usage:
	 * ~~~
	 * $user = ORM::factory('user')->create_user($_POST, array(
	 *	'username',
	 *	'password',
	 *	'email',
	 * );
	 * ~~~
	 *
	 * @param array $values
	 * @param array $expected
	 * @throws ORM_Validation_Exception
	 */
	public function create_user($values, $expected)
	{
		// Validation for passwords
		$extra_validation = Model_User::get_password_validation($values)
			->rule('password', 'not_empty');
		return $this->values($values, $expected)->create($extra_validation);
	}

	/**
	 * Update an existing user
	 *
	 * [!!] We make the assumption that if a user does not supply a password, that they do not wish to update their password.
	 *
	 * Example usage:
	 * ~~~
	 * $user = ORM::factory('user')
	 *	->where('username', '=', 'kiall')
	 *	->find()
	 *	->update_user($_POST, array(
	 *		'username',
	 *		'password',
	 *		'email',
	 *	);
	 * ~~~
	 *
	 * @param array $values
	 * @param array $expected
	 * @throws ORM_Validation_Exception
	 */
	public function update_user($user_id, $values, $expected = NULL)
	{
            $user = ORM::factory('auth_user', $user_id);
//		if (empty($values['password']))
//		{
//			unset($values['password'], $values['password_confirm']);
//		}

		// Validation for passwords
		$extra_validation = Model_User::get_password_validation($values);
                if(isset($values['password'])) $extra_validation->rule('password', 'not_empty');

		return $user->values($values, $expected)->update($extra_validation);
	}


	public function login($login, $password) 
	{
		// Auth::instance()->login($_POST['email'], $_POST['password']);
		$user = $this->where('email', '=', $_POST['email'])->find();
		if($user->id && $user->status == 0) {
			Helper_Output::addErrors('1003');
			Helper_Output::keepErrors();
		} else {
			$status = Auth::instance()->login($_POST['email'], $_POST['password']);
                        
			if($status) {
				// Helper_iAuth::instance()->createSession();
				return true;
			} else {
				Helper_Output::addErrors('1002');
				Helper_Output::keepErrors();
				return false;
			}
		}
	}
        
        /*
        * Get users by id
        */
       public function get_user_by_id($id)
       {
           if(is_numeric($id))
           {
               $user =  ORM::factory('user', $id);
               if($user->loaded())
                   return $user;
           }
           else
               return false;
       }
       
        /*
        * Delete user 
        */
        public function delete_user($id)
        {
            try 
            {
                $user = ORM::factory('user', $id);
                
                $user_folder = APPPATH.'assets/files/users/'.$user->id;
                Helper_Folders::remove_folder($user_folder);
                
                $user->delete();
                return true;
            } 
            catch (ORM_Validation_Exception $e) 
            {
                return false;
            }
        }
        
        public function get_approved_users($role)
        {
            $count_users = ORM::factory('auth_user')
                ->where('status', '=', 0);
            switch($role)
            {
                case 'students':
                    $count_users->join('dg_stdnts')
                        ->on('dg_stdnts.student_id', '=', 'auth_user.id');
                    break;
                case 'teachers':
                    $count_users->join('dg_tchrs')
                        ->on('dg_tchrs.teacher_id', '=', 'auth_user.id');
                    break;
                case 'admins':
                    $count_users->join('dg_admns')
                        ->on('dg_admns.admin_id', '=', 'auth_user.id');
                    break;
            }
            return $count_users->count_all();
        }
        
        public function get_count_users($role)
        {
            $count_users = ORM::factory('auth_user')
                ->where('status', '=', 1);
            switch($role)
            {
                case 'students':
                    $count_users->join('dg_stdnts')
                        ->on('dg_stdnts.student_id', '=', 'auth_user.id');
                    break;
                case 'teachers':
                    $count_users->join('dg_tchrs')
                        ->on('dg_tchrs.teacher_id', '=', 'auth_user.id');
                    break;
                case 'admins':
                    $count_users->join('dg_admns')
                        ->on('dg_admns.admin_id', '=', 'auth_user.id');
                    break;
            }
            return $count_users->count_all();
        }
        
        public function check_email($emil)
        {
            $user = ORM::factory('auth_user')
                    ->where('email', '=', $emil)
                    ->find();
            if($user->loaded())
                return $user;
            else
                return false;
        }
        
        public function set_new_password($data)
        {
            try{
                $user = ORM::factory('auth_user', $data['user_id'])
                    ->set('password', $data['password'])->update();
                return true;
            }
            catch (ORM_Validation_Exception $er)
            {
                return false;
            }
        }
} // End Auth User Model