<?php
class LHN_Chat_Block_Button extends Mage_Core_Block_Abstract implements Mage_Widget_Block_Interface{
	protected function _toHtml(){
		$lhn_account = $this->getData('account_number');
		$lhn_button = $this->getData('button_number');
		
		$lhn_account = str_replace("lhn","",strtolower($lhn_account));
	  
		if(substr($lhn_account, -2)=="-1"){
		    $subText = "";
		}else{
		    $subText = '<div style="font-size:10px;"><a title="Help desk software" href="http://www.LiveHelpNow.net/" style="font-size:10px;" target="_blank">Help desk software</a></div>';
		}
		$lhn_account = str_replace("-1","",$lhn_account);
		
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
	  
		$content = PHP_EOL.'<!--start http://www.livehelpnow.net  -->'.PHP_EOL;
		$content .= '<!--This DIV object will show the live chat button, have it placed in the location on your website where you would like the live chat button to show-->'.PHP_EOL;
		$content .= '<div id="lhnContainer" style="text-align:center;">'.PHP_EOL;
		$content .= '<div id="lhnChatButton"></div>'.PHP_EOL;
		$content .= $subText.PHP_EOL;
		$content .= '</div>'.PHP_EOL;
		$content .= '<!--You may install the following code in an external JavaScript file if you like-->'.PHP_EOL;
		$content .= '<script type="text/javascript">'.PHP_EOL;
		$content .= 'if(typeof lhnChatButton == "undefined"){'.PHP_EOL;
		$content .= 'var lhnChatButton = 1;'.PHP_EOL;
		$content .= 'var lhnAccountN = '. $lhn_account .';'.PHP_EOL;
		$content .= 'var lhnButtonN = '. $lhn_button .';'.PHP_EOL;
		$content .= 'var lhnVersion = 5.3; '.PHP_EOL;
		$content .= 'var lhnJsHost = (("https:" == document.location.protocol) ? "https://" : "http://");'.PHP_EOL; 
		$content .= 'var lhnInviteEnabled = 0;'.PHP_EOL;
		$content .= 'var lhnInviteChime = 0;'.PHP_EOL;
		$content .= 'var lhnWindowN = 0;'.PHP_EOL;
		$content .= 'var lhnDepartmentN = 0;'.PHP_EOL;
		$content .= 'var lhnCustomInvitation = "";'.PHP_EOL;
		$content .= 'var lhnCustom1 = "'.$lhnCustomer.'";'.PHP_EOL;
		$content .= 'var lhnCustom2 = "'.$lhnEmail.'";'.PHP_EOL;
		$content .= 'var lhnCustom3 = "'.$lhnCart.'";'.PHP_EOL;
		$content .= 'var lhnPlugin = "Mage-'.Mage::getVersion().'-Chat";'.PHP_EOL;
		$content .= 'var lhnTrackingEnabled = "t";'.PHP_EOL;
		$content .= 'var lhnScriptSrc = lhnJsHost + "www.livehelpnow.net/lhn/scripts/livehelpnow.aspx?lhnid=" + lhnAccountN + "&iv=" + lhnInviteEnabled + "&d=" + lhnDepartmentN + "&ver=" + lhnVersion + "&rnd=" + Math.random();'.PHP_EOL;
		$content .= 'lhnLoadEvent = addLHNButton(lhnScriptSrc,"append");'.PHP_EOL;
		$content .= '}else{'.PHP_EOL;
		$content .= 'lhnLoadEvent = addLHNButton('.$lhn_button.',"insert");'.PHP_EOL;
		$content .= '}'.PHP_EOL;
		$content .= 'if (window.addEventListener) {'.PHP_EOL;
		$content .= 'window.addEventListener("load", function () {'.PHP_EOL;
		$content .= 'lhnLoadEvent;'.PHP_EOL;
		$content .= '});'.PHP_EOL;
		$content .= '}else{'.PHP_EOL;
		$content .= 'window.attachEvent("onload", function () {'.PHP_EOL;
		$content .= 'lhnLoadEvent;'.PHP_EOL;
		$content .= '});'.PHP_EOL;
		$content .= '}'.PHP_EOL;
		$content .= 'function addLHNButton(lhnbutton, lhntype){'.PHP_EOL;
		$content .= 'element = document.getElementById("lhnContainer");'.PHP_EOL;
		$content .= 'element.id = "lhnContainerDone";'.PHP_EOL;
		$content .= 'if(lhntype == "insert"){'.PHP_EOL;
		$content .= 'var lhnScript = document.createElement("a");lhnScript.href = "#";lhnScript.onclick = function(){OpenLHNChat();return false;};'.PHP_EOL;
		$content .= 'lhnScript.innerHTML = "<img id=\"lhnchatimg\" alt=\"Live Help\" border=\"0\" nocache src=\""+lhnJsHost+"www.livehelpnow.net/lhn/functions/imageserver.ashx?lhnid="+lhnAccountN+"&amp;navname=&amp;java=&amp;referrer=&amp;pagetitle=&amp;pageurl=&amp;t=f&amp;zimg="+lhnbutton+"&amp;d=0&amp;rndstr=999\" />";'.PHP_EOL;
		$content .= 'element.insertBefore(lhnScript,element.firstChild);'.PHP_EOL;
		$content .= '}else{'.PHP_EOL;
		$content .= 'console.log(lhnbutton);var lhnScript = document.createElement("script");lhnScript.type = "text/javascript";lhnScript.src = lhnbutton;'.PHP_EOL;
		$content .= 'element.appendChild(lhnScript);'.PHP_EOL;
		$content .= '}'.PHP_EOL;
		$content .= '}'.PHP_EOL;
		$content .= '</script>'.PHP_EOL;
		$content .= '<!--end http://www.livehelpnow.net  -->'.PHP_EOL;
		return $content;
	}
}