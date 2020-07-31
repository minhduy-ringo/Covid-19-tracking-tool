CALL `udpt`.`SP_CREATE_USER`('NguyenVanA', 'nam', '123 duong abc', '123456789', '0352837767', 'abc@gmail.com', '');
CALL `udpt`.`SP_CREATE_USER`('NguyenVanB', 'nu', '123 duong def', '987654321', '0352837766', 'def@gmail.com', md5('password'));

UPDATE `userauthentication` SET `ActivateState` = 1 WHERE UserId = 1;

DELETE FROM `userauthentication` where UserId = 5;
DELETE FROM `userdetail` where UserId = 5;

CALL SP_LOGIN('0352837766', md5('password'), '192.168.1.1');

SELECT * FROM `userdetail`;
SELECT * FROM `userauthentication`;
SELECT * FROM `session`;
SELECT current_timestamp();

DELETE FROM `session` WHERE `SessionId` = 1;
