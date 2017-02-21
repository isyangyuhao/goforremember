-- phpMyAdmin SQL Dump
-- version phpStudy 2014
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2016 年 04 月 19 日 20:16
-- 服务器版本: 5.6.21
-- PHP 版本: 5.3.29

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `app_goforremember`
--

-- --------------------------------------------------------

--
-- 表的结构 `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '管理员编号',
  `name` varchar(100) NOT NULL COMMENT '管理员名称',
  `password` varchar(32) NOT NULL COMMENT '管理员登陆密码',
  `is_delete` tinyint(4) NOT NULL DEFAULT '0' COMMENT '管理员注销',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `admin`
--

INSERT INTO `admin` (`id`, `name`, `password`, `is_delete`) VALUES
(1, 'root', '63a9f0ea7bb98050796b649e85481845', 0),
(2, 'root2', '63a9f0ea7bb98050796b649e85481845', 0),
(3, 'root3', '63a9f0ea7bb98050796b649e85481845', 0);

-- --------------------------------------------------------

--
-- 表的结构 `find`
--

CREATE TABLE IF NOT EXISTS `find` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '发现类别编号',
  `title` varchar(200) NOT NULL COMMENT '发现类别名称',
  `description` varchar(500) NOT NULL COMMENT '发现类别描述',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '发现类别状态',
  `icon` varchar(500) NOT NULL DEFAULT 'default.png',
  `href` varchar(500) NOT NULL COMMENT '发现链接地址',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `find`
--

INSERT INTO `find` (`id`, `title`, `description`, `status`, `icon`, `href`) VALUES
(1, '图说那年', '用图像还原当时的记忆', 1, '1.jpg', 'photo'),
(2, '听', 'this is title 2 description', 1, '2.jpg', 'music'),
(3, '我的昨天', 'this is description 3', 0, '3.jpg', 'write'),
(4, '影片', 'this is description 4', 0, '4.jpg', 'movie'),
(5, '文章', 'this is description 5', 0, '5.jpg', 'article');

-- --------------------------------------------------------

--
-- 表的结构 `find_article`
--

CREATE TABLE IF NOT EXISTS `find_article` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '发现文章编号',
  `title` varchar(200) NOT NULL COMMENT '发现文章标题',
  `description` varchar(500) NOT NULL COMMENT '发现文章简介',
  `content` varchar(5000) NOT NULL COMMENT '发现文章内容',
  `time` int(11) NOT NULL COMMENT '发现文章发布时间',
  `status` tinyint(4) NOT NULL COMMENT '发现文章分级',
  `find_id` int(11) NOT NULL COMMENT '发现文章对应类别',
  `is_delete` tinyint(4) NOT NULL DEFAULT '0' COMMENT '发现文章注销权限',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `find_article`
--

INSERT INTO `find_article` (`id`, `title`, `description`, `content`, `time`, `status`, `find_id`, `is_delete`) VALUES
(1, 'this is first index article title', 'this is first index article description', 'this is first index article content', 1, 1, 1, 0),
(2, 'this is second index article title', 'this is second index article description', 'this is second index article content', 2, 2, 1, 0),
(3, 'this is third index article title', 'this is third index article description', 'this is thirdindex article content', 3, 3, 2, 0),
(4, 'this is fourth index article title', 'this is fourthindex article description', 'this is fourthindex article content', 4, 0, 3, 0);

-- --------------------------------------------------------

--
-- 表的结构 `find_contribute`
--

CREATE TABLE IF NOT EXISTS `find_contribute` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '投稿编号',
  `content` varchar(5000) NOT NULL COMMENT '投稿内容',
  `user_id` int(11) NOT NULL COMMENT '投稿用户id',
  `time` int(11) NOT NULL COMMENT '投稿时间',
  `is_delete` tinyint(4) NOT NULL COMMENT '投稿注销',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `find_contribute`
--

INSERT INTO `find_contribute` (`id`, `content`, `user_id`, `time`, `is_delete`) VALUES
(4, '突然好想你', 37, 1460647280, 0);

-- --------------------------------------------------------

--
-- 表的结构 `find_movie`
--

CREATE TABLE IF NOT EXISTS `find_movie` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '影片编号',
  `title` varchar(500) NOT NULL COMMENT '影片标题',
  `description` varchar(1000) NOT NULL COMMENT '影片描述',
  `src` varchar(500) NOT NULL COMMENT '影片链接',
  `status` tinyint(4) NOT NULL COMMENT '影片状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `find_movie`
--

INSERT INTO `find_movie` (`id`, `title`, `description`, `src`, `status`) VALUES
(1, '匆匆那年', '  时光流转，曾经美好的青春时代有如一场不真实的梦。她充满躁动、喜悦、悲伤与愤慨，她是远离着社会现实尔虞我诈的青春懵懂，傻了傻气的纯真涂抹下最为亮丽耀眼的色彩。而今回首往事，即使如梦般虚幻，却又让人唏嘘不已，感慨万千。只因偶然的机缘，早已过了而立之年的陈寻回想起那个曾经呼喊过千遍万遍的名字。遥远的学生时代，陈寻与让他心动的女孩方茴，以及乔燃、林嘉茉、赵烨等一般死党行走在尘土飞扬的校园里。友情、爱情在诸多禁忌的年代里如野草般自由疯长，曾经那是他们所坚守笃定的一切，而这些又都被碾压得支离不堪。许下的誓言你还记得吗？ ', 'http://player.mgtv.com/mango-tv3-main/MangoTV_3.swf?play_type=1&video_id=1110920', 0),
(2, '那些年，我们一起追过的女孩', '柯景腾和他的一群好友，爱耍帅却老是情场失意的老曹，停止不了勃起所以叫勃起的勃起，想用搞笑致胜却总是失败的该边，胖界的夺爱高手阿和，从国中到高中，一直是不离不弃的死党。他们都对班花沈佳宜有着一种纠结的感情。一方面，他们瞧不起这种只会用功读书的女生，另一方面他们又为她的美好气质倾倒。因为学习成绩较差，柯景腾被老师安排坐在沈佳宜前面。因为他的一次英雄救美，她开始用强制的方式帮他补习功课。此事令其他兄弟羡慕嫉妒恨，但是大家都未说破。毕业后，柯景腾和沈佳宜在各自大学保持恋人般的联系。直到他举办自由格斗赛，事情才出现了变化…… 这一连串下，原本按兵不动的好友也都纷纷加入女神争夺战！但是麻吉诚可贵，青春价更高，若为女神故，是否二者皆可抛哩？！ ', 'http://player.video.qiyi.com/e64f46d79bfe0faa82f0c5bbe5af50bb/0/0/w_19rqqkiw3t.swf-albumId=1819895909-tvId=1819895909-isPurchase=0-cnId=2', 0),
(3, '青春派', '不疯狂，怎叫青春？居然在高考前拍毕业照时，当着全校师生的面，大声地用泰戈尔的诗句向暗恋了三年的黄晶晶表白，收获了甜蜜的初恋。但很快初恋的甜蜜就被闻讯赶来的母亲破坏了，黄晶晶在居然母亲的刺激下傲然离去，居然伤心的想爬墙挽回初恋，却摔伤了尾骨。失恋加受伤的他高考失利，看着黄晶晶前往复旦的身影，决定复读追逐爱情。开始了一段疯狂的高三历程。 在每个青春的回忆中，一个深陷暗恋默默付出的女孩儿，几个情感丰富讲义气的哥们，一群各有故事特色十足的损友，一段所有人共有的回忆。这就是青春派——生活里总在闪烁，永不褪色的一段岁月。', 'http://static.video.qq.com/TPout.swf?vid=b0013xrut6p&auto=0', 0);

-- --------------------------------------------------------

--
-- 表的结构 `find_music`
--

CREATE TABLE IF NOT EXISTS `find_music` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '听编号',
  `name` varchar(100) NOT NULL COMMENT '听名称',
  `singer` varchar(100) NOT NULL COMMENT '听歌手',
  `description` varchar(200) NOT NULL COMMENT '听介绍',
  `src` varchar(500) NOT NULL COMMENT '听链接',
  `icon` varchar(500) NOT NULL COMMENT '听配图',
  `status` tinyint(4) NOT NULL COMMENT '听状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `find_music`
--

INSERT INTO `find_music` (`id`, `name`, `singer`, `description`, `src`, `icon`, `status`) VALUES
(1, '南山南', '张磊', '这是一首伤感的民谣', 'music.mp3', 'default.png', 0);

-- --------------------------------------------------------

--
-- 表的结构 `find_photo`
--

CREATE TABLE IF NOT EXISTS `find_photo` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '图说那年编号',
  `src` varchar(500) NOT NULL COMMENT '图说那年图片链接',
  `description` varchar(500) NOT NULL COMMENT '图说那年图片描述',
  `status` smallint(6) NOT NULL COMMENT '图说那年图片状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=13 ;

--
-- 转存表中的数据 `find_photo`
--

INSERT INTO `find_photo` (`id`, `src`, `description`, `status`) VALUES
(1, 'photo_1.jpg', 'this is description ....1', 0),
(2, 'photo_2.jpg', 'this is description ....2', 0),
(3, 'photo_3.jpg', 'this is description ....3', 0),
(4, 'photo_4.jpg', 'this is description ....4', 0),
(5, 'photo_5.jpg', 'this is description ....5', 0),
(6, 'photo_6.jpg', 'this is description ....6', 0),
(7, 'photo_7.jpg', 'this is description ....7', 0),
(8, 'photo_8.jpg', 'this is description ....8', 0),
(9, 'photo_9.jpg', 'this is description ....9', 0),
(10, 'photo_10.jpg', 'this is description ....10', 0),
(11, 'photo_11.jpg', 'this is description ....11', 0),
(12, 'photo_12.jpg', 'this is description ....12', 0);

-- --------------------------------------------------------

--
-- 表的结构 `fragment`
--

CREATE TABLE IF NOT EXISTS `fragment` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '碎片编号',
  `content` varchar(500) NOT NULL COMMENT '碎片内容',
  `time` int(11) NOT NULL COMMENT '碎片时间',
  `user_id` int(11) NOT NULL COMMENT '碎片用户',
  `is_delete` tinyint(4) NOT NULL DEFAULT '0' COMMENT '碎片注销',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=11 ;

--
-- 转存表中的数据 `fragment`
--

INSERT INTO `fragment` (`id`, `content`, `time`, `user_id`, `is_delete`) VALUES
(3, 'Biu~Biu~你Biu~Biu~Biu~Biu~', 1458491225, 37, 0),
(4, 'this is a test !!! 1111', 1458532630, 37, 0),
(5, 'this is test 2222', 1458536352, 37, 0),
(7, 'Biu~Biu~你Biu~Biu~Biu~Biu~', 1458818228, 37, 0),
(8, 'haha', 1459775556, 37, 0),
(9, 'this is a test', 1460468333, 37, 0),
(10, 'Biu~Biu~你Biu~Biu~Biu~Biu~', 1461066917, 37, 0);

-- --------------------------------------------------------

--
-- 表的结构 `index_advertisement`
--

CREATE TABLE IF NOT EXISTS `index_advertisement` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '首页广告编号',
  `content` varchar(500) NOT NULL COMMENT '首页广告内容',
  `href` varchar(500) NOT NULL COMMENT '首页广告链接',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '主页广告开关',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `index_advertisement`
--

INSERT INTO `index_advertisement` (`id`, `content`, `href`, `status`) VALUES
(1, '这是一个神奇的广告                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           ', '#', 0);

-- --------------------------------------------------------

--
-- 表的结构 `index_article`
--

CREATE TABLE IF NOT EXISTS `index_article` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主页文章编号',
  `title` varchar(200) NOT NULL COMMENT '主页文章标题',
  `description` varchar(500) NOT NULL COMMENT '主页文章简介',
  `content` varchar(10000) NOT NULL COMMENT '主页文章内容',
  `time` int(11) NOT NULL COMMENT '主页文章发布时间',
  `status` tinyint(4) NOT NULL COMMENT '主页文章分级',
  `is_delete` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `index_article`
--

INSERT INTO `index_article` (`id`, `title`, `description`, `content`, `time`, `status`, `is_delete`) VALUES
(1, '过去的生活——王安忆', '一日，走在上海虹桥开发区前的天山路上，在陈旧的工房住宅楼下的街边，两个老太在互打招呼。其中一个手里端了一个…', '<p>\n    <br/><span style="color: rgb(17, 17, 17); font-family: Helvetica, Arial, sans-serif; font-size: 13px; line-height: 21.06px; white-space: normal;">&nbsp; 一日，走在上海虹桥开发区前的天山路上，在陈旧的工房住宅楼下的街边，两个老太在互打招呼。其中一个手里端了一口小铝锅，铝锅看上去已经有年头了，换了底，盖上有一些瘪塘。这老太对那老太说，烧泡饭时不当心烧焦了锅底，她正要去那边工地上，问人要一些黄沙来擦一擦。两个老人说着话，她们身后是开发区林立的高楼。新型的光洁的建筑材料，以及抽象和理性的楼体线条，就像一面巨大的现代戏剧的天幕。这两个老人则是生动的，她们过着具体而仔细的生活，那是过去的生活。&nbsp;</span><br style="color: rgb(17, 17, 17); font-family: Helvetica, Arial, sans-serif; font-size: 13px; line-height: 21.06px; white-space: normal;"/><br style="color: rgb(17, 17, 17); font-family: Helvetica, Arial, sans-serif; font-size: 13px; line-height: 21.06px; white-space: normal;"/><span style="color: rgb(17, 17, 17); font-family: Helvetica, Arial, sans-serif; font-size: 13px; line-height: 21.06px; white-space: normal;">&nbsp; 那时候，生活其实是相当细致的，什么都是从长计议。在夏末秋初，豇豆老了，即将落市，价格也跟着下来了。于是，勤劳的主妇便购来一篮篮的豇豆，捡好，洗净。然后，用针穿一条长线，将豇豆一条一条穿起来，晾起来，晒干。冬天就好烧肉吃了。用过的线呢，清水里淘一淘，理顺，收好，来年晒豇豆时好再用。缝被子的线，也是横的竖的量准再剪断，缝到头正好。拆洗被子时，一针一针抽出来，理顺，洗净，晒干，再缝上。农人插秧拉秧行的线，就更要收好了，是一年之计，可传几代人的。电影院大多没有空调，可是供有纸扇，放在检票口的木箱里。进去时，拾一把，出来时，再扔回去，下一场的人好再用。这种生活养育着人生的希望，今年过了有明年，明年过了还有后年，一点不是得过且过。不像今天，四处是一次性的用具，用过了事，今天过了，明天就不过了。这样的短期行为，挥霍资源不说，还挥霍生活的兴致，多少带着些“混”。&nbsp;</span><br style="color: rgb(17, 17, 17); font-family: Helvetica, Arial, sans-serif; font-size: 13px; line-height: 21.06px; white-space: normal;"/><br style="color: rgb(17, 17, 17); font-family: Helvetica, Arial, sans-serif; font-size: 13px; line-height: 21.06px; white-space: normal;"/><span style="color: rgb(17, 17, 17); font-family: Helvetica, Arial, sans-serif; font-size: 13px; line-height: 21.06px; white-space: normal;">&nbsp; 梅雨季节时，满目的花尼龙伞，却大多是残败的。或是伞骨折了，或是伞面脱落下来，翻了一半边上去，雨水从不吃水的化纤布面上倾泻而下，伞又多半很小，柄也短，人缩在里面躲雨。过去，伞没有现在那么鲜艳好看，也没那么多的花样：两折、三折，又有自动的机关，“哗啦”一声张开来。那时的伞，多是黑的布伞，或者蜡黄的油布伞，大而且坚固，雨打下来，那声音也是结实的，啪、啪、啪。有一种油纸伞，比较有色彩，却也比较脆弱，不小心就会戳一个洞。但是油纸伞的木伞骨子排得很细密，并且那时候的人，用东西都很爱惜。不像现在的人，东西不当东西。那时候，人们用过了伞，都要撑开了阴干，再收起来。木伞骨子和伞柄渐渐地，就像上了油，越用久越结实。铁伞骨子，也绝不会生锈。伞面倘若破了，就会找修伞的工匠来补。他们都有一双巧手，补得服服帖帖，平平整整。撑出去，又是一把遮风避雨的好伞。那时候，工匠也多，还有补碗的呢!有碎了的碗，只要不是碎成渣，他就有本事对上茬口，再打上一排钉，一点不漏的。今天的人听起来就要以为是神话了。小孩子玩的皮球破了，也能找皮匠补的。藤椅，藤榻，甚至淘箩坏了，是找篾匠补。有多少好手艺人啊!现在全都没了。结果是，废品堆积成山。现在的生活其实是要粗糙得多，大量的物质被匆忙地吞吐着。而那时候的生活，是细嚼慢咽。&nbsp;</span><br style="color: rgb(17, 17, 17); font-family: Helvetica, Arial, sans-serif; font-size: 13px; line-height: 21.06px; white-space: normal;"/><br style="color: rgb(17, 17, 17); font-family: Helvetica, Arial, sans-serif; font-size: 13px; line-height: 21.06px; white-space: normal;"/><span style="color: rgb(17, 17, 17); font-family: Helvetica, Arial, sans-serif; font-size: 13px; line-height: 21.06px; white-space: normal;">&nbsp; 那时候，吃是有限制的。家境好的人家，大排骨也是每顿一人一块。一条鱼，要吃一家子。那时，吃一只鸡是大事情，简直带有隆重的气氛。现在鸡是多了，从传送带上啄食人工饲料，没练过腿脚，肉是松散的，味同嚼蜡。那时候，一块豆腐，都是用卤水点的。绿豆芽吃起来很费工，一根一根摘去根须。现在的绿豆芽却没有根须，而且肥胖，吃起来口感也不错，就是不像绿豆芽。现在的东西多是多了，好像都会繁殖，东西生东西，无限地多下去。可是，其实，好东西还是那么些，要想多，只能稀释了。&nbsp;</span><br style="color: rgb(17, 17, 17); font-family: Helvetica, Arial, sans-serif; font-size: 13px; line-height: 21.06px; white-space: normal;"/><br style="color: rgb(17, 17, 17); font-family: Helvetica, Arial, sans-serif; font-size: 13px; line-height: 21.06px; white-space: normal;"/><span style="color: rgb(17, 17, 17); font-family: Helvetica, Arial, sans-serif; font-size: 13px; line-height: 21.06px; white-space: normal;">&nbsp; 这晚，去一家常去的饭店吃晚饭，因有事，只要了两碗冷面。其时，生意正旺。老板和伙计上上下下地跑，送上活蛇活鱼给客人检验，复又回去，过一时，就端上了滚热的鱼虾蛇鳖。就是不给你上冷面，死活催也不上，生生打发走人。现在的生意也是如此，做的是一锤子买卖。不像更远的过去，客人来一回，就面熟了，下一回，已经与你拉起了家常。店家靠的是回头客，这才是天长日久的生意之道。不像现在，今天做过了，明天就关门，后天，连个影子都不见了。生活，变得没什么指望。</span>\n</p>', 1457539231, 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `index_contact`
--

CREATE TABLE IF NOT EXISTS `index_contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `content` varchar(200) NOT NULL COMMENT '留言信息',
  `time` int(11) NOT NULL COMMENT '留言时间',
  `user_id` int(11) NOT NULL COMMENT '留言用户id',
  `is_delete` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `index_links`
