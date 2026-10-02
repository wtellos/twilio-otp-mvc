# Twilio OTP Auth (Native PHP)

A minimal, framework-free PHP app demonstrating **passwordless authentication
via SMS one-time passcodes** using [Twilio Verify](https://www.twilio.com/verify).

Register with first name, last name, email, and phone. Twilio sends a 6-digit
code by SMS. Enter the code, and you're logged in. No passwords, ever.

Built as a small MVC skeleton (router → controller → model → view) with PDO +
SQLite, Composer for dependencies, and Dotenv for configuration.

---

## Features

- Phone-first registration and login (no passwords)
- OTP delivery and verification via Twilio Verify
- SQLite storage, zero setup
- Simple front-controller MVC layout
- Session + cookie based auth
- Dark-mode UIKit frontend

---

## Prerequisites

- **PHP 8.1+** with the `pdo_sqlite` extension enabled
- **Composer**
- A **Twilio account** — sign up at https://www.twilio.com/try-twilio
- A **Twilio Verify Service** (created in the console — see below)
- Ability to receive SMS on the phone number you test with
  (Twilio trial accounts can only send to verified numbers — see Notes)

---

## Getting the Twilio credentials

You need three values. Grab them before continuing:

| Env var | Where to find it |
|---|---|
| `TWILIO_ACCOUNT_SID` | Twilio Console → Account Info (starts with `AC...`) |
| `TWILIO_TOKEN` | Twilio Console → Account Info → Auth Token (click to reveal) |
| `TWILIO_VERIFY_SID` | Twilio Console → Verify → Services → your service's SID (starts with `VA...`) |

If you don't have a Verify Service yet:

1. Console → **Verify** → **Services** → **Create Service**
2. Give it a name (e.g. "My App OTP"), keep the defaults
3. Copy the **Service SID** (`VA...`) — that's your `TWILIO_VERIFY_SID`

> ⚠️ Trial accounts can only send SMS to numbers you've verified in the Twilio
> console (Phone Numbers → Verified Caller IDs). Add your test number there
> first, or OTPs will silently fail to arrive.

---

## Installation

Clone the repo and install dependencies:

```bash
git clone https://github.com/<you>/<repo>.git
cd <repo>

composer install
```

### Create the storage folder if it doesn't exist

The app writes its SQLite database into `storage/`. Create the folder once:

```bash
mkdir -p storage
```

On Windows (cmd or PowerShell):

```powershell
mkdir storage
```

You don't need to create the database file itself — it's created automatically
on the first request. Just make sure the folder exists and is writable.

### Create `.env.example` in the repo with the same keys but placeholder values

Commit this file so anyone cloning the repo knows which variables to set. Then
each user copies it to `.env` and fills in their own values:

`.env.example`:

```
TWILIO_ACCOUNT_SID=ACxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
TWILIO_TOKEN=your_auth_token_here
TWILIO_VERIFY_SID=VAxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
```

Then, locally:

```bash
cp .env.example .env
# Edit .env and fill in the three Twilio values
```

> `.env` is gitignored and must never be committed. If it ever is, rotate the
> Twilio Auth Token in the console immediately.

---

## Running the app

Start the built-in PHP server with `public/` as the document root:

```bash
php -S localhost:8000 -t public
```

Then open:

```
http://localhost:8000/register
```

The SQLite database is created automatically on first request at
`storage/database.sqlite`. Delete that file any time to reset the schema and
wipe all users.

---

## How to use

1. **Register** — go to `/register` and fill in first name, last name, email,
   and phone (E.164 format, e.g. `+1234567890`).
2. **Receive OTP** — Twilio sends a 6-digit code to the phone number by SMS.
3. **Verify** — enter the code at `/verify`. On success, the user row is
   created and you're logged in.
4. **Dashboard** — you're redirected to `/dashboard`, which shows your
   authenticated phone number.
5. **Log out** — click **Log Out** to clear the session and cookie.

**Existing users** log in at `/login` by entering only their phone number —
no password required. The same OTP flow applies.

---

## Project structure

```
.
├── app/
│   ├── Config/Database.php        # PDO connection + schema bootstrap
│   ├── Controllers/               # AuthController, DashboardController
│   └── Models/User.php
├── public/
│   └── index.php                  # Front controller
├── routes/
│   └── web.php                    # Route table
├── storage/
│   └── database.sqlite            # Created on first run (gitignored)
├── views/
│   ├── partials/head.php, foot.php
│   ├── login.php, register.php, verify.php, dashboard.php
├── .env.example
└── composer.json
```

---

## Notes & known limitations

- **No CSRF protection.** Fine for local learning; add tokens before any real deployment.
- **No rate limiting.** Twilio has its own limits, but you should add per-phone throttling.
- **Sessions are in-memory/file-based** — not suitable for multi-server setups as-is.
- **The auth cookie is set but not validated** on subsequent requests in this demo;
  a real app would persist a token in the DB and check it on each request.
- **SQLite** is used for zero-setup convenience. Swap in MySQL/Postgres by changing
  the PDO DSN in `app/Config/Database.php`.
