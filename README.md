# OpenPaycheck

This is a project which allows users to enter their salary information and get statistics of other salaries entered by others within a specified group.

The application is used as a web app. The user is able to enter their salary via the web page and view the results.


# Git ohjeet

# Git workflow

1. Varmista, että olet branchissa main. Jos et ole, mene sinne komennolla:
```
$ git checkout main
```
2. Varmista, että main-branchisi on ajan tasalla ottamalla pull:
```
$ git pull
```
3. Luo uusi lokaalibranchi, jonne teet muutoksen:
```
$ git checkout -b "branchin_nimi"
```
4. Tee muutos
  4.1. Lisää muutokset staging arealle commitointia varten:
  ```
  $ git add "tiedoston_nimi"
  ```
6. Tee lokaalicommit/committeja:
```
$ git commit -m "kuvaava_viesti"
```
6. Kun haluat puskea branchisi gittiin:
```
$ git push
```
Huom! Aina ensimmäisellä kerralla uudessa branchissa, joutuu käyttämään:
```
$ git push --set-upstream origin "branchin_nimi"
```
