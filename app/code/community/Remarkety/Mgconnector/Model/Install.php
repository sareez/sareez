<?php

/**
 * Install model
 *
 * @category   Remarkety
 * @package    Remarkety_Mgconnector
 * @author     Piotr Pierzak <piotrek.pierzak@gmail.com>
 */
class Remarkety_Mgconnector_Model_Install
{
    /**
     * Upgrade mode code
     */
    const MODE_UPGRADE = 'upgrade';

    /**
     * Install create mode code
     */
    const MODE_INSTALL_CREATE = 'install_create';

    /**
     * Install login mode code
     */
    const MODE_INSTALL_LOGIN = 'install_login';

    /**
     * Completed mode code
     */
    const MODE_COMPLETE = 'complete';

    /**
     * Welcome mode code
     */
    const MODE_WELCOME = 'welcome';

    /**
     * Web service remarkety username
     */
    const WEB_SERVICE_USERNAME = 'remarkety';

    /**
     * Web service role name
     */
    const WEB_SERVICE_ROLE = 'remarkety';

    /**
     * Install data
     *
     * @var array
     */
    protected $_data = null;

    /**
     * Set data
     *
     * @param   array $data
     * @return  Remarkety_Mgconnector_Model_Install
     */
    public function setData(array $data)
    {
        $this->_data['mode'] = $data['mode'];
        $this->_data['email']= array_key_exists('email', $data) ? $data['email'] : null;
        $this->_data['first_name']= array_key_exists('first_name', $data) ? $data['first_name'] : null;
        $this->_data['last_name']= array_key_exists('last_name', $data) ? $data['last_name'] : null;
        $this->_data['phone']= array_key_exists('phone', $data) ? $data['phone'] : null;
        $this->_data['password']= array_key_exists('password', $data) ? $data['password'] : null;
        $this->_data['terms'] = array_key_exists('terms', $data) ? ($data['terms']== '1' ? 'true' : 'false') : null;
        $this->_data['store_id'] = array_key_exists('store_id', $data) ? $data['store_id'] : null;
        $this->_data['key'] = array_key_exists('key', $data) ? $data['key'] : null;

        return $this;
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        return $this->_data;
    }

    /**
     * Create web service role and user
     *
     * @return Remarkety_Mgconnector_Model_Install
     */
    protected function _webServiceConfiguration()
    {
        $this->_data['key'] = $this->_generateApiKey();
        Mage::getModel('core/config')->saveConfig('remarkety/mgconnector/api_key', $this->_data['key']);

        if(!$this->_getWebServiceUser()->getId()) {
            $role = Mage::getModel('api/roles')
                ->setName(self::WEB_SERVICE_ROLE)
                ->setPid(false)
                ->setRoleType('G')
                ->save();

            Mage::getModel("api/rules")
                ->setRoleId($role->getId())
                ->setResources(array('all'))
                ->saveRel();

            $user = Mage::getModel('api/user')
                ->setData(array(
                    'username' => self::WEB_SERVICE_ROLE,
                    'firstname' => $this->_data['first_name'],
                    'lastname' => $this->_data['last_name'],
                    'email' => $this->_data['email'],
                    'api_key' => $this->_data['key'],
                    'api_key_confirmation' => $this->_data['key'],
                    'is_active' => 1,
                    'user_roles' => '',
                    'assigned_user_role' => '',
                    'role_name' => '',
                    'roles' => array($role->getId())
                ))
                ->save();

            $user
                ->setRoleIds(array($role->getId()))
                ->setRoleUserId($user->getUserId())
                ->saveRelations();
        } else {
            $this
                ->_getWebServiceUser()
                ->setEmail($this->_data['email'])
                ->setFirstname($this->_data['first_name'])
                ->setLastname($this->_data['last_name'])
                ->setNewApiKey($this->_data['key'])
                ->save();
        }

        return $this;
    }

    /**
     * Send request
     *
     * @param   $payload
     * @return  Remarkety_Mgconnector_Model_Install
     */
    protected function _sendRequest($payload)
    {
        Mage::getModel('mgconnector/request')->makeRequest($payload);

        return $this;
    }

    /**
     * Install extension creating new remarkety account
     *
     * @return Remarkety_Mgconnector_Model_Install
     * @throws Mage_Core_Exception
     */
    public function installByCreateExtension()
    {
        $connection = Mage::getSingleton('core/resource')->getConnection('core_write');

        try {
            $connection->beginTransaction();

            $this->_webServiceConfiguration();

            $connection->commit();
        } catch(Mage_Core_Exception $e) {
            $connection->rollback();
            throw new Mage_Core_Exception($e->getMessage());
        }

        $store = Mage::getModel('core/store')->load($this->_data['store_id']);

        $this->_sendRequest(array(
            'key' => $this->_data['key'],
            'email' => $this->_data['email'],
            'password' => $this->_data['password'],
            'acceptTerms' => $this->_data['terms'],
            'selectedView' => json_encode(array(
                'website_id' => $store->getWebsiteId(),
                'store_id' => $store->getGroupId(),
                'view_id' => $this->_data['store_id'],
            )),
            'isNewUser' => true,
            'firstName' => $this->_data['first_name'],
            'lastName' => $this->_data['last_name'],
            'phone' => $this->_data['phone'],
        ));

        $this->_markInstalled();
        return $this;
    }

