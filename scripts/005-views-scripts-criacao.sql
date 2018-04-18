CREATE VIEW `vw_sectors_list_info` AS select `sector`.`Sector_Id` AS `Sector_Id`,`sector`.`Name` AS `Name`, count(`ocurr`.`Ocurrence_Id`) AS `Open_Ocurrences`,max(`ocurr`.`Opening_Date`) AS `Last_Ocurrence` from ((`tb_sectors` `sector` left join `tb_ocurrences` `ocurr` on((`ocurr`.`Sector_Id` = `sector`.`Sector_Id`))) left join `tb_ocurrence_updates` `up` on(((`ocurr`.`Ocurrence_Id` = `up`.`Ocurrence_Id`) and (`up`.`Ocurrence_Status_Id` = 1)))) group by `sector`.`Sector_Id`;

CREATE VIEW `vw_user_profiles` AS select `users`.`User_Id` AS `User_Id`,`users`.`Name` AS `Name`,`profiles`.`Profile_Id` AS `Profile_Id`,`profiles`.`Description` AS `Description`,`profiles`.`FullAccess` AS `FullAccess` from (`tb_users` `users` join `tb_profiles` `profiles` on((`profiles`.`Profile_Id` = `users`.`Profile_Id`)));