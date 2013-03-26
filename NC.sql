-- 
-- 表的结构 `nc_imgsharing`
-- 
CREATE TABLE `nc_imgsharing` (
  `id` int(11) NOT NULL auto_increment COMMENT '主键id',
  `path` varchar(60) collate utf8_unicode_ci NOT NULL COMMENT '图片存储路径',
  `status` tinyint(4) NOT NULL default '1' COMMENT '图片审核状态 -1=>删除 0=>不通过 1=>上传 2=>通过(生成缩略图)',
  `update` datetime NOT NULL COMMENT '上传时间',
  `udate` datetime NOT NULL COMMENT '更新时间',
  `upip` varchar(30) collate utf8_unicode_ci NOT NULL COMMENT '上传人IP地址',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='图片分享表' AUTO_INCREMENT=1 ;

