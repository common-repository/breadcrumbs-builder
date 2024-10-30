<?php

class SGBB
{
	private $autoload;
	private $menuActions = array();
	private $ajaxCallbacks = array();
	private $postCallbacks = array();
	private $shortcodes = array();
	private $slugs = array();
	public $prefix = '';
	public $app_path = '';
	public $app_url = '';

	public function __construct()
	{
		$this->prefix = strtolower(__CLASS__).'_';
		$var = strtoupper($this->prefix).'AUTOLOAD';
		global $$var;
		$this->autoload = $$var;
	}

	public function __call($name, $args)
	{
		$param1 = null;
		$param2 = null;

		if (strpos($name, 'wp_ajax_')===0) {
			$action = $this->ajaxCallbacks[$name];
		}
		else if (strpos($name, 'wp_shortcode_')===0) {;
			$action = $this->shortcodes[$name];
			$param1 = $args[0];
			$param2 = $args[1];
		}
		else {
			$action = $this->menuActions[$name];
		}

		return $this->dispatchAction($action, $param1, $param2);
	}

	public function run()
	{
		$this->registerSetupController();

		if (count($this->autoload['menu_items'])) {
			add_action('admin_menu', array($this, 'loadMenu'));
		}

		if (count($this->autoload['network_admin_menu_items'])) {
			add_action('network_admin_menu', array($this, 'loadNetworkAdminMenu'));
		}

		$this->registerAjaxCallbacks();
		$this->registerShortcodes();
		$this->registerPostCallbacks();

		add_action('admin_enqueue_scripts', array($this, 'includeAdminScriptsAndStyles'));
		add_action('wp_enqueue_scripts', array($this, 'includeFrontScriptsAndStyles'));
		add_action('media_buttons', array($this, 'sgbb_media_button'));
		add_action('loop_start', array(&$this, 'sgbb_header'));
		add_action('loop_end', array(&$this, 'sgbb_footer'));
		add_action('the_content', array($this, 'sgbb_content'));
		add_action('wp_head', array($this, 'sgbbCreateAjaxUrl'));
		add_action('wp_head', array(&$this, 'sgbb_head'));
		add_action('wp_footer', array(&$this, 'sgbb_foot'));
	}

	public function sgbb_content ($content)
	{
		$htmlBefore = '';
		$htmlAfter = '';
		$this->includeController('Breadcrumb');
		$newBreadcrumb = new SGBB_BreadcrumbController();
		$htmlBefore .= $newBreadcrumb->prepareBreadcrumbHtml('', SGBB_POSITION_BEFORE, '');
		$htmlAfter .= $newBreadcrumb->prepareBreadcrumbHtml('', SGBB_POSITION_AFTER, '');
		if ($htmlBefore) {
			$content = $htmlBefore.$content;
		}
		if ($htmlAfter) {
			$content = $content.$htmlAfter;
		}
		echo do_shortcode($content);
	}

	public function sgbb_header( &$wp_query )
	{
		global $wp_the_query;
		if ( ( $wp_query === $wp_the_query ) && !is_admin() && !is_feed() && !is_robots() && !is_trackback() ) {
			$html = '';
			$this->includeController('Breadcrumb');
			$newBreadcrumb = new SGBB_BreadcrumbController();
			$html .= $newBreadcrumb->prepareBreadcrumbHtml('', SGBB_POSITION_TOP_2, '');
			if ($html) {
				echo $html;
			}
		}
	}

	public function sgbb_head()
	{
		$this->includeController('Breadcrumb');
		$html = '';
		$newBreadcrumb = new SGBB_BreadcrumbController();
		$html = $newBreadcrumb->prepareBreadcrumbHtml('', SGBB_POSITION_TOP_1, '');
		if ($html) {
			echo $html;
		}
	}

	public function sgbb_foot()
	{
		if ( !is_admin() && !is_feed() && !is_robots() && !is_trackback() ) {
			$html = '';
			$this->includeController('Breadcrumb');
			$newBreadcrumb = new SGBB_BreadcrumbController();
			$html = $newBreadcrumb->prepareBreadcrumbHtml('', SGBB_POSITION_BOTTOM_1, '');
			if ($html) {
				echo $html;
			}
		}
	}


