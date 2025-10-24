<?php
/**
 * Validator class
 *
 * Usage example:
 *
 * if(!empty($_POST)){
 *      $db = new Model();
 *      $errorHandler = new ErrorHandler();
 *
 *      $validator = new Validator($db, $errorHandler);
 *
 *      $validation = $validator->check($_POST,[
 *      'username' => [
 *          'required' => true,
 *          'maxlength' => 20,
 *          'minlength' => 3,
 *          'alphanum' => true
 *      ],
 *      'email' => [
 *          'required' => true,
 *          'maxlength' => 255,
 *          'email' => true
 *      ],
 *      'password' => [
 *          'required' => true,
 *          'minlength' => 7
 *      ],
 *      'password_again' => [
 *          'matches' => 'password'
 *      ]]);
 *
 *      if( $validation->fails() )    {
 *          // echo '<pre>' . print_r( $validation, 1 ) . '</pre>';
 *
 *          if( $validation->errors()->hasErrors('username') ) {
 *              $errorsHtml = '<li>' . implode('</li><li>', $validation->errors()->all('username')) . '</li>';
 *          }
 *          if( $validation->errors()->hasErrors('email') ) {
 *              $errorsHtml .= '<li>' . implode('</li><li>', $validation->errors()->all('email')) . '</li>';
 *          }
 *          if( $validation->errors()->hasErrors('password') ) {
 *              $errorsHtml .= '<li>' . implode('</li><li>', $validation->errors()->all('password')) . '</li>';
 *          }
 *          if( $validation->errors()->hasErrors('password_again') )    {
 *              $errorsHtml .= '<li>' . implode('</li><li>', $validation->errors()->all('password_again')) . '</li>';
 *          }
 *
 *          echo "Validation errors: <br>" . $errorsHtml;
 *      } else {
 *          echo "No validation errors";
 *      }
 *
 * }
 *
 * @package framework/classes
 * @filesource framework/classes/Validator.php
 * @author Rosario Carvello <rosario.carvello@gmail.com>
 * @version GIT:v1.1.0
 * @copyright (c) 2024 Rosario Carvello <rosario.carvello@gmail.com> - All rights reserved. See License.txt file
 * @license BSD Clause 3 License
 * @license https://opensource.org/licenses/BSD-3-Clause This software is distributed under BSD-3-Clause Public License
 */

use framework\classes\ErrorHandler;
use framework\Model;

class Validator
{

    /**
     * Reference to ErrorHandler Class
     *
     * @var ErrorHandler
     **/
    protected $errorHandler;

    /**
     * Reference to Model Class
     *
     * @var Model
     **/
    protected $db;

    /**
     * holds $_POST data
     *
     * @var array
     **/
    protected $items;

    /**
     * Rules for the validator class
     *
     * @var array
     **/
    protected $rules = ['required', 'minlength', 'maxlength', 'email', 'activeemail', 'url', 'activeurl', 'ip', 'alpha', 'alphaupper', 'alphalower', 'alphadash', 'alphanum', 'hexadecimal', 'numeric', 'matches', 'unique'];

    /**
     * messages for the rules
     *
     * @var array
     **/
    public $messages = [
        'required' => 'The :field field is required',
        'minlength' => 'The :field field must be a minimum of :satisfied length',
        'maxlength' => 'The :field field must be a maximum of :satisfied length',
        'email' => 'That is not a valid email address',
        'activeemail' => 'That is not a valid domain email address',
        'activeemail' => 'The :field field must be active email address',
        'url' => 'The :field field must be url',
        'activeurl' => 'The :field field must be a vaild domain url',
        'activeurl' => 'The :field field must be activeurl',
        'ip' => 'The :field field must be valid ip',
        'alpha' => 'The :field field must be alphabetic',
        'alphaupper' => 'The :field field must be upper alpha',
        'alphalower' => 'The :field field must be lower alpha',
        'alphadash' => 'The :field field must be alpha with dash',
        'alphanum' => 'The :field field must be alphanumeirc',
        'hexadecimal' => 'The :field field must be hexadecimal',
        'numeric' => 'The :field field must be numeric',
        'matches' => 'The :field field must matches the :satisfied field'
    ];

    /**
     * Constructor
     *
     * @param Model $db
     * @param ErrorHandler $errorHandler
     */
    public function __construct(Model $db, ErrorHandler $errorHandler)
    {
        $this->db = $db;
        $this->errorHandler = $errorHandler;
    }

    /**
     * check
     *
     * @param array $_POST
     * @param array $rules rules to check
     * @return Validator
     **/
    public function check($items, $rules)
    {

        $this->items = $items;
        foreach ($items as $key => $value) {

            if (in_array($key, array_keys($rules))) {

                $this->validate([
                    'field' => $key,
                    'value' => $value,
                    'rules' => $rules[$key]
                ]);
            }
        }

        return $this;
    }

    /**
     * fails
     *
     * @return boolean true if errors else false
     **/
    public function fails()
    {
        return $this->errorHandler->hasErrors();
    }

    /**
     * errors
     *
     * @return ErrorHandler
     **/
    public function errors()
    {

        return $this->errorHandler;
    }

    /**
     * @param $item
     * @return void
     */
    protected function validate($item)
    {

        $field = $item['field'];

        foreach ($item['rules'] as $rule => $satisfied) {

            if (in_array($rule, $this->rules)) {

                if (!call_user_func_array([$this, $rule], [$field, $item['value'], $satisfied])) {
                    $this->errorHandler->addError(
                        str_replace([':field', ':satisfied'], [$field, $satisfied], $this->messages[$rule]),
                        $field
                    );
                }
            }
        }
    }

