webpackJsonp(["main"],{

/***/ "./src/$$_lazy_route_resource lazy recursive":
/***/ (function(module, exports, __webpack_require__) {

var map = {
	"Admin/dashboard/dashboard.module": [
		"./src/app/Admin/ngx/dashboard/dashboard.module.ts",
		"dashboard.module"
	],
	"Admin/layout/layout.module": [
		"./src/app/Admin/ngx/layout/layout.module.ts",
		"common",
		"layout.module"
	],
	"Admin/login/login.module": [
		"./src/app/Admin/ngx/login/login.module.ts",
		"login.module"
	],
	"Admin/not-found/not-found.module": [
		"./src/app/Admin/ngx/not-found/not-found.module.ts",
		"not-found.module"
	],
	"Admin/pages/configuration/nav/configuration.nav.module": [
		"./src/app/Admin/ngx/pages/configuration/nav/configuration.nav.module.ts",
		"common",
		"configuration.nav.module"
	],
	"Admin/pages/store/general/general.module": [
		"./src/app/Admin/ngx/pages/store/general/general.module.ts",
		"general.module"
	],
	"Admin/pages/store/payment/payment.module": [
		"./src/app/Admin/ngx/pages/store/payment/payment.module.ts",
		"payment.module"
	],
	"Admin/signup/signup.module": [
		"./src/app/Admin/ngx/signup/signup.module.ts",
		"signup.module"
	]
};
function webpackAsyncContext(req) {
	var ids = map[req];
	if(!ids)
		return Promise.reject(new Error("Cannot find module '" + req + "'."));
	return Promise.all(ids.slice(1).map(__webpack_require__.e)).then(function() {
		return __webpack_require__(ids[0]);
	});
};
webpackAsyncContext.keys = function webpackAsyncContextKeys() {
	return Object.keys(map);
};
webpackAsyncContext.id = "./src/$$_lazy_route_resource lazy recursive";
module.exports = webpackAsyncContext;

/***/ }),

/***/ "./src/app/Admin/ngx/app-routing.module.ts":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
Object.defineProperty(exports, "__esModule", { value: true });
var core_1 = __webpack_require__("./node_modules/@angular/core/esm5/core.js");
var router_1 = __webpack_require__("./node_modules/@angular/router/esm5/router.js");
var assembly_1 = __webpack_require__("./src/app/Admin/ngx/assembly.ts");
var shared_1 = __webpack_require__("./src/app/Admin/ngx/shared/index.ts");
var AppRoutingModule = (function () {
    function AppRoutingModule() {
    }
    AppRoutingModule = __decorate([
        core_1.NgModule({
            imports: [router_1.RouterModule.forRoot(assembly_1.ROOTROUTES)],
            exports: [router_1.RouterModule],
            providers: [shared_1.AuthGuard]
        })
    ], AppRoutingModule);
    return AppRoutingModule;
}());
exports.AppRoutingModule = AppRoutingModule;


/***/ }),

/***/ "./src/app/Admin/ngx/app.component.html":
/***/ (function(module, exports) {

module.exports = "<router-outlet></router-outlet>\n"

/***/ }),

/***/ "./src/app/Admin/ngx/app.component.scss":
/***/ (function(module, exports) {

module.exports = ":host .fa-chevron-circle-icon {\n  color: #ffeb00;\n  font-size: 25px; }\n"

/***/ }),

/***/ "./src/app/Admin/ngx/app.component.ts":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
Object.defineProperty(exports, "__esModule", { value: true });
var core_1 = __webpack_require__("./node_modules/@angular/core/esm5/core.js");
var core_2 = __webpack_require__("./node_modules/@ngx-translate/core/index.js");
var _ngxsuit_1 = __webpack_require__("./src/app/common/index.ts");
var AppComponent = (function () {
    function AppComponent(translate, mq, elementRef, gv) {
        this.translate = translate;
        this.mq = mq;
        this.elementRef = elementRef;
        this.gv = gv;
        // this.fetchGlobalVars(elementRef);
        this.gv.initGlobalVarsFromRootElement(elementRef);
        localStorage.setItem("authToken", this.gv.get('token'));
        this.initTranslate(translate);
    }
    AppComponent.prototype.initTranslate = function (translate) {
        translate.addLangs(['en', 'fr', 'ur']);
        translate.setDefaultLang('en');
        var browserLang = translate.getBrowserLang();
        translate.use(browserLang.match(/en|fr|ur/) ? browserLang : 'en');
    };
    AppComponent = __decorate([
        core_1.Component({
            selector: 'app-root',
            template: __webpack_require__("./src/app/Admin/ngx/app.component.html"),
            styles: [__webpack_require__("./src/app/Admin/ngx/app.component.scss")],
            providers: []
        }),
        __metadata("design:paramtypes", [core_2.TranslateService, _ngxsuit_1.MQService, core_1.ElementRef, _ngxsuit_1.GlobalVarService])
    ], AppComponent);
    return AppComponent;
}());
exports.AppComponent = AppComponent;


/***/ }),

/***/ "./src/app/Admin/ngx/app.module.ts":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
Object.defineProperty(exports, "__esModule", { value: true });
var http_1 = __webpack_require__("./node_modules/@angular/common/esm5/http.js");
var platform_browser_1 = __webpack_require__("./node_modules/@angular/platform-browser/esm5/platform-browser.js");
var http_2 = __webpack_require__("./node_modules/@angular/http/esm5/http.js");
var http_3 = __webpack_require__("./node_modules/@angular/common/esm5/http.js");
var core_1 = __webpack_require__("./node_modules/@angular/core/esm5/core.js");
var forms_1 = __webpack_require__("./node_modules/@angular/forms/esm5/forms.js");
var core_2 = __webpack_require__("./node_modules/@ngx-translate/core/index.js");
// import { TranslateHttpLoader } from '@ngx-translate/http-loader';
var app_routing_module_1 = __webpack_require__("./src/app/Admin/ngx/app-routing.module.ts");
var app_component_1 = __webpack_require__("./src/app/Admin/ngx/app.component.ts");
var shared_1 = __webpack_require__("./src/app/Admin/ngx/shared/index.ts");
var _ngxsuit_1 = __webpack_require__("./src/app/common/index.ts");
var ui_schema_service_1 = __webpack_require__("./src/app/Admin/ngx/services/ui.schema.service.ts");
// import { LoaderLayerComponent, DefaultValuePipe, SafeHtmlPipe, AssetsPipe } from '@ngxsuit';
var TranslateHttpLoader = (function () {
    function TranslateHttpLoader(http, gv, prefix, suffix) {
        if (prefix === void 0) { prefix = "/i18n/"; }
        if (suffix === void 0) { suffix = ".json"; }
        this.http = http;
        this.gv = gv;
        this.prefix = prefix;
        this.suffix = suffix;
    }
    TranslateHttpLoader.prototype.getTranslation = function (lang) {
        var url_prefix = this.gv.getString('assets');
        return this.http.get("" + url_prefix + this.prefix + lang + this.suffix);
    };
    return TranslateHttpLoader;
}());
// AoT requires an exported function for factories
function HttpLoaderFactory(http, gv) {
    return new TranslateHttpLoader(http, gv);
}
exports.HttpLoaderFactory = HttpLoaderFactory;
var AppModule = (function () {
    function AppModule() {
    }
    AppModule = __decorate([
        core_1.NgModule({
            declarations: [
                app_component_1.AppComponent
            ],
            imports: [
                platform_browser_1.BrowserModule,
                forms_1.FormsModule,
                http_3.HttpClientModule,
                http_2.HttpModule,
                app_routing_module_1.AppRoutingModule,
                core_2.TranslateModule.forRoot({
                    loader: {
                        provide: core_2.TranslateLoader,
                        useFactory: HttpLoaderFactory,
                        deps: [http_1.HttpClient, _ngxsuit_1.GlobalVarService]
                    }
                })
            ],
            providers: [
                shared_1.AuthGuard, _ngxsuit_1.HTTPCLIENT_AUTH_PLUGIN, _ngxsuit_1.MQService, _ngxsuit_1.GlobalVarService, _ngxsuit_1.WindowRef, _ngxsuit_1.LocaltimeService, ui_schema_service_1.UISchemaService
            ],
            bootstrap: [app_component_1.AppComponent]
        })
    ], AppModule);
    return AppModule;
}());
exports.AppModule = AppModule;


/***/ }),

/***/ "./src/app/Admin/ngx/assembly.ts":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

Object.defineProperty(exports, "__esModule", { value: true });
var layout_component_1 = __webpack_require__("./src/app/Admin/ngx/layout/layout.component.ts");
var shared_1 = __webpack_require__("./src/app/Admin/ngx/shared/index.ts");
exports.ROOTROUTES = [
    {
        path: '',
        loadChildren: 'Admin/layout/layout.module#LayoutModule',
        canActivate: [shared_1.AuthGuard]
    },
    { path: 'login', loadChildren: 'Admin/login/login.module#LoginModule' },
    { path: 'signup', loadChildren: 'Admin/signup/signup.module#SignupModule' },
    { path: 'not-found', loadChildren: 'Admin/not-found/not-found.module#NotFoundModule' },
    { path: '**', redirectTo: 'not-found' }
];
exports.MENUS = [
    { sort: 1, name: "dashboard", link: "/dashboard", image: "/images/home.png", title: "Dashboard" },
    { sort: 100, name: "store", link: "/store", image: "/images/home.png", title: "Store" },
    { sort: 130, parent: 'store', name: "store_general", link: "/store/general", title: "General" },
    { sort: 160, parent: 'store', name: "store_sale_rules", link: "/store/salerules", title: "Sale Rules" },
    { sort: 190, parent: 'store', name: "store_theme", link: "/store/theme", title: "Theme" },
    { sort: 192, parent: 'store', name: "store_payment", link: "/store/payment", title: "Payment" },
    { sort: 195, parent: 'store', name: "store_configuration", link: "/store/configuration", title: "Configuration" },
    { sort: 200, name: "system", link: "/system", title: "System" },
];
// export const PROVIDERS = [AuthGuard]
//import { LayoutComponent } from 'RootLayout/layout/layout.component';
exports.CHILDROUTES = [
    {
        path: '', component: layout_component_1.LayoutComponent,
        children: [
            {
                path: "dashboard",
                loadChildren: "Admin/dashboard/dashboard.module#DashboardModule"
            },
            { path: "store/general", loadChildren: "Admin/pages/store/general/general.module#GeneralModule" },
            { path: "store/payment", loadChildren: "Admin/pages/store/payment/payment.module#PaymentModule" },
            { path: "configuration/:name", loadChildren: "Admin/pages/configuration/nav/configuration.nav.module#ConfigurationNavModule" }
        ]
    }
];


/***/ }),

/***/ "./src/app/Admin/ngx/layout/layout.component.html":
/***/ (function(module, exports) {

module.exports = "<app-header></app-header>\n<app-sidebar></app-sidebar>\n<section class=\"main-container\">\n    <app-loader></app-loader>\n    <router-outlet></router-outlet>\n</section>"

/***/ }),

/***/ "./src/app/Admin/ngx/layout/layout.component.scss":
/***/ (function(module, exports) {

module.exports = ".main-container {\n  margin-top: 50px;\n  margin-left: 85px;\n  padding: 15px;\n  -ms-overflow-x: hidden;\n  overflow-x: hidden;\n  overflow-y: scroll; }\n\n@media screen and (max-width: 992px) {\n  .main-container {\n    margin-left: 0px !important; } }\n"

/***/ }),

/***/ "./src/app/Admin/ngx/layout/layout.component.ts":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
Object.defineProperty(exports, "__esModule", { value: true });
var core_1 = __webpack_require__("./node_modules/@angular/core/esm5/core.js");
var router_1 = __webpack_require__("./node_modules/@angular/router/esm5/router.js");
var LayoutComponent = (function () {
    function LayoutComponent(router) {
        this.router = router;
    }
    LayoutComponent.prototype.ngOnInit = function () {
        if (this.router.url === '/') {
            this.router.navigate(['/dashboard']);
        }
    };
    LayoutComponent = __decorate([
        core_1.Component({
            selector: 'app-layout',
            template: __webpack_require__("./src/app/Admin/ngx/layout/layout.component.html"),
            styles: [__webpack_require__("./src/app/Admin/ngx/layout/layout.component.scss")]
        }),
        __metadata("design:paramtypes", [router_1.Router])
    ], LayoutComponent);
    return LayoutComponent;
}());
exports.LayoutComponent = LayoutComponent;


