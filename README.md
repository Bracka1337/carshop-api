

# Project setup

## php part
```
composer install
```

### Migrate DB and create keys

```
php artisan migrate
php artisan key:generate
php artisan passport:client --personal
php artisan passport:keys
php artisan db:seed
```

### Run development

```
php artisan serve
```

## Tailwind part 

### install tailwind

```
npm i
```

### run dev (for development)

```
npm run dev
```

### run build (for prod)

```
npm run build
```
