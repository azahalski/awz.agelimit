# AWZ: Возрастное ограничение (awz.agelimit)

### [Установка модуля](https://github.com/zahalski/awz.agelimit/tree/main/docs/install.md)

<!-- desc-start -->

## Описание
Модуль позволяет вывести окно подтверждения возраста как на обработчике OnEndBufferContent, так и вручную вызовом компонента.

**Поддерживаемые редакции CMS Битрикс:**<br>
«Старт», «Стандарт», «Малый бизнес», «Бизнес», «Корпоративный портал», «Энтерпрайз», «Интернет-магазин + CRM»

<!-- desc-end -->

## Документация
<!-- dev-start -->
### код вызова компонента

```php
//разместить в footerюзрз шаблона перед </body>
<?$APPLICATION->IncludeComponent("awz:window.agelimit",
".default",
    Array(
        "COMPONENT_TEMPLATE" => ".default"
    ),
    null, array("HIDE_ICONS"=>"Y")
);?>
```

<!-- dev-end -->


<!-- cl-start -->
## История версий

https://github.com/zahalski/awz.agelimit/blob/master/CHANGELOG.md

<!-- cl-end -->
