ALTER TABLE userrole ADD COLUMN id INT(11) NOT NULL FIRST;

ALTER TABLE userrole
  ADD PRIMARY KEY (id);

ALTER TABLE userrole
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;
 
ALTER TABLE userrole CHANGE roleid escolaid INT(11);
  
ALTER TABLE userrole RENAME userescola;

ALTER TABLE escola MODIFY numero CHAR(11) DEFAULT NULL;


CREATE TABLE `escola_vagas` (
  `id` int(11) NOT NULL,
  `etapa_id` int(11),
  `escola_id` int(11),
  `matutino` int(11) DEFAULT 0,
  `vespertino` int(11) DEFAULT 0,
  `integral` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `escola_vagas`
  ADD PRIMARY KEY (`id`);
  
 ALTER TABLE `escola_vagas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

  CREATE TABLE `config` (
  `id` int(11) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `valor` varchar(50) NOT NULL  
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `config`
  ADD PRIMARY KEY (`id`);
  
ALTER TABLE `config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

  INSERT INTO `config` (`descricao`, `valor`) VALUES
('permiteCadDuplicado', 'sim')


-- TRIGGERS TRIGGER PARA GERAR O PROTOCOLO DIRETO NO BANCO DE DADOS PARE EVITAR PROTOCOLO DUPLICADO
/* DELIMITER $

CREATE TRIGGER geraproto BEFORE INSERT
ON fila
FOR EACH ROW
BEGIN
	SET @lastID = (SELECT id FROM fila ORDER BY id DESC LIMIT 1);
	IF @lastID IS NULL OR @lastID = '' THEN
			SET @lastID = 0;
	END IF;
	SET @lastID = @lastID + 1;
	SET new.protocolo = concat(@lastID, YEAR(NOW()));
END$


DELIMITER ; */



DELIMITER $

CREATE TRIGGER geraproto BEFORE INSERT
ON fila
FOR EACH ROW
BEGIN
	SET @lastID = (SELECT `AUTO_INCREMENT` FROM  INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'filaunica' AND TABLE_NAME = 'fila');
	IF @lastID IS NULL OR @lastID = '' THEN
			SET @lastID = 0;
	END IF;	
	SET new.protocolo = concat(@lastID, YEAR(NOW()));
END$


DELIMITER ;




