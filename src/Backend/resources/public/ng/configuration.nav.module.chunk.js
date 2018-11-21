webpackJsonp(["configuration.nav.module"],{

/***/ "./src/app/Admin/ngx/pages/configuration/detail/configuration.detail.component.html":
/***/ (function(module, exports) {

module.exports = "<div *ngIf=\"item\" class=\"card card-lightgrey\">\n    <div class=\"card-header card-high-level-header\">\n        {{ item.title }}\n    </div>\n    <div class=\"card-block\">\n        <ng-container *ngFor=\"let subitem of item.items\">\n            <ng-container *ngTemplateOutlet=\"recursiveItemBlock; context:{ $implicit: subitem }\"></ng-container>\n        </ng-container>\n    </div>\n</div>\n\n<ng-template #recursiveItemBlock let-item>\n    <ng-container *ngIf=\"item.items\">\n        <div class=\"card-header card-high-level-header\" (click)=\"item.ui_expanded = !item.ui_expanded\">\n            {{item.title}}\n            <i class=\"fa fa-fw fa-chevron-circle-icon {{ item.ui_expanded ? 'fa-chevron-circle-up':'fa-chevron-circle-down'}} \"></i>\n        </div>\n        <div class=\"card-block {{ item.ui_expanded ? '':'hide'}}\">\n            <ng-container *ngTemplateOutlet=\"recursiveSubItemsBlock; context:{ $implicit: item.items }\"></ng-container>\n        </div>\n    </ng-container>\n\n    <div class=\"card-header\" *ngIf=\"!item.items && (item.depends === undefined || config_pairs[item.depends] || item.cpath == item.depends)\">\n        <div class=\"row\">\n            <div class=\"col-sm-4 unique-item-title\">{{item.title}}:</div>\n            <div class=\"col-sm-4\">\n                <!-- text type -->\n                <input class=\"unique-item-content\" *ngIf=\"item.type=='text'\" type=\"text\" [value]=\"config_pairs[item.cpath]\" (input)=\"config_pairs_temp[item.cpath]=$event.target.value\" (change)=\"inputChanged(item)\" />\n\n                <textarea class=\"unique-item-content\" *ngIf=\"item.type=='textarea'\" rows=\"4\" cols=\"50\" [value]=\"config_pairs[item.cpath]\" (input)=\"config_pairs_temp[item.cpath]=$event.target.value\" (change)=\"inputChanged(item)\"></textarea>\n\n                <!-- boolean Type -->\n                <label *ngIf=\"item.type=='boolean'\" class=\"switch\" (click)=\"inputChanged(item)\">\n                    <input type=\"checkbox\" [checked]=\"config_pairs[item.cpath]\">\n                    <span class=\"slider round\"></span>\n                </label>\n\n                <!-- date/datetime type -->\n                <div *ngIf=\"item.type=='date' || item.type=='datetime' || item.type=='time'\" class=\"input-group-datetime\">\n                    <!-- <input class=\"form-control filter-active\" placeholder=\"yyyy-mm-dd\" [(ngModel)]=\"config_pairs[item.cpath]\" ngbDatepicker #d=\"ngbDatepicker\" (click)=\"d.toggle()\"/> -->\n                    <div *ngIf=\"item.type !='time'\" class=\"input-group date-picker\">\n                        <input class=\"form-control\" placeholder=\"yyyy-mm-dd\" name=\"dpfrom\" ngbDatepicker #df=\"ngbDatepicker\" [(ngModel)]=\"config_pairs[item.cpath]\" (click)=\"df.toggle()\">\n                        <div class=\"input-group-addon\" (click)=\"df.toggle()\">\n                            <span class=\"fa fa-calendar\"></span>\n                        </div>\n                    </div>\n                    <ngb-timepicker *ngIf=\"item.type !='date'\" [(ngModel)]=\"config_pairs[item.cpath]\" [seconds]=\"true\"></ngb-timepicker>\n                </div>\n\n                <!-- select type -->\n                <div *ngIf=\"item.type=='select'\">\n                    <select [(ngModel)]=\"config_pairs[item.cpath]\" (change)=\"inputChanged(item)\">\n                        <option *ngFor=\"let op of item.options\" [ngValue]=\"op\">\n                            {{ op }}\n                        </option>\n                    </select>\n                </div>\n\n                <!-- multi-select type -->\n                <div *ngIf=\"item.type=='treeview'\">\n                </div>\n            </div>\n            <div *ngIf=\"item.tip\" class=\"col-sm-2 unique-item-tip\">{{item.tip}}</div>\n        </div>\n    </div>\n</ng-template>\n\n<ng-template #recursiveSubItemsBlock let-items>\n    <div class=\"card card-info mb-3\" *ngFor=\"let item of items\">\n        <ng-container *ngTemplateOutlet=\"recursiveItemBlock; context:{ $implicit: item }\"></ng-container>\n    </div>\n</ng-template>"

/***/ }),

/***/ "./src/app/Admin/ngx/pages/configuration/detail/configuration.detail.component.scss":
/***/ (function(module, exports) {

module.exports = ":host {\n  /* The switch - the box around the slider */\n  /* Hide default HTML checkbox */\n  /* The slider */\n  /* Rounded sliders */ }\n  :host .title {\n    font-size: 20px;\n    font-weight: bold; }\n  :host .hide {\n    display: none; }\n  :host .card-header i {\n    float: right; }\n  :host .unique-item-title {\n    text-align: right; }\n  :host .unique-item-content {\n    width: 100%; }\n  :host .unique-item-tip {\n    font-style: italic;\n    font-size: 14px; }\n  :host .card-lightgrey {\n    background-color: #ddd; }\n  :host .card-lightgrey .card-high-level-header {\n      color: blue; }\n  :host .switch {\n    position: relative;\n    display: inline-block;\n    width: 60px;\n    height: 34px; }\n  :host .switch input {\n    display: none; }\n  :host .slider {\n    position: absolute;\n    cursor: pointer;\n    top: 0;\n    left: 0;\n    right: 0;\n    bottom: 0;\n    background-color: #ccc;\n    -webkit-transition: .4s;\n    transition: .4s; }\n  :host .slider:before {\n    position: absolute;\n    content: \"\";\n    height: 26px;\n    width: 26px;\n    left: 4px;\n    bottom: 4px;\n    background-color: white;\n    -webkit-transition: .4s;\n    transition: .4s; }\n  :host input:checked + .slider {\n    background-color: #2196F3; }\n  :host input:focus + .slider {\n    -webkit-box-shadow: 0 0 1px #2196F3;\n            box-shadow: 0 0 1px #2196F3; }\n  :host input:checked + .slider:before {\n    -webkit-transform: translateX(26px);\n    transform: translateX(26px); }\n  :host .slider.round {\n    border-radius: 34px; }\n  :host .slider.round:before {\n    border-radius: 50%; }\n  :host .input-group-datetime {\n    display: -webkit-inline-box;\n    display: -ms-inline-flexbox;\n    display: inline-flex; }\n  :host .input-group-datetime ngb-timepicker {\n      float: left; }\n  :host .input-group-datetime ngb-timepicker .ngb-tp-spacer {\n        color: #fff !important; }\n  :host .input-group-datetime .input-group {\n      max-height: 40px;\n      max-width: 160px;\n      margin: auto; }\n"

/***/ }),

/***/ "./src/app/Admin/ngx/pages/configuration/detail/configuration.detail.component.ts":
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
var http_1 = __webpack_require__("./node_modules/@angular/common/esm5/http.js");
var _ngxsuit_1 = __webpack_require__("./src/app/common/index.ts");
var ConfigurationDetailComponent = (function () {
    function ConfigurationDetailComponent(http, mq, gv) {
        this.http = http;
        this.mq = mq;
        this.gv = gv;
        this.config_pairs = {};
        this.config_pairs_temp = {};
        this.config_keys = [];
    }
    ConfigurationDetailComponent.prototype.ngOnInit = function () {
    };
    ConfigurationDetailComponent.prototype.ngOnChanges = function (changes) {
        this.config_keys = [];
        this.assembleConfigKeys(this.item);
        this.loadConfigValues(this.config_keys);
    };
    ConfigurationDetailComponent.prototype.assembleConfigKeys = function (item) {
        if (item && item !== undefined) {
            if (item.cpath) {
                this.config_keys.push(item.cpath);
            }
            if (item.items) {
                for (var _i = 0, _a = item.items; _i < _a.length; _i++) {
                    var subitem = _a[_i];
                    this.assembleConfigKeys(subitem);
                }
            }
        }
    };
    ConfigurationDetailComponent.prototype.loadConfigValues = function (keys) {
        var _this = this;
        console.log('url', this.gv.getString('admin_prefix') + '/rest/v1/admin/configuration');
        if (keys.length > 0) {
            this.mq.sendMessage('app-loader', { type: "", load: { loading: true } });
            console.log('url', this.gv.getString('admin_prefix') + '/rest/v1/admin/configuration');
            this.http.get(this.gv.getString('admin_prefix') + '/rest/v1/admin/configuration?keys=' + keys.join(','), {
                withCredentials: true,
            }).subscribe(function (data) {
                _this.config_pairs = data;
                _this.mq.sendMessage('app-loader', { type: "", load: { loading: false } });
                var expire_at = Math.ceil((new Date()).getTime() / 1000);
                var admin = JSON.parse(localStorage.getItem('admin_login'));
                admin.expire = expire_at + 60 * (+_this.gv.getString('session_lifetime'));
                localStorage.setItem('admin_login', JSON.stringify(admin));
            });
        }
    };
    ConfigurationDetailComponent.prototype.inputChanged = function (item) {
        switch (item.type) {
            case 'text':
                break;
            case 'boolean':
                this.config_pairs_temp[item.cpath] = (!this.config_pairs[item.cpath] ? 1 : 0);
                break;
            case 'select':
                this.config_pairs_temp[item.cpath] = this.config_pairs[item.cpath];
                this.config_pairs[item.cpath] = '';
                break;
        }
        if (this.config_pairs[item.cpath] != this.config_pairs_temp[item.cpath]) {
            this.postConfigValues([
                {
                    key: item.cpath,
                    value: this.config_pairs_temp[item.cpath]
                }
            ]);
        }
    };
    ConfigurationDetailComponent.prototype.postConfigValues = function (key_values) {
        var _this = this;
        // key_values = 
        // [
        //     {
        //         key:key,
        //         value:this.config_pairs_temp[value]
        //     }
        // ]
        this.mq.sendMessage('app-loader', { type: "", load: { loading: true } });
        console.log('url', this.gv.getString('admin_prefix') + '/rest/v1/admin/configuration');
        this.http.post(this.gv.getString('admin_prefix') + '/rest/v1/admin/configuration', key_values).subscribe(function (data) {
            var pairs = data;
            for (var _i = 0, key_values_1 = key_values; _i < key_values_1.length; _i++) {
                var item = key_values_1[_i];
                _this.config_pairs[item.key] = item.value;
            }
            var expire_at = Math.ceil((new Date()).getTime() / 1000);
            var admin = JSON.parse(localStorage.getItem('admin_login'));
            admin.expire = expire_at + 60 * (+_this.gv.getString('session_lifetime'));
            localStorage.setItem('admin_login', JSON.stringify(admin));
            _this.mq.sendMessage('app-loader', { type: "", load: { loading: false } });
        });
    };
    __decorate([
        core_1.Input(),
        __metadata("design:type", Object)
    ], ConfigurationDetailComponent.prototype, "item", void 0);
    ConfigurationDetailComponent = __decorate([
        core_1.Component({
            selector: 'store-configuration-detail',
            template: __webpack_require__("./src/app/Admin/ngx/pages/configuration/detail/configuration.detail.component.html"),
            styles: [__webpack_require__("./src/app/Admin/ngx/pages/configuration/detail/configuration.detail.component.scss")]
        }),
        __metadata("design:paramtypes", [http_1.HttpClient, _ngxsuit_1.MQService, _ngxsuit_1.GlobalVarService])
    ], ConfigurationDetailComponent);
    return ConfigurationDetailComponent;
}());
exports.ConfigurationDetailComponent = ConfigurationDetailComponent;


/***/ }),

