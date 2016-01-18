<?php

class AdminCmsController extends AdminCmsControllerCore {
	public function __construct()
	{
		parent::__construct();
	}

	public function renderView()
	{		

		echo 'rendeview';
	}
	
	public function renderForm()
	{
		
		if (!$this->loadObject(true))
			return;
			
		$checkVersion = version_compare(_PS_VERSION_, '1.6');
		
		$this->isPS6 = false;
		
		if ($checkVersion >= 0){
			$this->isPS6 = true;
		}
		
		if (Validate::isLoadedObject($this->object))
			$this->display = 'edit';
		else
			$this->display = 'add';

		if (!$this->isPS6) { //ps5
			$this->toolbar_btn['save-and-preview'] = array(
				'href' => '#',
				'desc' => $this->l('Save and preview')
			);
			$this->toolbar_btn['save-and-stay'] = array(
				'short' => 'SaveAndStay',
				'href' => '#',
				'desc' => $this->l('Save and stay'),
			);
		}
		
		$this->initToolbar();
		if ($this->isPS6) //ps6
			$this->initPageHeaderToolbar();

		$categories = CMSCategory::getCategories($this->context->language->id, false);
		$html_categories = CMSCategory::recurseCMSCategory($categories, $categories[0][1], 1, $this->getFieldValue($this->object, 'id_cms_category'), 1);
		
		$galleries = $this->getSliders();

		$this->fields_form = array(
			'tinymce' => true,
			'legend' => array(
				'title' => $this->l('CMS Page'),
				'image' => '../img/admin/tab-categories.gif',
				'icon' => 'icon-folder-close'
			),
			'input' => array(
				// custom template
				array(
					'type' => 'select_category',
					'label' => $this->l('CMS Category'),
					'name' => 'id_cms_category',
					'options' => array(
						'html' => $html_categories,
					),
				),
				array(
					'type' => 'text',
					'label' => $this->l('Meta title:'),
					'name' => 'meta_title',
					'id' => 'name', // for copy2friendlyUrl compatibility
					'lang' => true,
					'required' => true,
					'class' => 'copy2friendlyUrl copyMeta2friendlyURL',
					'hint' => $this->l('Invalid characters:').' <>;=#{}',
					//'size' => ($this->isPS6 ? '' : 50)
				),
				array( //syncrea
					'type' => 'select_category',
					'label' => $this->l('Slider'),
					'name' => 'proslider',
					'empty_message' => $this->l('None'),
					'options' => array(                                  // only if type == select
						'html' => $galleries,
                            // key that will be used for each option "value" attribute
					  ),
				),
				array(
					'type' => 'text',
					'label' => $this->l('Meta description'),
					'name' => 'meta_description',
					'lang' => true,
					'hint' => $this->l('Invalid characters:').' <>;=#{}',
					//'size' => ($this->isPS6 ? '' : 70)
				),
				array(
					'type' => 'tags',
					'label' => $this->l('Meta keywords'),
					'name' => 'meta_keywords',
					'lang' => true,
					'hint' => $this->l('Invalid characters:').' <>;=#{}',
					//'size' => ($this->isPS6 ? '' : 70),
					'desc' => $this->l('To add "tags" click in the field, write something, and then press "Enter."')
				),
				array(
					'type' => 'text',
					'label' => $this->l('Friendly URL'),
					'name' => 'link_rewrite',
					'required' => true,
					'lang' => true,
					'hint' => $this->l('Only letters and the minus (-) character are allowed')
				),
				array(
					'type' => 'textarea',
					'label' => $this->l('Page content'),
					'name' => 'content',
					'autoload_rte' => true,
					'lang' => true,
					'rows' => 5,
					'cols' => 40,
					'hint' => $this->l('Invalid characters:').' <>;=#{}'
				),
				array(
					'type' => ($this->isPS6 ? 'switch' : 'hidden'),
					'label' => $this->l('Indexation by search engines'),
					'name' => 'indexation',
					'required' => false,
					'class' => 't',
					'is_bool' => true,
					'values' => array(
						array(
							'id' => 'indexation_on',
							'value' => 1,
							'label' => $this->l('Enabled')
						),
						array(
							'id' => 'indexation_off',
							'value' => 0,
							'label' => $this->l('Disabled')
						)
					),
				),
				array(
					'type' => ($this->isPS6 ? 'switch' : 'radio'),
					'label' => $this->l('Displayed:'),
					'name' => 'active',
					'required' => false,
					'class' => 't',
					'is_bool' => true,
					'values' => array(
						array(
							'id' => 'active_on',
							'value' => 1,
							'label' => $this->l('Enabled')
						),
						array(
							'id' => 'active_off',
							'value' => 0,
							'label' => $this->l('Disabled')
						)
					),
				),
			),
			'submit' => array(
				'title' => $this->l('Save'),
				'class' => 'button btn btn-default'
			)
		);
		
		if ($this->isPS6) {
			$this->fields_form['buttons'] = array(
				'save_and_preview' => array(
					'name' => 'viewcms',
					'type' => 'submit',
					'title' => $this->l('Save and preview'),
					'class' => 'btn btn-default pull-right',
					'icon' => 'process-icon-preview'
				),
			);
		}
		
		$this->fields_form['submit'] = array(
			'title' => $this->l('Save'),
			'class' => 'button btn btn-default pull-right'
		);

		if (Shop::isFeatureActive())
		{
			$this->fields_form['input'][] = array(
				'type' => 'shop',
				'label' => $this->l('Shop association:'),
				'name' => 'checkBoxShopAsso',
			);
		}
		
		if ($this->isPS6) {
			if (Validate::isLoadedObject($this->object))
				$this->context->smarty->assign('url_prev' , $this->getPreviewUrl($this->object));
		}

		$this->tpl_form_vars = array(
			'active' => $this->object->active,
			'PS_ALLOW_ACCENTED_CHARS_URL', (int)Configuration::get('PS_ALLOW_ACCENTED_CHARS_URL')
		);
		return adminController::renderForm();
	}
	
