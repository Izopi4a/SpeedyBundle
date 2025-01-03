# SpeedyBundle

in development

# install
```shell
composer require izopi4a/speedy-bundle
```


# Speedy.bg
Documentation of the API can be found here: https://api.speedy.bg/web-api.html

# post install
```shell
#add this to your env
IZOPI4A_SPEEDY_USER=123456789
IZOPI4A_SPEEDY_PASS=
IZOPI4A_SPEEDY_LOCALE=BG
```

```php
$res = $speedyService->quickDeliveryCalc(151, true, 1, 1, 200);
dd($res);

$res = $speedyService->findOffice(151);
dd($res);


$res = $speedyService->findCity("A");
dd($res);

```