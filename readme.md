# Api example

## Description
You can register a user in the system.
Only telephone number is required.
A user can have a loyalty card.

Fields:
* phone
* email
* name
* card_id
* notes
* register_date (automatic)
* balance (always 0)

## Available methods
`GET /`  
displays hello message

`GET /users`
get list of all users

`POST /users`
add new user, all fields except telephone are optional
Balance will be always 0
```json
{
  "telephone": 123456789,
  "name": "Test Test",
  "notes": "some notes",
  "email": "test@test.test",
  "card_id": "123456"
}
```
```json
{
  "telephone": 123456789,
  "name": "Test Test",
  "notes": "some notes",
  "email": null,
  "card_id": null
}
```

```json
{
  "telephone": 123456789
}
```
`GET /users/{id}`
get user info

`PUT /users/{id}`
update user info, you can't change balance
```json
{
  "telephone": 12345
}
```

`DELETE /users/{id}`
delete user

`GET /users/add-fake-user`
add fake user to the database


```sql
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

CREATE TABLE IF NOT EXISTS `sales` (
  `sale_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_ud` int(11) NOT NULL,
  `message` varchar(255) NOT NULL DEFAULT '',
  `added_on` datetime NOT NULL DEFAULT current_timestamp(),
  `amount` decimal(10,2) NOT NULL,
  PRIMARY KEY (`sale_id`),
  KEY `FK_sales_users` (`user_ud`),
  CONSTRAINT `FK_sales_users` FOREIGN KEY (`user_ud`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) DEFAULT '',
  `telephone` bigint(20) NOT NULL DEFAULT 0,
  `register_date` datetime NOT NULL DEFAULT current_timestamp(),
  `name` varchar(255) NOT NULL DEFAULT '',
  `card_id` bigint(20) DEFAULT 0,
  `notes` text NOT NULL DEFAULT '',
  `balance` decimal(10,2) NOT NULL DEFAULT 0.00,
  PRIMARY KEY (`id`),
  UNIQUE KEY `telephone` (`telephone`),
  UNIQUE KEY `card_id` (`card_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
```

