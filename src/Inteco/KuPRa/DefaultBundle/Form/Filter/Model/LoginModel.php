<?php

namespace Inteco\KuPRa\DefaultBundle\Form\Filter\Model;

class LoginModel {

    /**
     * @var string
     */
    protected $loginName;

    /**
     * @var string
     */
    protected $password;

    /**
     * @param $loginName
     * @return LoginModel
     */
    public function setLoginName($loginName)
    {
        $this->loginName = $loginName;

        return $this;
    }

    /**
     * @return string
     */
    public function getLoginName()
    {
        return $this->loginName;
    }

    /**
     * @param $password
     * @return LoginModel
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }
}
