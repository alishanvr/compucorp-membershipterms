DROP TABLE IF EXISTS `civicrm_membershipterms`;

CREATE TABLE IF NOT EXISTS `civicrm_membershipterms` (
  `id` INT (10) NOT NULL AUTO_INCREMENT COMMENT 'Unique Membership Term ID',
  `contact_id` INT(10) UNSIGNED COMMENT 'FK to Contact',
  `start_date` DATETIME NOT NULL COMMENT 'Membership Starting Date',
  `end_date` DATETIME NULL COMMENT 'Membership Ending Date',
  `updated_at` DATETIME NULL COMMENT 'When record is updated',
  `created_at` DATETIME NULL COMMENT 'When record is created',
  `deleted_at` DATETIME NULL COMMENT 'When record is Deleted',
  PRIMARY KEY (`id`),
  INDEX `cc_mt_cid` (`contact_id` ASC),
  CONSTRAINT `cc_memterm_cid`
    FOREIGN KEY (`contact_id`)
    REFERENCES `civicrm_contact`(`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;