	public function sgbb_footer(&$wp_query)
	{
		global $wp_the_query;
		if (($wp_query === $wp_the_query) && !is_admin() && !is_feed() && !is_robots() && !is_trackback()) {
			$html = '';
			$this->includeController('Breadcrumb');
			$newBreadcrumb = new SGBB_BreadcrumbController();
			$html = $newBreadcrumb->prepareBreadcrumbHtml('', SGBB_POSITION_BOTTOM_2, '');
			if ($html) {
				echo $html;
			}
		}

	}

	public function sgbb_media_button()
	{
		$buttonTitle = "Insert breadcrumb";
		$output = '';
		$buttonIcon = '<i class="dashicons dashicons-editor-insertmore" style="padding: 3px 2px 0"></i>';
		$output = '<a href="javascript:void(0);" onclick="jQuery(\'#sgbb-thickbox\').dialog({ width: 450, modal: true ,resizable: false,beforeClose : function(event, ui) { jQuery(\'.sgbb-not-selected-notice-message\').css(\'display\', \'none\') } });" class="button" title="'.$buttonTitle.'" style="padding-left: .4em;">'. $buttonIcon.$buttonTitle.'</a>';
		echo $output;
		add_action('admin_footer',array($this,'mediaButtonThickboxs'));
	}

	public function sgbbCreateAjaxUrl()
	{
		?>
			<script type="text/javascript">
			var sgbb_ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
			</script>
		<?php
	}

	public function mediaButtonThickboxs()
	{
		$this->includeStyle('page/styles/jquery-ui-dialog');
		$this->includeScript('core/scripts/jquery-ui-dialog');

		?>
		<script type="text/javascript">
			jQuery(document).ready(function () {
				jQuery('#sgbb-insert').on('click', function () {
					var id = jQuery('#sgbb-buttons-id').val();
					if ('' === id) {
						jQuery('.sgbb-not-selected-notice-message').css('display', 'inline');
						jQuery('.sgbb-insert-button').css('margin-top', 0);
						return;
					}
					else {
						jQuery('.sgbb-not-selected-notice-message').css('display', 'none');
						jQuery('.sgbb-insert-button').css('margin-top', '20px');
					}
					selectionText = '';
					if (typeof(tinyMCE.editors.content) != "undefined") {
						selectionText = (tinyMCE.activeEditor.selection.getContent()) ? tinyMCE.activeEditor.selection.getContent() : '';
					}
					window.send_to_editor('[sgbb_breadcrumb id=' + id + ']');
					jQuery('#sgbb-thickbox').dialog('close');
				});
			});
		</script>
		<div id="sgbb-thickbox" title="Insert breadcrumb" style="height:0;width:350px;display:none">
			<div class="wrap">
				<p class="insert-title">Insert the shortcode for showing a Breadcrumb.</p>
				<div>
					<select id="sgbb-buttons-id">
						<option value="">Please select...</option>
						<?php
							$proposedTypes = array();
							$orderBy = 'id DESC';
							$allTables = SGBB_BreadcrumbModel::finder()->findAll();
							foreach ($allTables as $table) : ?>
								<option value="<?php echo esc_attr($table->getId());?>"><?php echo esc_html($table->getTitle());?></option>;
							<?php endforeach; ?>
					</select>
				</div>
				<p class="sgbb-not-selected-notice-message" style="display:none">Notice : select your breadcrumb</p>
				<p class="submit sgbb-insert-button">
					<input type="button" id="sgbb-insert" class="button-primary dashicons-share" value="Insert"/>
					<a class="button-secondary" onclick="jQuery('#sgbb-thickbox').dialog('close')" title="Cancel">Cancel</a>
				</p>
			</div>
		</div>
	<?php
	}

	public function includeController($controller)
	{
		require_once($this->app_path.'com/controllers/'.$controller.'.php');
	}

