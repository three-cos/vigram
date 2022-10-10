# Vigrom test project

### Установка
```bash
cp docker-compose.override.yml.dist docker-compose.override.yml

make up

make cli

composer install

php artisan key:generate

php artisan migrate --seed
```

#### Начислить деньги
```bash
curl --request POST \
  --url http://localhost:8000/api/wallet/transaction \
  --form wallet_id=1 \
  --form type=debit \
  --form amount=1 \
  --form currency=RUB \
  --form reason=stock
```

#### Снять деньги
```bash
curl --request POST \
  --url http://localhost:8000/api/wallet/transaction \
  --form wallet_id=1 \
  --form type=credit \
  --form amount=1 \
  --form currency=RUB \
  --form reason=refund
```

#### Проверить баланс
```bash
curl --request POST \
  --url http://localhost:8000/api/wallet \
  --form wallet_id=1
```

#### Проверить отозванные платежи за 7 дней
```bash
curl --request POST \
  --url http://localhost:8000/api/wallet/refunds \
  --form wallet_id=1
  --form days=7
```

### Тестирование
```bash
make test

// or

make cli
php artisan test
```