
CREATE TABLE `faqs` (
  `id` int(50) NOT NULL auto_increment,
  `pregunta` varchar(250) character set utf8 collate utf8_unicode_ci NOT NULL,
  `respuesta` text character set utf8 collate utf8_unicode_ci NOT NULL,
  `fecha` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=5 ;

--
-- Volcar la base de datos para la tabla `faqs`
--

INSERT INTO `faqs` (`id`, `pregunta`, `respuesta`, `fecha`) VALUES
(1, '�C�mo se hace para conseguir el login del sistema?', 'Deberá contactarse con el owner del proyecto a trav�s de un email', '2007-10-14 00:21:14'),
(2, '�qu� otra pregunta puedo hacer en una FAQ?', 'Cómo preguntar bien y ser entendido', '2008-01-27 00:36:03'),
(3, '�C�mo deber�aa hacer aquello?', 'Y los pasos son: 3', '2008-01-27 22:39:12');
