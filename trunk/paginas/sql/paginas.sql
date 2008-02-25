
CREATE TABLE `paginas` (
  `id` int(10) NOT NULL auto_increment,
  `titulo` varchar(150) collate utf8_spanish_ci NOT NULL,
  `contenido` text collate utf8_spanish_ci NOT NULL,
  `fecha` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `id_usuario` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=11 ;

--
-- Volcar la base de datos para la tabla `paginas`
--

INSERT INTO `paginas` (`id`, `titulo`, `contenido`, `fecha`, `id_usuario`) VALUES
(1, 'Declaran esencialidad de servicios quirúrgicos', 'Tras el Consejo de Ministros', '2007-08-01 01:15:13', 1),
(3, 'pagina2', 'contenido de la segunda pagina', '2007-08-01 01:25:40', 0),
(5, 'Primer página con TinyMCE', 'Mmm... c&oacute;mo se ve esto?', '2007-08-13 20:32:18', 0),
(6, 'Sin festejos, Fidel cumple años', '<img src="http://www.elpais.com.uy/07/08/13/33742_298.JPG" alt="Fidel" title="Fidel Castro" width="298" height="255" align="right" />La Habana', '2007-08-14 01:23:57', 0),
(7, 'Introducción', 'Uruguay explota recursos naturales pesqueros del Oc&eacute;ano Atl&aacute;ntico Sud Occidental', '2007-08-16 02:22:55', 0),
(8, 'Investigación', 'La Investigaci&oacute;n Cient&iacute;fica de los Recursos Pesqueros', '2007-08-16 02:28:01', 0),
(9, 'Página de 14/10/2007', '<p><em>Nueva p&aacute;gina del d&iacute;a de hoy<img alt="" src="/surforce-cms/public/scripts/fckeditor/editor/images/smiley/msn/cry_smile.gif" /></em></p>', '2007-10-14 00:29:37', 0);
