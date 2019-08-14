<?php
class LHN_Chat_Block_Button extends Mage_Core_Block_Abstract implements Mage_Widget_Block_Interface{
	protected function _toHtml(){
		$lhn_account = $this->getData('account_number');
		$lhn_button = $this->getData('button_number');
		$lhn_invite = $this->getData('invite');
		$lhn_invite = empty($lhn_invite) ? "0" : "1";
		$lhn_window = $this->getData('window_number');
		$lhn_window = empty($lhn_window) ? "0" : $lhn_window;
		$lhn_invitation = $this->getData('invitation_number');
		$lhn_invitation = empty($lhn_invitation) ? "0" : $lhn_invitation;
		$lhn_department = $this->getData('department_number');
		$lhn_department = empty($lhn_department) ? "0" : $lhn_department;
		
		$lhn_account = str_replace("lhn","",strtolower($lhn_account));
				
		$lhnEmail = "";
		$lhnCustomer = "";
		$lhnCart = "";
		if(Mage::getSingleton('customer/session')->isLoggedIn()){
			$customer = Mage::getSingleton('customer/session');
			$customerData = Mage::getModel('customer/customer')->load($customer->getId())->getData();
			
			$lhnEmail = urlencode($customerData['email']);
			$lhnCustomer = urlencode($customerData['firstname']." ".$customerData['lastname']);
			
			$cart = Mage::helper('checkout')->getQuote()->getData();
			if($cart['items_qty'] < 1){$cart['items_qty'] = 0;}
			if($cart['subtotal'] < 1){$cart['subtotal'] = 0.00;}
			$lhnCart = urlencode("Quantity: ".intval($cart['items_qty'])." total items<br />");
			$lhnCart .= urlencode("Subtotal: $".$cart['subtotal']);
		}
	  
		$content = '<script type="text/javascript">'.PHP_EOL;
		$content .= 'var lhnAccountN = "'. $lhn_account .'";'.PHP_EOL;
		$content .= 'var lhnButtonN = '. $lhn_button .';'.PHP_EOL;
		$content .= 'var lhnInviteEnabled = '.$lhn_invite.';'.PHP_EOL;
		$content .= 'var lhnWindowN = '.$lhn_window.';'.PHP_EOL;
		$content .= 'var lhnInviteN = '.$lhn_invitation.';'.PHP_EOL;
		$content .= 'var lhnDepartmentN = '.$lhn_department.';'.PHP_EOL;
		$content .= 'var lhnCustom1 = "'.$lhnCustomer.'";'.PHP_EOL;
		$content .= 'var lhnCustom2 = "'.$lhnEmail.'";'.PHP_EOL;
		$content .= 'var lhnCustom3 = "'.$lhnCart.'";'.PHP_EOL;
		$content .= 'var lhnPlugin = "Mage-'.Mage::getVersion().'-Chat";'.PHP_EOL;
		$content .= '</script>'.PHP_EOL;
		$content .= '<a href="http://www.LiveHelpNow.net/" target="_blank" style="font-size:10px;" id="lhnHelp">Help Desk Software</a>'.PHP_EOL;
		$content .= '<script src="//www.livehelpnow.net/lhn/widgets/chatbutton/lhnchatbutton-current.min.js" type="text/javascript" id="lhnscript"></script>'.PHP_EOL;

		return $content;
	}
}