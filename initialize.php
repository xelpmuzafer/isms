<?php
$dev_data = array('id'=>'-1','firstname'=>'Developer','lastname'=>'','username'=>'dev_oretnom','password'=>'5da283a2d990e8d8512cf967df5bc0d0','last_login'=>'','date_updated'=>'','date_added'=>'');
if(!defined('base_app')) define('base_app', str_replace('\\','/',__DIR__).'/' );
// if(!defined('dev_data')) define('dev_data',$dev_data);

define('ENV', 'uat');
if(ENV=='dev'){
    if(!defined('base_url')) define('base_url','http://rnd.xelpmoc.in:8000/isms/');
    if(!defined('DB_SERVER')) define('DB_SERVER',"localhost");
    if(!defined('DB_USERNAME')) define('DB_USERNAME',"root");
    if(!defined('DB_PASSWORD')) define('DB_PASSWORD',"root");
    if(!defined('DB_NAME')) define('DB_NAME',"isms_db");
}else if(ENV == 'uat'){
    if(!defined('base_url')) define('base_url','https://isms.reverely.ai/');
    if(!defined('DB_SERVER')) define('DB_SERVER',"localhost");
    if(!defined('DB_USERNAME')) define('DB_USERNAME',"reverely");
    if(!defined('DB_PASSWORD')) define('DB_PASSWORD',"j9NnYK0CvR&2G0aB");
    if(!defined('DB_NAME')) define('DB_NAME',"isms_db");
}
?>
