CREATE TABLE `noticias` (
  `id` int(10) NOT NULL auto_increment,
  `titulo` varchar(150) collate utf8_spanish_ci NOT NULL,
  `contenido` text collate utf8_spanish_ci NOT NULL,
  `contenido_ext` text collate utf8_spanish_ci NOT NULL,
  `contenido_ext3` text collate utf8_spanish_ci NOT NULL,
  `contenido_ext2` varchar(100) collate utf8_spanish_ci NOT NULL,
  `fecha` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `id_usuario` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=13 ;

--
-- Volcar la base de datos para la tabla `noticias`
--

INSERT INTO `noticias` (`id`, `titulo`, `contenido`, `contenido_ext`, `contenido_ext3`, `contenido_ext2`, `fecha`, `id_usuario`) VALUES
(11, 'Otra noticia nueva', '<p>Problemos el nuevo m&oacute;dulo para noticias</p>', '<p>Y esta es la noticia extendida</p>', '', '', '2008-01-26 20:58:18', 0),
(9, 'Cienpies exports Card Reader to France', '<p>Cienpies Design is a good example of young, talented Uruguayan people who seek to make their way through the international market.</p>', '<p>adfadf ad fadf adsf ad f</p>', '', '', '2008-01-08 20:46:37', 0),
(10, 'Nueva noticia extendida', '<p>Contenido simple</p>', '<p>contenido extendido y con t&iacute;ldes!</p>', '', '', '2008-01-08 22:01:00', 0),
(12, 'Buscan a Maddie en Chile', '<p><span id="_ctl5_lblNota">La polic&iacute;a dijo el viernes que est&aacute; investigando un informe sobre el supuesto avistamiento en el norte de Chile de la ni&ntilde;a brit&aacute;nica Madeleine McCann, desaparecida el 3 de mayo del a&ntilde;o pasado en una playa en Portugal.<br />\r\n</span></p>', '<p>El detective Segundo Leyton, jefe de la brigada especializada en la b&uacute;squeda de personas desaparecidas, dijo a medios locales que la investigaci&oacute;n se inici&oacute; luego de que un ciudadano no identificado dijo a la polic&iacute;a haber visto una pareja de extranjeros con una ni&ntilde;a parecida a la peque&ntilde;a.</p>\r\n<p>El denunciante &quot;se&ntilde;ala que hab&iacute;a visto a una menor de similares caracter&iacute;sticas a la peque&ntilde;a Madeleine y que estaba acompa&ntilde;ada de una persona adulta y una mujer&quot;, dijo Leyton.</p>\r\n<p>Agreg&oacute; que &quot;le llama m&aacute;s la atenci&oacute;n la presencia del sujeto, que lo encuentra muy similar a la persona que aparece en la prensa&quot;, aludiendo a un sospechoso cuyo retrato hablado fue entregado por los padres de la ni&ntilde;a recientemente.</p>\r\n<p>Agreg&oacute; que el hombre dijo que la pareja hablaba un idioma extranjero.<br />\r\nEl informante dijo que la menor estaba en la ciudad de Vicu&ntilde;a, 500 kil&oacute;metros al norte, y que el hombre con ella correspond&iacute;a al retrato hablado del supuesto secuestrador divulgado este mes por los padres de la menor.</p>\r\n<p>El hombre que alert&oacute; a la polic&iacute;a, del que s&oacute;lo se dijo que es un t&eacute;cnico en refrigeraci&oacute;n, dijo a la polic&iacute;a que vio a la pareja y la ni&ntilde;a en el museo de la poetisa chilena Gabriela Mistral.</p>\r\n<p>(AP)</p>', '', '', '2008-01-26 23:19:20', 0);

-- --------------------------------------------------------