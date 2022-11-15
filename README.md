# API Rest
[Postman documentation](https://www.getpostman.com/collections/bdeb373f133f2ba7cfce) [[JSON file](./Web2TPE_API.postman_collection.json)]

---

## List all

URL: `GET /web2_tpe_api/reviews`

RETURNS:

-   **200**: `[{"id":<int>,"bookId":<int>,"userId":<int?>,"rating":<string>,"comments":<string>}]`
-   **204**: `null`

---

## List all by bookId

URL: `GET /web2_tpe_api/reviews/:bookId`

RETURNS:

-   **200**: `[{"id":<int>,"bookId":<int>,"userId":<int?>,"rating":<string>,"comments":<string>,"bookTile":<string>,"authorName":<string>,"authorLastName":<string>,"userAlias":<string?>}]`
-   **204**: `null`

**Los siguientes filtros se le pueden aplicar conjuntamente o por separado:**

### Sorted by

> Existe un ordenado por defecto segun reviewId ASC

URL: `GET /web2_tpe_api/reviews/:bookId?sortCriteria=<enum>&isOrderReversed=<boolean?>`

`sortCriteria` valores posibles:

-   `reviewId`
-   `bookId`
-   `authorId`
-   `userId`
-   `rating`
-   `comments`
-   `bookTitle`
-   `authorName`
-   `authorLastName`
-   `userAlias`

RETURNS:

-   **200**: `[{"id":<int>,"bookId":<int>,"userId":<int?>,"rating":<string>,"comments":<string>,"bookTile":<string>,"authorName":<string>,"authorLastName":<string>,"userAlias":<string?>}]`
-   **204**: `null`
-   **400**: `<error message>`

### Filtered by

> No aplica un comportamiento por defecto

URL: `GET /web2_tpe_api/reviews/:bookId?filterCriteria=<enum>&filterValue=<any>`
> Ej: `/web2_tpe_api/reviews/1?filterCriteria=authorId&filterValue=co`

`filterCriteria` valores posibles:

-   `reviewId`
-   `bookId`
-   `authorId`
-   `userId`
-   `rating`
-   `comments`
-   `bookTitle`
-   `authorName`
-   `authorLastName`
-   `userAlias`

RETURNS:

-   **200**: `[{"id":<int>,"bookId":<int>,"userId":<int?>,"rating":<string>,"comments":<string>,"bookTile":<string>,"authorName":<string>,"authorLastName":<string>,"userAlias":<string?>}]`
-   **204**: `null`
-   **400**: `<error message>`

### Pagination

> Existe un paginado por defecto de los 100 primeros resultados segun el reviewId.

URL: `GET /web2_tpe_api/reviews/:bookId?amount=<integer?>&nPage=<integer?>`
> Ej: `/web2_tpe_api/reviews/1?amount=2&nPage=1`

RETURNS:

-   **200**: `[{"id":<int>,"bookId":<int>,"userId":<int?>,"rating":<string>,"comments":<string>,"bookTile":<string>,"authorName":<string>,"authorLastName":<string>,"userAlias":<string?>}]`
-   **204**: `null`

---

## Get by Id

URL: `GET /web2_tpe_api/review/:id`

RETURNS:

-   **200**: `{"id":<int>,"bookId":<int>,"userId":<int?>,"rating":<string>,"comments":<string>}`
-   **404**: `<error message>`

---

## Add one

URL: `POST /web2_tpe_api/review`

RECEIVES:
- CONTENT-TYPE: `application/json`

- BODY:
  - `comment`: varchar(280) NOT NULL
  - `rating`: enum('1','2','3','4','5') NOT NULL
  - `bookId`: int(11) NOT NULL
  - `userId`: int(11) NOT NULL

RETURNS:

-   **201**: `{"id":<int>,"bookId":<int>,"userId":<int?>,"rating":<string>,"comments":<string>}`
-   **400**: `<error message>`

---

## Delete one

URL: `DELETE /web2_tpe_api/review/:id`

RETURNS:

-   **200**: `"DELETED"`
-   **404**: `<error message>`