/***/ }),

/***/ "./src/app/Admin/ngx/services/ui.schema.service.ts":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
Object.defineProperty(exports, "__esModule", { value: true });
var http_1 = __webpack_require__("./node_modules/@angular/common/esm5/http.js");
var core_1 = __webpack_require__("./node_modules/@angular/core/esm5/core.js");
var _ngxsuit_1 = __webpack_require__("./src/app/common/index.ts");
var _ngxsuit_2 = __webpack_require__("./src/app/common/index.ts");
var UISchemaService = (function () {
    function UISchemaService(mq, http, gv) {
        this.mq = mq;
        this.http = http;
        this.gv = gv;
        this.bSchemaLoaded = false;
        this.listeners = [];
        console.log('UISchemaService constructor');
        this.loadSchema();
    }
    UISchemaService.prototype.wait4UISchema = function (listener) {
        if (this.bSchemaLoaded) {
            this.mq.sendMessage(listener, { type: 'ui-schema-fetched', load: this.navitems });
        }
        else {
            this.listeners.push(listener);
        }
    };
    UISchemaService.prototype.loadSchema = function () {
        var _this = this;
        this.mq.sendMessage('app-loader', { type: "", load: { loading: true, tip: 'Loading UI schema...' } });
        this.http.get(this.gv.getString('admin_prefix') + '/rest/v1/admin/ui/schema').subscribe(function (data) {
            console.log(_this.navitems);
            _this.mq.sendMessage('app-loader', { type: "", load: { loading: false, tip: 'UI schema loaded.', delay: 1 } });
            _this.navitems = _ngxsuit_1.MLevelItemsParser([data]);
            _this.broadcast();
        }, function (error) {
            _this.mq.sendMessage('app-loader', { type: "", load: { loading: false, tip: 'UI schema loaded.', delay: 1 } });
            var data = [
                { "parent": "store_config", "name": "store_config_theme_abtest", "title": "Theme & ABTest" },
                { "parent": "store_config_theme_abtest", "name": "store_config_abtest", "title": "A\/B Test" },
                { "parent": "store_config_theme_abtest", "name": "store_config_theme", "title": "Theme" },
                { "parent": "store_config_theme", "name": "store_config_desktoptheme", "title": "Desktop Theme",
                    "items": [{ "name": "dtheme0", "title": "Enable AB Test", "cpath": "theme\/abtest\/desktop\/enable", "type": "boolean" },
                        { "name": "dtheme1", "title": "A(main)", "cpath": "theme\/desktop\/a", "type": "select", "options": ["MobileTheme", "Theme"] },
                        { "name": "dtheme2", "title": "B(test)", "cpath": "theme\/desktop\/b", "type": "select", "options": ["MobileTheme", "Theme"],
                            "depends": "theme\/abtest\/desktop\/enable" },
                        { "name": "dtheme3", "title": "Traffic To A Main(Percentage)",
                            "cpath": "theme\/abtest\/desktop\/abrate", "tip": "Please Input number between 0-100.", "type": "text", "depends": "theme\/abtest\/desktop\/enable" }] },
                { "parent": "store_config_theme", "name": "store_config_mobiletheme", "title": "Mobile Theme",
                    "items": [{ "name": "mtheme0", "title": "Enable AB Test", "cpath": "theme\/abtest\/mobile\/enable", "type": "boolean" },
                        { "name": "mtheme1", "title": "A(main)", "cpath": "theme\/mobile\/a", "type": "select", "options": ["MobileTheme", "Theme"] },
                        { "name": "mtheme2", "title": "B(test)", "cpath": "theme\/mobile\/b", "type": "select", "options": ["MobileTheme", "Theme"],
                            "depends": "theme\/abtest\/mobile\/enable" },
                        { "name": "mtheme3", "title": "Traffic To A Main(Percentage)", "cpath": "theme\/abtest\/mobile\/abrate",
                            "tip": "Please Input number between 0-100.", "type": "text", "depends": "theme\/abtest\/mobile\/enable" }] },
                { "parent": "store_config_theme", "name": "store_config_ipadtheme", "title": "iPad Theme",
                    "items": [{ "name": "ipadtheme0", "title": "Enable AB Test", "cpath": "theme\/abtest\/ipad\/enable", "type": "boolean" },
                        { "name": "ipadtheme1", "title": "A(main)", "cpath": "theme\/ipad\/a", "type": "select", "options": ["MobileTheme", "Theme"] },
                        { "name": "ipadtheme2", "title": "B(test)", "cpath": "theme\/ipad\/b", "type": "select", "options": ["MobileTheme", "Theme"],
                            "depends": "theme\/abtest\/ipad\/enable" }, { "name": "ipadtheme3", "title": "Traffic To A Main(Percentage)", "cpath": "theme\/abtest\/mobile\/abrate",
                            "tip": "Please Input number between 0-100.", "type": "text", "depends": "theme\/abtest\/ipad\/enable" }] },
                { "sort": 5, "is_menu": true, "name": "root_store", "title": "Store" },
                { "sort": 6, "is_menu": true, "parent": "root_store", "name": "store_config", "title": "Configuration", "link": "\/configuration\/store" },
                { "sort": 20, "parent": "store_config", "name": "store_config_general", "title": "General" },
                { "sort": 20, "parent": "store_config_general", "name": "store_config_general_store", "title": "Store" },
                { "parent": "store_config_general_store", "name": "store_config_general_store_options", "title": "Business Detail",
                    "items": [{ "name": "title", "title": "Business Name", "cpath": "title", "type": "text" }, { "name": "abn", "title": "ABN", "cpath": "abn", "type": "text" },
                        { "name": "address", "title": "Contact Address", "cpath": "address", "type": "text" },
                        { "name": "copyright", "title": "Copyright", "cpath": "copyright", "type": "text" },
                        { "name": "hotline", "title": "Contact Phone Number", "cpath": "hotline", "type": "text" }] },
                { "sort": 21, "parent": "store_config_general", "name": "store_config_general_web", "title": "Web" },
                { "parent": "store_config_general_web", "name": "general_web_base_urls", "title": "Base Urls",
                    "items": [{ "name": "base_url", "title": "Base Url", "cpath": "web\/base_url", "type": "text" },
                        { "name": "static_base_url", "title": "Base URL for Static View Files", "cpath": "web\/static_base_url", "type": "text" }] },
                { "parent": "store_config_general_web", "name": "general_web_cookies", "title": "Default Cookie Settings",
                    "items": [{ "name": "web_cookie_lifetime", "title": "Cookie Lifetime", "cpath": "web\/cookies\/lifetime", "type": "text" },
                        { "name": "web_cookie_path", "title": "Cookie Path", "cpath": "web\/cookies\/path", "type": "text" }, { "name": "web_cookie_domain", "title": "Cookie Domain", "cpath": "web\/cookies\/domain", "type": "select", "options": ["*.", "www."] }, { "name": "web_cookie_http_only", "title": "Use Http Only", "cpath": "web\/cookies\/httponly", "type": "boolean" }] }, { "parent": "store_config_general_web", "name": "general_web_admin", "title": "Admin Portal", "items": [{ "name": "web_admin_url_prefix", "title": "Admin Portal Url Prefix", "cpath": "admin_url_prefix", "type": "text" }] }, { "parent": "store_config_general_web", "name": "general_web_catalog_imglib", "title": "Catalog Image Library", "items": [{ "name": "general_web_catalog_imglib1", "title": "Catalog Image Lib Path", "cpath": "catalog_image_lib", "type": "text" }] }, { "parent": "store_config_general_web", "name": "general_web_seo", "title": "Search Engine Optimization", "items": [{ "name": "general_web_seo_enable", "title": "Use Web Server Rewrites", "cpath": "web\/seo", "type": "boolean" }] }, { "parent": "store_config_sales_paymentmethods", "name": "cs_payments_ewaytp", "title": "eWay Rapid3.1", "items": [{ "name": "cs_payments_eway_mode", "title": "Mode", "cpath": "payment\/eway\/mode", "type": "select", "options": ["sandbox", "production"], "tip": "Please select Sandbox and Production Mode." }, { "name": "cs_payments_eway_sandbox", "title": "Sandbox API Setting", "items": [{ "name": "cs_payments_eway_sandbox_apikey", "title": "API Key", "cpath": "payment\/eway\/sandbox\/api_key", "type": "text", "tip": "The title will display on the frontend checkout page." }, { "name": "cs_payments_eway_sandbox_apisecret", "title": "API Secret", "cpath": "payment\/eway\/sandbox\/api_secret", "type": "text", "tip": "The title will display on the frontend checkout page." }, { "name": "cs_payments_eway_sandbox_accesscode_url", "title": "API Access Code URL", "cpath": "payment\/eway\/sandbox\/api_accesscode_url", "type": "text", "tip": "The URL that can retrieve AccessCode." }] }, { "name": "cs_payments_eway_production", "title": "Production API Setting", "items": [{ "name": "cs_payments_eway_production_apikey", "title": "API Key", "cpath": "payment\/eway\/production\/api_key", "type": "text", "tip": "Production API Key" }, { "name": "cs_payments_eway_production_apisecret", "title": "API Secret", "cpath": "payment\/eway\/production\/api_secret", "type": "text", "tip": "Production API Secret" }, { "name": "cs_payments_eway_production_accesscode_url", "title": "API Access Code URL", "cpath": "payment\/eway\/production\/api_accesscode_url", "type": "text", "tip": "The URL that can retrieve AccessCode." }] }, { "name": "cs_payments_ewaytp", "title": "eWay Transparent Pay Method", "items": [{ "name": "cs_payments_ewaytp_title", "title": "Title", "cpath": "payment\/ewaytp\/title", "type": "text", "tip": "The title will display on the frontend checkout page." }, { "name": "cs_payments_ewaytp_active", "title": "Enable this solution", "cpath": "payment\/ewaytp\/active", "type": "boolean", "tip": "Enable or Disable this payment method." }] }] }, { "sort": "3000", "parent": "store_config_sales", "name": "store_config_sales_paymentmethods", "title": "Payment Methods" }, { "parent": "store_config_sales_paymentmethods", "name": "config_sales_bank_transfer", "title": "Bank Transfer", "items": [{ "name": "store_config_bank_transfer_payment_title", "title": "Title", "cpath": "payment\/bank_transfer\/title", "type": "text", "tip": "The title will display on the frontend checkout page." }, { "name": "sconfig_bank_transfer_active", "title": "Active", "cpath": "payment\/bank_transfer\/active", "type": "boolean", "tip": "Enable or Disable this payment method." }, { "name": "sconfig_bank_transfer_bsb", "title": "BSB Number", "cpath": "payment\/bank_transfer\/bsbnumber", "type": "text" }, { "name": "sconfig_bank_transfer_account", "title": "Account", "cpath": "payment\/bank_transfer\/account", "type": "text" }, { "name": "sconfig_bank_transfer_accountname", "title": "Account Name", "cpath": "payment\/bank_transfer\/accountname", "type": "text" }, { "name": "sconfig_bank_transfer_bankname", "title": "Bank Name", "cpath": "payment\/bank_transfer\/bankname", "type": "text" }] }, { "sort": 121, "parent": "store_config", "name": "store_config_sales", "title": "Sales" }, { "sort": "2900", "parent": "store_config_sales", "name": "store_config_sales_general", "title": "General" }, { "is_menu": true, "name": "root_sales", "title": "Sales" }, { "is_menu": true, "name": "root_sales_orders", "parent": "root_sales", "title": "Orders", "link": "\/sales\/orders" }, { "is_menu": true, "name": "root_sales_orders", "parent": "root_sales", "title": "Invoices", "link": "\/sales\/invoices" }, { "is_menu": true, "name": "root_sales_credit_memos", "parent": "root_sales", "title": "Credit Memos", "link": "\/sales\/creditmemos" }, { "is_menu": true, "name": "root_sales_shipments", "parent": "root_sales", "title": "Shipments", "link": "\/sales\/shipments" }, { "is_menu": true, "name": "root_sales_billing_agreements", "parent": "root_sales", "title": "Billing Agreements", "link": "\/sales\/billing_agreements" }, { "is_menu": true, "name": "root_sales_Transactions", "parent": "root_sales", "title": "Transactions", "link": "\/sales\/transactions" }, { "parent": "store_config_sales_general", "name": "reorder", "title": "Re-Order", "items": [{ "name": "reorder1", "title": "Enable Reorder", "cpath": "sales\/reorder\/enable", "type": "boolean" }, { "name": "reorder2", "title": "Reorder Redirect To", "cpath": "sales\/reorder\/redirect_to", "type": "select", "options": ["cart", "checkout"], "tip": "Which page will be redirected to?" }, { "name": "reorder3", "title": "Reorder Action For Cart", "cpath": "sales\/reorder\/cart_action", "type": "select", "options": ["Merge", "Replace"], "tip": "Merge\/Replace To Current Cart" }] }, { "parent": "store_config_sales_paymentmethods", "name": "config_sales_paypalexpress", "title": "Paypal Express", "items": [{ "name": "config_paypalexpress_mode", "title": "Mode", "cpath": "payment\/paypalexpress\/mode", "type": "select", "options": ["sandbox", "production"], "tip": "Please select Sandbox and Production Mode." }, { "name": "config_paypalexpress_sandbox_clientid", "title": "Sandbox Client ID", "cpath": "payment\/paypalexpress\/sandbox\/clientid", "type": "text" }, { "name": "config_paypalexpress_production_clientid", "title": "Production Client ID", "cpath": "payment\/paypalexpress\/production\/clientid", "type": "text" }, { "name": "config_paypalexpress_title", "title": "Title", "cpath": "payment\/paypalexpress\/title", "type": "text", "tip": "The title will display on the frontend checkout page." }, { "name": "config_paypalexpress_active", "title": "Enable this solution", "cpath": "payment\/paypalexpress\/active", "type": "boolean", "tip": "Enable or Disable this payment method." }] }, { "parent": "store_config_general", "name": "store_config_general_socialite", "title": "Social Login" }, { "parent": "store_config_general_socialite", "name": "config_socialite_facebook", "title": "Facebook", "items": [{ "name": "config_socialite_facebook_i0", "title": "Enable Facebook Login", "type": "boolean", "cpath": "socialite\/enabled\/facebook" }, { "name": "config_socialite_facebook_i1", "title": "Client ID", "cpath": "socialite\/client\/id\/facebook", "type": "text" }, { "name": "config_socialite_facebook_i2", "title": "Client Secret", "cpath": "socialite\/client\/secret\/facebook", "type": "text" }] }, { "parent": "store_config_general_socialite", "name": "config_socialite_google", "title": "Google", "items": [{ "name": "config_socialite_goog_i0", "title": "Enable Google Login", "type": "boolean", "cpath": "socialite\/enabled\/google" }, { "name": "config_socialite_goog_i1", "title": "Client ID", "cpath": "socialite\/client\/id\/google", "type": "text" }, { "name": "config_socialite_goog_i2", "title": "Client Secret", "cpath": "socialite\/client\/secret\/google", "type": "text" }] }, { "sort": 2000, "parent": "store_config", "name": "store_config_email", "title": "Email Configuration" }, { "parent": "store_config_email", "name": "store_config_email_general", "title": "Email Sending" }, { "parent": "store_config_email_general", "name": "store_config_email_general_1", "title": "General", "items": [{ "name": "sc_email_general_use_queue", "title": "Send By Queue", "cpath": "email\/async_queue", "type": "boolean", "tip": "Send Email By Async Queue" }] }, { "parent": "store_config_email", "name": "store_config_email_sales", "title": "Sales Email" }, { "parent": "store_config_email_sales", "name": "s_c_salesemail_general", "title": "Sales Email General", "items": [{ "name": "s_c_salesemail_general_0", "title": "Send From Email", "cpath": "email\/sales\/from", "type": "text", "tip": "Send from Email." }, { "name": "s_c_salesemail_general_1", "title": "Send From Name", "cpath": "email\/sales\/from_name", "type": "text", "tip": "Send from Name." }, { "name": "s_c_salesemail_general_2", "title": "Reply to Email", "cpath": "email\/sales\/reply_to", "type": "text", "tip": "Reply to Email" }, { "name": "s_c_salesemail_general_3", "title": "Reply to Name", "cpath": "email\/sales\/reply_to_name", "type": "text", "tip": "Reply to Name" }, { "name": "s_c_salesemail_general_4", "title": "CC", "cpath": "email\/sales\/cc", "type": "text", "tip": "CC" }, { "name": "s_c_salesemail_general_5", "title": "BCC", "cpath": "email\/sales\/bcc", "type": "text", "tip": "BCC" }] }, { "parent": "store_config_email_sales", "name": "s_c_salesemail_placeorder_success", "title": "Place Order Success Email", "items": [{ "name": "scsp_success_using_mandrill", "title": "Using Mandrill Template", "cpath": "email\/placeorder\/success\/using_mandrill", "type": "boolean", "tip": "Using Mandrill Email Template" }, { "name": "scsp_success_mandrill_template", "title": "Mandrill Template", "cpath": "email\/placeorder\/success\/mandrill_template", "type": "select", "options": ["", "adminPwForgetEmail", "InvitedEmail", "orderEmail", "OrderPostTracking", "orderUpdateEmail", "pwForgetEmail", "welcomeEmail"], "tip": "Please input template name." }, { "name": "scsp_success_local_template", "title": "Local Template", "cpath": "email\/placeorder\/success\/local_template", "type": "select", "options": ["", "mail.newcustomer", "mail.orderplacedsuccess", "mail.recoverpassword"], "tip": "Please input template name." }, { "name": "scsp_success_subject", "title": "Subject", "cpath": "email\/placeorder\/success\/subject", "type": "text", "tip": "Please input subject." }] }, { "parent": "store_config_email_sales", "name": "s_c_salesemail_placeorder_fail", "title": "Place Order Fail Email", "items": [{ "name": "scsp_placeorder_fail_0", "title": "Send To Customer", "cpath": "email\/placeorder\/fail\/send_to_customer", "type": "boolean", "tip": "If enable, fail email will send to customer." }, { "name": "scsp_placeorder_fail_local_template", "title": "Local Template", "cpath": "email\/placeorder\/fail\/local_template", "type": "select", "options": ["", "mail.newcustomer", "mail.orderplacedsuccess", "mail.recoverpassword"], "tip": "Please input template name." }, { "name": "scsp_fail_subject", "title": "Subject", "cpath": "email\/placeorder\/fail\/subject", "type": "text", "tip": "Please input subject." }] }, { "parent": "store_config_email_sales", "name": "recoverpassword0", "title": "Recover Password Email", "items": [{ "name": "recoverpassword01", "title": "Using Mandrill Template", "cpath": "email\/recoverpassword\/using_mandrill", "type": "boolean", "tip": "Using Mandrill Email Template" }, { "name": "recoverpassword02", "title": "Mandrill Template", "cpath": "email\/recoverpassword\/mandrill_template", "type": "select", "options": ["", "adminPwForgetEmail", "InvitedEmail", "orderEmail", "OrderPostTracking", "orderUpdateEmail", "pwForgetEmail", "welcomeEmail"], "tip": "Please input template name." }, { "name": "recoverpassword1", "title": "Local Template", "cpath": "email\/recoverpassword\/local_template", "type": "select", "options": ["", "mail.newcustomer", "mail.orderplacedsuccess", "mail.recoverpassword"], "tip": "Please input template name." }, { "name": "recoverpassword2", "title": "Subject", "cpath": "email\/recoverpassword\/subject", "type": "text", "tip": "Please input subject." }] }, { "sort": 1, "is_menu": true, "name": "root_dashboard", "title": "Dashboard", "link": "\/bitbucket/manage", "image": "\/images\/home.png" }
            ];
            _this.navitems = _ngxsuit_1.MLevelItemsParser([data]);
            _this.broadcast();
        });
    };
    UISchemaService.prototype.broadcast = function () {
        this.bSchemaLoaded = true;
        for (var _i = 0, _a = this.listeners; _i < _a.length; _i++) {
            var listener = _a[_i];
            this.mq.sendMessage(listener, { type: 'ui-schema-fetched', load: this.navitems });
        }
        this.listeners = [];
    };
    UISchemaService = __decorate([
        core_1.Injectable(),
        __metadata("design:paramtypes", [_ngxsuit_1.MQService, http_1.HttpClient, _ngxsuit_2.GlobalVarService])
    ], UISchemaService);
    return UISchemaService;
}());
exports.UISchemaService = UISchemaService;


