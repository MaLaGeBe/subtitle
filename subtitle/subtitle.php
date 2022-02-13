<?php
/*
Plugin Name: 文章副标题
Version: 1.0
Plugin URL: https://www.emlog.net/plugin/detail/440
Description: 为你的emlog文章添加一个副标题
Author: MaLaGeBe
Author URL: 
ForEmlog: pro
*/

addAction('adm_writelog_head', 'hook_subtitle');
addAction('save_log', 'save_subtitle');

function hook_subtitle()
{
    global $subtitle;
    echo "<script>var html='<div class=\"mt-2\"><input type=\"text\" name=\"subtitle\" id=\"subtitle\" value=\"{$subtitle}\" class=\"form-control\" placeholder=\"文章副标题\"></div>';$('#post_bar').before(html);</script>";
}

function save_subtitle($blogid)
{
    $Log_Model = new Log_Model();
    $subtitle = isset($_POST['subtitle']) ? addslashes(trim($_POST['subtitle'])) : '';

    $logData = array(
        'subtitle' => $subtitle
    );

    $Log_Model->updateLog($logData, $blogid);
}

function get_subtitle($logid)
{
    $db = Database::getInstance();
    $sql = "SELECT * FROM " . DB_PREFIX . "blog WHERE gid=$logid";
    $res = $db->query($sql);
    $row = $db->fetch_array($res);
    if ($row['subtitle']) {
        $subtitle  = htmlspecialchars($row['subtitle']);
    }
    return isset($subtitle) ? $subtitle : '';
}