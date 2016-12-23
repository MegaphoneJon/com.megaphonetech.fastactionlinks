-- /*******************************************************
-- *
-- * civicrm_fast_action_link
-- *
-- *******************************************************/
CREATE TABLE `civicrm_fast_action_link` (


     `id` int unsigned NOT NULL AUTO_INCREMENT  COMMENT 'Unique FastActionLink ID',
     `uf_group_id` int unsigned NOT NULL   COMMENT 'Which profile this link is associated with.',
     `action` varchar(64) NOT NULL   COMMENT 'e.g. addToGroup, removeFromGroup.',
     `action_entity_id` int unsigned    COMMENT 'If the action requires an entity ID, it is stored here.',
     `dim_on_use` tinyint   DEFAULT 1 COMMENT 'Should this link be disabled and the corresponding search result dimmed on click?',
     `is_active` tinyint   DEFAULT 1 COMMENT 'Is this link currently active?  If not, do not show.',
     `weight` int NOT NULL  DEFAULT 1 COMMENT 'Controls order in which links appear.' 
,
    PRIMARY KEY ( `id` )
 
 
,          CONSTRAINT FK_civicrm_fast_action_link_uf_group_id FOREIGN KEY (`uf_group_id`) REFERENCES `civicrm_uf_group`(`id`) ON DELETE CASCADE  
)  ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci  ;
