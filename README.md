# TTMS-0900-Harkka

14.08.2020<br />
Oskari Saarinen N8243<br />
TTMS-0900 Web-palvelinohjelmointi - Harjoitustyö<br />

Toimiva sovellus löytyy täältä: https:// saario.xyz /gallery (Tulossa)

Kaikki lähdekoodit (myös automaattisesti luodut) zipattuna: https://saario.xyz/gallery/all.zip

Videoesittely: https://youtu.be/bdJ38PdB-qY

## Kuvaus
### Mitä:
Laravelin avulla toteutettu kuvagalleria. Sovelluksessa voi annettujen käyttöoikeuksien
mukaan etsiä/selata, ladata uusia kuvia ja luoda albumeita.

### Miksi:
Harrastan valokuvaamista ja minulla on kuvia myynnissä muutamissa kuvatoimistoissa, kuten
suomalaisessa Vastavalossa (https://www.vastavalo.net/profile.php?uid=12079&lim=32). Halusin
siksi tehdä oman kuvagallerian verkkosivuilleni ja tämä kurssi antoi siihen tilaisuuden.

### Toiminta:
Etusivulla näkyy kaikki albumit, joita klikkaamalla aukeaa sivu jolla näkyy kaikki albumin kuvat.
Kuvia klikkaamalla aukeaa kuvaesitys jossa voi selata nuolella albumin kuvia (tai kuvahaun tuloksia).

<strong>Sovelluksessa on 3 käyttäjä roolia:</strong><br />
<strong>Admin</strong> - Kaikki oikeudet<br />
<strong>Manager</strong> - Voi ladata uusia kuvia galleriaan<br />
<strong>User</strong> - "Asiakas", tarkoituksena oli luoda toivelista sekä ostettujen kuvien lataussivu, mutta näitä ominaisuuksia en ehtinyt tehdä<br />

Kuvia voi selata ja kuvakohtaisiin hakusanoihin perustuvaa kuvahakua voi käyttää myös kirjautumatta sivustolle.

<strong>Kuva valmiista sivusta</strong>:

![valmis](readme-images/valmis.png)

## Tietokanta

### Migrations:

#### Käyttäjät
`users`:

![migration_users](readme-images/migration_users.png)

#### Roolit
`add_role`:

![migration_add_role](readme-images/migration_add_role.png)

#### Users
Valmis `users` table:

![cli_users](readme-images/cli_users.png)

#### Albumit
`albums`:

![migration_albums](readme-images/migration_albums.png)

#### Kuvat
`images`:

![migration_images](readme-images/migration_images.png)

### Data Models:

#### Album
`Album`:

![model_album](readme-images/model_album.png)

#### Kuva
`Image`:

![model_image](readme-images/model_image.png)

## Rakenne
### Näkymät ja Reitit
Päänäkymä muodostuu `layouts/app.blade.php` -tiedostosta johon muiden sivujen data lisätään.

Päänäkymä tarvitsee Albumien tiedot, joten sitä varten on `composer` funktio niiden hakemiseen automaattisesti:

`AppServiceProvider.php`:

![AppServiceProvider](readme-images/AppServiceProvider.png)

Sivusto käyttää Bootstrap kirjastoa ulkoasun ja käytettävyyden parantamiseksi.

`web.php` Reitit:

![Routes](readme-images/routes.png)

#### Index:
Etusivu, joka sisältää listan kaikista albumeista.
 
#### Album:
`/album/{id}`, jossa id on albumin id.<br />
Sisältää albumin kuvat jaettuna max. 32 kuvaan per sivu.
  
#### Kuvahaku:
`/search?sword=hakusana`<br />
Sisältää kuvahaun tulokset (jos hakusanaa ei ole syötetty, näytetään kaikki kuvat).

#### Uusi albumi:
`/createalbum`<br />
Lomake jolla voi luoda uuden albumin
 
#### Albumin muokkaus:
`/editalbum/{id}`, jossa id on albumin id<br />
Sisältää albumin tietojen muokkauslomakkeen (En ehtinyt tehdä loppuun)

#### Albumin poistaminen:
`/deletealbum/{id}`, jossa id on albumin id<br />
Albumin poistaminen (vaatii Admin-oikeudet)

#### Kuvan lisäys:
`/addimage`<br />
Sisältää kuvan latauslomakkeen

#### Kuvan siirto toiseen albumiin:
`/moveimage`<br />
POST-request jolla kuvan voi siirtää toiseen albumiin

#### Kuvan poistaminen:
`/deleteimage/{id}`, jossa id on kuvan id

...

## Koodin toiminta
### Kuvien käsittely:
Kuvien käsittelyyn käytetään kirjastoa: Intervention/Image

Sen voi asentaa komennolla: `composer require intervention/image`

Tarkemmat asennusohjeet ja dokumentaatio löytyy täältä: http://image.intervention.io/getting_started/installation

#### ImagesController
Ladatut kuvat pienennetään ja niihin lisätään vesileima. Kuvista myös tallennetaan EXIF ja IPTC metada jos sellaiset löytyy.
Alla olevassa kuvassa koodi jolla tämä toteutetaan:

![intervention_image](readme-images/intervention_image.png)

#### AlbumsController
Myös albumien kuvakkeet pienennetään, mutta niihin ei lisätä vesileimaa, eikä niiden metadataa tarvita:

![intervention_album](readme-images/intervention_album.png)

### Roolit

#### AuthServiceProvider.php
Gates

![intervention_album](readme-images/AuthServiceProvider.png)

#### HasRoleMiddleware.php
Käyttäjän oikeuksien tarkistus

![intervention_album](readme-images/HasRoleMiddleware.png)

#### User.php
User

![intervention_album](readme-images/User.png)
 
## Itsearvio
Ehdotan työn arvosanaksi 5. Työ on laaja ja sisältää paljon eri tekniikoita, kuten `PHP`, `Laravel`, `MySQL`, `HTML`, `CSS`...
Työ sisältää paljon koodia. Käytin työhön aikaa kahden viikon aikana arviolta ~40-50h. Käytin päivästä riippuen ~2-10h/päivä.
En ehtinyt kaikkia haluamiani ominaisuuksia tehdä, mutta kaikki tärkeimmät kyllä. 

...


## Asennus
Asennus vaatii, että koneellesi on asennettu `composer`.

`composer.json` sisältää projektin vaatimukset.

Tee uusi Laravel-sovellus ja kopioi/korvaa lähdekoodit näillä:

`routes/web.php`<br />
`composer.json`<br />
`app/Http/Middleware/HasRoleMiddleware.php`<br />
`app/User.php`<br />
`app/Album.php`<br />
`app/Image.php`<br />
`app/Http/Kernel.php`<br />
`app/Providers/AuthServiceProvider.php`<br />
`app/Http/Controllers/AlbumsController.php`<br />
`app/Http/Controllers/ImagesController.php`<br />
`app/Providers/AppServiceProvider.php`<br />
`database/migrations/2020_08_02_125254_create_images_table.php`<br />
`database/migrations/2020_08_02_123639_create_albums_table.php`<br />
`database/migrations/2014_10_12_000000_create_users_table.php`<br />
`database/migrations/2020_07_31_174450_add_role_column_to_users_table.php`<br />
`resources/views/home.blade.php`<br />
`app/Http/Controllers/HomeController.php`<br />
`resources/views/auth/changepassword.blade.php`<br />
`resources/views/index.blade.php`<br />
`resources/views/createalbum.blade.php`<br />
`resources/views/album.blade.php`<br />
`resources/views/addimage.blade.php`<br />
`resources/views/addimagefree.blade.php`<br />
`resources/views/search.blade.php`<br />
`resources/views/layouts/app.blade.php`<br />
`public/js/main.js`

HUOM! Jokin tiedosto saattaa puuttua tästä listasta!

### Tietokannan asennus
Luotuasi uuden Laravel-sovelluksen ja kopioituasi/korvattuasi lähdekoodit, aja komento `php artisan migrate`

Tämä ajaa Migrations komennot ja luo tietokantaan tarvittavat. HUOM! Muista muuttaa tietokantasi nimi ja tunnukset!

Tarkempia ohjeita löytyy täältä: https://laravel.com

## License

This Laravel app is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).