    /**
     * required
     *
     * @param string $field
     * @param string $value
     * @param string $satisfied
     * @return boolean
     **/
    protected function required($field, $value, $satisfied)
    {
        return !empty(trim($value));
    }

    /**
     * minlength
     *
     * @param string $field
     * @param string $value
     * @param string $satisfied
     * @return boolean
     **/
    protected function minlength($field, $value, $satisfied)
    {
        return mb_strlen($value) >= $satisfied;
    }

    /**
     * maxlength
     *
     * @param string $field
     * @param string $value
     * @param string $satisfied
     * @return boolean
     **/
    protected function maxlength($field, $value, $satisfied)
    {
        return mb_strlen($value) <= $satisfied;
    }

    /**
     * email
     *
     * @param string $field
     * @param string $value
     * @param string $satisfied
     * @return boolean
     **/
    protected function email($field, $value, $satisfied)
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }

    /**
     * active_email
     *
     * @param string $field
     * @param string $value
     * @param string $satisfied
     * @return boolean
     **/
    protected function active_email($field, $value, $satisfied)
    {

        if ($this->email($field, $value, $satisfied)) {
            $exploded = explode("@", $value);
            if (checkdnsrr(array_pop($exploded), "MX")) {
                return true;
            } else {
                return false;
            }

        } else {

            return false;

        }
    }

    /**
     * url
     *
     * @param string $field
     * @param string $value
     * @param string $satisfied
     * @return boolean
     **/
    protected function url($field, $value, $satisfied)
    {
        return filter_var($value, FILTER_VALIDATE_URL);
    }

    /**
     * active_url
     *
     * @param string $field
     * @param string $value
     * @param string $satisfied
     * @return boolean
     **/
    protected function active_url($field, $value, $satisfied)
    {

        if ($this->email($field, $value, $satisfied)) {

            if (checkdnsrr("www.goofdfsdfsgle.com", "ANY")) {
                return true;
            } else {
                return false;
            }

        } else {

            return false;

        }
    }

    /**
     * ip
     *
     * @param string $field
     * @param string $value
     * @param string $satisfied
     * @return boolean
     **/
    protected function ip($field, $value, $satisfied)
    {
        return filter_var($value, FILTER_VALIDATE_IP);
    }

    /**
     * alpha
     *
     * @param string $field
     * @param string $value
     * @param string $satisfied
     * @return boolean
     **/
    protected function alpha($field, $value, $satisfied)
    {
        return ctype_alpha($value);
    }

    /**
     * alphaupper
     *
     * @param string $field
     * @param string $value
     * @param string $satisfied
     * @return boolean
     **/
    protected function alphaupper($field, $value, $satisfied)
    {
        return ctype_upper($value);
    }

    /**
     * alphalower
     *
     * @param string $field
     * @param string $value
     * @param string $satisfied
     * @return boolean
     **/
    protected function alphalower($field, $value, $satisfied)
    {
        return ctype_lower($value);
    }

    /**
     * alphadash
     *
     * @param string $field
     * @param string $value
     * @param string $satisfied
     * @return boolean
     **/
    protected function alphadash($field, $value, $satisfied)
    {
        // return preg_match('^[A-Za-z-]+$', $value);
        return (bool)preg_match('/^[a-zA-Z0-9_-]+$/', $value);
    }

    /**
     * alphanum
     *
     * @param string $field
     * @param string $value
     * @param string $satisfied
     * @return boolean
     **/
    protected function alphanum($field, $value, $satisfied)
    {
        return ctype_alnum($value);
    }

    /**
     * hexadecimal
     *
     * @param string $field
     * @param string $value
     * @param string $satisfied
     * @return boolean
     **/
    protected function hexadecimal($field, $value, $satisfied)
    {
        return ctype_xdigit($value);
    }

    /**
     * numeric
     *
     * @param string $field
     * @param string $value
     * @param string $satisfied
     * @return boolean
     **/
    protected function numeric($field, $value, $satisfied)
    {
        return ctype_digit($value);
    }

    /**
     * matches
     *
     * @param string $field
     * @param string $value
     * @param string $satisfied
     * @return boolean
     **/
    protected function matches($field, $value, $satisfied)
    {
        return (strcmp($value, $this->items[$satisfied]) == 0) ? true : false;
    }

    /**
     * activeemail
     * Verifica se il dominio dell'email esiste (record MX)
     *
     * @param string $field
     * @param string $value
     * @param string $satisfied
     * @return boolean
     */
    protected function activeemail($field, $value, $satisfied)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        $domain = substr(strrchr($value, "@"), 1);
        if (!$domain) {
            return false;
        }

        // Verifica record MX del dominio (richiede funzione checkdnsrr)
        return function_exists('checkdnsrr') && checkdnsrr($domain, 'MX');
    }

    /**
     * activeurl
     * Verifica se l'URL è valido e il dominio risponde
     *
     * @param string $field
     * @param string $value
     * @param string $satisfied
     * @return boolean
     */
    protected function activeurl($field, $value, $satisfied)
    {
        if (!filter_var($value, FILTER_VALIDATE_URL)) {
            return false;
        }

        $host = parse_url($value, PHP_URL_HOST);
        if (!$host) {
            return false;
        }

        // Controlla se il dominio ha un record DNS valido (A o AAAA)
        return function_exists('checkdnsrr') && (checkdnsrr($host, 'A') || checkdnsrr($host, 'AAAA'));
    }
}