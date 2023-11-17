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
