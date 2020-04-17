php artisan migrate
php artisan passport:install
php artisan package:enable Zento_Kernel
php artisan package:enable Zento_RouteAndRewriter
php artisan package:enable Zento_Backend
php artisan package:enable Zento_Passport
php artisan package:enable Zento_Catalog
php artisan package:enable Zento_Customer
php artisan package:enable Zento_BladeTheme
php artisan package:enable Zento_HelloSns
php artisan package:enable Zento_CatalogSearch
php artisan package:enable Zento_Checkout
php artisan package:enable Zento_PaymentGateway
php artisan package:enable Zento_Shipment
php artisan package:enable Zento_FreeShipping
php artisan package:enable Zento_StoreFront
php artisan package:enable Zento_ShoppingCart
php artisan package:enable Zento_Sales
php artisan package:enable Zento_Acl
php artisan package:enable Zento_SalesAdmin
php artisan package:enable Zento_DownloadableProduct
php artisan package:enable Zento_ConfigurableProduct
php artisan package:enable Zento_VueTheme


 [WARNING] [Zento_EWayPayment] not actived.

 [WARNING] [Zento_PaypalPayment] not actived.

php artisan vendor:publish --tag=Zento
