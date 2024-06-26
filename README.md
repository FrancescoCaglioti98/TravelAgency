# TravelAgency API

Serie di API per un'agenzia di viaggi.

Al momento di scrittura di questo documento sono presenti 2 punti api principali

 - `api/v1/travels` => Restituisce tutti i viaggi pubblicati con paginazione
 - `api/v1/travels/{travelSlug}/tours` => Tutti i tour creati in base a quei Viaggi


La struttura principale dei modelli prevede queste entità:

 - Ruoli Utente
 - Tour
 - Viaggi
 - Utenti

Tutti i modelli sono dotati di UUID gestito direttamente attraverso Laravel.

Ho creato degli UnitTest per gestire Tour e Travels, sono azionabili attraverso il comando `php artisan test` e sono consultabili alla cartella `test/Feature`

È stato creato un comando custom per la generazione di un qualsiasi utente da riga di comando: `php artisan users:create`\
Alla generazione verranno chieste alcune informazioni:
 - Nome
 - Email
 - Password
 - Ruolo

In alternativa, nella fase di migrazione basta aggiungere il parametro `--seed` per permettere la creazione dei ruoli basici e di un primo utente ADMIN.\
Questo utente admin avrà:
- email => admin@admin.com
- password => password

In allegato le richieste che ho seguito per basarmi sulla realizzazione di questi punti API:


## Laravel hiring test

Create a Laravel APIs application for a travel agency.

### Glossary
Travel is the main unit of the project: it contains all the necessary information,
like the number of days, the images, title, etc.
An example is:
 - Japan: road to Wonder
 - Norway: the land of the ICE;

Tour is a specific dates-range of a travel with its own price and details.\
Japan: road to Wonder may have a tour from 10 to 27 May at €1899, another one from 10 to 15 September at €669 etc. At the end, you will book a tour, not a travel.


### Goals
At the end, the project should have:
 - A private (admin) endpoint to create new users. If you want, this could also be an artisan command, as you like. It will mainly be used to generate users for this exercise;
 - A private (admin) endpoint to create new travels;
 - A private (admin) endpoint to create new tours for a travel;
 - A private (editor) endpoint to update a travel;
 - A public (no auth) endpoint to get a list of paginated travels. It must return only public travels;
 - A public (no auth) endpoint to get a list of paginated tours by the travel slug (e.g. all the tours of the travel foo-bar). Users can filter (search) the results by priceFrom, priceTo, dateFrom (from that startingDate) and dateTo (until that startingDate). User can sort the list by price asc and desc. They will always be sorted, after every additional user-provided filter, by startingDate asc.


#### Models
 - Users
   - ID
   - Email
   - Password
   - Roles (M2M relationship)
   - Roles
   - ID
   - Name
- Travels
  - ID
  - Is Public (bool)
  - Slug
  - Name
  - Description
  - Number of days
  - Number of nights (virtual, computed by numberOfDays - 1)
- Tours
  - ID
  - Travel ID (M2O relationship)
  - Name
  - Starting date
  - Ending date
  - Price (integer, see below)
  - Notes

Feel free to use the native Laravel authentication.\
We use UUIDs as primary keys instead of incremental IDs, but it's not required for you to use them,
although highly appreciated;\

 - Tours prices are integer multiplied by 100:\
    for example, €999 euro will be 99900, but, when returned to Frontends, they will be formatted (99900 / 100);
 - Tours names inside the samples are a kind-of what we use internally, but you can use whatever you want;
 - Every admin user will also have the editor role;
   - Every creation endpoint, of course, should create one and only one resource.\
    You can't, for example, send an array of resource to create;
 - Usage of php-cs-fixer and larastan are a plus;
 - Creating docs is big plus;
 - Feature tests are a big big plus.


---
Tutti i messaggi di commit sono generati grazie a:\
https://whatthecommit.com/