--

CREATE TABLE IF NOT EXISTS `index_links` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主页友情链接编号',
  `name` varchar(50) NOT NULL COMMENT '主页友情链接名称',
  `src` varchar(200) NOT NULL COMMENT '主页友情链接地址',
  `is_delete` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `index_links`
--

INSERT INTO `index_links` (`id`, `name`, `src`, `is_delete`) VALUES
(1, 'Materlize', 'http://www.materialscss.com', 0),
(2, 'ThinkPHP', 'http://www.thinkphp.cn', 0),
(3, 'JQuery', 'http://jquery.com', 0),
(4, 'Bootstrap', 'http://www.bootcss.com', 0);

-- --------------------------------------------------------

--
-- 表的结构 `index_photo`
--

CREATE TABLE IF NOT EXISTS `index_photo` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '图片编号',
  `src` varchar(500) NOT NULL COMMENT '图片链接',
  `status` tinyint(4) NOT NULL COMMENT '图片属性',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=8 ;

--
-- 转存表中的数据 `index_photo`
--

INSERT INTO `index_photo` (`id`, `src`, `status`) VALUES
(1, 'index_main1.jpg', 1),
(2, 'index_main2.jpg', 2),
(3, 'index_main3.jpg', 3),
(4, 'index_main4.jpg', 4),
(5, 'index_main5.jpg', 5),
(6, 'index_main6.jpg', 6),
(7, 'index_main7.jpg', 0);