    /**
     * Install extension using existing remarkety account
     *
     * @return Remarkety_Mgconnector_Model_Install
     * @throws Mage_Core_Exception
     */
    public function installByLoginExtension()
    {
        $connection = Mage::getSingleton('core/resource')->getConnection('core_write');

        try {
            $connection->beginTransaction();

            $this->_webServiceConfiguration();

            $connection->commit();
        } catch(Mage_Core_Exception $e) {
            $connection->rollback();
            throw new Mage_Core_Exception($e->getMessage());
        }

        $store = Mage::getModel('core/store')->load($this->_data['store_id']);

        $this->_sendRequest(array(
            'key' => $this->_data['key'],
            'email' => $this->_data['email'],
            'password' => $this->_data['password'],
            'acceptTerms' => $this->_data['terms'],
            'selectedView' => json_encode(array(
                'website_id' => $store->getWebsiteId(),
                'store_id' => $store->getGroupId(),
                'view_id' => $this->_data['store_id'],
            )),
            'isNewUser' => false,
        ));
        $this->_markInstalled();
        return $this;
    }

    /**
     * Upgrade extension
     *
     * @return Remarkety_Mgconnector_Model_Install
     * @throws Mage_Core_Exception
     */
    public function upgradeExtension()
    {
        $connection = Mage::getSingleton('core/resource')->getConnection('core_write');

        try {
            $connection->beginTransaction();

            $webServiceUser = $this->_getWebServiceUser();

            $this->_data['email'] = $webServiceUser->getEmail();
            $this->_data['key'] = $this->_generateApiKey();

            $this
                ->_getWebServiceUser()
                ->setNewApiKey($this->_data['key'])
                ->save();

            Mage::getModel('core/config')->saveConfig('remarkety/mgconnector/api_key', $this->_data['key']);

            $connection->commit();
        } catch(Mage_Core_Exception $e) {
            $connection->rollback();
            throw new Mage_Core_Exception($e->getMessage());
        }

        $this->_sendRequest(array());

        return $this;
    }

    /**
     * Complete extension installation
     *
     * @return Remarkety_Mgconnector_Model_Install
     * @throws Mage_Core_Exception
     */
    public function completeExtensionInstallation()
    {
        $connection = Mage::getSingleton('core/resource')->getConnection('core_write');

        try {
            $connection->beginTransaction();

            $ver = Mage::getConfig()->getModuleConfig("Remarkety_Mgconnector")->version;
            Mage::getModel('core/config')->saveConfig('remarkety/mgconnector/installed', $ver);

            $intervals = Mage::getStoreConfig('mgconnector_options/mgconnector_options_group/intervals');
            if(!empty($intervals)) {
                Mage::getModel('core/config')->saveConfig('remarkety/mgconnector/intervals', $intervals);
            } else {
            	Mage::getModel('core/config')->saveConfig('remarkety/mgconnector/intervals', "1,3,10");
            }

            // remove old config entries if exist
            Mage::getModel('core/config')
                ->deleteConfig('mgconnector_options/mgconnector_options_group/api_key')
                ->deleteConfig('mgconnector_options/mgconnector_options_group/intervals');

            // remove old files
            $blockDir = Mage::getModuleDir('Block', 'Remarkety_Mgconnector') . DS . 'Block';
            $etcDir = Mage::getModuleDir('etc', 'Remarkety_Mgconnector');

            if(file_exists($file = $etcDir . DS . 'system.xml')) {
                unlink($file);
            }
            if(file_exists($file = $blockDir . DS . 'Adminhtml' . DS . 'Mgconnector.php')) {
                unlink($file);
            }
            if(file_exists($file = $blockDir . DS . 'Adminhtml' . DS . 'Mgconnector' . DS . 'Grid.php')) {
                unlink($file);
            }
            if(file_exists($file = $blockDir . DS . 'Adminhtml' . DS . 'Mgconnector' . DS . 'Grid' . DS . 'Column' . DS . 'Renderer' . DS . 'Status.php')) {
                unlink($file);
            }

            $connection->commit();
        } catch(Mage_Core_Exception $e) {
            $connection->rollback();
            throw new Mage_Core_Exception($e->getMessage());
        }

        return $this;
    }

    /**
     * Generate new api key
     *
     * @return string
     * @throws Mage_Core_Exception
     */
    protected function _generateApiKey()
    {
        if(!empty($this->_data['email'])) {
            return md5($this->_data['email'] . time());
        }
        throw new Mage_Core_Exception('Can not generate api key');
    }

    /**
     * Return remarkety webservice user
     *
     * @return Mage_Api_Model_User
     */
    protected function _getWebServiceUser()
    {
        $webServiceUser = Mage::getModel('api/user')
            ->loadByUsername(self::WEB_SERVICE_USERNAME);

        return $webServiceUser;
    }
    
    protected function _markInstalled() {$connection = Mage::getSingleton('core/resource')->getConnection('core_write');

        try {
            $connection->beginTransaction();
            $ver = Mage::getConfig()->getModuleConfig("Remarkety_Mgconnector")->version;
            Mage::getModel('core/config')->saveConfig('remarkety/mgconnector/installed', $ver);
        	$connection->commit();
        	Mage::app()->getCacheInstance()->cleanType('config');
        } catch(Mage_Core_Exception $e) {
            $connection->rollback();
            throw new Mage_Core_Exception($e->getMessage());
        }
        $installed = Mage::getStoreConfig('remarkety/mgconnector/installed');
    }
}