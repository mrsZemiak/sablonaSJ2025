## 📌 Šablóna SJ 2025 – PHP Cvičenia - STÁLE AKTUÁLNE AJ PRE ROK 2026

Tento projekt slúži ako podklad pre cvičenia z predmetu Skriptovacie jazyky, kde sa študenti postupne učia nové funkcionality vrámci jazyka PHP.

### 📂 Štruktúra repozitára
Každá **branch** predstavuje jedno cvičenie. Obsahuje všetky zmeny a nové funkcionality, ktoré sa študenti počas hodiny naučili.

main – základná verzia projektu
feature-cviko-deň_v_týždni_dátum – konkrétna vetva z daného cvičenia podľa skupín


### 🛠️ Ako klonovať a spustiť repozitár pomocou Git?

1. **Klonovanie repozitára**  
   ```
   git clone https://github.com/mrsZemiak/sablonaSJ2025.git
   cd sablonaSJ2025
    ```
2. **Prepnutie na konkrétnu vetvu (cvičenie)**
```
git checkout feature-cviko-den_v_tyzdni-datum
```

### 🛠️ Ako klonovať a spustiť repozitár pomocou GitHub Desktop? 

Ak nechcete pracovať s terminálom, môžete si repozitár naklokovať cez **GitHub Desktop**:

1. Otvorte **GitHub Desktop**.  
2. Kliknite na **File > Clone repository...**.  
3. Vyberte **URL** a zadajte adresu repozitára:
   ```
   https://github.com/mrsZemiak/sablonaSJ2025.git
   ```
5. Zvoľte si priečinok, kam chcete repozitár uložiť -> nakoľko používame aplikáciu **XAMPP**, je vhodné si projekt uložiť na nasledujúcu cestu:
```
   C:\xampp\htdocs\sablonaSJ2025
```
6. Kliknite na **Clone**.  
8. Po dokončení klonovania si môžete prepínať jednotlivé vetvy (`branch`) cez **Current Branch -> Checkout branch**

---------------------------------------------------------------------------------------------------------------------
### Spustenie projektu cez XAMPP
Ak chcete projekt spustiť cez XAMPP, resp. nad Apache: 
```
Note: 
Apache je open-source webový server, ktorý sa používa na poskytovanie webových stránok cez internet. Pri práci s PHP je kľúčový, pretože:
- Prijíma požiadavky od prehliadača a odosiela späť vygenerované stránky
- Spúšťa PHP skripty a spracováva dynamický obsah
** 👉 Bez Apache by PHP skripty nefungovali v prehliadači **
```
1. Po nainštalovaní XAMPP aplikácie otvorte Control Panel a spustite Apache a MySQL. 
** Note: Repozitár musí byť uložený v priečinku `htdocs` **
2. Otvorte webový prehliadač a zadaj do adresného riadku:
```
http://localhost/sablonaSJ2025/index.php
```
----------------------------------------------------------------------------------------------------------------------

## 🔄 Čo je to Fork a ako ho použiť?

Fork je kópia repozitára, ktorú si môžete vytvoriť vo svojom vlastnom GitHub účte. Umožňuje nám robiť zmeny bez ovplyvnenia pôvodného repozitára.

Fork sa používa napríklad na:
✅ Experimentovanie so zmenami bez rizika poškodenia originálneho kódu
✅ Návrh vylepšení a opráv chýb, ktoré môžeš neskôr poslať do pôvodného repozitára
✅ Prácu na open-source projektoch

Ak chcete pracovať so svojou vlastnou kópiou repozitára, môžete si ho forknúť:

1. Kliknite na tlačidlo Fork v hornej časti GitHub stránky - > Vytvorí sa kópia repozitára vo vašom účte
2. Naklonujte ju: 
```
git clone https://github.com/mrsZemiak/sablonaSJ2025.git
```
3. Následne môžete pracovať na tejto kópii

![duck](https://img.artpal.com/398651/693-24-4-4-9-18-2m.jpg)