	public function includeView($view)
	{
		require_once($this->app_path.'com/views/'.$view.'.php');
	}

	public function includeModel($model)
	{
		require_once($this->app_path.'com/models/'.$model.'.php');
	}

	public function includeLib($lib)
	{
		require_once($this->app_path.'com/lib/'.$lib.'.php');
	}

	public function includeCore($core)
	{
		require_once($this->app_path.'com/core/'.$core.'.php');
	}

	public function asset($component)
	{
		return $this->app_url.'assets/'.$component;
	}

	public function tablename($tbl)
	{
		global $wpdb;
		return $wpdb->prefix.$this->prefix.$tbl;
	}

	public function layoutPath($layout)
	{
		return $this->app_path.'com/layouts/'.$layout.'.php';
	}

	public function adminUrl($action, $extra='')
	{
		$url = admin_url().'admin.php?page='.$this->actionToSlug($action);
		if ($extra) $url .= '&'.$extra;
		return $url;
	}

	public function adminPostUrl($action, $extra='')
	{
		$url = admin_url().'admin-post.php?action='.$action;
		if ($extra) $url .= '&'.$extra;
		return $url;
	}

	public function url($component)
	{
		return $this->app_url.$component;
	}

	public function redirect($component)
	{
		header('Location: '.$this->url($component));
		exit;
	}

	public function registerSetupController()
	{
		$this->includeController('Setup');
		$controllerName = $this->prefix.'SetupController';

		register_activation_hook($this->app_path.'app.php', array($controllerName, 'activate'));
		register_deactivation_hook($this->app_path.'app.php', array($controllerName, 'deactivate'));
		register_uninstall_hook($this->app_path.'app.php', array($controllerName, 'uninstall'));

		add_action('wpmu_new_blog', array($controllerName, 'createBlog'));
	}

	private function registerAjaxCallbacks()
	{
		if (count($this->autoload['front_ajax'])) {
			foreach ($this->autoload['front_ajax'] as $callback) {
				$id = 'wp_ajax_nopriv_'.$this->prefix.$callback['controller'].'_'.$callback['action'];
				$this->ajaxCallbacks[$id] = array($callback['controller'], $callback['action']);
				add_action($id, array($this, $id));

				$id = 'wp_ajax_'.$this->prefix.$callback['controller'].'_'.$callback['action'];
				$this->ajaxCallbacks[$id] = array($callback['controller'], $callback['action']);
				add_action($id, array($this, $id));
			}
		}

		if (count($this->autoload['admin_ajax'])) {
			foreach ($this->autoload['admin_ajax'] as $callback) {
				$id = 'wp_ajax_'.$this->prefix.$callback['controller'].'_'.$callback['action'];
				$this->ajaxCallbacks[$id] = array($callback['controller'], $callback['action']);
				add_action($id, array($this, $id));
			}
		}
	}

	private function registerPostCallbacks()
	{
		if (count($this->autoload['admin_post'])) {
			foreach ($this->autoload['admin_post'] as $callback) {
				$id = 'admin_post_'.$this->prefix.$callback['controller'].'/'.$callback['action'];
				$this->postCallbacks[$id] = array($callback['controller'], $callback['action']);
				add_action($id, array($this, $id));
			}
		}
	}

	private function registerShortcodes()
	{
		foreach ($this->autoload['shortcodes'] as $shortcode) {
			$id = 'wp_shortcode_'.$shortcode['shortcode'];
			$this->shortcodes[$id] = array($shortcode['controller'], $shortcode['action']);
			add_shortcode($shortcode['shortcode'], array($this, $id));
		}
	}

	public function setLocale($locale)
	{
		return 'en';
	}

	private function prepareForLocalization()
	{

	}

	public function includeScript($script)
	{
		if ($script=='wp_enqueue_media') {
			wp_enqueue_media();
			return;
		}

		if ($script=='wp_ajax_library') {
			add_action('wp_head', array($this, 'addAjaxLibrary'));
			return;
		}

		if(is_admin()) {
			wp_enqueue_script($this->prefix.$script, $this->asset($script.'.js'), array('jquery', 'wp-color-picker'), SGBB_VERSION, true);
			wp_enqueue_media();
		}
		wp_enqueue_script($this->prefix.$script, $this->asset($script.'.js'), array('jquery'),false);
	}

