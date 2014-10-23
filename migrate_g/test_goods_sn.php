<?php
define('IN_ECS', true);

require(dirname(__FILE__) . '/../ecshop/includes/init.php');
require_once(ROOT_PATH . '/../ecshop/' . ADMIN_PATH . '/includes/lib_goods.php');

$max_id     = $db->getOne("SELECT MAX(goods_id) + 1 FROM ".$ecs->table('goods'));
$goods_sn   = generate_goods_sn($max_id);

echo $goods_sn."<br/>";

?>