webpackJsonp(["general.module"],{

/***/ "./src/app/Admin/ngx/pages/store/general/general-routing.module.ts":
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
var general_component_1 = __webpack_require__("./src/app/Admin/ngx/pages/store/general/general.component.ts");
var routes = [
    { path: '', component: general_component_1.GeneralComponent,
        children: []
    }
];
var GeneralRoutingModule = (function () {
    function GeneralRoutingModule() {
    }
    GeneralRoutingModule = __decorate([
        core_1.NgModule({
            imports: [router_1.RouterModule.forChild(routes)],
            exports: [router_1.RouterModule]
        })
    ], GeneralRoutingModule);
    return GeneralRoutingModule;
}());
exports.GeneralRoutingModule = GeneralRoutingModule;


/***/ }),

/***/ "./src/app/Admin/ngx/pages/store/general/general.component.html":
/***/ (function(module, exports) {

module.exports = "<div class=\"row\">\n    <div class=\"col-sm-4\">\n        <div class=\"card  card-info  card-inverse mb-3\">\n            <div class=\"card-header\">\n                Store Title\n            </div>\n            <div class=\"card-block\">\n                <input type=\"text\" value=\"Zento\" class=\"form-control\">\n            </div>\n        </div>\n        <div class=\" card card-info card-inverse mb-3 \">\n            <div class=\"card-header \">\n                Store Contact Number\n            </div>\n            <div class=\"card-block bg-white\">\n                <input type=\"text \" value=\"1300 00 00 00 \" class=\"form-control\">\n            </div>\n        </div>\n\n        <div class=\" card card-info card-inverse mb-3 \">\n            <div class=\"card-header \">\n                Store Admin Url Prefix\n            </div>\n            <div class=\"card-block bg-white\">\n                <input type=\"text \" value=\"admin_v1\" class=\"form-control\">\n            </div>\n        </div>\n        <div class=\" card card-info card-inverse mb-3 \">\n            <div class=\"card-header\">\n                Store Copyright\n            </div>\n            <div class=\"card-block bg-white\">\n                <input type=\"text \" value=\"admin_v1\" class=\"form-control\">\n            </div>\n        </div>\n    </div>\n</div>"

/***/ }),

/***/ "./src/app/Admin/ngx/pages/store/general/general.component.ts":
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
var GeneralComponent = (function () {
    function GeneralComponent() {
    }
    GeneralComponent.prototype.ngOnInit = function () { };
    GeneralComponent = __decorate([
        core_1.Component({
            selector: 'store-general',
            template: __webpack_require__("./src/app/Admin/ngx/pages/store/general/general.component.html")
        }),
        __metadata("design:paramtypes", [])
    ], GeneralComponent);
    return GeneralComponent;
}());
exports.GeneralComponent = GeneralComponent;


/***/ }),

/***/ "./src/app/Admin/ngx/pages/store/general/general.module.ts":
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
var general_routing_module_1 = __webpack_require__("./src/app/Admin/ngx/pages/store/general/general-routing.module.ts");
var general_component_1 = __webpack_require__("./src/app/Admin/ngx/pages/store/general/general.component.ts");
var GeneralModule = (function () {
    function GeneralModule() {
    }
    GeneralModule = __decorate([
        core_1.NgModule({
            imports: [
                common_1.CommonModule,
                general_routing_module_1.GeneralRoutingModule
            ],
            exports: [],
            declarations: [general_component_1.GeneralComponent],
            providers: [],
        })
    ], GeneralModule);
    return GeneralModule;
}());
exports.GeneralModule = GeneralModule;


/***/ })

});
//# sourceMappingURL=general.module.chunk.js.map