/***/ }),

/***/ "./src/app/Admin/ngx/shared/components/header/header.component.html":
/***/ (function(module, exports) {

module.exports = "<div class=\"pos-f-t fixed-top header\">\n    <nav class=\"navbar navbar-inverse bg-inverse navbar-toggleable-md\">\n        <button class=\"navbar-toggler navbar-toggler-right\" (click)=\"toggleSidebar()\">\n            <span class=\"navbar-toggler-icon\"></span>\n        </button>\n        <a class=\"navbar-brand\" href=\"javascript:void(0)\">{{title}}</a>\n        <div class=\"collapse navbar-collapse\">\n            <!-- <form class=\"form-inline my-2 my-lg-0\">\n                <input class=\"form-control mr-sm-2\" type=\"text\" placeholder=\"Search\">\n            </form> -->\n\n            <div class=\"form-inline my-2 my-lg-0\" #layoutheaderbar></div>\n\n            <ul class=\"navbar-nav ml-auto mt-2 mt-md-0\">\n                <li class=\"nav-item dropdown\" ngbDropdown>\n                    <!-- <div class=\"dropdown\"> -->\n                    <a class=\"nav-link\" href=\"javascript:void(0)\" ngbDropdownToggle>\n                        <i class=\"fa fa-envelope\"></i> <b class=\"caret\"></b><span class=\"sr-only\">(current)</span>\n                    </a>\n                    <ul class=\"dropdown-menu dropdown-menu-right messages\">\n                        <li class=\"media\" *ngFor=\"let notify of notifies\">\n                            <div class=\"media-body\">\n                                <h5 class=\"mt-0 mb-1\">{{notify.brief}}</h5>\n                                <p class=\"small text-muted\"><i class=\"fa fa-clock-o\"></i>{{notify.time | date:'medium'}}</p>\n                                <p class=\"last\">{{notify.detail}}</p>\n                            </div>\n                        </li>\n                    </ul>\n                </li>\n                <li class=\"nav-item dropdown\" ngbDropdown>\n                    <a href=\"javascript:void(0)\" class=\"nav-link\" ngbDropdownToggle>\n                        <i class=\"fa fa-bell\"></i> <b class=\"caret\"></b><span class=\"sr-only\">(current)</span>\n                    </a>\n                    <ul class=\"dropdown-menu dropdown-menu-right\">\n                        <a href=\"javascript:void(0)\" class=\"dropdown-item\">Pending Task <span class=\"badge badge-info\">0</span></a>\n                        <a href=\"javascript:void(0)\" class=\"dropdown-item\">In queue <span class=\"badge badge-info\">0</span></a>\n                        <a href=\"javascript:void(0)\" class=\"dropdown-item\">Mail <span class=\"badge badge-info\">0</span></a>\n                        <li class=\"dropdown-divider\"></li>\n                        <a href=\"javascript:void(0)\" class=\"dropdown-item\">View All</a>\n                    </ul>\n                </li>\n                <!--                 <li class=\"nav-item dropdown\" ngbDropdown>\n                    <a href=\"javascript:void(0)\" class=\"nav-link\" ngbDropdownToggle>\n                        <i class=\"fa fa-language\"></i> {{ 'language' | translate }} <b class=\"caret\"></b>\n                    </a>\n                    <div class=\"dropdown-menu dropdown-menu-right\">\n                        <a class=\"dropdown-item\" href=\"javascript:void(0)\" (click)=\"changeLang('en')\">English</a>\n                        <a class=\"dropdown-item\" href=\"javascript:void(0)\" (click)=\"changeLang('fr')\">French</a>\n                        <a class=\"dropdown-item\" href=\"javascript:void(0)\" (click)=\"changeLang('ur')\">Urdu</a>\n                    </div>\n                </li> -->\n                <li class=\"nav-item dropdown\" ngbDropdown>\n                    <a href=\"javascript:void(0)\" class=\"nav-link\" ngbDropdownToggle>\n                        <i class=\"fa fa-user\"></i> {{admin.email}} <b class=\"caret\"></b>\n                    </a>\n                    <div class=\"dropdown-menu dropdown-menu-right\">\n                        <a class=\"dropdown-item\" href=\"javascript:void(0)\"><i class=\"fa fa-fw fa-user\"></i> Profile</a>\n                        <a class=\"dropdown-item\" href=\"javascript:void(0)\"><i class=\"fa fa-fw fa-envelope\"></i> Inbox</a>\n                        <a class=\"dropdown-item\" href=\"javascript:void(0)\"><i class=\"fa fa-fw fa-gear\"></i> Settings</a>\n                        <a class=\"dropdown-item\" (click)=\"onLoggedout()\"><i class=\"fa fa-fw fa-power-off\"></i> Log Out</a>\n                    </div>\n                </li>\n            </ul>\n        </div>\n    </nav>\n</div>"

/***/ }),

