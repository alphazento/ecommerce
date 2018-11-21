webpackJsonp(["layout.module"],{

/***/ "./src/app/Admin/ngx/layout/layout-routing.module.ts":
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
var _ngxsuit_1 = __webpack_require__("./src/app/common/index.ts");
var LayoutRoutingModule = (function () {
    function LayoutRoutingModule() {
    }
    LayoutRoutingModule = __decorate([
        core_1.NgModule({
            imports: _ngxsuit_1.CHILDROUTES_DEFINES,
            exports: [router_1.RouterModule]
        })
    ], LayoutRoutingModule);
    return LayoutRoutingModule;
}());
exports.LayoutRoutingModule = LayoutRoutingModule;


/***/ }),

/***/ "./src/app/Admin/ngx/layout/layout.module.ts":
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
var ng_bootstrap_1 = __webpack_require__("./node_modules/@ng-bootstrap/ng-bootstrap/index.js");
var core_2 = __webpack_require__("./node_modules/@ngx-translate/core/index.js");
var layout_routing_module_1 = __webpack_require__("./src/app/Admin/ngx/layout/layout-routing.module.ts");
var layout_component_1 = __webpack_require__("./src/app/Admin/ngx/layout/layout.component.ts");
var shared_1 = __webpack_require__("./src/app/Admin/ngx/shared/index.ts");
var _ngxsuit_1 = __webpack_require__("./src/app/common/index.ts");
var LayoutModule = (function () {
    function LayoutModule() {
    }
    LayoutModule = __decorate([
        core_1.NgModule({
            imports: [
                common_1.CommonModule,
                shared_1.SharedPipesModule,
                ng_bootstrap_1.NgbModule.forRoot(),
                ng_bootstrap_1.NgbDropdownModule.forRoot(),
                layout_routing_module_1.LayoutRoutingModule,
                core_2.TranslateModule,
                _ngxsuit_1.AppCommonModule
            ],
            declarations: [
                _ngxsuit_1.RouterLinkOverride,
                layout_component_1.LayoutComponent,
                shared_1.HeaderComponent,
                shared_1.SidebarComponent
            ],
        })
    ], LayoutModule);
    return LayoutModule;
}());
exports.LayoutModule = LayoutModule;


/***/ })

});
//# sourceMappingURL=layout.module.chunk.js.map