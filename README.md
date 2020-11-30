# Eventos y Boletos

## Instalacion

Configurar .env
`SANCTUM_STATEFUL_DOMAINS`
`SESSION_DOMAIN`
`DB_*`

```php
php artisan migrate --seed
php artisan storage:link
```

#### Auth

email: admin@gmail.com

password: password

## Api

POST: /login

POST: /logout

### Customer

```json
GET: /api/customers
reponse:
[{
 id: integer, name: string, birth_day: date, email: string, phone: string
}]

POST: /api/customers
params
{
   name: string|required,
   email: string|required,
   phone: string,
   birth_day:
   date,
   document:
   string|required
}
response {
 id: integer, name: string, birth_day: date, email: string, phone: string
}

GET: /api/customer/{id}
response {
 id: integer, name: string, birth_day: date, email: string, phone: string
}

GET: /api/customer/{id}?tickets=true
response {
 id: integer, name: string, birth_day: date, email: string, phone: string, tickets: [{base}]
}

GET: /api/customer/{id}?tickets=true&meetup=true
response {
   id: integer,
   name: string,
   birth_day: date,
   email: string,
   phone: string,
   tickets: [{base}, meetup: {base}]
}

PUT: /api/customers/{id}
params
{
   name: string|required,
   email: string|required,
   phone: string,
   birth_day:
   date,
   document:
   string|required
}
response {
 id: integer, name: string, birth_day: date, email: string, phone: string
}
```

### Meetups

```json
GET: /api/meetups
response: [{
	id: intger,
	name: string,
	cover_path:string,
	date: date,
	quantity: integer,
	sold: integer,
	available: integer
	place: string,
}]

POST: /api/meetups
params: {
	name: string,
	cover: file|img,
	date:date,
	quantity: integer,
	place: string
}
response: {base}

GET: /api/meetups/{id}
response: {dabe}

GET: /api/meetups?tickets=true
response: {base, tickets: [{base}]}

GET: /api/meetups?tickets=true&customer=true
response: {base, tickets: [{base, customer:{base}}]}

GET: /apu/meetups/{id}/availability
response {
	availability: interger,
	message: string
}
```

### Tickets

```json
POST: /api/tickets
params: {customer_id: integer, meetups_id: integer}
respospo: {data: success}

POST: /tickets/{id}/confirm
response: {message: 'used' | 'success'}
```
