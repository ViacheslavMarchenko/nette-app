# Nubium test - nette app
V aplikaci implementovano několik typů entyt:
- [x] užívatelé
- [x] stránky
- [x] nastavení
- [x] soubory

Po spuštění dockeru se instalují php s doplňkama pro práce s soubory, mysql (několik tabulek a nějake defaultní data), phpmyadmin, nginx.

> Do projektu je nutné přídat složky temp a log
> 
> Projekt v Docker lze spustit ze složky .docker

## Užívatele
Do aplikace lse příhlasit jako administrator nebo jako běžný užívatel na hlavní stránce nebo na stránce /admin. Rozdil je v omezeni práva vídět určité typy entyt nebo omezeni jejích použití.

Administrator má full prava. Pro příhlašení použíjte email **admin@nubium-sandbox.test** a heslo **123**.

Běžný užívatel se příhlasi jako **user@nubium-sandbox.test** a heslo **123**

## Co umí
Pokud má uživatel plná práva, lze:
- přidávat, odebírat, upravovat nebo posouvat mezí sebou jpg souboty v záložce Soubory
- přidávat, odebírat, upravovat nebo posouvat mezí sebou stránký v záložce Stránky. Lze přídavat stránku jako oblíbenu a ta bude stále v horní části seznamu stránek
- přidávat, odebírat, upravovat užívatele, generovat nové hesla

Všude kromě Nastavení lze použit výhledávaní.

Běžný užívatel nevidí záložky Soubory a Nastavení, v záložce Užívatele vidí a upravuje pouze vlastní informace. Stránky muže davat do oblíbených be ohledu na výběr jiných užívatelů, nelzé je však ale odstranitt nebo přesunout.

## Ajax
Funkcionalita bez reloadu celé stránky:
- favorite pages
- posouvání entyt
- přejmenování souborů
- nahravání obrázku do konkrítní stránky
- generování hesel pro užívatele

## P.S.
Omlouvám se za svou češtinu 😊
