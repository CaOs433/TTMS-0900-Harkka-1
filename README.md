# TTMS-0900-Harkka

14.08.2020<br />
Oskari Saarinen N8243<br />
TTMS-0900 Web-palvelinohjelmointi - Harjoitustyö<br />

Toimiva sovellus löytyy täältä: https://saario.xyz/gallery

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

![valmis](readme-images/_.png)


## Tietokanta
...
### MySQL:
...:
<strong>...</strong>, joka sisältää ...
<strong>...</strong>, joka sisältää ...

![tietokanta](readme-images/_.png)

### Migrations:
...

### Data Models:
...

### PHP:
<strong>PHP-tiedostoja ...</strong>:

`_.php` - ...
(...)

`_.php` - ...
(...)

`_.php` - ...

`_.php` - ...


## Rakenne
### Näkymät ja Reitit
Päänäkymä muodostuu `layouts/app.blade.php` -tiedostosta johon muiden sivujen data lisätään.

![Blade](readme-images/App.png)

Sivustolla on seuraavat sivut:
#### Index:
Etusivu, joka sisältää listan kaikista albumeista.
 
#### Album:
`/album/{id}`, jossa id on albumin id.
Sisältää albumin kuvat jaettuna max. 32 kuvaan per sivu.
  
#### Kuvahaku:
`/search?sword=hakusana`
Sisältää kuvahaun tulokset (jos hakusanaa ei ole syötetty, näytetään kaikki kuvat).

#### Uusi albumi:
`/createalbum`
Lomake jolla voi luoda uuden albumin
 
#### Albumin muokkaus:
`/editalbum/{id}`, jossa id on albumin id
Sisältää albumin tietojen muokkauslomakkeen (En ehtinyt tehdä loppuun)

#### Albumin poistaminen:
`/deletealbum/{id}`, jossa id on albumin id
Albumin poistaminen (vaatii Admin-oikeudet)

#### Kuvan lisäys:
`/addimage`
Sisältää kuvan latauslomakkeen

#### Kuvan siirto toiseen albumiin:
`/moveimage`
POST-request jolla kuvan voi siirtää toiseen albumiin

#### Kuvan poistaminen:
`/deleteimage/{id}`, jossa id on kuvan id

#### ...:
`...`
Sisältää

#### ...:
`...`
Sisältää

#### ...:
`...`
Sisältää

## Koodin toiminta
### Datan haku:
Data ...

![...](readme-images/_.png)

...

![...](readme-images/_.png)

### Kuvien käsittely:
Kuvien käsittelyyn käytetään kirjastoa: Intervention/Image

Sen voi asentaa komennolla: `composer require intervention/image`

Tarkemmat asennusohjeet ja dokumentaatio löytyy täältä: http://image.intervention.io/getting_started/installation

![...](readme-images/_.png)

...

![...](readme-images/_.png)
 
 
## Itsearvio
Ehdotan työn arvosanaksi 5. Työ on laaja ja sisältää paljon eri tekniikoita, kuten `PHP`, `Laravel`, `MySQL`, `HTML`, `CSS`...
Työ sisältää paljon koodia. Käytin työhön aikaa kahden viikon aikana arviolta ~40-50h. Käytin päivästä riippuen ~2-10h/päivä.
En ehtinyt kaikkia haluamiani omianisuuksia tehdä, mutta kaikki tärkeimmät kyllä. 

...


## Asennus
Manuaalinen asennus vaatii, että koneellesi on asennettu `...`.

...

### Manuaalinen asennus:
Tee uusi `Laravel`-sovellus komennolla `...`

Kopioi kansion `...` sisältö edellä luomasi sovelluksen kansioon `.../...`

Asenna `...` komennolla `...`

Käynnistä kehityspalvelin siirtymällä kansioon `cd app-name` ajamalla komento `...`

...

### Tietokannan asennus
...

Tietokannan luonti tiedosto on `init.sql`

...

...



















<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
