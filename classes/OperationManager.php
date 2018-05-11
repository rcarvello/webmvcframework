<?php
/**
 * Class OperationManager
 * Manages operations for storing ownership information about
 * table record when inserting rows.
 *
 * @package classes
 * @category Custom class
 * @author  Rosario Carvello - rosario.carvello@gmail.com
 */
namespace classes;
use framework\User;
use models\beans\BeanOpRegistry;

class OperationManager extends \mysqli
{

    private $pk;
    private $table;
    private $action;

    /**
     * OperationManager constructor.
     * @param null $pk
     * @param string $table
     * @throws \Exception If table was not found
     */
    public function __construct($pk=null, $table)
    {
        parent::__construct(DBHOST,DBUSER,DBPASSWORD,DBNAME);
        $this->setTable($table);
        $this->pk = $pk;
    }

    /**
     * Sets current table name
     * @param $table
     * @throws \Exception If table was not found.
     */
    public function setTable($table)
    {
        $sql = "SELECT * FROM information_schema.tables WHERE table_schema='". DBNAME . "' AND table_name = '$table' LIMIT 1";
        $this->query($sql);
        if ($this->affected_rows != 0){
            $this->table = $table;
        } else {
            throw new \Exception("Table $table was not found !");
        }

    }

    /**
     * Sets and stores ownership information.
     * Ownership of each new rows is assigned to the current logged
     * in user
     * @param null|string $pk The pk idendifing row. If null
     *                        it uses current
     *                        Note: Current pk could be null after
     *                        adding a new record.
     */
    public function setOwnership($pk=null){

        if (empty($pk)){
            $pk = $this->pk;
        }

        if (!empty($pk)) {
            $this->action = "INSERT";
            $sql = "SELECT id_op FROM op_registry WHERE pk='$pk' AND entity_name='$this->table'";
            $this->query($sql);
            if ($this->affected_rows > 0){
                $this->action = "UPDATE";
            }
        }

        if ( $this->action=="INSERT"){
            $user = new User();
            $userId = $user->getId();
            if (!empty($userId)) {
                $bean = new BeanOpRegistry();
                $currentDate = date('Y-m-d h:i:s', time());
                $bean->setEntityName($this->table);
                $bean->setPk($pk);
                $bean->setOperationType($this->action);
                $bean->setOperationDate($currentDate);
                $bean->setUserId($userId);
                $bean->insert();
            }
        }
    }

    /**
     * Returns ownership (true or false) of a table row.
     *
     * @return bool True if the current user is the row owner.
     */
    public function isOwner()
    {
        $user = new User();
        $userId = $user->getId();

        if (!empty($userId)) {
          if ($user->getRole()==100)
              return true;
        }

        if (!empty($userId)) {
            $sql = "SELECT id_op FROM op_registry WHERE pk='$this->pk' AND entity_name='$this->table' AND user_id=$userId AND operation_type='INSERT'";
            $this->query($sql);
            if ($this->affected_rows > 0){
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

}