-- --------------------------------------------------------

--
-- 表的结构 `person_write`
--

CREATE TABLE IF NOT EXISTS `person_write` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '写下昨天编号',
  `time` int(11) NOT NULL COMMENT '写下昨天时间',
  `content` varchar(5000) NOT NULL COMMENT '写下昨天内容',
  `user_id` int(11) NOT NULL COMMENT '写下昨天用户id',
  `is_delete` tinyint(4) NOT NULL DEFAULT '0' COMMENT '写下昨天注销标记',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=20 ;

--
-- 转存表中的数据 `person_write`
--

INSERT INTO `person_write` (`id`, `time`, `content`, `user_id`, `is_delete`) VALUES
(15, 1458471319, 'Cx6I5tBsA1Ez4PO5hUIq5iE', 37, 0),
(16, 1459783952, 'y7+gOgamDYSLzY+vac2mxxP3xI7Paf3c274', 37, 0),
(18, 1460473595, 'ghYvPpT7EULBlbwGLDorO5Fu4PGdWXbKaIhF77VGVN7OxQSMu/TwLbrPTAy6KUDt92kffqIhYyyhg2mhWIJjDUs', 37, 0),
(19, 1461067036, 'QI+VlNNeHKLxx1yMYW07zru3lXQVVObiagilqnnrtuqS5hk', 37, 0);