/***/ "./src/app/Admin/ngx/shared/components/header/header.component.scss":
/***/ (function(module, exports) {

module.exports = ".topnav {\n  border-radius: 0;\n  background-color: #373330;\n  padding: 6px;\n  z-index: 2; }\n  .topnav .text-center {\n    text-align: center;\n    padding-left: 0;\n    cursor: pointer; }\n  .topnav .top-right-nav .buy-now a {\n    color: #999; }\n  .topnav .top-right-nav .dropdown-menu {\n    top: 40px;\n    right: -5px;\n    left: auto; }\n  .topnav .top-right-nav .dropdown-menu .message-preview .media .media-body .media-heading {\n      font-size: 14px;\n      font-weight: bold;\n      margin-bottom: 0; }\n  .topnav .top-right-nav .dropdown-menu .message-preview .media .media-body p {\n      margin: 0; }\n  .topnav .top-right-nav .dropdown-menu .message-preview .media .media-body p.last {\n      font-size: 13px;\n      margin-bottom: 0; }\n  .topnav .top-right-nav .dropdown-menu hr {\n      margin-top: 1px;\n      margin-bottom: 4px; }\n  .messages {\n  width: 300px; }\n  .messages .media {\n    border-bottom: 1px solid #DDD;\n    padding: 5px 10px; }\n  .messages .media:last-child {\n      border-bottom: none; }\n  .messages .media-body h5 {\n    font-size: 13px;\n    font-weight: 600; }\n  .messages .media-body .small {\n    margin: 0; }\n  .messages .media-body .last {\n    font-size: 12px;\n    margin: 0; }\n  .header .navbar {\n  background: #373330 !important; }\n  .headerbar * {\n  color: white; }\n  .fixed-top {\n  left: 80px; }\n  @media screen and (max-width: 992px) {\n  .fixed-top {\n    left: 0; } }\n"

/***/ }),

/***/ "./src/app/Admin/ngx/shared/components/header/header.component.ts":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
Object.defineProperty(exports, "__esModule", { value: true });
var core_1 = __webpack_require__("./node_modules/@angular/core/esm5/core.js");
var router_1 = __webpack_require__("./node_modules/@angular/router/esm5/router.js");
var core_2 = __webpack_require__("./node_modules/@ngx-translate/core/index.js");
var _ngxsuit_1 = __webpack_require__("./src/app/common/index.ts");
var http_1 = __webpack_require__("./node_modules/@angular/common/esm5/http.js");
var HeaderComponent = (function () {
    function HeaderComponent(translate, router, mq, gv, http) {
        var _this = this;
        this.translate = translate;
        this.router = router;
        this.mq = mq;
        this.gv = gv;
        this.http = http;
        this.title = '';
        this.admin = {};
        this.router.events.subscribe(function (val) {
            if (val instanceof router_1.NavigationEnd && window.innerWidth <= 992) {
                _this.toggleSidebar();
            }
        });
    }
    HeaderComponent.prototype.toggleSidebar = function () {
        var dom = document.querySelector('body');
        dom.classList.toggle('push-right');
    };
    HeaderComponent.prototype.rltAndLtr = function () {
        var dom = document.querySelector('body');
        dom.classList.toggle('rtl');
    };
    HeaderComponent.prototype.onLoggedout = function () {
        var _this = this;
        console.log('onLoggedout');
        this.http.post(this.gv.getString('admin_logout'), {
            _token: this.gv.getString('csrf_token'),
            is_ajax: 1
        }, { withCredentials: true }).subscribe(function (data) {
            localStorage.removeItem('admin_login');
            _this.router.navigate(['/login']);
        });
    };
    HeaderComponent.prototype.changeLang = function (language) {
        this.translate.use(language);
    };
    HeaderComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.admin = JSON.parse(localStorage.getItem('admin_login'));
        if (localStorage.getItem('PRIVATE_NOTIFIES')) {
            this.notifies = JSON.parse(localStorage.getItem('PRIVATE_NOTIFIES'));
        }
        else {
            this.notifies = [{
                    brief: 'No Message',
                    time: Date.now(),
                    detail: ''
                }];
        }
        this.subscription = this.mq.getMessage('headercompoment').subscribe(function (message) {
            var msg = message;
            switch (msg.type) {
                case 'title':
                    _this.title = msg.load;
                    break;
                case 'headerbar':
                    _this._headerbar.remove(0);
                    if (msg.load) {
                        _this._headerbar.createEmbeddedView(msg.load);
                    }
                    break;
                case 'notify':
                    _this.handlePrivteNotify(msg.load);
                    break;
            }
        });
    };
    HeaderComponent.prototype.handlePrivteNotify = function (notify) {
        notify.time = Date.now();
        this.notifies.unshift(notify);
        if (this.notifies) {
            while (this.notifies.length > 20) {
                this.notifies.pop();
            }
            localStorage.setItem('PRIVATE_NOTIFIES', JSON.stringify(this.notifies));
        }
    };
    HeaderComponent.prototype.ngOnDestroy = function () {
        this.subscription.unsubscribe();
    };
    __decorate([
        core_1.ViewChild('layoutheaderbar', { read: core_1.ViewContainerRef }),
        __metadata("design:type", Object)
    ], HeaderComponent.prototype, "_headerbar", void 0);
    HeaderComponent = __decorate([
        core_1.Component({
            selector: 'app-header',
            template: __webpack_require__("./src/app/Admin/ngx/shared/components/header/header.component.html"),
            styles: [__webpack_require__("./src/app/Admin/ngx/shared/components/header/header.component.scss")]
        }),
        __metadata("design:paramtypes", [core_2.TranslateService, router_1.Router, _ngxsuit_1.MQService, _ngxsuit_1.GlobalVarService, http_1.HttpClient])
    ], HeaderComponent);
    return HeaderComponent;
}());
exports.HeaderComponent = HeaderComponent;


/***/ }),

/***/ "./src/app/Admin/ngx/shared/components/index.ts":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

function __export(m) {
    for (var p in m) if (!exports.hasOwnProperty(p)) exports[p] = m[p];
}
Object.defineProperty(exports, "__esModule", { value: true });
__export(__webpack_require__("./src/app/Admin/ngx/shared/components/header/header.component.ts"));
__export(__webpack_require__("./src/app/Admin/ngx/shared/components/sidebar/sidebar.component.ts"));


/***/ }),

/***/ "./src/app/Admin/ngx/shared/components/sidebar/sidebar.component.html":
/***/ (function(module, exports) {

module.exports = "<nav class=\"sidebar {{selected=='' ? '' : 'expended' }}\" [ngClass]=\"{sidebarPushRight: isActive}\">\n    <ul class=\"list-group\">\n        <li *ngFor=\"let menu of menus\">\n            <a class=\"list-group-item\" (click)=\"onClickRouteLink(menu)\" [routerNav]=\"(menu.items === undefined || menu.items.length==0) && menu.submenu_resource === undefined\" [routerLink]=\"menu.link\" [routerLinkActive]=\"['router-link-active']\" [extlink]=\"menu.extlink\">\n                <i *ngIf=\"menu.icon\" class=\"fa fa-fw {{ menu.icon }}\" aria-hidden=\"true\"></i>\n                <img *ngIf=\"menu.image\" class=\"routenav-image\" src=\"{{menu.image | assets}}\" />\n                <span class=\"title\">\n                    {{ menu.title | translate }}\n                </span>\n            </a>\n\n            <div *ngIf=\"menu.items != undefined\" class=\"submenu\" [ngbCollapse]=\"selected != menu.name\">\n                <a [routerLink]=\"menu.link\" *ngIf=\"menu.link !=''\" (click)=\"selected=''\">\n                    <strong class=\"submenu-title\">{{ menu.title | translate}}</strong>\n                </a>\n                <strong class=\"submenu-title\" *ngIf=\"menu.link ==''\">{{ menu.title  | translate}}</strong>\n                <a class=\"close-submenu\" data-role=\"close-submenu\" (click)=\"selected=''\"><i class=\"fa fa-times\" aria-hidden=\"true\"></i></a>\n\n                <ng-container *ngTemplateOutlet=\"recursiveMenu; context:{ $implicit: menu.items }\"></ng-container>\n            </div>\n        </li>\n    </ul>\n</nav>\n\n<ng-template #recursiveMenu let-list>\n    <ng-container *ngFor=\"let item of list\">\n        <li *ngIf=\"item.is_menu\">\n            <a [routerLink]=\"item.link\" *ngIf=\"item.link !=''\" (click)=\"selected=''\">\n                    {{item.title}}\n                </a>\n            <ul *ngIf=\"item.items !=undefined\">\n                <ng-container *ngTemplateOutlet=\"recursiveMenu; context:{ $implicit: item.items }\"></ng-container>\n            </ul>\n        </li>\n    </ng-container>\n</ng-template>"

/***/ }),

