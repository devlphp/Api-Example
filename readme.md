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