-- --------------------------------------------------------

--
-- 表的结构 `shop_goods`
--

CREATE TABLE IF NOT EXISTS `shop_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '商品编号',
  `name` varchar(500) NOT NULL COMMENT '商品名称',
  `description` varchar(1000) NOT NULL COMMENT '商品描述',
  `img` varchar(500) NOT NULL COMMENT '商品图片地址',
  `href` varchar(500) NOT NULL COMMENT '商品链接地址',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '商品属性',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `shop_goods`
--

INSERT INTO `shop_goods` (`id`, `name`, `description`, `img`, `href`, `status`) VALUES
(1, '四驱车', '童年玩伴，让我们再赛一场！', 'g1.png', 'https://detail.tmall.com/item.htm?spm=a230r.1.14.13.EB3gut&id=520186874724&cm_id=140105335569ed55e27b&abbucket=13&sku_properties=5919063:6536025', 0),
(2, '悠悠球', '放学别走，借我悠悠球玩一下~', 'g2.jpg', 'https://item.taobao.com/item.htm?spm=a230r.1.0.0.jpKNsv&id=520182957737&ns=1&abbucket=13#detail', 0),
(3, '翻绳', '你还记得怎么玩吗 → →', 'g3.jpg', 'https://item.taobao.com/item.htm?spm=a230r.1.14.150.BTXrMy&id=525025306908&ns=1&abbucket=13#detail', 0);

-- --------------------------------------------------------

--
-- 表的结构 `shop_main`
--

CREATE TABLE IF NOT EXISTS `shop_main` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '商城轮播图片编号',
  `img` varchar(500) NOT NULL COMMENT '轮播图片加载地址',
  `href` varchar(500) NOT NULL COMMENT '商城轮播图片链接地址',
  `description` varchar(500) DEFAULT NULL COMMENT '商城轮播图片信息',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '商城轮播图片类别',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `shop_main`
--

INSERT INTO `shop_main` (`id`, `img`, `href`, `description`, `status`) VALUES
(1, 'default_main.png', '#', '', 0);

-- --------------------------------------------------------

--
-- 表的结构 `simple`
--

CREATE TABLE IF NOT EXISTS `simple` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '极简编号',
  `title` varchar(500) NOT NULL COMMENT '极简标题',
  `description` varchar(5000) NOT NULL COMMENT '文章概述',
  `content` mediumtext NOT NULL COMMENT '极简内容',
  `time` int(11) NOT NULL COMMENT '极简发布时间',
  `is_delete` tinyint(4) NOT NULL DEFAULT '0' COMMENT '极简注销权限',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `simple`
--

INSERT INTO `simple` (`id`, `title`, `description`, `content`, `time`, `is_delete`) VALUES
(1, 'this is simple title 1', '', 'this is simple content 1', 1, 0),
(2, 'this is simple title 2', '', 'this is simple content 2', 2, 0),
(3, 'this is simple title 3', '', 'this is simple content 3', 3, 0),
(4, 'this is simple title 4', '', 'this is simple content 444', 4, 0),
(5, '诉说', '123', '<p style="margin-top: 0px; margin-bottom: 1.5em; padding: 0px; text-indent: 2em; font-size: 15px; font-family: arial, &#39;Microsoft Yahei&#39;, sans-serif; line-height: 28px; white-space: normal;">\n    听着<a href="http://www.sanwen.net/sanwen/youmei/" target="_blank" style="text-decoration: none; color: rgb(68, 68, 68);">优美</a>的音乐，难得地可以有<a href="http://shijian.sanwen8.cn/" target="_blank" style="text-decoration: none; color: rgb(68, 68, 68);">时间</a>和空闲去<a href="http://huiyi.sanwen8.cn/" target="_blank" style="text-decoration: none; color: rgb(68, 68, 68);">回忆</a><a href="http://cengjing.sanwen8.cn/" target="_blank" style="text-decoration: none; color: rgb(68, 68, 68);">过去</a>了。\n</p>\n<p style="margin-top: 0px; margin-bottom: 1.5em; padding: 0px; text-indent: 2em; font-size: 15px; font-family: arial, &#39;Microsoft Yahei&#39;, sans-serif; line-height: 28px; white-space: normal;">\n    关于小时候<a href="http://huiyi.sanwen8.cn/" target="_blank" style="text-decoration: none; color: rgb(68, 68, 68);">记忆</a>，无它，<a href="http://www.sanwen8.cn/" target="_blank" style="text-decoration: none; color: rgb(68, 68, 68);">美好</a>的，是小小的年纪已经见识过我心中的至<a href="http://www.sanwen8.cn/sanwen/love/" target="_blank" style="text-decoration: none; color: rgb(68, 68, 68);">爱</a>。\n</p>\n<p style="margin-top: 0px; margin-bottom: 1.5em; padding: 0px; text-indent: 2em; font-size: 15px; font-family: arial, &#39;Microsoft Yahei&#39;, sans-serif; line-height: 28px; white-space: normal;">\n    当时，我并不知道，他是全民好偶像，我以为只有我喜欢他而已。其实，我并不在意别人是否喜欢。\n</p>\n<p style="margin-top: 0px; margin-bottom: 1.5em; padding: 0px; text-indent: 2em; font-size: 15px; font-family: arial, &#39;Microsoft Yahei&#39;, sans-serif; line-height: 28px; white-space: normal;">\n    后来，我想我知道了原因。\n</p>\n<p style="margin-top: 0px; margin-bottom: 1.5em; padding: 0px; text-indent: 2em; font-size: 15px; font-family: arial, &#39;Microsoft Yahei&#39;, sans-serif; line-height: 28px; white-space: normal;">\n    世上果然没有无缘无故的爱。\n</p>\n<p style="margin-top: 0px; margin-bottom: 1.5em; padding: 0px; text-indent: 2em; font-size: 15px; font-family: arial, &#39;Microsoft Yahei&#39;, sans-serif; line-height: 28px; white-space: normal;">\n    老实说，我原以为<a href="http://www.sanwen.net/sanwen/love/" target="_blank" style="text-decoration: none; color: rgb(68, 68, 68);">爱情</a>是一件玄而又玄的事情，经历过这么多的是是非非，遇到过各式老奸巨滑的坏人<span style="position: relative; left: -100000px;">(&nbsp;<a href="http://www.sanwen.net/" target="_blank" style="text-decoration: none; color: rgb(68, 68, 68);">文章</a><a href="http://www.sanwen.net/" target="_blank" style="text-decoration: none; color: rgb(68, 68, 68);">阅读</a>网：www.sanwen.net )</span>\n</p>\n<p style="margin-top: 0px; margin-bottom: 1.5em; padding: 0px; text-indent: 2em; font-size: 15px; font-family: arial, &#39;Microsoft Yahei&#39;, sans-serif; line-height: 28px; white-space: normal;">\n    我有一种不祥的感觉，爱情，虽然是世间至美之物，却并没有太多的玄妙之处。\n</p>\n<p style="margin-top: 0px; margin-bottom: 1.5em; padding: 0px; text-indent: 2em; font-size: 15px; font-family: arial, &#39;Microsoft Yahei&#39;, sans-serif; line-height: 28px; white-space: normal;">\n    人，总是为着不解之迷而着迷\n</p>\n<p style="margin-top: 0px; margin-bottom: 1.5em; padding: 0px; text-indent: 2em; font-size: 15px; font-family: arial, &#39;Microsoft Yahei&#39;, sans-serif; line-height: 28px; white-space: normal;">\n    一旦，解开了谜底，解谜之乐也就不复存在了，\n</p>\n<p style="margin-top: 0px; margin-bottom: 1.5em; padding: 0px; text-indent: 2em; font-size: 15px; font-family: arial, &#39;Microsoft Yahei&#39;, sans-serif; line-height: 28px; white-space: normal;">\n    我想，这是否就是<a href="http://rensheng.sanwen.net/" target="_blank" style="text-decoration: none; color: rgb(68, 68, 68);">人生</a>平淡的原因？\n</p>\n<p style="margin-top: 0px; margin-bottom: 1.5em; padding: 0px; text-indent: 2em; font-size: 15px; font-family: arial, &#39;Microsoft Yahei&#39;, sans-serif; line-height: 28px; white-space: normal;">\n    所以说四十不惑以后的人生呀，希望不在<a href="http://xiangxinziji.sanwen8.cn/" target="_blank" style="text-decoration: none; color: rgb(68, 68, 68);">自己</a>，而在下一代的身上了。\n</p>\n<p style="margin-top: 0px; margin-bottom: 1.5em; padding: 0px; text-indent: 2em; font-size: 15px; font-family: arial, &#39;Microsoft Yahei&#39;, sans-serif; line-height: 28px; white-space: normal;">\n    我十四，你四十，这种组合，你可还适应？\n</p>\n<p style="margin-top: 0px; margin-bottom: 1.5em; padding: 0px; text-indent: 2em; font-size: 15px; font-family: arial, &#39;Microsoft Yahei&#39;, sans-serif; line-height: 28px; white-space: normal;">\n    经历过这许多的磨难，人心疲惫，真的不堪重负，好希望，能有一个清幽之地能静心调养，\n</p>\n<p style="margin-top: 0px; margin-bottom: 1.5em; padding: 0px; text-indent: 2em; font-size: 15px; font-family: arial, &#39;Microsoft Yahei&#39;, sans-serif; line-height: 28px; white-space: normal;">\n    疗伤总是免不了的，肉体的疼，心上的伤，<a href="http://www.sanwen.net/sanwen/xinqing/" target="_blank" style="text-decoration: none; color: rgb(68, 68, 68);">情感</a>上受到的重创，重重叠叠，已经几乎分辨不出一个人本来的面目了。面目全非。\n</p>\n<p style="margin-top: 0px; margin-bottom: 1.5em; padding: 0px; text-indent: 2em; font-size: 15px; font-family: arial, &#39;Microsoft Yahei&#39;, sans-serif; line-height: 28px; white-space: normal;">\n    小楼昨<a href="http://ye.sanwen8.cn/" target="_blank" style="text-decoration: none; color: rgb(68, 68, 68);">夜</a>又东风，故国不堪回首月明中，雕栏玉砌应犹在，只是朱颜改。\n</p>\n<p style="margin-top: 0px; margin-bottom: 1.5em; padding: 0px; text-indent: 2em; font-size: 15px; font-family: arial, &#39;Microsoft Yahei&#39;, sans-serif; line-height: 28px; white-space: normal;">\n    如果能够重活一次，就象重游故地，就想策马慢踱，把沿途的风景，好好地，细细看透。才是不辜负一场青<a href="http://chuntian.sanwen8.cn/" target="_blank" style="text-decoration: none; color: rgb(68, 68, 68);">春</a>。\n</p>\n<p style="margin-top: 0px; margin-bottom: 1.5em; padding: 0px; text-indent: 2em; font-size: 15px; font-family: arial, &#39;Microsoft Yahei&#39;, sans-serif; line-height: 28px; white-space: normal;">\n    * * *\n</p>\n<p style="margin-top: 0px; margin-bottom: 1.5em; padding: 0px; text-indent: 2em; font-size: 15px; font-family: arial, &#39;Microsoft Yahei&#39;, sans-serif; line-height: 28px; white-space: normal;">\n    没有落下别的病根，只是，变得不爱讲话了，心也荒凉了，对<a href="http://www.sanwen.net/sanwen/xinqing/" target="_blank" style="text-decoration: none; color: rgb(68, 68, 68);">感情</a>，似乎已看破了，精力，用尽了，智慧，现有的，都是用血泪和苦水养成的，容颜渐老。\n</p>\n<p style="margin-top: 0px; margin-bottom: 1.5em; padding: 0px; text-indent: 2em; font-size: 15px; font-family: arial, &#39;Microsoft Yahei&#39;, sans-serif; line-height: 28px; white-space: normal;">\n    既然都不再奢望爱情，是否该养个花，种个草，什么什么的。听老人说：只有享不了的福，没有吃不了的苦，可是，这苦，我是吃够够的了。\n</p>\n<p style="margin-top: 0px; margin-bottom: 1.5em; padding: 0px; text-indent: 2em; font-size: 15px; font-family: arial, &#39;Microsoft Yahei&#39;, sans-serif; line-height: 28px; white-space: normal;">\n    有时候，觉得就是苍天弄人。\n</p>\n<p style="margin-top: 0px; margin-bottom: 1.5em; padding: 0px; text-indent: 2em; font-size: 15px; font-family: arial, &#39;Microsoft Yahei&#39;, sans-serif; line-height: 28px; white-space: normal;">\n    明明你是个<a href="http://danchun.sanwen8.cn/" target="_blank" style="text-decoration: none; color: rgb(68, 68, 68);">单纯</a>的小萝莉，就一定会遇上呆萌的大叔。\n</p>\n<p style="margin-top: 0px; margin-bottom: 1.5em; padding: 0px; text-indent: 2em; font-size: 15px; font-family: arial, &#39;Microsoft Yahei&#39;, sans-serif; line-height: 28px; white-space: normal;">\n    明明你希望着<a href="http://xingfu.sanwen8.cn/" target="_blank" style="text-decoration: none; color: rgb(68, 68, 68);">幸福</a>，却收获着<a href="http://tongku.sanwen8.cn/" target="_blank" style="text-decoration: none; color: rgb(68, 68, 68);">痛苦</a>。\n</p>\n<p style="margin-top: 0px; margin-bottom: 1.5em; padding: 0px; text-indent: 2em; font-size: 15px; font-family: arial, &#39;Microsoft Yahei&#39;, sans-serif; line-height: 28px; white-space: normal;">\n    明明你想爱我的时候，偏偏爱着别人。\n</p>\n<p style="margin-top: 0px; margin-bottom: 1.5em; padding: 0px; text-indent: 2em; font-size: 15px; font-family: arial, &#39;Microsoft Yahei&#39;, sans-serif; line-height: 28px; white-space: normal;">\n    明明想过简单的<a href="http://www.sanwen.net/suibi/shenghuo/" target="_blank" style="text-decoration: none; color: rgb(68, 68, 68);">生活</a>，偏偏就有重任在身。\n</p>\n<p style="margin-top: 0px; margin-bottom: 1.5em; padding: 0px; text-indent: 2em; font-size: 15px; font-family: arial, &#39;Microsoft Yahei&#39;, sans-serif; line-height: 28px; white-space: normal;">\n    明明想与人为善，偏偏人不与我为善。\n</p>\n<p style="margin-top: 0px; margin-bottom: 1.5em; padding: 0px; text-indent: 2em; font-size: 15px; font-family: arial, &#39;Microsoft Yahei&#39;, sans-serif; line-height: 28px; white-space: normal;">\n    总之，总是事与愿违。才确知：天下事，不如意者，十之八九。\n</p>\n<p style="margin-top: 0px; margin-bottom: 1.5em; padding: 0px; text-indent: 2em; font-size: 15px; font-family: arial, &#39;Microsoft Yahei&#39;, sans-serif; line-height: 28px; white-space: normal;">\n    不听老人言，吃亏在眼前，老话是有一定的道理的。\n</p>\n<p style="margin-top: 0px; margin-bottom: 1.5em; padding: 0px; text-indent: 2em; font-size: 15px; font-family: arial, &#39;Microsoft Yahei&#39;, sans-serif; line-height: 28px; white-space: normal;">\n    可是我就是不想这样，总是想象马一样的，不顾一路坎坷，想偶尔飞奔一下，<a href="http://baogao.sanwen.net/xindetihui/" target="_blank" style="text-decoration: none; color: rgb(68, 68, 68);">体会</a>风的速度和飞一般的感觉。\n</p>\n<p style="margin-top: 0px; margin-bottom: 1.5em; padding: 0px; text-indent: 2em; font-size: 15px; font-family: arial, &#39;Microsoft Yahei&#39;, sans-serif; line-height: 28px; white-space: normal;">\n    我知道，有些事情，我是<a href="http://yongheng.sanwen8.cn/" target="_blank" style="text-decoration: none; color: rgb(68, 68, 68);">永远</a>永远都不可能知道的了，但是我也没什么可<a href="http://houhui.sanwen8.cn/" target="_blank" style="text-decoration: none; color: rgb(68, 68, 68);">后悔</a>的，你知道了，也一样，两个人的事，至少有一个知道，就可以了。\n</p>\n<p style="margin-top: 0px; margin-bottom: 1.5em; padding: 0px; text-indent: 2em; font-size: 15px; font-family: arial, &#39;Microsoft Yahei&#39;, sans-serif; line-height: 28px; white-space: normal;">\n    可是，有时候，我也觉得自己是苍天的眷顾。\n</p>\n<p style="margin-top: 0px; margin-bottom: 1.5em; padding: 0px; text-indent: 2em; font-size: 15px; font-family: arial, &#39;Microsoft Yahei&#39;, sans-serif; line-height: 28px; white-space: normal;">\n    怎么说呢？\n</p>\n<p style="margin-top: 0px; margin-bottom: 1.5em; padding: 0px; text-indent: 2em; font-size: 15px; font-family: arial, &#39;Microsoft Yahei&#39;, sans-serif; line-height: 28px; white-space: normal;">\n    明明是个孽种，偏偏得遇贵人，从此改变了自己的命运。\n</p>\n<p style="margin-top: 0px; margin-bottom: 1.5em; padding: 0px; text-indent: 2em; font-size: 15px; font-family: arial, &#39;Microsoft Yahei&#39;, sans-serif; line-height: 28px; white-space: normal;">\n    偷来的东西是不得炫耀的。所以我总是很低调。我知道，这句话，也有着炫耀的成分，可是，就象那深深水底的黑色一样，是隐而不见的。\n</p>\n<p style="margin-top: 0px; margin-bottom: 1.5em; padding: 0px; text-indent: 2em; font-size: 15px; font-family: arial, &#39;Microsoft Yahei&#39;, sans-serif; line-height: 28px; white-space: normal;">\n    你知道吗？当你认为一些事情与你无关的时候，你就已经知道，并不是只有自己经历过的事情才可以<a href="http://zuowen.sanwen.net/z/10671-gandong" target="_blank" style="text-decoration: none; color: rgb(68, 68, 68);">感动</a>自己。\n</p>\n<p style="margin-top: 0px; margin-bottom: 1.5em; padding: 0px; text-indent: 2em; font-size: 15px; font-family: arial, &#39;Microsoft Yahei&#39;, sans-serif; line-height: 28px; white-space: normal;">\n    当年，我在一个暑假的时候，捧着一本残破的<a href="http://www.sanwen.net/novel/" target="_blank" style="text-decoration: none; color: rgb(68, 68, 68);">小说</a>，看得那叫一个入迷，教室外面有很高的梧桐树，可是风是热的，可是我原本浮躁的<a href="http://www.sanwen.net/rizhi/xinqing/" target="_blank" style="text-decoration: none; color: rgb(68, 68, 68);">心情</a>，竟然在看完那本小说后，变得清凉无比。\n</p>\n<p style="margin-top: 0px; margin-bottom: 1.5em; padding: 0px; text-indent: 2em; font-size: 15px; font-family: arial, &#39;Microsoft Yahei&#39;, sans-serif; line-height: 28px; white-space: normal;">\n    <a href="http://www.sanwen8.cn/jingdian/" target="_blank" style="text-decoration: none; color: rgb(68, 68, 68);">语言</a>的魅力，初次显现。\n</p>\n<p style="margin-top: 0px; margin-bottom: 1.5em; padding: 0px; text-indent: 2em; font-size: 15px; font-family: arial, &#39;Microsoft Yahei&#39;, sans-serif; line-height: 28px; white-space: normal;">\n    那是一种意境。我喜欢，不得了。\n</p>\n<p style="margin-top: 0px; margin-bottom: 1.5em; padding: 0px; text-indent: 2em; font-size: 15px; font-family: arial, &#39;Microsoft Yahei&#39;, sans-serif; line-height: 28px; white-space: normal;">\n    * * *\n</p>\n<p style="margin-top: 0px; margin-bottom: 1.5em; padding: 0px; text-indent: 2em; font-size: 15px; font-family: arial, &#39;Microsoft Yahei&#39;, sans-serif; line-height: 28px; white-space: normal;">\n    他们都说我变了。\n</p>\n<p style="margin-top: 0px; margin-bottom: 1.5em; padding: 0px; text-indent: 2em; font-size: 15px; font-family: arial, &#39;Microsoft Yahei&#39;, sans-serif; line-height: 28px; white-space: normal;">\n    我是变了。\n</p>\n<p style="margin-top: 0px; margin-bottom: 1.5em; padding: 0px; text-indent: 2em; font-size: 15px; font-family: arial, &#39;Microsoft Yahei&#39;, sans-serif; line-height: 28px; white-space: normal;">\n    变得，有些，黑色的性情。总有着伤的痛的，隐藏在身体各处，时不时地触景生情，睹物思人，自我折磨一番\n</p>\n<p style="margin-top: 0px; margin-bottom: 1.5em; padding: 0px; text-indent: 2em; font-size: 15px; font-family: arial, &#39;Microsoft Yahei&#39;, sans-serif; line-height: 28px; white-space: normal;">\n    后来，也习惯了，心变得越发地狠，如果遇到敌人，出手再不会犹犹豫豫的，\n</p>\n<p style="margin-top: 0px; margin-bottom: 1.5em; padding: 0px; text-indent: 2em; font-size: 15px; font-family: arial, &#39;Microsoft Yahei&#39;, sans-serif; line-height: 28px; white-space: normal;">\n    但是，我也比<a href="http://cengjing.sanwen8.cn/" target="_blank" style="text-decoration: none; color: rgb(68, 68, 68);">以前</a>更知道分寸了。\n</p>\n<p style="margin-top: 0px; margin-bottom: 1.5em; padding: 0px; text-indent: 2em; font-size: 15px; font-family: arial, &#39;Microsoft Yahei&#39;, sans-serif; line-height: 28px; white-space: normal;">\n    有时候，人生，我觉得只有一个技巧，那就是分寸的拿捏。\n</p>\n<p style="margin-top: 0px; margin-bottom: 1.5em; padding: 0px; text-indent: 2em; font-size: 15px; font-family: arial, &#39;Microsoft Yahei&#39;, sans-serif; line-height: 28px; white-space: normal;">\n    可是，对于你我之间发生的<a href="http://tonghua.sanwen.net/" target="_blank" style="text-decoration: none; color: rgb(68, 68, 68);">故事</a>，我拿不准。\n</p>\n<p style="margin-top: 0px; margin-bottom: 1.5em; padding: 0px; text-indent: 2em; font-size: 15px; font-family: arial, &#39;Microsoft Yahei&#39;, sans-serif; line-height: 28px; white-space: normal;">\n    都说英雄难过美人关，你说我算是个英雄吗？\n</p>\n<p style="margin-top: 0px; margin-bottom: 1.5em; padding: 0px; text-indent: 2em; font-size: 15px; font-family: arial, &#39;Microsoft Yahei&#39;, sans-serif; line-height: 28px; white-space: normal;">\n    不算，我也觉得不算。\n</p>\n<p style="margin-top: 0px; margin-bottom: 1.5em; padding: 0px; text-indent: 2em; font-size: 15px; font-family: arial, &#39;Microsoft Yahei&#39;, sans-serif; line-height: 28px; white-space: normal;">\n    我全然忘记了自己是谁，这一世，简直一塌糊涂，\n</p>\n<p style="margin-top: 0px; margin-bottom: 1.5em; padding: 0px; text-indent: 2em; font-size: 15px; font-family: arial, &#39;Microsoft Yahei&#39;, sans-serif; line-height: 28px; white-space: normal;">\n    原来整齐的生活，被搞得歪七扭八，不成体统，可是，我们还得这样在疯子面前拼命保持尊严和庄重。\n</p>\n<p>\n    <br/>\n</p>', 145961256, 0);

-- --------------------------------------------------------

--
-- 表的结构 `speak`
--

CREATE TABLE IF NOT EXISTS `speak` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '论坛帖子编号',
  `title` varchar(1000) NOT NULL COMMENT '论坛帖子标题',
  `content` varchar(5000) NOT NULL COMMENT '论坛帖子内容',
  `user_id` int(11) NOT NULL COMMENT '论坛帖子发送者',
  `time` int(11) NOT NULL COMMENT '论坛帖子发布时间',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '论坛帖子状态',
  `is_reply` tinyint(4) NOT NULL DEFAULT '1' COMMENT '帖子评论权限',
  `is_delete` tinyint(11) NOT NULL DEFAULT '0' COMMENT '论坛帖子注销状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=9 ;

--
-- 转存表中的数据 `speak`
--

INSERT INTO `speak` (`id`, `title`, `content`, `user_id`, `time`, `status`, `is_reply`, `is_delete`) VALUES
(1, '这是系统管理员发送的消息1', '这是系统管理员发送的消息的具体内容1', 37, 1457885429, 1, 1, 0),
(2, '这是普通用户发来的普通帖子1', '这是普通用户发来的普通帖子的内容1', 37, 1457885429, 0, 1, 0),
(3, '这是普通用户发来的普通帖子2', '这是普通用户发来的普通帖子的内容2', 37, 1457885410, 0, 1, 0),
(4, '这是普通用户发来的普通帖子3', '这是普通用户发来的普通帖子的内容3', 37, 1457885411, 0, 0, 0),
(8, '这是一个帖子4', '44444444444444', 37, 1458745531, 0, 1, 0);

-- --------------------------------------------------------

--
-- 表的结构 `speak_advertisement`
--

CREATE TABLE IF NOT EXISTS `speak_advertisement` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '论坛广告编号',
  `content` varchar(500) NOT NULL COMMENT '论坛广告内容',
  `href` varchar(500) NOT NULL COMMENT '论坛广告链接',
  `status` smallint(6) NOT NULL DEFAULT '0' COMMENT '论坛广告开关',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `speak_advertisement`
--

INSERT INTO `speak_advertisement` (`id`, `content`, `href`, `status`) VALUES
(1, '这是一个神奇的广告                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           ', '#', 0);

-- --------------------------------------------------------

--
-- 表的结构 `speak_like`
--

CREATE TABLE IF NOT EXISTS `speak_like` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '收藏帖子编号',
  `speak_id` int(11) NOT NULL COMMENT '收藏帖子对应id',
  `user_id` int(11) NOT NULL COMMENT '收藏帖子用户id',
  `time` int(11) NOT NULL COMMENT '收藏帖子时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=40 ;

--
-- 转存表中的数据 `speak_like`
--

INSERT INTO `speak_like` (`id`, `speak_id`, `user_id`, `time`) VALUES
(25, 3, 37, 1458816843),
(27, 2, 37, 1459091834),
(38, 2, 38, 1459154048);

-- --------------------------------------------------------

--
-- 表的结构 `speak_reply`
--

CREATE TABLE IF NOT EXISTS `speak_reply` (
  `id` int(11) NOT NULL COMMENT '回帖编号',
  `content` varchar(11) NOT NULL COMMENT '回帖内容',
  `user_id` int(11) NOT NULL COMMENT '回帖用户',
  `speak_id` int(11) NOT NULL COMMENT '回帖所在帖编号',
  `time` int(11) NOT NULL COMMENT '回帖时间',
  `is_delete` tinyint(11) NOT NULL DEFAULT '0' COMMENT '回帖注销'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `speak_reply`
--

INSERT INTO `speak_reply` (`id`, `content`, `user_id`, `speak_id`, `time`, `is_delete`) VALUES
(0, '333', 37, 8, 1459866335, 0),
(0, '22222222222', 37, 3, 1459866344, 0),
(0, '你真棒', 37, 2, 1460041424, 0),
(0, '要想蛤蛤一样江山', 37, 2, 1460041472, 0),
(0, '楼上说的真对', 37, 2, 1460041478, 0),
(0, '11', 37, 8, 1460904405, 0),
(0, '哈哈哈', 37, 8, 1461066943, 0);

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户编号',
  `username` varchar(50) NOT NULL COMMENT '用户名',
  `password` varchar(32) NOT NULL COMMENT '密码',
  `email` varchar(50) NOT NULL COMMENT '邮箱',
  `sex` tinyint(1) NOT NULL COMMENT '性别',
  `age` tinyint(4) NOT NULL DEFAULT '25' COMMENT '年龄',
  `description` varchar(200) DEFAULT '您暂时没有签名' COMMENT '个人说明',
  `tell` varchar(200) NOT NULL DEFAULT '您暂时没有想说的话' COMMENT '告诉世界',
  `phone` varchar(50) DEFAULT '---' COMMENT '联系电话',
  `address` varchar(200) DEFAULT '地球上 = =' COMMENT '住址',
  `icon` varchar(200) NOT NULL DEFAULT 'default.jpg' COMMENT '用户头像存放地址',
  `regtime` int(11) NOT NULL COMMENT '注册时间',
  `token` varchar(32) NOT NULL COMMENT '激活密钥',
  `token_exptime` int(11) NOT NULL COMMENT '密钥过期时间',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '激活状态',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '注销状态',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=40 ;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `email`, `sex`, `age`, `description`, `tell`, `phone`, `address`, `icon`, `regtime`, `token`, `token_exptime`, `status`, `is_delete`) VALUES
(37, 'root', '63a9f0ea7bb98050796b649e85481845', '1101632336@qq.com', 0, 20, '好好学习，天天向上', 'while there is life there is hope.', '15122640047', '天津市河西区', 'icon_37.jpg', 1457853225, '829f7249b5a94e37f3ac188024f62c21', 1457939625, 1, 0),
(38, 'root2', '63a9f0ea7bb98050796b649e85481845', '1101632336@qq.com', 1, 34, '您暂时没有签名', '您暂时没有想说的话', '---', '地球上 = =', 'default.jpg', 1458141392, '1523940f49083d69e4f5fda770b22f12', 1458227792, 1, 0),
(39, 'root3', '63a9f0ea7bb98050796b649e85481845', '1101632336@qq.com', 0, 72, '您暂时没有签名', '您暂时没有想说的话', '---', '地球上 = =', 'default.jpg', 1458141392, '1523940f49083d69e4f5fda770b22f12', 1458227792, 3, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
