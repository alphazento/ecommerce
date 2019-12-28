import StoreConfigurationPage from "./pages/store_configuration/RoutePage";
import StoreDynamicAttributePage from "./pages/store_dynamic_attribute/RoutePage";

export default {
    "components": {
        "spinner-layer": "components/SpinnerLayer.vue",
        "z-file-picker": "components/FilePicker.vue",
        "admin-toolbar": "components/layout/AdminToolbar.vue",
        "z-breadcrumbs": "components/layout/Breadcrumbs.vue",

        "config-readonly-label": "components/configurable/Label.vue",
        "config-text-item": "components/configurable/Text.vue",
        "config-longtext-item": "components/configurable/LongText.vue",
        "config-boolean-item": "components/configurable/Switch.vue",
        "config-options-item": "components/configurable/Options.vue",
        "config-multi-options-item": "components/configurable/MultipleOptions.vue",

        "config-image-uploader-item": "components/configurable/ImageUploader.vue",
        "config-json-item": "components/configurable/JsonEditor.vue",
        "simple-json-item": "components/configurable/SimpleJsonEditor.vue",

        "dynamic-attribute-edit-dialogbody": "pages/store_dynamic_attribute/components/DAEditDialogBody.vue",
        // "admin-footer": "components/layout/ThemeFooter.vue",
    },
    "routes": [{
            name: "store.configuration",
            path: "/admin/store-configurations",
            component: StoreConfigurationPage
        },
        {
            name: "store.dynamic_attributes",
            path: "/admin/store-dynamic-attributes",
            component: StoreDynamicAttributePage
        }
    ]
}
