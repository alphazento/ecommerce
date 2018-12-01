composer require laravel/passport
php artisan migrate
php artisan passport:install

php artisan package:enable Zento_Kernel
php artisan vendor:publish --tag=Zento

php artisan package:enable Zento_ThemeManager
php artisan package:enable Zento_RouteAndRewriter
php artisan package:enable Zento_Catalog
php artisan package:enable Zento_Passport
php artisan package:enable Zento_Catalog
php artisan package:enable Zento_Customer
php artisan package:enable Zento_ShoppingCart
php artisan package:enable Zento_Checkout
php artisan package:enable Zento_Shipment
php artisan package:enable Zento_Sales
php artisan package:enable Zento_FreeShipping