/***/ "./src/app/Admin/ngx/shared/components/sidebar/sidebar.component.scss":
/***/ (function(module, exports) {

module.exports = ".sidebar {\n  border-radius: 0;\n  position: fixed;\n  z-index: 2000;\n  top: 0;\n  left: 235px;\n  width: 85px;\n  margin-left: -235px;\n  border: none;\n  border-radius: 0;\n  background-color: #373330;\n  bottom: 0;\n  overflow-y: auto;\n  overflow-x: hidden;\n  padding-bottom: 40px;\n  -webkit-transition: all 0.2s ease-in-out;\n  transition: all 0.2s ease-in-out; }\n  .sidebar .list-group a.list-group-item {\n    background: #373330;\n    border: 0;\n    border-radius: 0;\n    color: #999;\n    text-decoration: none;\n    text-align: center;\n    padding: 10px 0 10px 0;\n    margin: auto; }\n  .sidebar .list-group a.list-group-item .fa {\n      margin: auto;\n      font-size: 1.5em; }\n  .sidebar .list-group a.list-group-item .title {\n      font-size: 0.7em;\n      margin: auto;\n      min-width: 60px;\n      text-transform: uppercase; }\n  .sidebar .list-group a:hover {\n    background: #524d49;\n    color: #fff; }\n  .sidebar .list-group a.router-link-active {\n    background: #4A4542;\n    color: #fff; }\n  .sidebar .list-group a[href=\"/\"] {\n    background: #373330; }\n  .sidebar .sidebar-dropdown *:focus {\n    border-radius: none;\n    border: none; }\n  .sidebar .sidebar-dropdown .panel-title {\n    font-size: 1rem;\n    height: 50px;\n    margin-bottom: 0; }\n  .sidebar .sidebar-dropdown .panel-title a {\n      color: #999;\n      text-decoration: none;\n      font-weight: 400;\n      background: #373330; }\n  .sidebar .sidebar-dropdown .panel-title a span {\n        position: relative;\n        display: block;\n        padding: .75rem 1.5rem;\n        padding-top: 1rem; }\n  .sidebar .sidebar-dropdown .panel-title a:hover,\n    .sidebar .sidebar-dropdown .panel-title a:focus {\n      color: #fff;\n      outline: none;\n      outline-offset: -2px; }\n  .sidebar .sidebar-dropdown .panel-title:hover {\n    background: #292624; }\n  .sidebar .sidebar-dropdown .panel-collapse {\n    border-radious: 0;\n    border: none; }\n  .sidebar .sidebar-dropdown .panel-collapse .panel-body .list-group-item {\n      border-radius: 0;\n      background-color: #373330;\n      border: 0 solid transparent; }\n  .sidebar .sidebar-dropdown .panel-collapse .panel-body .list-group-item a {\n        color: #999; }\n  .sidebar .sidebar-dropdown .panel-collapse .panel-body .list-group-item a:hover {\n        color: #FFF; }\n  .sidebar .sidebar-dropdown .panel-collapse .panel-body .list-group-item:hover {\n      background: #292624; }\n  .sidebar .routenav-image {\n    max-width: 80px;\n    width: 48px;\n    margin: auto; }\n  .sidebar.expended {\n  overflow: visible; }\n  .nested-menu .list-group-item {\n  cursor: pointer; }\n  .nested-menu .nested {\n  list-style-type: none; }\n  .nested-menu ul.submenu {\n  display: none;\n  height: 0; }\n  .nested-menu .expand ul.submenu {\n  display: block;\n  list-style-type: none;\n  height: auto; }\n  .nested-menu .expand ul.submenu li a {\n    color: #FFF;\n    padding: 10px;\n    display: block; }\n  @media screen and (max-width: 992px) {\n  .sidebar {\n    top: 54px;\n    left: 0px; } }\n  .submenu.collapse.show {\n  -webkit-transform: translateX(0px);\n          transform: translateX(0px);\n  visibility: visible;\n  z-index: 1998; }\n  .submenu.collapse {\n  background-color: #4a4542;\n  -webkit-box-shadow: 0 0 3px #000000;\n          box-shadow: 0 0 3px #000000;\n  left: 100%;\n  min-height: calc(7.5rem + 2rem + 100%);\n  padding: 1.2rem 2rem 0;\n  position: absolute;\n  top: 0;\n  -webkit-transform: translateX(-100%);\n          transform: translateX(-100%);\n  -webkit-transition-duration: 0.3s;\n          transition-duration: 0.3s;\n  -webkit-transition-property: visibility, -webkit-transform;\n  transition-property: visibility, -webkit-transform;\n  transition-property: transform, visibility;\n  transition-property: transform, visibility, -webkit-transform;\n  -webkit-transition-timing-function: ease-in-out;\n          transition-timing-function: ease-in-out;\n  visibility: hidden;\n  z-index: 1997;\n  color: #fff;\n  width: 300px;\n  height: 700px;\n  overflow: scroll; }\n  .submenu.collapse a {\n    color: #fff;\n    background-color: #4a4542; }\n  .submenu.collapse a.router-link-active {\n    background-color: #4a4542; }\n  .submenu.collapse .submenu-title {\n    font-size: 1.1rem;\n    padding-bottom: 5px;\n    text-transform: uppercase; }\n  .submenu.collapse .close-submenu {\n    float: right;\n    font-size: 1.2rem;\n    margin-right: -1.2rem; }\n  .submenu.external-menu {\n  width: 600px;\n  height: 500px; }\n  .submenu.external-menu.not-extend {\n  width: 1px; }\n  .submenu li {\n  padding-top: 5px;\n  padding-left: 20px;\n  list-style-type: none; }\n  .submenu li:first-child {\n  padding-top: 0; }\n  .submenu ul {\n  padding-top: 5px;\n  padding-left: 20px;\n  list-style-type: none; }\n"

/***/ }),

/***/ "./src/app/Admin/ngx/shared/components/sidebar/sidebar.component.ts":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
Object.defineProperty(exports, "__esModule", { value: true });
var core_1 = __webpack_require__("./node_modules/@angular/core/esm5/core.js");
var ui_schema_service_1 = __webpack_require__("./src/app/Admin/ngx/services/ui.schema.service.ts");
var _ngxsuit_1 = __webpack_require__("./src/app/common/index.ts");
var SidebarComponent = (function () {
    function SidebarComponent(uischema, mq) {
        this.uischema = uischema;
        this.mq = mq;
        this.isActive = false;
        this.showMenu = '';
        this.menus = [];
        this.selected = '';
    }
    SidebarComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.mqsub = this.mq.getMessage('SidebarComponent').subscribe(function (msg) {
            if (msg.type == 'ui-schema-fetched') {
                _this.menus = msg.load;
            }
        });
        this.uischema.wait4UISchema('SidebarComponent');
    };
    SidebarComponent.prototype.ngOnDestroy = function () {
        this.mqsub.unsubscribe();
    };
    SidebarComponent.prototype.onClickRouteLink = function (menu) {
        this.selected = menu.name;
        if (menu.absolute) {
            window.location.href = menu.link;
        }
    };
    SidebarComponent = __decorate([
        core_1.Component({
            selector: 'app-sidebar',
            template: __webpack_require__("./src/app/Admin/ngx/shared/components/sidebar/sidebar.component.html"),
            styles: [__webpack_require__("./src/app/Admin/ngx/shared/components/sidebar/sidebar.component.scss")]
        }),
        __metadata("design:paramtypes", [ui_schema_service_1.UISchemaService, _ngxsuit_1.MQService])
    ], SidebarComponent);
    return SidebarComponent;
}());
exports.SidebarComponent = SidebarComponent;


/***/ }),

/***/ "./src/app/Admin/ngx/shared/guard/auth.guard.ts":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
Object.defineProperty(exports, "__esModule", { value: true });
var core_1 = __webpack_require__("./node_modules/@angular/core/esm5/core.js");
var router_1 = __webpack_require__("./node_modules/@angular/router/esm5/router.js");
var AuthGuard = (function () {
    function AuthGuard(router) {
        this.router = router;
    }
    AuthGuard.prototype.canActivate = function () {
        // localStorage.setItem('admin_login', JSON.stringify(
        //     {
        //         email:'tony@tonercity.com.au',
        //         expire:20000000,
        //         username:'Tony'
        //     }
        // ));
        // return true;
        if (localStorage.getItem('admin_login')) {
            console.log(localStorage.getItem('admin_login'));
            try {
                var admin = JSON.parse(localStorage.getItem('admin_login'));
                console.log('admin', admin);
                var now = (new Date()).getTime() / 1000;
                if (admin && admin.email) {
                    if (admin.expire > now) {
                        return true;
                    }
                }
            }
            catch (e) {
                console.log(e);
            }
        }
        this.router.navigate(['/login']);
        return false;
    };
    AuthGuard = __decorate([
        core_1.Injectable(),
        __metadata("design:paramtypes", [router_1.Router])
    ], AuthGuard);
    return AuthGuard;
}());
exports.AuthGuard = AuthGuard;


/***/ }),

/***/ "./src/app/Admin/ngx/shared/index.ts":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

function __export(m) {
    for (var p in m) if (!exports.hasOwnProperty(p)) exports[p] = m[p];
}
Object.defineProperty(exports, "__esModule", { value: true });
__export(__webpack_require__("./src/app/Admin/ngx/shared/pipes/shared-pipes.module.ts"));
__export(__webpack_require__("./src/app/Admin/ngx/shared/components/index.ts"));
__export(__webpack_require__("./src/app/Admin/ngx/shared/modules/index.ts"));
__export(__webpack_require__("./src/app/Admin/ngx/shared/guard/auth.guard.ts"));


/***/ }),

/***/ "./src/app/Admin/ngx/shared/modules/index.ts":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

function __export(m) {
    for (var p in m) if (!exports.hasOwnProperty(p)) exports[p] = m[p];
}
Object.defineProperty(exports, "__esModule", { value: true });
__export(__webpack_require__("./src/app/Admin/ngx/shared/modules/stat/stat.module.ts"));
__export(__webpack_require__("./src/app/Admin/ngx/shared/modules/page-header/page-header.module.ts"));


/***/ }),

/***/ "./src/app/Admin/ngx/shared/modules/page-header/page-header.component.html":
/***/ (function(module, exports) {

module.exports = "<div class=\"row\">\n    <div class=\"col-xl-12\">\n        <h2 class=\"page-header\">\n            {{heading}}\n        </h2>\n        <ol class=\"breadcrumb\">\n            <li class=\"breadcrumb-item\">\n                <i class=\"fa fa-dashboard\"></i> <a href=\"Javascript:void(0)\" [routerLink]=\"['/dashboard']\">Dashboard</a>\n            </li>\n            <li class=\"breadcrumb-item active\"><i class=\"fa {{icon}}\"></i> {{heading}}</li>\n        </ol>\n    </div>\n</div>"

/***/ }),

/***/ "./src/app/Admin/ngx/shared/modules/page-header/page-header.component.scss":
/***/ (function(module, exports) {

module.exports = ""

/***/ }),

/***/ "./src/app/Admin/ngx/shared/modules/page-header/page-header.component.ts":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
Object.defineProperty(exports, "__esModule", { value: true });
var core_1 = __webpack_require__("./node_modules/@angular/core/esm5/core.js");
var PageHeaderComponent = (function () {
    function PageHeaderComponent() {
    }
    __decorate([
        core_1.Input(),
        __metadata("design:type", String)
    ], PageHeaderComponent.prototype, "heading", void 0);
    __decorate([
        core_1.Input(),
        __metadata("design:type", String)
    ], PageHeaderComponent.prototype, "icon", void 0);
    PageHeaderComponent = __decorate([
        core_1.Component({
            selector: 'app-page-header',
            template: __webpack_require__("./src/app/Admin/ngx/shared/modules/page-header/page-header.component.html"),
            styles: [__webpack_require__("./src/app/Admin/ngx/shared/modules/page-header/page-header.component.scss")]
        })
    ], PageHeaderComponent);
    return PageHeaderComponent;
}());
exports.PageHeaderComponent = PageHeaderComponent;


/***/ }),

/***/ "./src/app/Admin/ngx/shared/modules/page-header/page-header.module.ts":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
Object.defineProperty(exports, "__esModule", { value: true });
var core_1 = __webpack_require__("./node_modules/@angular/core/esm5/core.js");
var common_1 = __webpack_require__("./node_modules/@angular/common/esm5/common.js");
var router_1 = __webpack_require__("./node_modules/@angular/router/esm5/router.js");
var page_header_component_1 = __webpack_require__("./src/app/Admin/ngx/shared/modules/page-header/page-header.component.ts");
var PageHeaderModule = (function () {
    function PageHeaderModule() {
    }
    PageHeaderModule = __decorate([
        core_1.NgModule({
            imports: [
                common_1.CommonModule,
                router_1.RouterModule
            ],
            declarations: [page_header_component_1.PageHeaderComponent],
            exports: [page_header_component_1.PageHeaderComponent]
        })
    ], PageHeaderModule);
    return PageHeaderModule;
}());
exports.PageHeaderModule = PageHeaderModule;


/***/ }),

/***/ "./src/app/Admin/ngx/shared/modules/stat/stat.component.html":
/***/ (function(module, exports) {

module.exports = "<div class=\"card card-inverse {{bgClass}}\">\n    <div class=\"card-header\">\n        <div class=\"row\">\n            <div class=\"col col-xs-3\">\n                <i class=\"fa {{icon}} fa-5x\"></i>\n            </div>\n            <div class=\"col col-xs-9 text-right\">\n                <div class=\"d-block huge\">{{count}}</div>\n                <div class=\"d-block\">{{label}}</div>\n            </div>\n        </div>\n    </div>\n    <div class=\"card-footer\">\n        <span class=\"float-left\">View Details {{data}}</span>\n        <a href=\"javascript:void(0)\" class=\"float-right card-inverse\">\n            <span ><i class=\"fa fa-arrow-circle-right\"></i></span>\n        </a>\n    </div>\n</div>\n"

/***/ }),

/***/ "./src/app/Admin/ngx/shared/modules/stat/stat.component.scss":
/***/ (function(module, exports) {

module.exports = ""

/***/ }),

