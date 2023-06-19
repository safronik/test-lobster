# test-lobster

Greetings!

Warning! Code is a mess! It's 4:00 am. I think I bite more than I could chew =)
There is no comment because I have no time left. I applogize for that.

You can see it in action at test-lobster.webtm.ru

Main routes:
/admin - you can add lotteries there.
/participate - participate in a lottery.
/* - same as previous

The good news that it could be transfered to any framewrok or live without it. Or use any DB, as long as you provide a gateway for it.

So what I did and waht I tried to show you?
- REST level 2
- Cross-platform app
- Usage of code patterns( Hydrator, Singleton, Multiton, DTO, Gateway, Fabric Method ) It's all there.
- Dependency injection and inversion

...I guess that's it.

Almost all code was written, only Variables lib was copied from old project.

CREATE TABLE `lotteries` (
	`id` VARCHAR(130) NOT NULL COLLATE 'utf8_general_ci',
	`start_time` INT(10) NOT NULL DEFAULT '0',
	`win_chance` FLOAT NOT NULL DEFAULT '0',
	`win_hash` VARCHAR(130) NOT NULL DEFAULT '0' COLLATE 'utf8_general_ci',
	`duration` INT(10) NOT NULL DEFAULT '0',
	`lottery_status` ENUM('IN_PROCESS','PAUSED','STOPPED') NOT NULL DEFAULT 'IN_PROCESS' COLLATE 'utf8_general_ci',
	`restart_times` TINYINT(3) NULL DEFAULT NULL,
	PRIMARY KEY (`id`) USING BTREE
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB;

CREATE TABLE `participants` (
	`ip` VARCHAR(20) NOT NULL COLLATE 'utf8_general_ci',
	`lottery_id` VARCHAR(130) NOT NULL COLLATE 'utf8_general_ci',
	`hash` VARCHAR(130) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
	`roll_time` INT(10) NULL DEFAULT NULL,
	PRIMARY KEY (`ip`, `lottery_id`) USING BTREE,
	INDEX `FK_participant_lotteries` (`lottery_id`) USING BTREE
COLLATE='utf8_general_ci'
ENGINE=InnoDB;
