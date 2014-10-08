<?php

use JeremyKendall\Password\PasswordValidatorInterface;
use Zend\Authentication\Adapter\AbstractAdapter;
use Zend\Authentication\Result as AuthenticationResult;

class MysqliAdapter extends AbstractAdapter
{
    private $db_instance;
    private $connection;
    private $tableName;
    private $identityColumn;
    private $credentialColumn;
    protected $passwordValidator;

    public function __construct(
        $db_instance,
        $tableName,
        $identityColumn,
        $credentialColumn,
        $passwordValidator
    )
    {
        $this->db_instance = $db_instance;
        $this->connection=$this->db_instance->get_connection();
        $this->tableName = $tableName;
        $this->identityColumn = $identityColumn;
        $this->credentialColumn = $credentialColumn;
        $this->passwordValidator = $passwordValidator;
    }

    /**
     * Performs authentication
     *
     * @return AuthenticationResult Authentication result
     */
    public function authenticate()
    {
        echo "att";
        $user = $this->findUser();
        if ($user === false) {
            return new AuthenticationResult(
                AuthenticationResult::FAILURE_IDENTITY_NOT_FOUND,
                array(),
                array('User not found.')
            );
        }
        
        $validationResult = $this->passwordValidator->isValid(
            $this->credential, $user[$this->credentialColumn], $user['id']
        );
        ladybug_dump($user['id']);
        ladybug_dump($this->credential);
        ladybug_dump($user[$this->credentialColumn]);
        ladybug_dump($validationResult);
        if ($validationResult->isValid()) {
            // Don't store password in identity
            unset($user[$this->getCredentialColumn()]);

            return new AuthenticationResult(AuthenticationResult::SUCCESS, $user, array());
        } else {
            return new AuthenticationResult(
                AuthenticationResult::FAILURE_CREDENTIAL_INVALID,
                array(),
                array('Invalid username or password provided')
            );
        }
    }

    /**
     * Finds user to authenticate
     *
     * @return array|null Array of user data, null if no user found
     */
    private function findUser()
    {
        $query_str = sprintf(
            "SELECT * FROM %s WHERE %s = %s",
            $this->getTableName(),
            $this->getIdentityColumn(),
            "\"" . $this->identity . "\""//inherited variable from parent class
        );
        $query = mysqli_query($this->connection,$query_str);
        $result = mysqli_fetch_assoc($query);
        if(!$result)
        {
            return null;
        }
        else
        {
            return $result;
        }
    }

    /**
     * Get tableName
     *
     * @return string tableName
     */
    public function getTableName()
    {
        return $this->tableName;
    }

    /**
     * Get identityColumn
     *
     * @return string identityColumn
     */
    public function getIdentityColumn()
    {
        return $this->identityColumn;
    }

    /**
     * Get credentialColumn
     *
     * @return string credentialColumn
     */
    public function getCredentialColumn()
    {
        return $this->credentialColumn;
    }
}