	public function getShopId(){
		$shopcontext = $this->context->cookie->shopContext;
		if (empty($shopcontext)) {
			$shop = $this->context->shop->id;
		} else
		if (strpos($shopcontext,'s-') === false){
			$shop = $this->context->shop->id;
		} else if (strpos($shopcontext,'s-') === 0){
			$shop = str_replace('s-','',$shopcontext);
		}
		return (int)$shop;
	}
	
	public function getSliders()
	{
		if (Module::isInstalled('homesliderpro')) {
			$SlidersEverywhere = new homesliderpro();
			$hooks = $SlidersEverywhere->getConfig('HOMESLIDERPRO_HOOKS', (int)$this->getShopId());
			if (empty($hooks))
				$hooks = $SlidersEverywhere->getConfig('HOMESLIDERPRO_HOOKS');
			$cmsPage = Tools::getValue('id_cms');
			$html = '<option value="0">'.$this->l('None').'</option>';
			if (!empty($hooks)) {
				if ($cmsPage != '') {
					foreach ($hooks as $hook) {
						if ($sel = Db::getInstance()->getRow('SELECT * FROM `'._DB_PREFIX_.'cms` WHERE proslider = "'.$hook.'" AND id_cms='.$cmsPage)) {
							$selected = 'selected="selected"';
						} else {
							$selected = '';
						}
						$html.='<option '.$selected.' value="'.$hook.'">'.$hook.'</option>';
					}
				} else {
					foreach ($hooks as $hook) {
						$selected = '';
						$html.='<option '.$selected.' value="'.$hook.'">'.$hook.'</option>';
					}
				}
			} 
			return $html;
		}
		return false;
	}
	
	public function viewAccess() {
		return true;
	}
	
	public function checkAccess() {
		return true;
	}
	public function postProcess() {
		//echo ' - PostProcess';
		return parent::postProcess();
	}
	public function display() {
		return true;
	}
	public function initHeader() {
		return true;
	}
	public function initFooter() {
		return true;
	}
	public function initCursedPage() {
		return true;
	}
	public function setMedia() {
		return true;
	}
	
	public function redirect() {
		return parent::redirect();
	}
	
}

class CMS extends CMSCore
	{
		
		public $proslider;

		/**
		 * @see ObjectModel::$definition
		 */
		public static $definition = array(
			'table' => 'cms',
			'primary' => 'id_cms',
			'multilang' => true,
			'fields' => array(
				'id_cms_category' => 	array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'),
				'position' => 			array('type' => self::TYPE_INT),
				'indexation' =>     	array('type' => self::TYPE_BOOL),
				'active' => 			array('type' => self::TYPE_BOOL),

				// Lang fields
				'meta_description' => 	array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isGenericName', 'size' => 255),
				'meta_keywords' => 		array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isGenericName', 'size' => 255),
				'meta_title' =>			array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isGenericName', 'required' => true, 'size' => 128),
				'link_rewrite' => 		array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isLinkRewrite', 'required' => true, 'size' => 128),
				'content' => 			array('type' => self::TYPE_HTML, 'lang' => true, 'validate' => 'isCleanHtml', 'size' => 3999999999999),
				'proslider' => 			array('type' => self::TYPE_STRING, 'validate' => 'isConfigName'),
			),
		);
}

