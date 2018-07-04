<?php 
class ControllerExtensionModuleFacebookChat extends Controller  {
    public function index() {
        $data['heading_title'] = $this->language->get('heading_title');
        $this->document->addStyle('catalog/view/javascript/facebookchat/css/messenger.css');
        $this->document->addScript('catalog/view/javascript/facebookchat/js/jquery.event.move.js');
        $this->document->addScript('catalog/view/javascript/facebookchat/js/rebound.min.js');
        $this->load->model('extension/module/facebookchat');
        $this->load->language('extension/module/facebookchat');
        $data['text_language']  = $this->language->get('text_language');
        $data['text_facebookchat'] = $this->language->get('text_facebookchat');
        $data['text_chat'] = $this->language->get('text_chat');
        $facebookchat_info = $this->model_extension_module_facebookchat->getSetting('facebookchat', $this->config->get('config_store_id'));
        $data['language_current'] = $this->config->get('config_language_id');
            if($facebookchat_info){
                $data['facebookchats'] = array (
                            'username' => $facebookchat_info['facebookchat']['username'],
                            'welcom1' => $facebookchat_info['facebookchat']['welcom1'],
                            'welcom2' => $facebookchat_info['facebookchat']['welcom2'],
                     );
             }
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . 'extension/module/facebookchat')) {
                return $this->load->view($this->config->get('config_template') . 'extension/module/facebookchat', $data);
            } else {
                return $this->load->view('extension/module/facebookchat', $data);
            }
    }
}
?>