/***/ "./src/app/Admin/ngx/shared/modules/stat/stat.component.ts":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
Object.defineProperty(exports, "__esModule", { value: true });
var core_1 = __webpack_require__("./node_modules/@angular/core/esm5/core.js");
var StatComponent = (function () {
    function StatComponent() {
        this.event = new core_1.EventEmitter();
    }
    StatComponent.prototype.ngOnInit = function () { };
    __decorate([
        core_1.Input(),
        __metadata("design:type", String)
    ], StatComponent.prototype, "bgClass", void 0);
    __decorate([
        core_1.Input(),
        __metadata("design:type", String)
    ], StatComponent.prototype, "icon", void 0);
    __decorate([
        core_1.Input(),
        __metadata("design:type", Number)
    ], StatComponent.prototype, "count", void 0);
    __decorate([
        core_1.Input(),
        __metadata("design:type", String)
    ], StatComponent.prototype, "label", void 0);
    __decorate([
        core_1.Input(),
        __metadata("design:type", Number)
    ], StatComponent.prototype, "data", void 0);
    __decorate([
        core_1.Output(),
        __metadata("design:type", core_1.EventEmitter)
    ], StatComponent.prototype, "event", void 0);
    StatComponent = __decorate([
        core_1.Component({
            selector: 'app-stat',
            template: __webpack_require__("./src/app/Admin/ngx/shared/modules/stat/stat.component.html"),
            styles: [__webpack_require__("./src/app/Admin/ngx/shared/modules/stat/stat.component.scss")]
        }),
        __metadata("design:paramtypes", [])
    ], StatComponent);
    return StatComponent;
}());
exports.StatComponent = StatComponent;


/***/ }),

/***/ "./src/app/Admin/ngx/shared/modules/stat/stat.module.ts":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
Object.defineProperty(exports, "__esModule", { value: true });
var core_1 = __webpack_require__("./node_modules/@angular/core/esm5/core.js");
var common_1 = __webpack_require__("./node_modules/@angular/common/esm5/common.js");
var stat_component_1 = __webpack_require__("./src/app/Admin/ngx/shared/modules/stat/stat.component.ts");
var StatModule = (function () {
    function StatModule() {
    }
    StatModule = __decorate([
        core_1.NgModule({
            imports: [
                common_1.CommonModule
            ],
            declarations: [stat_component_1.StatComponent],
            exports: [stat_component_1.StatComponent]
        })
    ], StatModule);
    return StatModule;
}());
exports.StatModule = StatModule;


/***/ }),

/***/ "./src/app/Admin/ngx/shared/pipes/safeurl.pipe.ts":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
Object.defineProperty(exports, "__esModule", { value: true });
var core_1 = __webpack_require__("./node_modules/@angular/core/esm5/core.js");
var platform_browser_1 = __webpack_require__("./node_modules/@angular/platform-browser/esm5/platform-browser.js");
var SafeUrlPipe = (function () {
    function SafeUrlPipe(sanitizer) {
        this.sanitizer = sanitizer;
    }
    SafeUrlPipe.prototype.transform = function (url) {
        return this.sanitizer.bypassSecurityTrustResourceUrl(url);
    };
    SafeUrlPipe = __decorate([
        core_1.Pipe({ name: 'safeurl' }),
        __metadata("design:paramtypes", [platform_browser_1.DomSanitizer])
    ], SafeUrlPipe);
    return SafeUrlPipe;
}());
exports.SafeUrlPipe = SafeUrlPipe;


/***/ }),

/***/ "./src/app/Admin/ngx/shared/pipes/shared-pipes.module.ts":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
Object.defineProperty(exports, "__esModule", { value: true });
var core_1 = __webpack_require__("./node_modules/@angular/core/esm5/core.js");
var common_1 = __webpack_require__("./node_modules/@angular/common/esm5/common.js");
var safeurl_pipe_1 = __webpack_require__("./src/app/Admin/ngx/shared/pipes/safeurl.pipe.ts");
var SharedPipesModule = (function () {
    function SharedPipesModule() {
    }
    SharedPipesModule = __decorate([
        core_1.NgModule({
            imports: [
                common_1.CommonModule
            ],
            exports: [safeurl_pipe_1.SafeUrlPipe],
            declarations: [safeurl_pipe_1.SafeUrlPipe]
        })
    ], SharedPipesModule);
    return SharedPipesModule;
}());
exports.SharedPipesModule = SharedPipesModule;


/***/ }),

/***/ "./src/app/common/angular/routerlink.override.ts":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

// How to use
// put RouterLinkOverride to your modulename.module.ts file
//  
// @NgModule({
//   imports: [
//     ...
//   ],
//   declarations: [
//       RouterLinkOverride,        
//     ...
//   ]
// })
var __extends = (this && this.__extends) || (function () {
    var extendStatics = Object.setPrototypeOf ||
        ({ __proto__: [] } instanceof Array && function (d, b) { d.__proto__ = b; }) ||
        function (d, b) { for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p]; };
    return function (d, b) {
        extendStatics(d, b);
        function __() { this.constructor = d; }
        d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
    };
})();
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
Object.defineProperty(exports, "__esModule", { value: true });
var core_1 = __webpack_require__("./node_modules/@angular/core/esm5/core.js");
var router_1 = __webpack_require__("./node_modules/@angular/router/esm5/router.js");
var common_1 = __webpack_require__("./node_modules/@angular/common/esm5/common.js");
var global_var_service_1 = __webpack_require__("./src/app/common/services/global.var.service.ts");
var window_ref_1 = __webpack_require__("./src/app/common/services/window.ref.ts");
var RouterLinkOverride = (function (_super) {
    __extends(RouterLinkOverride, _super);
    function RouterLinkOverride(router0, route0, locationStrategy0, winRef, gv) {
        var _this = _super.call(this, router0, route0, locationStrategy0) || this;
        _this.router0 = router0;
        _this.route0 = route0;
        _this.locationStrategy0 = locationStrategy0;
        _this.winRef = winRef;
        _this.gv = gv;
        _super.prototype.onClick = _this.onClick;
        return _this;
    }
    RouterLinkOverride_1 = RouterLinkOverride;
    RouterLinkOverride.prototype.attrBoolValue = function (s) {
        return s === '' || !!s;
    };
    RouterLinkOverride.prototype.onClick = function (button, ctrlKey, metaKey, shiftKey) {
        if (this.constructor.name != RouterLinkOverride_1.name) {
            return false;
        }
        if (this.routerNav === false) {
            return false;
        }
        if (!this.routerLink && this.extlink != undefined) {
            var url = this.extlink;
            if (!this.extlink.startsWith('http://') && !this.extlink.startsWith('https://') && !this.extlink.startsWith('//')) {
                if (url.startsWith('/')) {
                    url = url.substr(1);
                }
                url = this.gv.getString('home') + url;
            }
            this.winRef.navigate(url);
            return false;
        }
        if (button !== 0 || ctrlKey || metaKey || shiftKey) {
            return true;
        }
        if (typeof this.target === 'string' && this.target != '_self') {
            return true;
        }
        var extras = {
            skipLocationChange: this.attrBoolValue(this.skipLocationChange),
            replaceUrl: this.attrBoolValue(this.replaceUrl),
        };
        this.router0.navigateByUrl(this.urlTree, extras);
        return false;
    };
    __decorate([
        core_1.Input(),
        __metadata("design:type", Boolean)
    ], RouterLinkOverride.prototype, "routerNav", void 0);
    __decorate([
        core_1.Input(),
        __metadata("design:type", String)
    ], RouterLinkOverride.prototype, "extlink", void 0);
    RouterLinkOverride = RouterLinkOverride_1 = __decorate([
        core_1.Directive({ selector: 'a[routerLink]' }),
        __metadata("design:paramtypes", [router_1.Router, router_1.ActivatedRoute,
            common_1.LocationStrategy,
            window_ref_1.WindowRef, global_var_service_1.GlobalVarService])
    ], RouterLinkOverride);
    return RouterLinkOverride;
    var RouterLinkOverride_1;
}(router_1.RouterLinkWithHref));
exports.RouterLinkOverride = RouterLinkOverride;


/***/ }),

/***/ "./src/app/common/app.common.module.ts":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
Object.defineProperty(exports, "__esModule", { value: true });
var core_1 = __webpack_require__("./node_modules/@angular/core/esm5/core.js");
var common_1 = __webpack_require__("./node_modules/@angular/common/esm5/common.js");
var loaderlayer_component_1 = __webpack_require__("./src/app/common/components/loaderlayer/loaderlayer.component.ts");
var defaultvalue_pipe_1 = __webpack_require__("./src/app/common/pipes/defaultvalue.pipe.ts");
var safehtml_pipe_1 = __webpack_require__("./src/app/common/pipes/safehtml.pipe.ts");
var assets_pipe_1 = __webpack_require__("./src/app/common/pipes/assets.pipe.ts");
var localdate_pipe_1 = __webpack_require__("./src/app/common/pipes/localdate.pipe.ts");
var AppCommonModule = (function () {
    function AppCommonModule() {
    }
    AppCommonModule = __decorate([
        core_1.NgModule({
            imports: [common_1.CommonModule],
            exports: [loaderlayer_component_1.LoaderLayerComponent, safehtml_pipe_1.SafeHtmlPipe, defaultvalue_pipe_1.DefaultValuePipe, assets_pipe_1.AssetsPipe, localdate_pipe_1.LocalDatePipe],
            declarations: [loaderlayer_component_1.LoaderLayerComponent, safehtml_pipe_1.SafeHtmlPipe, defaultvalue_pipe_1.DefaultValuePipe, assets_pipe_1.AssetsPipe, localdate_pipe_1.LocalDatePipe],
            providers: [],
        })
    ], AppCommonModule);
    return AppCommonModule;
}());
exports.AppCommonModule = AppCommonModule;


/***/ }),

/***/ "./src/app/common/assemble.ts":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

// How to use
// put GLOBAL_ROUTEDEFS to your layout.module.ts file
//  
// @NgModule({
//     imports: GLOBAL_ROUTEDEFS,
//     exports: [RouterModule]
// })
Object.defineProperty(exports, "__esModule", { value: true });
var router_1 = __webpack_require__("./node_modules/@angular/router/esm5/router.js");
var assembly_1 = __webpack_require__("./src/app/Admin/ngx/assembly.ts");
var assembly_2 = __webpack_require__("./src/app/Admin/ngx/assembly.ts");
var assembly_3 = __webpack_require__("./src/app/Admin/ngx/assembly.ts");
var app_module_1 = __webpack_require__("./src/app/Admin/ngx/app.module.ts");
exports.AppModule = app_module_1.AppModule;
var NOTFOUNDROUTES = [
    { path: 'not-found', loadChildren: 'Admin/not-found/not-found.module#NotFoundModule' },
    { path: '**', redirectTo: 'not-found' }
];
exports.ROOTROUTES_DEFINES = [router_1.RouterModule.forRoot(assembly_1.ROOTROUTES), router_1.RouterModule.forRoot(NOTFOUNDROUTES)];
exports.CHILDROUTES_DEFINES = [router_1.RouterModule.forChild(assembly_2.CHILDROUTES)];
exports.MENUS_DEFINES = [assembly_3.MENUS];


/***/ }),

/***/ "./src/app/common/components/loaderlayer/loaderlayer.component.html":
/***/ (function(module, exports) {

module.exports = "<div class=\"loading-mask\" *ngIf=\"loading\">\n    <div class=\"loader\">\n        <img alt=\"Loading...\" [src]=\"image\" />\n        <div class=\"text-container\">\n            <div style=\"text-align:left;\" [innerHTML]=\"controlMsg.html | safeHtml\"></div>\n            <div>{{controlMsg.tip}}</div>\n            <div>{{controlMsg.error}}</div>\n        </div>\n    </div>\n</div>"

/***/ }),

/***/ "./src/app/common/components/loaderlayer/loaderlayer.component.scss":
/***/ (function(module, exports) {

module.exports = ":host .loading-mask {\n  background: rgba(255, 255, 255, 0.5); }\n\n:host .loading-mask,\n:host .loading-mask .loader > img {\n  bottom: 0;\n  left: 0;\n  margin: auto;\n  position: fixed;\n  right: 0;\n  top: 0;\n  z-index: 9900; }\n\n:host .text-container {\n  position: fixed;\n  top: 50%;\n  text-align: center;\n  width: 100%;\n  margin-top: 20px;\n  margin-left: auto;\n  margin-right: auto; }\n\n:host .text-container div:last-child {\n    color: red;\n    font-size: 2rem;\n    text-transform: uppercase; }\n"

/***/ }),

