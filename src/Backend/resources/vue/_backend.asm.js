import StoreConfigurationPage from "./pages/store_configuration/RoutePage";
import StoreDynamicAttributePage from "./pages/store_dynamic_attribute/RoutePage";
import StoreDynamicAttributeSetPage from "./pages/store_dynamic_attribute_set/RoutePage";

export default {
    components: {
        "spinner-layer": "components/SpinnerLayer.vue",
        "admin-toolbar": "components/layout/AdminToolbar.vue",
        "z-breadcrumbs": "components/layout/Breadcrumbs.vue",
        "z-file-picker": "components/configurable/FilePicker.vue",

        "z-label": "components/display/Label.vue",
        "z-image": "components/display/Image.vue",
        "z-boolean-chip": "components/display/BooleanChip.vue",
        "z-options-display": "components/display/Options.vue",
        "config-text-item": "components/configurable/Text.vue",
        "config-longtext-item": "components/configurable/LongText.vue",
        "config-boolean-item": "components/configurable/Switch.vue",
        "config-options-item": "components/configurable/Options.vue",
        "config-multi-options-item": "components/configurable/MultipleOptions.vue",
        "config-date-item": "components/configurable/DatePicker.vue",
        "config-date-range-item": "components/configurable/DateRangePicker.vue",
        "config-data-table": "components/configurable/DataTable.vue",
        "z-config-actions": "components/configurable/Actions.vue",
        "config-model-editor": "components/ModelEditor.vue",

        "config-image-uploader-item": "components/configurable/ImageUploader.vue",
        "config-json-item": "components/configurable/JsonEditor.vue",
        "simple-json-item": "components/configurable/SimpleJsonEditor.vue",

        "z-dialog-container": "components/DialogContainer.vue",
        "z-dialog-confirm-body": "components/dialogbody/Confirm.vue",

        "z-dynamic-attribute-and-set-editor": "pages/inner_components/DyanmicAttrAndSetEditor.vue",
        "z-dynamic-attribute-set-attrs-manager": "pages/inner_components/DynamicAttributeSetAttrsManager.vue",
        "z-dynamic-attribute-value-map-manager": "pages/inner_components/AttributeValueMapManager.vue",
    },
    routes: [{
            name: "store.configuration",
            path: "/admin/store-configurations",
            component: StoreConfigurationPage
        },
        {
            name: "store.dynamic_attributes",
            path: "/admin/store-dynamic-attributes",
            component: StoreDynamicAttributePage
        },
        {
            name: "store.dynamic_attribute_set",
            path: "/admin/store-dynamic-attribute-sets",
            component: StoreDynamicAttributeSetPage
        }
    ]
}