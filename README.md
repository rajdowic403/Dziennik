# 🎓 E-Dziennik (System Zarządzania Edukacją)

Projekt nowoczesnej aplikacji webowej pełniącej funkcję elektronicznego dziennika. Umożliwia zarządzanie planem zajęć, sprawdzanie frekwencji oraz podział użytkowników na odpowiednie role (Administrator, Nauczyciel, Uczeń).

🚧 **Status projektu: W trakcie rozwoju (Work in Progress - Faza 1)** 🚧

## 📑 Obecny etap projektu
Zbudowane fundamenty systemu, w tym bazę danych, system autoryzacji oraz interaktywny panel nauczyciela. 

**Zrealizowane funkcjonalności:**
- [x] Konfiguracja środowiska Laravel Sail (Docker) i React (Vite).
- [x] Zaawansowany system ról i uprawnień (Spatie Permissions).
- [x] Modele i relacje w bazie danych: Użytkownicy, Klasy (Grupy), Przedmioty, Lekcje, Frekwencja.
- [x] Interaktywny kalendarz planu zajęć dla Nauczyciela (FullCalendar + React).
- [x] Obsługa kliknięć w kalendarzu wyświetlająca szczegóły lekcji.
- [x] Moduł sprawdzania obecności (Backend/Blade) zintegrowany z kalendarzem React.
- [x] Generowanie realistycznych danych testowych (Seedery: Nauczyciele, Uczniowie, Grupy, Przedmioty).

---

## 🛠 Stos technologiczny
- **Backend:** Laravel 11/12 (PHP 8.x)
- **Frontend:** React.js, Tailwind CSS, Blade (widoki Laravel), FullCalendar
- **Baza danych:** MySQL
- **Środowisko:** Docker (Laravel Sail)

---

## 🚀 Wymagania systemowe
Programy potrzebne do uruchomienia projektu:
1. **Docker** oraz **Docker Desktop** (uruchomiony w tle).
2. **Git** (do pobrania repozytorium).
3. (Opcjonalnie) **PHP** i **Composer** zainstalowane lokalnie ułatwiają pierwszy start, ale nie są wymagane.

---

## ⚙️ Instalacja i uruchomienie

1. Pobierz repozytorium

```bash
git clone https://github.com/rajdowic403/Dziennik
cd dziennik
```
2. Skonfiguruj plik środowiskowy

```bash
cp .env.example .env
```
3. Zainstaluj zależności i uruchom środowisko

```bash
docker run --rm -v ${PWD}:/var/www/html -w /var/www/html laravelsail/php83-composer:latest composer install --ignore-platform-reqs
```

4. Uruchom kontenery w tle

```bash
docker compose up -d
```

5. Wygeneruj klucz aplikacji i zasil bazę danych

```bash
docker compose exec laravel.test php artisan key:generate
docker compose exec laravel.test php artisan migrate:fresh --seed
```

6. Zainstaluj i uruchom frontend

```bash
docker compose exec laravel.test npm install
docker compose exec laravel.test npm run dev
```

