Zentlix Block Bundle
=================

This bundle is part of Zentlix CMS. Currently in development, please do not use in production!

## Установка
- Установить Zentlix CMS https://github.com/zentlix/MainBundle 
- Установить BlockBundle:
```bash
    composer require zentlix/block-bundle
```
- Создать миграцию:
```bash 
    php bin/console doctrine:migrations:diff
```
- Выполнить миграцию: 
```bash 
    php bin/console doctrine:migrations:migrate
```
- Выполнить установку бандла:
```bash 
    php bin/console zentlix_main:install zentlix/block-bundle
```

## Использование

- Создать текстовый блок в административной панели, скопировать "Символьный код".
- В шаблоне сайта разместить виджет:
```twig
    {{ blockWidget('symbol_code') }}
```