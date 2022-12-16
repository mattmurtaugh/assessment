## Setup Changes

The only major change is that the DB needs seeded after installation.

First run:
```
php artisan db:seed
```

Once that is complete, run the seeding for the Journal
```
php artisan db:seed --class=JournalSeeder
```
