
CREATE TABLE `contacto` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `nombre` varchar(50) collate utf8_spanish_ci default NULL,
  `email` varchar(50) collate utf8_spanish_ci NOT NULL,
  `comentario` varchar(500) collate utf8_spanish_ci default NULL,
  `fecha` datetime NOT NULL,
  `telefono` varchar(30) collate utf8_spanish_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=4 ;

--
-- Volcar la base de datos para la tabla `contacto`
--

INSERT INTO `contacto` (`id`, `nombre`, `email`, `comentario`, `fecha`, `telefono`) VALUES
(1, 'Evariste', 'evari@yahoo.com', 'Fracciones continuas', '2007-01-10 00:00:00', '12'),
(2, 'nombre', 'mail', 'comentario', '2008-01-08 21:04:48', '12'),
(3, 'enrique', 'enriqueplace@gmail.com', 'esta es una prueba', '2008-01-27 17:32:01', '1234');