/***/ "./src/app/Admin/ngx/pages/configuration/nav/configuration.nav-routing.module.ts":
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
var configuration_nav_component_1 = __webpack_require__("./src/app/Admin/ngx/pages/configuration/nav/configuration.nav.component.ts");
var routes = [
    { path: '', component: configuration_nav_component_1.ConfigurationNavComponent,
        children: []
    }
];
var ConfigurationNavRoutingModule = (function () {
    function ConfigurationNavRoutingModule() {
    }
    ConfigurationNavRoutingModule = __decorate([
        core_1.NgModule({
            imports: [router_1.RouterModule.forChild(routes)],
            exports: [router_1.RouterModule]
        })
    ], ConfigurationNavRoutingModule);
    return ConfigurationNavRoutingModule;
}());
exports.ConfigurationNavRoutingModule = ConfigurationNavRoutingModule;


/***/ }),

/***/ "./src/app/Admin/ngx/pages/configuration/nav/configuration.nav.component.html":
/***/ (function(module, exports) {

module.exports = "<div class=\"row\">\n    <div class=\"card card-inverse card-lightgrey col-sm-2\">\n        <div class=\"card-header title\">\n            {{title}}\n        </div>\n        <div class=\"card-block\">\n            <div class=\"card card-info mb-3\" *ngFor=\"let item of navitems\">\n                <div class=\"card-header\" (click)=\"item.ui_expanded = !item.ui_expanded\">\n                    {{item.title}}\n                    <i class=\"fa fa-fw fa-chevron-circle-icon {{ item.ui_expanded ? 'fa-chevron-circle-up':'fa-chevron-circle-down'}} \"></i>\n                </div>\n                <div class=\"card-block {{ item.ui_expanded ? '':'hide'}}\">\n                    <a class=\"nav-link\" *ngFor=\"let subItem of item.items\" (click)=\"selected_item=subItem\">\n                        {{ subItem.title }}\n                    </a>\n                </div>\n            </div>\n        </div>\n    </div>\n\n    <div *ngIf=\"selected_item\" class=\"card card-inverse col-sm-5 col-sm-offset-1 card-configuration-detail\">\n        <!-- put details here-->\n        <store-configuration-detail [item]=\"selected_item\"></store-configuration-detail>\n    </div>\n</div>"

/***/ }),