/***/ "./src/app/common/components/loaderlayer/loaderlayer.component.ts":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
Object.defineProperty(exports, "__esModule", { value: true });
var core_1 = __webpack_require__("./node_modules/@angular/core/esm5/core.js");
var mq_service_1 = __webpack_require__("./src/app/common/services/mq.service.ts");
var global_var_service_1 = __webpack_require__("./src/app/common/services/global.var.service.ts");
var LoaderLayerComponent = (function () {
    function LoaderLayerComponent(mq, gv) {
        this.mq = mq;
        this.gv = gv;
        this.image = '';
    }
    LoaderLayerComponent.prototype.ngOnInit = function () {
        var _this = this;
        console.log('loader layer init');
        this.image = this.assets('/images/loader.gif');
        var originStatus = this.loading;
        if (!originStatus) {
            this.loading = true;
        }
        this.controlMsg = { loading: this.loading, tip: '', delay: 0, error: '', html: '' };
        this.subscription = this.mq.getMessage('app-loader').subscribe(function (message) {
            var msg = message.load;
            _this.controlMsg.tip = (msg.tip === undefined ? '' : msg.tip);
            _this.controlMsg.error = (msg.error === undefined ? '' : msg.error);
            _this.controlMsg.delay = (msg.delay === undefined ? 0 : msg.delay);
            _this.controlMsg.html = (msg.html === undefined ? '' : msg.html);
            if (msg.loading) {
                _this.loading = _this.controlMsg.loading;
            }
            else {
                if (msg.delay !== undefined) {
                    setTimeout(function () {
                        _this.loading = false;
                        _this.controlMsg.tip = '';
                        _this.controlMsg.error = '';
                        _this.controlMsg.html = '';
                    }, msg.delay * 1000);
                }
                else {
                    _this.loading = false;
                    _this.controlMsg.tip = '';
                    _this.controlMsg.error = '';
                    _this.controlMsg.html = '';
                }
            }
        });
        if (!originStatus) {
            this.loading = false;
        }
    };
    LoaderLayerComponent.prototype.ngOnDestroy = function () {
        this.subscription.unsubscribe();
    };
    LoaderLayerComponent.prototype.assets = function (suffix) {
        if (suffix === void 0) { suffix = ''; }
        var prefix = this.gv.getString('assets');
        return "" + prefix + suffix;
    };
    __decorate([
        core_1.Input(),
        __metadata("design:type", Boolean)
    ], LoaderLayerComponent.prototype, "loading", void 0);
    LoaderLayerComponent = __decorate([
        core_1.Component({
            selector: 'app-loader',
            template: __webpack_require__("./src/app/common/components/loaderlayer/loaderlayer.component.html"),
            styles: [__webpack_require__("./src/app/common/components/loaderlayer/loaderlayer.component.scss")]
        }),
        __metadata("design:paramtypes", [mq_service_1.MQService, global_var_service_1.GlobalVarService])
    ], LoaderLayerComponent);
    return LoaderLayerComponent;
}());
exports.LoaderLayerComponent = LoaderLayerComponent;


/***/ }),

/***/ "./src/app/common/index.ts":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

function __export(m) {
    for (var p in m) if (!exports.hasOwnProperty(p)) exports[p] = m[p];
}
Object.defineProperty(exports, "__esModule", { value: true });
__export(__webpack_require__("./src/app/common/services/mq.service.ts"));
__export(__webpack_require__("./src/app/common/services/authHttp.ts"));
__export(__webpack_require__("./src/app/common/services/httpwithauth.ts"));
__export(__webpack_require__("./src/app/common/services/global.var.service.ts"));
__export(__webpack_require__("./src/app/common/services/window.ref.ts"));
__export(__webpack_require__("./src/app/common/services/localtime.service.ts"));
__export(__webpack_require__("./src/app/common/pipes/defaultvalue.pipe.ts"));
__export(__webpack_require__("./src/app/common/pipes/safehtml.pipe.ts"));
__export(__webpack_require__("./src/app/common/pipes/assets.pipe.ts"));
__export(__webpack_require__("./src/app/common/pipes/localdate.pipe.ts"));
__export(__webpack_require__("./src/app/common/angular/routerlink.override.ts"));
__export(__webpack_require__("./src/app/common/components/loaderlayer/loaderlayer.component.ts"));
// export * from './components/loaderlayer/loaderlayer.module';
// export * from './providers/menu.provider';
__export(__webpack_require__("./src/app/common/providers/m.level.items.parser.ts"));
__export(__webpack_require__("./src/app/common/assemble.ts"));
__export(__webpack_require__("./src/app/common/app.common.module.ts"));


/***/ }),

/***/ "./src/app/common/pipes/assets.pipe.ts":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
Object.defineProperty(exports, "__esModule", { value: true });
var core_1 = __webpack_require__("./node_modules/@angular/core/esm5/core.js");
var global_var_service_1 = __webpack_require__("./src/app/common/services/global.var.service.ts");
var AssetsPipe = (function () {
    function AssetsPipe(gv) {
        this.gv = gv;
    }
    AssetsPipe.prototype.transform = function (value) {
        return this.gv.getString('assets') + (value ? value : '');
    };
    AssetsPipe = __decorate([
        core_1.Pipe({ name: 'assets' }),
        __metadata("design:paramtypes", [global_var_service_1.GlobalVarService])
    ], AssetsPipe);
    return AssetsPipe;
}());
exports.AssetsPipe = AssetsPipe;


/***/ }),

/***/ "./src/app/common/pipes/defaultvalue.pipe.ts":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
Object.defineProperty(exports, "__esModule", { value: true });
var core_1 = __webpack_require__("./node_modules/@angular/core/esm5/core.js");
/*
 * Raise the value exponentially
 * Takes an exponent argument that defaults to 1.
 * Usage:
 *   value | exponentialStrength:exponent
 * Example:
 *   {{ 2 | exponentialStrength:10 }}
 *   formats to: 1024
*/
var DefaultValuePipe = (function () {
    function DefaultValuePipe() {
    }
    DefaultValuePipe.prototype.transform = function (value, exponent) {
        if (value === undefined) {
            return exponent;
        }
        else {
            return value;
        }
    };
    DefaultValuePipe = __decorate([
        core_1.Pipe({ name: 'default' })
    ], DefaultValuePipe);
    return DefaultValuePipe;
}());
exports.DefaultValuePipe = DefaultValuePipe;


/***/ }),

/***/ "./src/app/common/pipes/localdate.pipe.ts":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var __extends = (this && this.__extends) || (function () {
    var extendStatics = Object.setPrototypeOf ||
        ({ __proto__: [] } instanceof Array && function (d, b) { d.__proto__ = b; }) ||
        function (d, b) { for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p]; };
    return function (d, b) {
        extendStatics(d, b);
        function __() { this.constructor = d; }
        d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
    };
})();
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
Object.defineProperty(exports, "__esModule", { value: true });
var core_1 = __webpack_require__("./node_modules/@angular/core/esm5/core.js");
var common_1 = __webpack_require__("./node_modules/@angular/common/esm5/common.js");
var LocalDatePipe = (function (_super) {
    __extends(LocalDatePipe, _super);
    function LocalDatePipe() {
        return _super !== null && _super.apply(this, arguments) || this;
    }
    LocalDatePipe.prototype.transform = function (value, pattern) {
        if (pattern === void 0) { pattern = 'Australia/Sydney'; }
        var datestr = _super.prototype.transform.call(this, value, 'EEEE, d MMMM y hh:mm:ss');
        if (datestr == null) {
            return null;
        }
        datestr = datestr + ' GMT';
        var date = new Date(datestr);
        return date.toLocaleString('en-us', { timeZone: pattern });
    };
    LocalDatePipe = __decorate([
        core_1.Pipe({ name: 'localdate' })
    ], LocalDatePipe);
    return LocalDatePipe;
}(common_1.DatePipe));
exports.LocalDatePipe = LocalDatePipe;


/***/ }),

/***/ "./src/app/common/pipes/safehtml.pipe.ts":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
Object.defineProperty(exports, "__esModule", { value: true });
var core_1 = __webpack_require__("./node_modules/@angular/core/esm5/core.js");
var platform_browser_1 = __webpack_require__("./node_modules/@angular/platform-browser/esm5/platform-browser.js");
var SafeHtmlPipe = (function () {
    function SafeHtmlPipe(sanitizer) {
        this.sanitizer = sanitizer;
    }
    SafeHtmlPipe.prototype.transform = function (style) {
        // return this.sanitizer.bypassSecurityTrustStyle(style);
        return this.sanitizer.bypassSecurityTrustHtml(style);
        // return this.sanitizer.bypassSecurityTrustXxx(style); - see docs
    };
    SafeHtmlPipe = __decorate([
        core_1.Pipe({ name: 'safeHtml' }),
        __metadata("design:paramtypes", [platform_browser_1.DomSanitizer])
    ], SafeHtmlPipe);
    return SafeHtmlPipe;
}());
exports.SafeHtmlPipe = SafeHtmlPipe;


/***/ }),

/***/ "./src/app/common/providers/m.level.items.parser.ts":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

Object.defineProperty(exports, "__esModule", { value: true });
function MLevelItemsParser(defined_Collection, extraCollection) {
    var sort = 1000;
    // if (defined_Collection === undefined) {
    //     defined_Collection = MENUS_DEFINES;
    // }
    var rawCollection = defined_Collection[0];
    for (var i = 1; i < defined_Collection.length; i++) {
        rawCollection = rawCollection.concat(defined_Collection[i]);
    }
    if (extraCollection) {
        for (var i = 0; i < extraCollection.length; i++) {
            rawCollection = rawCollection.concat(extraCollection[i]);
        }
    }
    if (rawCollection === undefined) {
        return [];
    }
    var tmpCollection = {};
    var sortedMap = {};
    var nameCollection = {};
    for (var _i = 0, rawCollection_1 = rawCollection; _i < rawCollection_1.length; _i++) {
        var item = rawCollection_1[_i];
        nameCollection[item.name] = item;
    }
    for (var _a = 0, rawCollection_2 = rawCollection; _a < rawCollection_2.length; _a++) {
        var item = rawCollection_2[_a];
        item.level = calcItemLevel(nameCollection, item, 0);
        item.sort = item.sort ? item.sort : (sort++) * 100 + item.level * 1000;
        if (tmpCollection.hasOwnProperty(item.sort)) {
            item.sort = item.sort + 100;
        }
        tmpCollection[item.sort] = item;
        sortedMap[item.name] = item.sort;
    }
    for (var key in tmpCollection) {
        if (tmpCollection.hasOwnProperty(key)) {
            var item = tmpCollection[key];
            if (item !== undefined && item.level > 0) {
                key = sortedMap[item.parent];
                var parent_1 = tmpCollection[key];
                if (parent_1 !== undefined) {
                    if (parent_1.items === undefined) {
                        parent_1.items = {};
                    }
                    item.level = parent_1.level + 1;
                    parent_1.items[item.sort] = item;
                }
            }
        }
    }
    return sortCollection(tmpCollection, 0);
}
exports.MLevelItemsParser = MLevelItemsParser;
function calcItemLevel(collection, item, level) {
    if (item.parent !== undefined) {
        var parent_2 = collection[item.parent];
        if (parent_2.parent !== undefined) {
            var grandparent = collection[parent_2.name];
            return calcItemLevel(collection, grandparent, level + 1);
        }
        else {
            return level + 1;
        }
    }
    return level;
}
function sortCollection(collection, level) {
    var items = [];
    for (var key in collection) {
        if (collection.hasOwnProperty(key)) {
            var item = collection[key];
            if (item.level === undefined) {
                items.push(item);
            }
            else {
                if (item.level === level) {
                    if (item.items !== undefined) {
                        item.items = sortCollection(item.items, 1 + level);
                    }
                    items.push(item);
                }
            }
        }
    }
    return items;
}


/***/ }),

