<?php

namespace kuakling\smartmenus;

use kuakling\smartmenus\SmartMenusAsset;
/**
 * This is just an example.
 */
class Gen extends \yii\base\Widget
{
	public $r = '';
	public $items;
	public $template = [
		'name' => 'sm-blue',
		'file' => '/css/sm-blue.css',
		'bundle' => true,
	];
	public $options = [];


    public function run()
    {
    	$this->templateProcess();
    	$this->registerPlugin();
    	$this->r = '<div';
    	foreach ($this->options as $key => $value) {
    		$this->r .= ' '.$key.'="'.$value.'"';
    	}
    	$this->r .= '>';
    	$this->r .= '<ul id="main-menu" class="sm '.$this->template['name'].'">';
    	$this->r .= $this->menu($this->items);
    	$this->r .= '</ul>';
    	$this->r .= '</div>';

        return $this->r;
    }

    public function menu($items = [])
    {
        $result = '';
        //$result = self::menuRecrusive($role_id);
        //return $result;

        foreach ($items as $item) {
        	$this->r .= '<li>';
        	$this->r .= '<a href="#">';
            $this->r .= $item['label'];
            $this->r .= '</a>';
            if(array_key_exists('items', $item)){
            	$this->r .= '<ul>';
            	$this->menu($item['items']);
            	$this->r .= '</ul>';
            }
            $this->r .= '</li>';
            //$this->r .= "\n";
        }
    }

    private function templateProcess(){
    	if(!array_key_exists('file', $this->template))
    		$this->template['file'] = null;

    	if(!array_key_exists('bundle', $this->template))
    		$this->template['bundle'] = true;
    }

    public function registerPlugin(){
    	$view = $this->getView();
        $bundle = SmartMenusAsset::register($view);
        if($this->template['bundle'])
        	$templateFile = $bundle->baseUrl.'/css/'.$this->template['name'].'.css';
        else
        	$templateFile = $this->template['file'];

        $this->getView()->registerCssFile($templateFile);

        $js = "$('#main-menu').smartmenus();";
        $view->registerJs($js);
    }
}
