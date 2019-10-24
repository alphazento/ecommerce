import Zento_VueDesktopTheme_Components from /var/www/html/mypackages/Zento/VueDesktopTheme/resources/vue/_components.js
var configs = [];
configs.push(Zento_VueDesktopTheme_Components);

    for (var i = 0; i < configs; i++) {
        for (const [key, value] of Object.entries(configs[i])) {
            console.log(key, value);
        }
    }
        