/***/ "./src/app/common/services/authHttp.ts":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
Object.defineProperty(exports, "__esModule", { value: true });
var core_1 = __webpack_require__("./node_modules/@angular/core/esm5/core.js");
var http_1 = __webpack_require__("./node_modules/@angular/http/esm5/http.js");
var Rx = __webpack_require__("./node_modules/rxjs/Rx.js");
var Action;
(function (Action) {
    Action[Action["QueryStart"] = 0] = "QueryStart";
    Action[Action["QueryStop"] = 1] = "QueryStop";
})(Action = exports.Action || (exports.Action = {}));
;
var AuthHttp = (function () {
    function AuthHttp(_http) {
        this._http = _http;
        this.process = new core_1.EventEmitter();
        this.authFailed = new core_1.EventEmitter();
    }
    AuthHttp.prototype._buildAuthHeader = function () {
        return localStorage.getItem("authToken");
    };
    AuthHttp.prototype.get = function (url, options) {
        return this._request(http_1.RequestMethod.Get, url, null, options);
    };
    AuthHttp.prototype.post = function (url, body, options) {
        return this._request(http_1.RequestMethod.Post, url, body, options);
    };
    AuthHttp.prototype.put = function (url, body, options) {
        return this._request(http_1.RequestMethod.Put, url, body, options);
    };
    AuthHttp.prototype.delete = function (url, options) {
        return this._request(http_1.RequestMethod.Delete, url, null, options);
    };
    AuthHttp.prototype.patch = function (url, body, options) {
        return this._request(http_1.RequestMethod.Patch, url, body, options);
    };
    AuthHttp.prototype.head = function (url, options) {
        return this._request(http_1.RequestMethod.Head, url, null, options);
    };
    AuthHttp.prototype._request = function (method, url, body, options) {
        var _this = this;
        var requestOptions = new http_1.RequestOptions(Object.assign({
            method: method,
            url: url,
            body: body
        }, options));
        console.log('options', options);
        console.log(requestOptions);
        if (!requestOptions.headers) {
            requestOptions.headers = new http_1.Headers();
        }
        requestOptions.headers.set("Authorization", this._buildAuthHeader());
        return Rx.Observable.create(function (observer) {
            _this.process.next(Action.QueryStart);
            _this._http.request(new http_1.Request(requestOptions))
                .map(function (res) { return res.json(); })
                .finally(function () {
                _this.process.next(Action.QueryStop);
            }).subscribe(function (res) {
                observer.next(res);
                observer.complete();
            }, function (err) {
                switch (err.status) {
                    case 401:
                        //intercept 401
                        _this.authFailed.next(err);
                        observer.error(err);
                        break;
                    default:
                        observer.error(err);
                        break;
                }
            });
        });
    };
    AuthHttp = __decorate([
        core_1.Injectable(),
        __metadata("design:paramtypes", [http_1.Http])
    ], AuthHttp);
    return AuthHttp;
}());
exports.AuthHttp = AuthHttp;


/***/ }),

/***/ "./src/app/common/services/global.var.service.ts":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
Object.defineProperty(exports, "__esModule", { value: true });
var core_1 = __webpack_require__("./node_modules/@angular/core/esm5/core.js");
var GlobalVarService = (function () {
    function GlobalVarService() {
        console.log('GlobalVarService constructor');
    }
    GlobalVarService_1 = GlobalVarService;
    GlobalVarService.prototype.get = function (key) {
        return GlobalVarService_1.vars[key];
    };
    GlobalVarService.prototype.getString = function (key) {
        if (GlobalVarService_1.vars[key]) {
            return GlobalVarService_1.vars[key];
        }
        return '';
    };
    GlobalVarService.prototype.set = function (key, value) {
        GlobalVarService_1.vars[key] = value;
    };
    GlobalVarService.prototype.initGlobalVarsFromRootElement = function (rootElement) {
        var attr = rootElement.nativeElement.getAttribute('globals');
        var items = attr.split(';');
        var globals = {};
        for (var _i = 0, items_1 = items; _i < items_1.length; _i++) {
            var item = items_1[_i];
            var values = item.split('=');
            this.set(values[0], values[1]);
        }
    };
    GlobalVarService.vars = {};
    GlobalVarService = GlobalVarService_1 = __decorate([
        core_1.Injectable(),
        __metadata("design:paramtypes", [])
    ], GlobalVarService);
    return GlobalVarService;
    var GlobalVarService_1;
}());
exports.GlobalVarService = GlobalVarService;


/***/ }),

/***/ "./src/app/common/services/httpwithauth.ts":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
Object.defineProperty(exports, "__esModule", { value: true });
// import { Observable } from 'rxjs/Observable';
var Rx_1 = __webpack_require__("./node_modules/rxjs/_esm5/Rx.js");
__webpack_require__("./node_modules/rxjs/_esm5/add/operator/catch.js");
var core_1 = __webpack_require__("./node_modules/@angular/core/esm5/core.js");
var router_1 = __webpack_require__("./node_modules/@angular/router/esm5/router.js");
var http_1 = __webpack_require__("./node_modules/@angular/common/esm5/http.js");
var mq_service_1 = __webpack_require__("./src/app/common/services/mq.service.ts");
var global_var_service_1 = __webpack_require__("./src/app/common/services/global.var.service.ts");
var HttpWithAuth = (function () {
    function HttpWithAuth(mq, gv, router) {
        this.mq = mq;
        this.gv = gv;
        this.router = router;
    }
    HttpWithAuth.prototype.intercept = function (req, next) {
        var _this = this;
        console.log('OVERWRITE REQUEST', req);
        var authReq = req.clone({ headers: req.headers.set('Authorization', this.retrieveAuthToken()) });
        // return next.handle(authReq);
        return next.handle(authReq)
            .catch(function (err) {
            if (err.status === 401) {
                _this.router.navigate(['/login']);
                return;
            }
            console.log('Caught error', err.error);
            _this.mq.sendMessage('app-loader', { type: '', load: { loading: false, html: err.error } });
            return Rx_1.Observable.throw(err);
        });
    };
    HttpWithAuth.prototype.retrieveAuthToken = function () {
        var current_token = this.gv.getString('curent_auth_token');
        if (current_token !== '') {
            console.log('use token:', current_token);
            this.gv.set('curent_auth_token', false);
            return current_token;
        }
        var value = localStorage.getItem('authToken');
        return !value ? '' : value;
    };
    HttpWithAuth = __decorate([
        core_1.Injectable(),
        __metadata("design:paramtypes", [mq_service_1.MQService, global_var_service_1.GlobalVarService, router_1.Router])
    ], HttpWithAuth);
    return HttpWithAuth;
}());
exports.HttpWithAuth = HttpWithAuth;
exports.HTTPCLIENT_AUTH_PLUGIN = {
    provide: http_1.HTTP_INTERCEPTORS,
    useClass: HttpWithAuth,
    multi: true,
};


/***/ }),

/***/ "./src/app/common/services/localtime.service.ts":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var __extends = (this && this.__extends) || (function () {
    var extendStatics = Object.setPrototypeOf ||
        ({ __proto__: [] } instanceof Array && function (d, b) { d.__proto__ = b; }) ||
        function (d, b) { for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p]; };
    return function (d, b) {
        extendStatics(d, b);
        function __() { this.constructor = d; }
        d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
    };
})();
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
Object.defineProperty(exports, "__esModule", { value: true });
var core_1 = __webpack_require__("./node_modules/@angular/core/esm5/core.js");
var localdate_pipe_1 = __webpack_require__("./src/app/common/pipes/localdate.pipe.ts");
var LocaltimeService = (function (_super) {
    __extends(LocaltimeService, _super);
    function LocaltimeService() {
        return _super !== null && _super.apply(this, arguments) || this;
    }
    LocaltimeService.prototype.convert = function (from, pattern) {
        if (pattern === void 0) { pattern = "Australia/Sydney"; }
        return _super.prototype.transform.call(this, from, pattern);
    };
    LocaltimeService = __decorate([
        core_1.Injectable()
    ], LocaltimeService);
    return LocaltimeService;
}(localdate_pipe_1.LocalDatePipe));
exports.LocaltimeService = LocaltimeService;


/***/ }),

/***/ "./src/app/common/services/mq.service.ts":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
Object.defineProperty(exports, "__esModule", { value: true });
var core_1 = __webpack_require__("./node_modules/@angular/core/esm5/core.js");
var rxjs_1 = __webpack_require__("./node_modules/rxjs/Rx.js");
var Subject_1 = __webpack_require__("./node_modules/rxjs/_esm5/Subject.js");
var MQService = (function () {
    function MQService() {
        console.log('MQService constructor');
        MQService_1.queues = {};
    }
    MQService_1 = MQService;
    MQService.prototype.sendMessage = function (slot, data) {
        if (MQService_1.queues[slot] === undefined) {
            this.pushtoNoListenerQueue(slot, data);
        }
        this.getSlot(slot).next(data);
    };
    MQService.prototype.pushtoNoListenerQueue = function (slot, data) {
        if (MQService_1.noListenerMessages[slot] === undefined) {
            MQService_1.noListenerMessages[slot] = [];
        }
        MQService_1.noListenerMessages[slot].push(data);
    };
    MQService.prototype.checkNoListenerQueue = function (slot) {
        var _this = this;
        if (MQService_1.noListenerMessages[slot] !== undefined) {
            rxjs_1.Observable.timer(5).subscribe(function (x) {
                for (var _i = 0, _a = MQService_1.noListenerMessages[slot]; _i < _a.length; _i++) {
                    var data = _a[_i];
                    console.log('attach messages which created before listener.');
                    _this.getSlot(slot).next(data);
                }
                delete MQService_1.noListenerMessages[slot];
            });
        }
    };
    MQService.prototype.getMessage = function (slot) {
        this.checkNoListenerQueue(slot);
        return this.getSlot(slot).asObservable();
    };
    MQService.prototype.clearMessage = function () {
        for (var slot in MQService_1.queues) {
            if (MQService_1.queues.hasOwnProperty(slot)) {
                MQService_1.queues[slot].next();
            }
        }
        for (var slot in MQService_1.noListenerMessages) {
            if (MQService_1.noListenerMessages.hasOwnProperty(slot)) {
                delete MQService_1.noListenerMessages[slot];
            }
        }
        MQService_1.noListenerMessages = {};
    };
    MQService.prototype.clearSlot = function (slot) {
        if (MQService_1.queues[slot] !== undefined) {
            delete MQService_1.queues[slot];
        }
    };
    MQService.prototype.getSlot = function (slot) {
        if (MQService_1.queues[slot] === undefined) {
            MQService_1.queues[slot] = new Subject_1.Subject();
        }
        return MQService_1.queues[slot];
    };
    MQService.noListenerMessages = {};
    MQService = MQService_1 = __decorate([
        core_1.Injectable(),
        __metadata("design:paramtypes", [])
    ], MQService);
    return MQService;
    var MQService_1;
}());
exports.MQService = MQService;


/***/ }),

/***/ "./src/app/common/services/window.ref.ts":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
Object.defineProperty(exports, "__esModule", { value: true });
var core_1 = __webpack_require__("./node_modules/@angular/core/esm5/core.js");
var WindowRef = (function () {
    function WindowRef() {
    }
    WindowRef.prototype.getNativeWindow = function () {
        return window;
    };
    WindowRef.prototype.open = function (url) {
        this.getNativeWindow().open(url);
    };
    WindowRef.prototype.navigate = function (url) {
        this.getNativeWindow().location.href = url;
    };
    WindowRef = __decorate([
        core_1.Injectable(),
        __metadata("design:paramtypes", [])
    ], WindowRef);
    return WindowRef;
}());
exports.WindowRef = WindowRef;


/***/ }),

/***/ "./src/environments/environment.ts":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

// The file contents for the current environment will overwrite these during build.
// The build system defaults to the dev environment which uses `environment.ts`, but if you do
// `ng build --env=prod` then `environment.prod.ts` will be used instead.
// The list of which env maps to which file can be found in `.angular-cli.json`.
Object.defineProperty(exports, "__esModule", { value: true });
exports.environment = {
    production: false
};


/***/ }),

/***/ "./src/main.ts":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

Object.defineProperty(exports, "__esModule", { value: true });
var core_1 = __webpack_require__("./node_modules/@angular/core/esm5/core.js");
var platform_browser_dynamic_1 = __webpack_require__("./node_modules/@angular/platform-browser-dynamic/esm5/platform-browser-dynamic.js");
var _ngxsuit_1 = __webpack_require__("./src/app/common/index.ts");
var environment_1 = __webpack_require__("./src/environments/environment.ts");
if (environment_1.environment.production) {
    core_1.enableProdMode();
}
platform_browser_dynamic_1.platformBrowserDynamic().bootstrapModule(_ngxsuit_1.AppModule);


/***/ }),

/***/ 0:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("./src/main.ts");


/***/ })

},[0]);
//# sourceMappingURL=main.bundle.js.map