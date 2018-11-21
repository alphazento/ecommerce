webpackJsonp(["not-found.module"],{

/***/ "./src/app/Admin/ngx/not-found/not-found-routing.module.ts":
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
var not_found_component_1 = __webpack_require__("./src/app/Admin/ngx/not-found/not-found.component.ts");
var routes = [
    { path: '', component: not_found_component_1.NotFoundComponent }
];
var NotFoundRoutingModule = (function () {
    function NotFoundRoutingModule() {
    }
    NotFoundRoutingModule = __decorate([
        core_1.NgModule({
            imports: [router_1.RouterModule.forChild(routes)],
            exports: [router_1.RouterModule]
        })
    ], NotFoundRoutingModule);
    return NotFoundRoutingModule;
}());
exports.NotFoundRoutingModule = NotFoundRoutingModule;


/***/ }),

/***/ "./src/app/Admin/ngx/not-found/not-found.component.html":
/***/ (function(module, exports) {

module.exports = "<div class=\"welcome-page\">\n    <div class=\"row\">\n        <div class=\"col-md-10 push-md-1\">\n            <h1>404 - Page Not Found</h1>\n            <p class=\"lead\">This page does not exist</p>\n            <p class=\"lead\">\n                <a class=\"btn rounded-btn\" [routerLink]=\"['/']\">Restart</a>\n            </p>\n        </div>\n    </div>\n</div>"

/***/ }),

/***/ "./src/app/Admin/ngx/not-found/not-found.component.scss":
/***/ (function(module, exports) {

module.exports = ":host {\n  display: block; }\n\n.welcome-page {\n  position: absolute;\n  top: 0;\n  left: 0;\n  right: 0;\n  bottom: 0;\n  overflow: auto;\n  background: #222;\n  text-align: center;\n  color: #fff;\n  padding: 10em; }\n\n.welcome-page .col-lg-8 {\n    padding: 0; }\n\n.welcome-page .rounded-btn {\n    border-radius: 50px;\n    color: rgba(255, 255, 255, 0.8);\n    background: #222;\n    border: 2px solid rgba(255, 255, 255, 0.8);\n    font-size: 18px;\n    line-height: 40px;\n    padding: 0 25px; }\n\n.welcome-page .rounded-btn:hover, .welcome-page .rounded-btn:focus, .welcome-page .rounded-btn:active, .welcome-page .rounded-btn:visited {\n    color: white;\n    border: 2px solid white;\n    outline: none; }\n\n.welcome-page h1 {\n    font-weight: 300;\n    margin-top: 20px;\n    margin-bottom: 10px;\n    font-size: 36px; }\n"

/***/ }),

/***/ "./src/app/Admin/ngx/not-found/not-found.component.ts":
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
var NotFoundComponent = (function () {
    function NotFoundComponent() {
    }
    NotFoundComponent = __decorate([
        core_1.Component({
            selector: 'app-not-found',
            template: __webpack_require__("./src/app/Admin/ngx/not-found/not-found.component.html"),
            styles: [__webpack_require__("./src/app/Admin/ngx/not-found/not-found.component.scss")]
        })
    ], NotFoundComponent);
    return NotFoundComponent;
}());
exports.NotFoundComponent = NotFoundComponent;


/***/ }),

/***/ "./src/app/Admin/ngx/not-found/not-found.module.ts":
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
var not_found_component_1 = __webpack_require__("./src/app/Admin/ngx/not-found/not-found.component.ts");
var not_found_routing_module_1 = __webpack_require__("./src/app/Admin/ngx/not-found/not-found-routing.module.ts");
var NotFoundModule = (function () {
    function NotFoundModule() {
    }
    NotFoundModule = __decorate([
        core_1.NgModule({
            imports: [
                not_found_routing_module_1.NotFoundRoutingModule,
                router_1.RouterModule
            ],
            declarations: [not_found_component_1.NotFoundComponent]
        })
    ], NotFoundModule);
    return NotFoundModule;
}());
exports.NotFoundModule = NotFoundModule;


/***/ })

});
//# sourceMappingURL=not-found.module.chunk.js.map