/***/ "./src/app/Admin/ngx/pages/configuration/nav/configuration.nav.component.scss":
/***/ (function(module, exports) {

module.exports = ":host .card-lightgrey {\n  background-color: #cecbcb; }\n\n:host .title {\n  font-size: 20px;\n  font-weight: bold; }\n\n:host .hide {\n  display: none; }\n\n:host .card-header i {\n  float: right; }\n\n:host .nav-link {\n  border: 1px solid transparent;\n  border-width: 1px 0;\n  display: block;\n  font-weight: 500;\n  line-height: 1.2;\n  margin: 0 0 -1px;\n  -webkit-transition: border-color .1s ease-out, background-color .1s ease-out;\n  transition: border-color .1s ease-out, background-color .1s ease-out;\n  word-wrap: break-word;\n  cursor: pointer; }\n\n:host .nav-link:hover {\n  background-color: #ffc400;\n  color: red; }\n\n:host .card-inverse {\n  color: white;\n  font-weight: bold; }\n"

/***/ }),

/***/ "./src/app/Admin/ngx/pages/configuration/nav/configuration.nav.component.ts":
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
var router_1 = __webpack_require__("./node_modules/@angular/router/esm5/router.js");
var core_1 = __webpack_require__("./node_modules/@angular/core/esm5/core.js");
var ui_schema_service_1 = __webpack_require__("./src/app/Admin/ngx/services/ui.schema.service.ts");
var _ngxsuit_1 = __webpack_require__("./src/app/common/index.ts");
var ConfigurationNavComponent = (function () {
    function ConfigurationNavComponent(route, mq, uischema) {
        this.route = route;
        this.mq = mq;
        this.uischema = uischema;
        console.log(this.route.snapshot);
    }
    ConfigurationNavComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.title = 'Configuration';
        this.navitems = [];
        this.mq_sub = this.mq.getMessage('ConfigurationNavComponent').subscribe(function (msg) {
            if (msg.type == 'ui-schema-fetched') {
                _this.navitems = _this.findItem(msg.load);
                console.log(_this.navitems);
            }
        });
        this.router_sub = this.route.parent.url.subscribe(function (data) {
            var paths = [''];
            for (var _i = 0, data_1 = data; _i < data_1.length; _i++) {
                var part = data_1[_i];
                paths.push(part.path);
            }
            _this.path = paths.join('/');
            _this.uischema.wait4UISchema('ConfigurationNavComponent');
        });
    };
    ConfigurationNavComponent.prototype.findItem = function (items) {
        for (var _i = 0, items_1 = items; _i < items_1.length; _i++) {
            var item = items_1[_i];
            if (item.link === this.path) {
                return item.items;
            }
            if (item.items !== undefined) {
                var found = this.findItem(item.items);
                if (found.length > 0) {
                    return found;
                }
            }
        }
        return [];
    };
    ConfigurationNavComponent.prototype.ngOnDestroy = function () {
        this.mq_sub.unsubscribe();
        this.router_sub.unsubscribe();
    };
    ConfigurationNavComponent = __decorate([
        core_1.Component({
            selector: 'store-configuration-nav',
            template: __webpack_require__("./src/app/Admin/ngx/pages/configuration/nav/configuration.nav.component.html"),
            styles: [__webpack_require__("./src/app/Admin/ngx/pages/configuration/nav/configuration.nav.component.scss")]
        }),
        __metadata("design:paramtypes", [router_1.ActivatedRoute, _ngxsuit_1.MQService, ui_schema_service_1.UISchemaService])
    ], ConfigurationNavComponent);
    return ConfigurationNavComponent;
}());
exports.ConfigurationNavComponent = ConfigurationNavComponent;


