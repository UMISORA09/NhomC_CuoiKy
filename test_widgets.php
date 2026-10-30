<?php
/** Read-only checks for the current editable widget configuration. */
if ( PHP_SAPI !== 'cli' ) { http_response_code(403); exit; }
require __DIR__.'/wp-load.php';
$checks=array();
$areas=get_option('sidebars_widgets');
$backup=get_option(get_option('nhomc_widgets_backup',''));
$checks['configuration backup retained']=is_array($backup)&&isset($backup['options']['sidebars_widgets']);
$checks['eight current areas registered']=count($GLOBALS['wp_registered_sidebars'])===8;
$checks['editable migration applied']=get_option('nhomc_widgets_version')===NHOMC_WIDGETS_VERSION;
foreach(nhomc_page_widgets() as $area=>$definition){
    $checks[$area.' block count']=count($areas[$area]??array())===count($definition[1]);
    foreach(array_keys($definition[1]) as $index=>$section){
        $id=$areas[$area][$index]??'';
        $checks[$section.' registered']=isset($GLOBALS['wp_registered_widgets'][$id]);
        if(!$definition[1][$section][1]){
            $base='nhomc_'.str_replace('-','_',$section);
            $instance=nhomc_active_widget_settings($area,$base);
            $checks[$section.' editable source retained']=isset($instance['html'])&&count(nhomc_widget_html_editor($instance['html'])['fields'])>0;
        }
    }
}
$checks['footer has dedicated menu widget']=str_starts_with($areas['nhomc-footer-menu'][0]??'','nhomc_footer_menu-');
ob_start();dynamic_sidebar('nhomc-footer-menu');$footer=ob_get_clean();
$checks['footer contains five intended links']=substr_count($footer,'<a ')===5;
$checks['footer contains no archive/category blocks']=strpos($footer,'wp-block-archives')===false&&strpos($footer,'wp-block-categories')===false;
ob_start();dynamic_sidebar('nhomc-newsletter');$newsletter=ob_get_clean();
$checks['newsletter uses real handler and nonce']=strpos($newsletter,'name="action" value="nhomc_newsletter"')!==false&&strpos($newsletter,wp_create_nonce('nhomc_newsletter'))!==false;
$filter_before=has_filter('dynamic_sidebar_params');
ob_start();nhomc_render_page_widgets('nhomc-home',array('home_jobs'=>array(),'home_blogs'=>array()));$home=ob_get_clean();
$checks['dynamic lists are not frozen']=strpos($home,'hm-job-card')===false;
$checks['temporary context filter removed']=has_filter('dynamic_sidebar_params')===$filter_before;
$checks['classic direct controls enabled']=!wp_use_widgets_block_editor();
foreach($checks as $name=>$passed){if(!$passed){echo 'FAIL: '.$name."\n";}}
echo count(array_filter($checks)).'/'.count($checks)." widget configuration checks passed.\n";
exit(in_array(false,$checks,true)?1:0);
