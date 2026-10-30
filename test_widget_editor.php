<?php
if ( PHP_SAPI !== 'cli' ) { http_response_code(403); exit; }
require __DIR__.'/wp-load.php';
$checks=array();
$source='<section style="background-image: url(\'/old.jpg\')"><svg viewBox="0 0 10 10"><text>ICON</text></svg><h2>Old &amp; title</h2><p>Old body</p><a href="/jobs/">Go</a><img src="/old.jpg" srcset="/old.jpg 1x" alt="Old alt"><form action="/jobs/"><input name="search_keywords" placeholder="Search"><button>Search jobs</button></form><script>const untouched = "keep";</script></section>';
$parsed=nhomc_widget_html_editor($source);
$changes=array();
foreach($parsed['fields'] as $key=>$field){
    if($field['value']==='Old & title'){$changes[$key]='New <script>alert(1)</script> & title';}
    if($field['value']==='Old body'){$changes[$key]="Nội dung tiếng Việt\nDòng hai";}
    if($field['type']==='image'){$changes[$key]='https://example.com/new.jpg';}
    if($field['type']==='url'){$changes[$key]='javascript:alert(1)';}
}
$edited=nhomc_widget_html_editor($source,$changes)['html'];
$checks['existing SVG and form wiring preserved']=strpos($edited,'viewBox="0 0 10 10"')!==false&&strpos($edited,'name="search_keywords"')!==false&&strpos($edited,'action="/jobs/"')!==false;
$checks['scripts and SVG labels not editable']=!in_array('ICON',array_map(static function($field){return $field['value'];},$parsed['fields']),true)&&!in_array('const untouched = "keep";',array_map(static function($field){return $field['value'];},$parsed['fields']),true);
$checks['old responsive image sources removed']=strpos($edited,'srcset=')===false;
$checks['Vietnamese content updated']=strpos($edited,'Nội dung tiếng Việt')!==false;
$checks['unsafe link rejected']=strpos($edited,'javascript:')===false;
$checks['image and background updated']=substr_count($edited,'https://example.com/new.jpg')===2;
$checks['text HTML not executable']=strpos($edited,'<script>alert(1)</script>')===false;
$checks['unchanged save preserves markup']=nhomc_widget_html_editor($source,array_map(static function($field){return $field['value'];},$parsed['fields']))['html']===$source;
$checks['empty image can be removed']=true;
foreach($parsed['fields'] as $key=>$field){if($field['type']==='image'&&str_starts_with($key,'src_')){$removed=nhomc_widget_html_editor($source,array($key=>''))['html'];$checks['empty image can be removed']=strpos($removed,'src=""')!==false;break;}}
$widget=new NhomC_Section_Widget('about-intro','About','nhomc-about',false);
$original=array('html'=>$source);
$saved=$widget->update(array('changes'=>$changes,'html'=>'<script>evil()</script>'),$original);
$checks['posted raw HTML cannot replace saved source']=strpos($saved['html'],'evil()')===false;
$checks['saved fields render at frontend']=strpos($saved['html'],'Nội dung tiếng Việt')!==false;
ob_start();$widget->form($original);$form=ob_get_clean();
$checks['image selector and preview present']=strpos($form,'nc-widget-image-select')!==false&&strpos($form,'nc-widget-image-preview')!==false;
$checks['editor has no raw HTML textarea']=strpos($form,'name="'.$widget->get_field_name('html').'"')===false;
foreach(nhomc_page_widgets() as $area=>$definition){foreach($definition[1] as $section=>$data){
    $base='nhomc_'.str_replace('-','_',$section);
    $registered_bases=array_map(static function($widget){return $widget->id_base;},$GLOBALS['wp_widget_factory']->widgets);
    $checks[$base.' registered']=in_array($base,$registered_bases,true);
    if(!$data[1]){$default=nhomc_widget_default_html($section);$checks[$section.' has editable text']=count(nhomc_widget_html_editor($default)['fields'])>0;}
}}
foreach($checks as $name=>$passed){if(!$passed){echo 'FAIL: '.$name."\n";}}
echo count(array_filter($checks)).'/'.count($checks)." editor checks passed.\n";
exit(in_array(false,$checks,true)?1:0);