/***/ }),

/***/ "./src/app/Admin/ngx/pages/configuration/nav/configuration.nav.module.ts":
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
var forms_1 = __webpack_require__("./node_modules/@angular/forms/esm5/forms.js");
var ng_bootstrap_1 = __webpack_require__("./node_modules/@ng-bootstrap/ng-bootstrap/index.js");
var configuration_nav_routing_module_1 = __webpack_require__("./src/app/Admin/ngx/pages/configuration/nav/configuration.nav-routing.module.ts");
var configuration_nav_component_1 = __webpack_require__("./src/app/Admin/ngx/pages/configuration/nav/configuration.nav.component.ts");
var configuration_detail_component_1 = __webpack_require__("./src/app/Admin/ngx/pages/configuration/detail/configuration.detail.component.ts");
var ConfigurationNavModule = (function () {
    function ConfigurationNavModule() {
    }
    ConfigurationNavModule = __decorate([
        core_1.NgModule({
            imports: [
                common_1.CommonModule,
                forms_1.FormsModule,
                configuration_nav_routing_module_1.ConfigurationNavRoutingModule,
                ng_bootstrap_1.NgbModule.forRoot()
            ],
            exports: [configuration_nav_component_1.ConfigurationNavComponent, configuration_detail_component_1.ConfigurationDetailComponent],
            declarations: [configuration_nav_component_1.ConfigurationNavComponent, configuration_detail_component_1.ConfigurationDetailComponent],
            providers: [],
        })
    ], ConfigurationNavModule);
    return ConfigurationNavModule;
}());
exports.ConfigurationNavModule = ConfigurationNavModule;


/***/ })

});
//# sourceMappingURL=configuration.nav.module.chunk.js.map