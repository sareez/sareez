<?php
    class Biztech_Easymaintanance_Model_Observer
    {
        const XML_PATH_EMAIL_SENDER     = 'contacts/email/sender_email_identity';
        public function initControllerRouters($request) 
        {
            $adminFrontName = (string)Mage::getConfig()->getNode('admin/routers/adminhtml/args/frontName');

            $area = Mage::app()->getRequest()->getOriginalPathInfo();
            if((!preg_match('/'.$adminFrontName.'/',$area)) && (!preg_match('/postFeedback/',$area)))
            {
                $storeId = Mage::app()->getStore()->getStoreId();
                $isEnabled = Mage::getStoreConfig('easymaintanance/general/enabled',$storeId);

                if ($isEnabled == 1) 
                {
                    $allowedIPs = Mage::getStoreConfig('easymaintanance/general/allowedIPs',$storeId);
                    $allowedIPs = preg_replace('/ /', '', $allowedIPs);
                    $IPs = array();
                    if ('' !== trim($allowedIPs)) 
                    {
                        $IPs = explode(',', $allowedIPs);
                    }
                    $currentIP = $_SERVER['REMOTE_ADDR'];
                    $allowForAdmin = Mage::getStoreConfig('easymaintanance/general/allowforadmin',$storeId);
                    $adminIp = null;
                    if ($allowForAdmin == 1) 
                    {
                        Mage::getSingleton('core/session', array('name' => 'adminhtml'));
                        $adminSession = Mage::getSingleton('admin/session');
                        if ($adminSession->isLoggedIn()) {
                            $adminIp = $adminSession['_session_validator_data']['remote_addr'];
                        }
                    }
                    if ($currentIP === $adminIp) 
                    {
                        $this->createLog('Access granted for admin with IP: ' . $currentIP . ' and store ' . $storeId, $storeId);

                    } else {
                        if (!in_array($currentIP, $IPs))
                        {
                            $this->createLog('Access denied  for IP: ' . $currentIP . ' and store ' . $storeId,  $storeId);

                            $html = Mage::getSingleton('core/layout')->createBlock('core/template')->setTemplate('easymaintanance/easymaintanance.phtml')->toHtml();

                            if ('' !== $html) 
                            {
                                Mage::getSingleton('core/session', array('name' => 'front'));
                                $response = $request->getEvent()->getFront()->getResponse();
                                $response->setHeader('HTTP/1.1', '503 Service Temporarily Unavailable');
                                $response->setHeader('Status', '503 Service Temporarily Unavailable');
                                $response->setHeader('Retry-After', '5000');
                                $response->setBody($html);
                                $response->sendHeaders();
                                $response->outputBody();
                            }
                            exit();
                        } else {
                            $this->createLog('Access granted for IP: ' . $currentIP . ' and store ' . $storeId,  $storeId);
                        }
                    }
                }

            }
        }


        private function createLog($text, $storeId = null, $zendLevel = Zend_Log::DEBUG) 
        {
            $logFile = trim(Mage::getStoreConfig('easymaintanance/general/logFileName',$storeId));
            if ('' === $logFile) 
            {
                $logFile = 'easymaintenance.log';
            }
            Mage::log($text, $zendLevel, $logFile);
        }

        public function timeralert() 
        {
            
            $storeId = Mage::app()->getStore()->getStoreId();
            $hour = Mage::getStoreConfig('easymaintanance/timer/timer_hour',$storeId);
            $min = Mage::getStoreConfig('easymaintanance/timer/timer_min',$storeId);
            
            $isEnabled = Mage::getStoreConfig('easymaintanance/general/enabled',$storeId);
            if ($isEnabled == 1) 
            {
                $time1 = Mage::getStoreConfig('easymaintanance/timer/timer_date',$storeId)." ".$hour.":".$min.":"."00";
                $time2 = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
                $precision = 6;
                if (!is_int($time1)) {
                    $time1 = strtotime($time1);
                }
                if (!is_int($time2)) {
                    $time2 = strtotime($time2);
                }
                if ($time1 > $time2) {
                    $ttime = $time1;
                    $time1 = $time2;
                    $time2 = $ttime;
                }
                $intervals = array('minute');
                $diffs = array();

                foreach ($intervals as $interval) {
                    $ttime = strtotime('+1 ' . $interval, $time1);
                    $add = 1;
                    $looped = 0;
                    while ($time2 >= $ttime) {
                        $add++;
                        $ttime = strtotime("+" . $add . " " . $interval, $time1);
                        $looped++;
                    }

                    $time1 = strtotime("+" . $looped . " " . $interval, $time1);
                    $diffs[$interval] = $looped;
                }

                $count = 0;

                foreach ($diffs as $interval => $value) {
                    if ($count >= $precision) {
                        break;
                    }
                    if ($value > 0) {
                        if ($value != 1) {
                            $interval .= "s";
                        }
                        $times= $value;
                        $count++;
                    }
                }

                $storeId = Mage::app()->getStore()->getStoreId();
                $alert_min = Mage::getStoreConfig('easymaintanance/timer/timer_alert',$storeId);
                if($times <= $alert_min)
                {
                    $fromEmail          = Mage::getStoreConfig(self::XML_PATH_EMAIL_SENDER);
                    $toEmail            = Mage::getStoreConfig('easymaintanance/timer/timer_email');
                    $message            = Mage::getStoreConfig('easymaintanance/timer/timer_email_template');
                    $subject            = "Timer Alert";

                    try{
                        $mail = new Zend_Mail();
                        $mail->setFrom($fromEmail);
                        $mail->addTo($toEmail);
                        $mail->setSubject($subject);
                        $mail->setBodyHtml($message); 
                        $mail->send();

                    }catch(Exception $e){
                        echo $e->getMassage();

                    }
                }
            }
        }

    }
