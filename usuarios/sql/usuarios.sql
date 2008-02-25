-

CREATE TABLE `usuarios` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `usuario` varchar(32) collate utf8_spanish_ci NOT NULL,
  `password` varchar(32) collate utf8_spanish_ci NOT NULL,
  `nombre` varchar(40) collate utf8_spanish_ci NOT NULL,
  `apellido` varchar(40) collate utf8_spanish_ci NOT NULL,
  `mail` varchar(64) collate utf8_spanish_ci default NULL,
  `estado` int(2) NOT NULL,
  `creado` datetime NOT NULL,
  `modificado` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `usuario` (`usuario`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=8 ;

--
-- Volcar la base de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `password`, `nombre`, `apellido`, `mail`, `estado`, `creado`, `modificado`) VALUES
(1, 'homero', 'clave', 'Homero''s', 'Simpson', 'homero@springfield.com', 1, '2007-07-03 21:11:50', '2007-07-26 01:17:25'),
(2, 'apu', 'clave', 'Apu', 'Nahasapeemapetilon', 'apu@springfield.com', 1, '2007-07-03 23:22:09', '2007-07-03 23:32:19'),
(4, 'montgomery', 'clave', 'Montgomery', 'Burns', 'montgomery@springfield.com', 0, '2007-07-03 23:25:26', '2007-07-03 23:25:26'),
(5, 'kent', 'clave', 'Kent', 'Brockman', 'kent@springfield.com', 1, '2007-07-03 23:25:26', '2007-07-03 23:25:26'),
(6, 'eplace', 'pepe', 'Enrique', 'Place de Cuadro', 'enriqueplace@gmail.com', 1, '2007-07-25 23:45:28', '2007-10-15 22:43:16'),
(7, 'admin', 'pepe', 'Admin', 'Admin', 'admin@surforce.com', 1, '2008-01-26 21:38:25', '2008-01-26 20:38:26');