	public function includeStyle($style)
	{
		wp_enqueue_style($this->prefix.$style, $this->asset($style.'.css'), array('wp-color-picker'), false);
	}

	public function includeAdminScriptsAndStyles($hook)
	{
		if (count($this->autoload['admin_scripts'])) {
			foreach ($this->autoload['admin_scripts'] as $script) {
				$this->includeScript($script);
			}
		}

		if (count($this->autoload['admin_styles'])) {
			foreach ($this->autoload['admin_styles'] as $style) {
				$this->includeStyle($style);
			}
		}

		// need to add this style to header (template css issue)
		wp_enqueue_style('sgbb_page/styles/save',  $this->app_url.'/assets/page/styles/save.css', array(), 'all');
	}

	public function includeFrontScriptsAndStyles($hook)
	{
		if (count($this->autoload['front_scripts'])) {
			foreach ($this->autoload['front_scripts'] as $script) {
				$this->includeScript($script);
			}
		}

		if (count($this->autoload['front_styles'])) {
			foreach ($this->autoload['front_styles'] as $style) {
				$this->includeStyle($style);
			}
		}
		// need to add this style to header (template css issue)
		wp_enqueue_style('dashicons');
		wp_enqueue_style('sgbb_page/styles/save',  $this->app_url.'/assets/page/styles/save.css', array(), 'all');
	}

	public function addAjaxLibrary() {
		$html = "<script type=\"text/javascript\">\n";
		$html .= 'var ajaxurl = "'.admin_url('admin-ajax.php' ).'";'."\n";
		$html .= "</script>\n";

		echo $html;
	}

	public function actionToSlug($action)
	{
		if (isset($this->slugs[$action])) {
			return $this->slugs[$action];
		}

		return '';
	}

	private function dispatchAction($action, $param1, $param2)
	{
		$this->includeController(ucfirst($action[0]));

		$controllerName = strtoupper($this->prefix).ucfirst($action[0]).'Controller';

		$controller = new $controllerName();
		$controller->setController($action[0]);
		$controller->setAction($action[1]);
		return $controller->dispatch($param1, $param2);
	}

	public function loadMenu()
	{
		$this->loadMenuItems('menu_items');
	}

	public function loadNetworkAdminMenu()
	{
		$this->loadMenuItems('network_admin_menu_items');
	}

	public function loadMenuItems($key)
	{
		$autoload = $this->autoload;
		foreach ($autoload[$key] as $menu_item) {
			$menu_item_slug = $this->prefix.$menu_item['id'];
			$menu_item_func = array($this, $menu_item['id']);
			$this->menuActions[$menu_item['id']] = array($menu_item['controller'], $menu_item['action']);
			$this->slugs[$menu_item['controller'].'/'.$menu_item['action']] = $menu_item_slug;
			add_menu_page(
				$menu_item['page_title'],
				$menu_item['menu_title'],
				$menu_item['capability'],
				$menu_item_slug,
				$menu_item_func,
				$menu_item['icon']
			);
			if (count($menu_item['submenu_items'])) {
				foreach ($menu_item['submenu_items'] as $submenu_item) {
					$submenu_item_slug = $this->prefix.$submenu_item['id'];
					$submenu_item_func = array($this, $submenu_item['id']);
					$this->menuActions[$submenu_item['id']] = array($submenu_item['controller'], $submenu_item['action']);
					$this->slugs[$submenu_item['controller'].'/'.$submenu_item['action']] = $submenu_item_slug;
					add_submenu_page(
						$menu_item_slug,
						$submenu_item['page_title'],
						$submenu_item['menu_title'],
						$submenu_item['capability'],
						$submenu_item_slug,
						$submenu_item_func
					);
				}
			}
		}
	}
}
